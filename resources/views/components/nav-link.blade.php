@props(['to', 'match' => null])

@php
    $active = request()->routeIs($match ?? $to);
@endphp

<a
    href="{{ route($to) }}"
    @if ($active) aria-current="page" @endif
    {{ $attributes->class([
        'px-3 py-2 rounded-md text-sm font-medium transition-colors',
        'bg-indigo-600 text-white' => $active,
        'text-gray-700 hover:bg-gray-100' => ! $active,
    ]) }}
>
    {{ $slot }}
</a>