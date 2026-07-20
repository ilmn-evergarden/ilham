@props(['color' => 'indigo'])
@php
    $baseClasses = 'px-3 py-1 text-xs font-medium rounded inline-flex items-center';
    $colors = [
        'indigo' => 'bg-primary/10 text-primary dark:bg-primary/20 dark:text-primary',
        'green' => 'bg-primary/10 text-primary dark:bg-primary/20 dark:text-primary',
        'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-500',
        'red' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-500',
        'slate' => 'bg-[#f2f2f2] text-[#555] dark:bg-[#383848] dark:text-[#a4a4a4]',
    ];
    $classes = $baseClasses . ' ' . ($colors[$color] ?? $colors['indigo']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
