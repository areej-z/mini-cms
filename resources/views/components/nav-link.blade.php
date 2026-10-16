@props(['route'])

@php
    $active = request()->routeIs($route);
    $classes = $active
        ? 'text-gray-900 font-semibold'
        : 'text-gray-600 hover:text-gray-900';
@endphp

<a href="{{ route($route) }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>