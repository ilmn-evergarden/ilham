@extends('layouts.portfolio')
@section('title', 'Certificates')

@section('seo')
    <x-seo title="Certificates" description="My professional certificates and awards" />
@endsection

@section('content')
<section class="py-24 relative min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 reveal">
            <h1 class="text-4xl md:text-5xl font-bold font-serif text-[#222] dark:text-[#ddd] inline-block relative mb-4">
                Certificates & Awards
                <div class="absolute -bottom-2 left-1/4 w-1/2 h-1 bg-primary rounded"></div>
            </h1>
            <p class="text-[#555] dark:text-[#a4a4a4] max-w-2xl mx-auto">Continuous learning and professional achievements.</p>
        </div>

        @if($certificates->isEmpty())
            <x-empty-state title="No Certificates Found" message="There are currently no certificates available." icon="fas fa-certificate" />
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                @foreach($certificates as $cert)
                <div class="bg-white dark:bg-[#111] border border-[#e1e1e1] dark:border-[#383848] rounded-lg hover-lift transition-all reveal flex flex-col h-full group overflow-hidden">
                    <div class="relative h-40 overflow-hidden bg-[#f2f2f2] dark:bg-[#222]">
                        @if ($cert->image)
                            <img src="{{ Storage::url($cert->image) }}" alt="{{ $cert->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="font-bold text-4xl text-[#999] font-serif">{{ substr($cert->title, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4 w-10 h-10 bg-white dark:bg-[#333] rounded-full flex items-center justify-center shadow-md text-primary">
                            <i class="fas fa-award text-xl"></i>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow text-center">
                        <h3 class="font-bold text-lg mb-2 font-serif text-[#222] dark:text-[#ddd]">{{ $cert->title }}</h3>
                        <p class="text-sm text-[#555] dark:text-[#a4a4a4] mb-2">{{ $cert->issuer }}</p>
                        <p class="text-xs text-[#999] mb-4 flex-grow">{{ \Carbon\Carbon::parse($cert->issue_date)->format('F Y') }}</p>

                        @if ($cert->credential_url)
                            <a href="{{ $cert->credential_url }}" target="_blank"
                                class="inline-flex items-center justify-center px-4 py-2 text-xs font-medium rounded bg-[#e1e1e1] dark:bg-[#383848] hover:bg-primary hover:text-white transition-colors mt-auto">
                                Verify Credential &nearr;
                            </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $certificates->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
