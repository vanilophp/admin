@unless(isset($noCaption))
|
@endunless
@if($model->channels->count())
    @unless(isset($noCaption)){{ __('Channels') }}:@endunless
    @can('view channels')
        @foreach($model->channels->take(3) as $channel)
            <a href="{{ route('vanilo.admin.channel.show', $channel->id) }}">
                {{ $channel->name }}
            </a>
        @endforeach
    @else
        {{ $model->channels->take(3)->implode('name', ' | ') }}
    @endcan
@else
    {{ __('no channels') }}
@endif

@if($model->channels->count() > 3)
    | {{ __('+ :num more...', ['num' => $model->channels->count() - 3]) }}
@endif
