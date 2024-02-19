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
use Konekt\Address\Models\CountryProxy;
use Konekt\AppShell\Helpers\Currencies;
use Konekt\AppShell\Http\Controllers\BaseController;
use Konekt\Gears\Facades\Settings;
use Vanilo\Admin\Contracts\Requests\AssignChannels;
use Vanilo\Admin\Contracts\Requests\CreateChannel;
use Vanilo\Admin\Contracts\Requests\UpdateChannel;
use Vanilo\Channel\Contracts\Channel;
use Vanilo\Channel\Models\ChannelProxy;
use Vanilo\Pricing\Models\Pricelist;
use Vanilo\Support\Features;

class ChannelController extends BaseController
{
    public function index()
    {
        return view('vanilo::channel.index', [
            'channels' => ChannelProxy::paginate(100)
        ]);
    }

    public function create()
    {
        $channel = app(Channel::class);
        $channel->configuration = ['country_id' => Settings::get('appshell.default.country')];

        return view('vanilo::channel.create', [
            'channel' => $channel,
            'countries' => $this->getCountries(),
            'currencies' => Currencies::choices(),
            'pricelists' => $this->getPricelists(),
        ]);
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
        return view('vanilo::channel.show', ['channel' => $channel]);
    }

    public function edit(Channel $channel)
    {
        return view('vanilo::channel.edit', [
            'channel' => $channel,
            'countries' => $this->getCountries(),
            'currencies' => Currencies::choices(),
            'pricelists' => $this->getPricelists(),
        ]);
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
}
