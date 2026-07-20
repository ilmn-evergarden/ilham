@extends('layouts.portfolio')

@section('seo')
    <x-seo title="404 - Not Found" description="The page you are looking for does not exist." />
@endsection

@section('content')
<section class="min-h-screen flex items-center justify-center py-24 px-4 relative">
    <x-card class="text-center max-w-xl mx-auto p-12 relative z-10 reveal">
        <h1 class="text-9xl font-bold text-primary mb-4 font-serif">404</h1>
        <h2 class="text-3xl font-bold text-[#222] dark:text-[#ddd] mb-6 font-serif">Page Not Found</h2>
        <p class="text-[#555] dark:text-[#a4a4a4] mb-8">Oops! The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        <x-button href="{{ route('home') }}">
            <i class="fas fa-home mr-2"></i> Back to Home
        </x-button>
    </x-card>
</section>
@endsection
