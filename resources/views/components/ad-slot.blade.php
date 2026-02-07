<!-- Ad Slot Component -->
@props([
    'position' => '',
    'class' => ''
])

@php
    $slot = \App\Models\AdSlot::getByPosition($position);
@endphp

@if($slot && $slot->is_active && !empty($slot->code))
<div {{ $attributes->merge(['class' => "sf-widget sf-widget-{$position} {$class}"]) }} data-position="{{ $position }}" style="display: block !important; visibility: visible !important; opacity: 1 !important;">
    {!! $slot->code !!}
</div>
@else
<!-- Ad slot '{{ $position }}' not found or empty -->
@endif
