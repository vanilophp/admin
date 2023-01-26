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
use Vanilo\Order\Events\OrderWasCancelled;
use Vanilo\Order\Events\OrderWasCompleted;
use Vanilo\Order\Models\OrderProxy;
use Vanilo\Order\Models\OrderStatus;

class OrderController extends BaseController
{
    public function index(Request $request)
    {
        $filters = $this->getFilters();

        $filters->activateFromRequest($request);
        $query = OrderProxy::withCurrentPayment()->orderBy('created_at', 'desc');
        if (!$filters->isActive('status')) {
            $query->open(); // Give open orders only if no explicit status was requested
        }

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

        return view("vanilo::order.$view", ['order' => $order]);
    }

    public function update(Order $order, UpdateOrder $request)
    {
        try {
            $event = null;
            if ($request->wantsToChangeOrderStatus($order)) {
                $event = $this->getStatusUpdateEventClass($request->getStatus(), $order);
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
        if (OrderStatus::CANCELLED === $status) {
            return new OrderWasCancelled($order);
        }

        if (OrderStatus::COMPLETED === $status) {
            return new OrderWasCompleted($order);
        }

        return null;
    }
}
