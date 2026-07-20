@extends('layouts.portfolio')

@section('seo')
    <x-seo title="Projects" description="Explore my portfolio projects" />
@endsection

@section('content')
<section class="py-24 relative min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <h1 class="text-4xl md:text-5xl font-bold font-serif text-[#222] dark:text-[#ddd] inline-block relative mb-4">
                Projects
                <div class="absolute -bottom-2 left-1/4 w-1/2 h-1 bg-primary rounded"></div>
            </h1>
            <p class="text-[#555] dark:text-[#a4a4a4] max-w-2xl mx-auto">Browse through my latest works and experiments.</p>
        </div>

        <!-- Search & Filter -->
        <x-card class="mb-12 reveal">
            <form action="{{ route('projects.public.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-grow">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-[#999]"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-3 border border-[#e1e1e1] dark:border-[#383848] rounded leading-5 bg-[#f2f2f2] dark:bg-[#111] text-[#222] dark:text-[#ddd] placeholder-[#999] focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary sm:text-sm" placeholder="Search projects by title or description...">
                    </div>
                </div>
                <div class="md:w-64 shrink-0">
                    <label for="technology" class="sr-only">Technology</label>
                    <select name="technology" id="technology" class="block w-full py-3 px-4 border border-[#e1e1e1] dark:border-[#383848] rounded leading-5 bg-[#f2f2f2] dark:bg-[#111] text-[#222] dark:text-[#ddd] focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary sm:text-sm appearance-none">
                        <option value="">All Technologies</option>
                        @foreach($technologies as $tech)
                            <option value="{{ $tech->id }}" {{ request('technology') == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary hover-lift">
                    Filter
                </button>
            </form>
        </x-card>

        @if($projects->isEmpty())
            <x-empty-state title="No Projects Found" message="Try adjusting your search or filter criteria." icon="fas fa-folder-open">
                <x-slot name="action">
                    <x-button href="{{ route('projects.public.index') }}" variant="secondary">Clear Filters</x-button>
                </x-slot>
            </x-empty-state>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($projects as $project)
                <x-card class="flex flex-col h-full group p-0 overflow-hidden reveal">
                    <div class="relative h-48 overflow-hidden">
                        @if($project->thumbnail)
                        <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->title }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                        <div class="w-full h-full bg-[#f2f2f2] dark:bg-[#383848] flex items-center justify-center">
                            <i class="fas fa-image text-4xl text-[#999]"></i>
                        </div>
                        @endif
                        <div class="absolute top-4 right-4">
                            <x-badge color="primary">
                                {{ $project->status }}
                            </x-badge>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold mb-2 font-serif group-hover:text-primary transition-colors text-[#222] dark:text-[#ddd]">
                            <a href="{{ route('projects.public.show', $project->slug) }}">{{ $project->title }}</a>
                        </h3>
                        <p class="text-sm text-[#555] dark:text-[#a4a4a4] mb-4 line-clamp-3 flex-grow">
                            {{ Str::limit(strip_tags($project->description), 120) }}
                        </p>
                        
                        <div class="flex flex-wrap gap-2 mb-6 mt-auto">
                            @foreach($project->technologies as $tech)
                            <span class="text-xs px-2 py-1 rounded bg-[#f2f2f2] dark:bg-[#383848] text-[#555] dark:text-[#ddd] flex items-center gap-1">
                                @if($tech->icon)
                                    <i class="{{ $tech->icon }}"></i>
                                @endif
                                {{ $tech->name }}
                            </span>
                            @endforeach
                        </div>
                        
                        <div class="flex justify-between items-center border-t border-[#e1e1e1] dark:border-[#383848] pt-4">
                            <div class="flex space-x-3">
                                @if($project->github_url)
                                <a href="{{ $project->github_url }}" target="_blank" class="text-[#999] hover:text-[#222] dark:hover:text-[#ddd] transition-colors" title="Source Code">
                                    <i class="fab fa-github text-lg"></i>
                                </a>
                                @endif
                                @if($project->demo_url)
                                <a href="{{ $project->demo_url }}" target="_blank" class="text-[#999] hover:text-primary transition-colors" title="Live Demo">
                                    <i class="fas fa-external-link-alt text-lg"></i>
                                </a>
                                @endif
                            </div>
                            <a href="{{ route('projects.public.show', $project->slug) }}" class="text-sm font-medium text-primary hover:text-primary-dark">Details &rarr;</a>
                        </div>
                    </div>
                </x-card>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
