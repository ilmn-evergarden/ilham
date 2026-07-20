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
                <x-card class="flex flex-col items-center text-center p-8 group reveal">
                    <div class="w-20 h-20 bg-primary/10 dark:bg-primary/20 rounded-full flex items-center justify-center mb-6 text-primary group-hover:scale-110 transition-transform duration-500 group-hover:rotate-6">
                        <i class="fas fa-award text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-bold mb-2 font-serif text-[#222] dark:text-[#ddd]">{{ $cert->title }}</h3>
                    <p class="text-primary font-medium text-sm mb-4">{{ $cert->issuer }}</p>
                    <div class="text-xs text-[#999] dark:text-[#a4a4a4] mb-6 flex-grow">
                        <i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($cert->issue_date)->format('F Y') }}
                    </div>
                    @if($cert->credential_url)
                        <x-button href="{{ $cert->credential_url }}" target="_blank" variant="secondary" class="w-full text-xs py-2">
                            Verify <i class="fas fa-external-link-alt ml-2"></i>
                        </x-button>
                    @endif
                </x-card>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $certificates->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
