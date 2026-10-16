@props(['type' => 'info', 'title' => null])

@php
    $styles = [
        'info' => 'border-blue-500 bg-blue-50 text-blue-900',
        'success' => 'border-green-500 bg-green-50 text-green-900',
        'warning' => 'border-amber-500 bg-amber-50 text-amber-900',
        'error' => 'border-red-500 bg-red-50 text-red-900',
    ];

    $classes = $styles[$type] ?? $styles['info'];
@endphp

<div role="{{ $type === 'error' ? 'alert' : 'status' }}" {{ $attributes->merge(['class' => 'border-l-4 p-4 rounded '.$classes]) }}>
    @if ($title)
        <p class="font-semibold">{{ $title }}</p>
    @endif

    <div class="text-sm">{{ $slot }}</div>
</div>