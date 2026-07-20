@props(['title' => '', 'description' => '', 'image' => '', 'url' => url()->current(), 'context' => 'public'])
@php
    $suffix = $context === 'admin' ? 'Portfolio Admin' : 'Ilham Maulana';
    $fullTitle = $title ? "$title | $suffix" : $suffix;
    $desc = $description ?: 'Personal Portfolio Website';
    $img = $image ? url(Storage::url($image)) : url('/default-og.png');
@endphp
<title>{{ $fullTitle }}</title>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<meta name="description" content="{{ $desc }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $url }}">
<meta property="og:title" content="{{ $fullTitle }}">
<meta property="og:description" content="{{ $desc }}">
<meta property="og:image" content="{{ $img }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $fullTitle }}">
<meta name="twitter:description" content="{{ $desc }}">
<meta name="twitter:image" content="{{ $img }}">
