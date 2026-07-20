@extends('layouts.portfolio')

@section('seo')
    <x-seo title="{{ $project->title }}" description="{{ Str::limit(strip_tags($project->description), 150) }}" image="{{ $project->thumbnail }}" />
@endsection

@section('content')
<section class="py-24 relative min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <a href="{{ route('projects.public.index') }}" class="inline-flex items-center text-sm font-medium text-[#999] hover:text-primary mb-8 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Back to Projects
        </a>

        <x-card class="reveal p-8 md:p-12">
            <div class="flex flex-wrap gap-2 mb-4">
                <x-badge color="primary">
                    {{ $project->status }}
                </x-badge>
                <span class="text-xs text-[#999] flex items-center">
                    <i class="far fa-calendar-alt mr-1"></i> 
                    {{ \Carbon\Carbon::parse($project->start_date)->format('M Y') }}
                    @if($project->end_date)
                        - {{ \Carbon\Carbon::parse($project->end_date)->format('M Y') }}
                    @else
                        - Present
                    @endif
                </span>
            </div>

            <h1 class="text-4xl md:text-5xl font-bold mb-6 font-serif text-[#222] dark:text-[#ddd]">{{ $project->title }}</h1>

            <div class="flex flex-wrap gap-2 mb-8">
                @foreach($project->technologies as $tech)
                <span class="text-sm px-3 py-1 rounded bg-[#f2f2f2] dark:bg-[#383848] text-[#555] dark:text-[#ddd] flex items-center gap-2 border border-[#e1e1e1] dark:border-[#383848]">
                    @if($tech->icon)
                        <i class="{{ $tech->icon }}"></i>
                    @endif
                    {{ $tech->name }}
                </span>
                @endforeach
            </div>

            @if($project->thumbnail)
            <div class="rounded-lg overflow-hidden mb-8 shadow-2xl">
                <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->title }}" class="w-full h-auto object-cover">
            </div>
            @endif

            <div class="prose prose-lg prose-slate dark:prose-invert max-w-none mb-12 text-[#555] dark:text-[#a4a4a4]">
                {!! nl2br(e($project->description)) !!}
            </div>

            <div class="flex flex-wrap gap-4 pt-6 border-t border-[#e1e1e1] dark:border-[#383848]">
                @if($project->github_url)
                <x-button href="{{ $project->github_url }}" target="_blank" variant="secondary">
                    <i class="fab fa-github mr-2 text-xl"></i> View Source
                </x-button>
                @endif
                @if($project->demo_url)
                <x-button href="{{ $project->demo_url }}" target="_blank">
                    <i class="fas fa-external-link-alt mr-2 text-xl"></i> Live Demo
                </x-button>
                @endif
            </div>
        </x-card>

        @if($project->images->count() > 0)
        <div class="mt-16 reveal">
            <h3 class="text-2xl font-bold mb-8 font-serif text-[#222] dark:text-[#ddd]">Gallery</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($project->images as $image)
                <div class="rounded overflow-hidden shadow-sm border border-[#e1e1e1] dark:border-[#383848]">
                    <img src="{{ Storage::url($image->image_path) }}" loading="lazy" alt="Gallery Image" class="w-full h-auto hover:scale-105 transition-transform duration-500">
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($related->count() > 0)
        <div class="mt-20 reveal">
            <h3 class="text-2xl font-bold mb-8 font-serif text-[#222] dark:text-[#ddd]">Related Projects</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($related as $rel)
                <x-card class="p-0 overflow-hidden group">
                    <div class="h-40 overflow-hidden relative">
                        @if($rel->thumbnail)
                        <img src="{{ Storage::url($rel->thumbnail) }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full bg-[#f2f2f2] dark:bg-[#383848] flex items-center justify-center">
                            <i class="fas fa-image text-3xl text-[#999]"></i>
                        </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold font-serif text-[#222] dark:text-[#ddd] group-hover:text-primary transition-colors">
                            <a href="{{ route('projects.public.show', $rel->slug) }}">{{ $rel->title }}</a>
                        </h4>
                    </div>
                </x-card>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
