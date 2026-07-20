@extends('layouts.portfolio')

@section('seo')
    <x-seo title="500 - Server Error" description="Internal Server Error." />
@endsection

@section('content')
<section class="min-h-screen flex items-center justify-center py-24 px-4 relative">
    <x-card class="text-center max-w-xl mx-auto p-12 relative z-10 reveal">
        <h1 class="text-9xl font-bold text-red-600 mb-4 font-serif">500</h1>
        <h2 class="text-3xl font-bold text-[#222] dark:text-[#ddd] mb-6 font-serif">Server Error</h2>
        <p class="text-[#555] dark:text-[#a4a4a4] mb-8">Oops! Something went wrong on our servers. We are looking into it.</p>
        <x-button href="{{ route('home') }}" variant="secondary">
            <i class="fas fa-undo mr-2"></i> Try Again
        </x-button>
    </x-card>
</section>
@endsection
