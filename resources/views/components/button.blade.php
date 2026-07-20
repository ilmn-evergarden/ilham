@props(['href' => null, 'type' => 'button', 'variant' => 'primary'])
@php
    $baseClasses = 'inline-flex items-center justify-center px-6 py-2 rounded font-medium transition-colors hover-lift focus:outline-none focus:ring-2 focus:ring-offset-2';
    $variants = [
        'primary' => 'bg-primary text-white hover:bg-primary-dark focus:ring-primary',
        'secondary' => 'bg-[#f2f2f2] dark:bg-[#383848] text-[#555] dark:text-[#ddd] hover:bg-[#e1e1e1] dark:hover:bg-[#555] focus:ring-[#999]',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
    ];
    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
