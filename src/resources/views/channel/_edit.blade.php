<x-appshell::card accent="secondary">
    <x-slot:title>
        {{ __('Channels') }}
        <x-appshell::badge variant="secondary">{{ $model->channels->count() }}</x-appshell::badge>
    </x-slot:title>

    @error('channels')
    <x-appshell::alert variant="danger">{{ $message }}</x-appshell::alert>
    @enderror
    @error('for')
    <x-appshell::alert variant="danger">{{ $message }}</x-appshell::alert>
    @enderror
    @error('forId')
    <x-appshell::alert variant="danger">{{ $message }}</x-appshell::alert>
    @enderror
    <div class="mb-2">
        {!! Form::open(['route' => 'vanilo.admin.channels.assign', 'method' => 'PUT']) !!}
            {{ Form::hidden('for', $for ?? shorten(get_class($model))) }}
            {{ Form::hidden('forId', $model->id) }}

            @foreach($channels as $channelId => $channelName)
                <input type="checkbox" name="channels[]" value="{{ $channelId }}" id="chasf{{ $channelId }}" @if($model->isInChannel($channelId))checked="checked"@endif/>
                <label for="chasf{{ $channelId }}">{{ $channelName }}</label>
                &nbsp;
            @endforeach

            <hr>
            <x-appshell::button variant="outline-primary" size="sm">{{ __('Update') }}</x-appshell::button>

        {!! Form::close() !!}
    </div>
</x-appshell::card>
