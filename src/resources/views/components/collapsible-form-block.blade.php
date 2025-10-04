<?php
    $fields = match(true) {
        is_array($fields) => $fields,
        is_string($fields) => array_map('trim', explode(',', $fields)),
        default => [],
    };
    $cfbHasErrors = any_key_exists($errors->toArray(), $fields);
?>
<h{{ $labelSize ?? '5' }}><a data-bs-toggle="collapse" href="#collapsible-{{ $name }}" class="collapse-toggler-heading"
    @if ($cfbHasErrors)aria-expanded="true"@endif
><small>{!! icon('>') !!}</small> {{ $label ?? 'Collapse' }}</a></h{{ $labelSize ?? '5' }}>

<div id="collapsible-{{ $name }}" @class(['collapse', 'show' => $cfbHasErrors])>
    <div class="callout">
        {!! $slot !!}
    </div>
</div>
