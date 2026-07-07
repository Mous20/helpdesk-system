@props(['href', 'active' => false, 'icon' => null])

@php
    $baseClasses = 'flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200';
    $activeClasses = 'bg-gray-800 text-white shadow-md';
    $inactiveClasses = 'text-gray-300 hover:text-white hover:bg-gray-800';
    $classes = ($active ?? false) ? $baseClasses . ' ' . $activeClasses : $baseClasses . ' ' . $inactiveClasses;
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <x-icon name="{{ $icon }}" class="w-5 h-5" />
    @endif
    <span>{{ $slot }}</span>
</a>