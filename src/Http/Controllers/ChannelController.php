<?php

declare(strict_types=1);
/**
 * Contains the ChannelController class.
 *
 * @copyright   Copyright (c) 2019 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2019-07-30
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Konekt\Address\Models\CountryProxy;
use Konekt\Address\Models\Language;
use Konekt\Address\Query\Zones;
use Konekt\AppShell\Helpers\Currencies;
use Konekt\AppShell\Http\Controllers\BaseController;
use Konekt\Gears\Facades\Settings;
use Vanilo\Admin\Contracts\Requests\AssignChannels;
use Vanilo\Admin\Contracts\Requests\CreateChannel;
use Vanilo\Admin\Contracts\Requests\UpdateChannel;
use Vanilo\Channel\Contracts\Channel;
use Vanilo\Channel\Models\ChannelProxy;
use Vanilo\Foundation\Search\ProductSearch;
use Vanilo\Order\Models\OrderProxy;
use Vanilo\Pricing\Models\Pricelist;
use Vanilo\Support\Features;

class ChannelController extends BaseController
{
    public function index()
    {
        return view('vanilo::channel.index', $this->processViewData(__METHOD__, [
            'channels' => ChannelProxy::paginate(100)
        ]));
    }

    public function create()
    {
        $channel = app(Channel::class);
        $channel->configuration = ['country_id' => Settings::get('appshell.default.country')];

        return view('vanilo::channel.create', $this->processViewData(__METHOD__, [
            'channel' => $channel,
            'countries' => $this->getCountries(),
            'currencies' => Currencies::choices(),
            'pricelists' => $this->getPricelists(),
            'billingZones' => Zones::withBillingScope()->get(),
            'shippingZones' => Zones::withShippingScope()->get(),
            'domains' => null,
            'languages' => $this->getLanguages(),
        ]));
    }

    public function store(CreateChannel $request)
    {
        try {
            $channel = ChannelProxy::create($request->validated());
            flash()->success(__(':name has been created', ['name' => $channel->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.channel.index'));
    }

    public function show(Channel $channel)
    {
        return view('vanilo::channel.show', $this->processViewData(__METHOD__, [
            'channel' => $channel,
            'products' => (new ProductSearch())->withinChannel($channel)->withInactiveProducts()->getResults(),
            'country' => CountryProxy::where('id', $channel->configuration()['country_id'])->first(),
            'orderCount' => OrderProxy::where('channel_id', $channel->id)->count(),
            'orderTotalsPerCurrency' => OrderProxy::where('channel_id', $channel->id)
                ->get()
                ->groupBy('currency')
                ->map(fn($orders) => $orders->sum('total'))
        ]));
    }

    public function edit(Channel $channel)
    {
        return view('vanilo::channel.edit', $this->processViewData(__METHOD__, [
            'channel' => $channel,
            'countries' => $this->getCountries(),
            'currencies' => Currencies::choices(),
            'pricelists' => $this->getPricelists(),
            'billingZones' => Zones::withBillingScope()->get(),
            'shippingZones' => Zones::withShippingScope()->get(),
            'domains' => null,
            'languages' => $this->getLanguages(),
        ]));
    }

    public function update(Channel $channel, UpdateChannel $request)
    {
        try {
            $channel->update($request->validated());

            flash()->success(__(':name has been updated', ['name' => $channel->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.channel.index'));
    }

    public function destroy(Channel $channel)
    {
        try {
            $name = $channel->name;
            $channel->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('vanilo.admin.channel.index'));
    }

    public function assign(AssignChannels $request)
    {
        $model = $request->getFor();
        if (null === $model) {
            abort(400, sprintf('The `%s` with id `%s` could not be located', $request->input('for'), $request->input('forId')));
        }

        $model->assignChannels($request->channels());
        $model->touch();
        flash()->success(__('Channel assignments have been updated'));

        return redirect()->intended(url()->previous());
    }

    private function getCountries()
    {
        return CountryProxy::orderBy('name')->pluck('name', 'id');
    }

    private function getPricelists(): ?Collection
    {
        if (Features::isPricingDisabled()) {
            return null;
        }

        return Pricelist::select(['id', 'name'])->get()->pluck('name', 'id');
    }

    private function getLanguages()
    {
        return Language::select(['id', 'name'])->orderBy('name')->pluck('name', 'id');
    }
}
