<?php

declare(strict_types=1);

/**
 * Contains the OrderController class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-12-17
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Konekt\Address\Models\CountryProxy;
use Konekt\AppShell\Filters\Filters;
use Konekt\AppShell\Filters\Generic\ExactMatch;
use Konekt\AppShell\Filters\Generic\PartialMatch;
use Konekt\AppShell\Filters\PartialMatchPattern;
use Konekt\AppShell\Http\Controllers\BaseController;
use Konekt\AppShell\Widgets;
use Konekt\AppShell\Widgets\AppShellWidgets;
use Vanilo\Admin\Contracts\Requests\UpdateOrder;
use Vanilo\Admin\Filters\OrderStatusFilter;
use Vanilo\Channel\Models\ChannelProxy;
use Vanilo\Order\Contracts\Order;
use Vanilo\Order\Contracts\OrderAwareEvent;
use Vanilo\Order\Events\OrderBillpayerUpdated;
use Vanilo\Order\Events\OrderProcessingStarted;
use Vanilo\Order\Events\OrderShippingAddressUpdated;
use Vanilo\Order\Events\OrderWasCancelled;
use Vanilo\Order\Events\OrderWasCompleted;
use Vanilo\Order\Models\OrderProxy;
use Vanilo\Order\Models\OrderStatus;

class OrderController extends BaseController
{
    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            return JSON\OrderController::index($request);
        }

        $filters = $this->getFilters();

        $filters->activateFromRequest($request);
        $query = OrderProxy::withCurrentPayment()->with(['billpayer', 'items', 'items.adjustmentsRelation', 'adjustmentsRelation', 'paymentMethod', 'shippingAddress', 'shippingAddress.country'])->orderBy('created_at', 'desc');

        return view('vanilo::order.index', [
            'orders' => $filters->apply($query)->paginate(100)->withQueryString(),
            'filters' => Widgets::make(AppShellWidgets::FILTER_SET, [
                'route' => 'vanilo.admin.order.index',
                'filters' => $filters,
            ])
        ]);
    }

    public function show(Order $order, Request $request)
    {
        $view = $request->has('print') ? 'print' : 'show';
        if ('show' === $view) {
            $order = OrderProxy::where('id', $order->id)->with(['items', 'items.product'])->first();
        }

        $existingItemAdjustmentTypes = [];
        foreach ($order->getItems() as $item) {
            foreach ($item->adjustments() as $adjustment) {
                $existingItemAdjustmentTypes[$adjustment->getType()->value()] = $adjustment->getType()->label();
            }
        }

        return view("vanilo::order.$view", $this->processViewData(__METHOD__, [
            'order' => $order,
            'hasItemAdjustments' => !empty($existingItemAdjustmentTypes),
            'itemAdjustmentTypes' => $existingItemAdjustmentTypes,
            'countries' => CountryProxy::orderBy('name')->pluck('name', 'id'),
        ]));
    }

    public function update(Order $order, UpdateOrder $request)
    {
        try {
            $event = null;
            if ($request->wantsToChangeOrderStatus($order)) {
                $event = $this->getStatusUpdateEventClass($request->getStatus(), $order);
            }

            if ($request->wantsToUpdateBillpayerData()) {
                $billpayer = $order->billpayer;
                $billpayerAddress = $billpayer->address;

                DB::transaction(static function () use ($request, $billpayer, $billpayerAddress) {
                    $billpayer->update([
                        'email' => $request->input('billpayer.email'),
                        'phone' => $request->input('billpayer.phone'),
                        'firstname' => $request->input('billpayer.firstname'),
                        'lastname' => $request->input('billpayer.lastname'),
                        'company_name' => $request->input('billpayer.company_name'),
                        'tax_nr' => $request->input('billpayer.tax_nr'),
                        'registration_nr' => $request->input('billpayer.registration_nr'),
                        'is_organization' => $request->isOrganization(),
                    ]);

                    $billpayerAddress->update([
                        'country_id' => $request->input('billpayer.address.country_id'),
                        'postalcode' => $request->input('billpayer.address.postalcode'),
                        'city' => $request->input('billpayer.address.city'),
                        'address' => $request->input('billpayer.address.address'),
                    ]);
                });

                $event = new OrderBillpayerUpdated($order);
            }

            if ($request->wantsToUpdateShippingAddressData()) {
                $shippingAddress = $order->getShippingAddress();

                if (null !== $shippingAddress) {
                    $shippingAddress->update([
                        'name' => $request->input('shippingAddress.name'),
                        'country_id' => $request->input('shippingAddress.country_id'),
                        'postalcode' => $request->input('shippingAddress.postalcode'),
                        'city' => $request->input('shippingAddress.city'),
                        'address' => $request->input('shippingAddress.address'),
                    ]);

                    $event = new OrderShippingAddressUpdated($order);
                }
            }

            $order->update($request->all());

            if (null !== $event) {
                event($event);
            }

            flash()->success(__('Order :no has been updated', ['no' => $order->number]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.order.show', $order));
    }

    public function destroy(Order $order)
    {
        try {
            $number = $order->getNumber();
            $order->delete();

            flash()->warning(__('Order :no has been deleted', ['no' => $number]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('vanilo.admin.order.index'));
    }

    protected function getFilters(): Filters
    {
        $filters = [
            (new PartialMatch('number', __('Number'), PartialMatchPattern::ANYWHERE()))->displayAsTextField(),
        ];

        if (ChannelProxy::count() > 0) {
            $filters[] = new ExactMatch(
                'channel_id',
                __('Channel'),
                [null => __('Any channel')] + ChannelProxy::pluck('name', 'id')->toArray(),
            );
        }

        return Filters::make(array_merge($filters, [new OrderStatusFilter()]));
    }

    private function getStatusUpdateEventClass(string $status, Order $order): ?OrderAwareEvent
    {
        return match ($status) {
            OrderStatus::CANCELLED => new OrderWasCancelled($order),
            OrderStatus::COMPLETED => new OrderWasCompleted($order),
            OrderStatus::PROCESSING => new OrderProcessingStarted($order),
            default => null,
        };
    }
}
