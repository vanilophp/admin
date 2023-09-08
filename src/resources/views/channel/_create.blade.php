<x-appshell::card accent="success">
    <x-slot:title>{{ __('Channels') }}</x-slot:title>

    <div class="mb-2">
        @foreach($channels as $channelId => $channelName)
            <input type="checkbox" name="channels[]" value="{{ $channelId }}" id="chasf{{ $channelId }}" />
            <label for="chasf{{ $channelId }}">{{ $channelName }}</label>
            &nbsp;
        @endforeach
    </div>

    @if ($errors->has('channels.*'))
        <x-appshell::alert variant="danger" class="mt-2">
            @foreach($errors->get('channels.*') as $fileErrors)
                @foreach($fileErrors as $error)
                    {{ $error }}<br>
                @endforeach
            @endforeach
        </x-appshell::alert>
    @endif

</x-appshell::card>
