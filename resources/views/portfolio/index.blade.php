@extends('layouts.portfolio')
@section('title', 'Home')

@section('content')

    <!-- Hero Section -->
    <section id="hero" class="relative min-h-screen flex items-center pt-16 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-10">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="md:w-1/2 text-center md:text-left reveal">
                    <h1
                        class="text-4xl md:text-6xl font-extrabold font-serif tracking-tight mb-4 text-[#222] dark:text-[#ddd]">
                        Hi, I'm <span class="text-primary">{{ $user->name }}</span>
                    </h1>
                    <h2 class="text-2xl md:text-3xl font-medium text-slate-600 dark:text-slate-300 mb-6">
                        {{ $user->profile->profession ?? 'Web Developer' }}
                    </h2>
                    <p class="text-lg text-slate-500 dark:text-slate-400 mb-8 max-w-lg mx-auto md:mx-0">
                        {{ $user->profile->location ?? 'Based in the world' }}
                    </p>
                    <div class="flex space-x-4 justify-center md:justify-start">
                        <x-button href="#projects">
                            View Work
                        </x-button>
                        @if ($user->profile && $user->profile->cv)
                            <x-button href="{{ Storage::url($user->profile->cv) }}" target="_blank" variant="secondary">
                                Download CV
                            </x-button>
                        @endif
                    </div>
                </div>

                <div class="md:w-1/2 mt-12 md:mt-0 flex justify-center reveal" style="transition-delay: 200ms;">
                    <div class="relative w-64 h-64 md:w-96 md:h-96">
                        <div class="absolute inset-0 bg-primary/20 dark:bg-primary/10 rounded-full blur-2xl"></div>
                        @if ($user->profile && $user->profile->photo)
                            <img src="{{ Storage::url($user->profile->photo) }}" alt="{{ $user->name }}" loading="lazy"
                                class="relative z-10 w-full h-full object-cover rounded-full border-4 border-white dark:border-slate-800 shadow-2xl">
                        @else
                            <div
                                class="relative z-10 w-full h-full rounded-full border-4 border-white dark:border-[#383848] shadow-2xl bg-[#f2f2f2] dark:bg-[#383848] flex items-center justify-center">
                                <i class="fas fa-user text-6xl text-[#999]"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#about" class="text-[#999] hover:text-primary transition-colors">
                <i class="fas fa-chevron-down text-2xl"></i>
            </a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <h2 class="text-3xl font-bold font-serif text-[#222] dark:text-[#ddd] inline-block relative">
                    About Me
                    <div class="absolute -bottom-2 left-1/4 w-1/2 h-1 bg-primary rounded"></div>
                </h2>
            </div>

            <x-card class="reveal">
                <div class="prose prose-lg dark:prose-invert max-w-none text-[#555] dark:text-[#a4a4a4]">
                    {!! nl2br(e($user->profile->bio ?? 'No bio available.')) !!}
                </div>
            </x-card>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills"
        class="py-20 bg-[#f2f2f2] dark:bg-[#111] border-y border-[#e1e1e1] dark:border-[#383848] relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <h2 class="text-3xl font-bold font-serif text-[#222] dark:text-[#ddd] inline-block relative">
                    Skills & Expertise
                    <div class="absolute -bottom-2 left-1/4 w-1/2 h-1 bg-primary rounded"></div>
                </h2>
            </div>

            @php
                $groupedSkills = $user->skills->groupBy('category');
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($groupedSkills as $category => $skills)
                    <x-card class="reveal">
                        <h3 class="text-xl font-bold mb-6 font-serif text-primary">{{ $category }}</h3>
                        <div class="space-y-4">
                            @foreach ($skills as $skill)
                                <div class="flex items-center gap-4 bg-white dark:bg-[#1a1a1a] p-3 rounded-lg border border-[#e1e1e1] dark:border-[#383848] transition-colors hover:border-primary group">
                                    @php
                                        $hasValidIcon = false;
                                        if ($skill->icon) {
                                            $iconExtension = pathinfo($skill->icon, PATHINFO_EXTENSION);
                                            if (in_array(strtolower($iconExtension), ['svg', 'png', 'jpg', 'jpeg', 'webp', 'gif'])) {
                                                $hasValidIcon = true;
                                            }
                                        }
                                    @endphp

                                    @if ($hasValidIcon)
                                        <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-[#f2f2f2] dark:bg-[#222] rounded p-2 group-hover:scale-110 transition-transform">
                                            <img src="{{ Storage::url($skill->icon) }}" alt="{{ $skill->name }} icon" class="w-full h-full object-contain">
                                        </div>
                                    @else
                                        <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-[#f2f2f2] dark:bg-[#222] rounded p-2 group-hover:scale-110 transition-transform">
                                            <span class="font-bold text-xl text-[#999] font-serif">{{ substr($skill->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    
                                    <div class="flex-grow">
                                        <div class="flex justify-between mb-2 items-end">
                                            <span class="text-sm font-bold text-[#222] dark:text-[#ddd] leading-none">{{ $skill->name }}</span>
                                            <span class="text-xs font-medium text-[#999] leading-none">{{ $skill->level }}%</span>
                                        </div>
                                        <div class="w-full bg-[#e1e1e1] dark:bg-[#383848] rounded-full h-1.5">
                                            <div class="bg-primary h-1.5 rounded-full" style="width: {{ $skill->level }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-card>
                @empty
                    <div class="col-span-full text-center text-[#999]">No skills added yet.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Experience & Education -->
    <section id="experience" class="py-20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

                <!-- Experience -->
                <div>
                    <div class="mb-12 reveal">
                        <h2 class="text-3xl font-bold font-serif text-[#222] dark:text-[#ddd] inline-block relative">
                            <i class="fas fa-briefcase mr-2 text-primary"></i> Experience
                            <div class="absolute -bottom-2 left-0 w-1/2 h-1 bg-primary rounded"></div>
                        </h2>
                    </div>

                    <div class="space-y-8 pl-4 border-l-2 border-[#e1e1e1] dark:border-[#383848]">
                        @forelse($user->experiences as $exp)
                            <div
                                class="timeline-item reveal relative pl-8 before:absolute before:left-[-6px] before:top-2 before:w-3 before:h-3 before:bg-primary before:rounded-full">
                                <span class="text-sm font-medium text-primary mb-2 inline-block">
                                    {{ $exp->start_date->format('M Y') }} -
                                    {{ $exp->is_current ? 'Present' : ($exp->end_date ? $exp->end_date->format('M Y') : 'N/A') }}
                                </span>
                                <h3 class="text-xl font-bold text-[#222] dark:text-[#ddd] mt-1">{{ $exp->position }}</h3>
                                <h4 class="text-md font-medium text-[#555] dark:text-[#a4a4a4] mb-3">{{ $exp->company }}
                                    <span class="text-sm font-normal text-[#999]">({{ $exp->employment_type }})</span></h4>
                                <p class="text-[#555] dark:text-[#a4a4a4] text-sm leading-relaxed">
                                    {!! nl2br(e($exp->description)) !!}
                                </p>
                            </div>
                        @empty
                            <p class="text-[#999]">No experience records found.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Education -->
                <div>
                    <div class="mb-12 reveal">
                        <h2 class="text-3xl font-bold font-serif text-[#222] dark:text-[#ddd] inline-block relative">
                            <i class="fas fa-graduation-cap mr-2 text-primary"></i> Education
                            <div class="absolute -bottom-2 left-0 w-1/2 h-1 bg-primary rounded"></div>
                        </h2>
                    </div>

                    <div class="space-y-8 pl-4 border-l-2 border-[#e1e1e1] dark:border-[#383848]">
                        @forelse($user->educations as $edu)
                            <div
                                class="timeline-item reveal relative pl-8 before:absolute before:left-[-6px] before:top-2 before:w-3 before:h-3 before:bg-primary before:rounded-full">
                                <span class="text-sm font-medium text-primary mb-2 inline-block">
                                    {{ $edu->start_year }} - {{ $edu->end_year ?? 'Present' }}
                                </span>
                                <h3 class="text-xl font-bold text-[#222] dark:text-[#ddd] mt-1">{{ $edu->major }}</h3>
                                <h4 class="text-md font-medium text-[#555] dark:text-[#a4a4a4] mb-3">
                                    {{ $edu->school_name }} <span
                                        class="text-sm font-normal text-[#999]">({{ $edu->level }})</span></h4>
                                <p class="text-[#555] dark:text-[#a4a4a4] text-sm leading-relaxed">
                                    {!! nl2br(e($edu->description)) !!}
                                </p>
                            </div>
                        @empty
                            <p class="text-[#999]">No education records found.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Projects -->
    <section id="projects" class="py-20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <h2 class="text-3xl font-bold font-serif text-[#222] dark:text-[#ddd] inline-block relative">
                    Featured Projects
                    <div class="absolute -bottom-2 left-1/4 w-1/2 h-1 bg-primary rounded"></div>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($user->projects as $project)
                    <div class="bg-white dark:bg-[#111] border border-[#e1e1e1] dark:border-[#383848] rounded-lg hover-lift transition-all reveal flex flex-col h-full group overflow-hidden">
                        <div class="relative h-48 overflow-hidden">
                            @if ($project->thumbnail)
                                <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->title }}"
                                    loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
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
                            <h3
                                class="text-xl font-bold mb-2 font-serif group-hover:text-primary transition-colors text-[#222] dark:text-[#ddd]">
                                {{ $project->title }}</h3>
                            <p class="text-sm text-[#555] dark:text-[#a4a4a4] mb-4 line-clamp-3 flex-grow">
                                {{ Str::limit(strip_tags($project->description), 120) }}
                            </p>

                            <div class="flex flex-wrap gap-2 mb-6 mt-auto">
                                @foreach ($project->technologies as $tech)
                                    <span
                                        class="text-xs px-2 py-1 rounded bg-[#f2f2f2] dark:bg-[#383848] text-[#555] dark:text-[#ddd] flex items-center gap-1">
                                        @if ($tech->icon)
                                            <i class="{{ $tech->icon }}"></i>
                                        @endif
                                        {{ $tech->name }}
                                    </span>
                                @endforeach
                            </div>

                            <div
                                class="flex justify-between items-center border-t border-[#e1e1e1] dark:border-[#383848] pt-4">
                                <div class="flex space-x-3">
                                    @if ($project->github_url)
                                        <a href="{{ $project->github_url }}" target="_blank"
                                            class="text-[#999] hover:text-[#222] dark:hover:text-[#ddd] transition-colors"
                                            title="Source Code">
                                            <i class="fab fa-github text-lg"></i>
                                        </a>
                                    @endif
                                    @if ($project->demo_url)
                                        <a href="{{ $project->demo_url }}" target="_blank"
                                            class="text-[#999] hover:text-primary transition-colors" title="Live Demo">
                                            <i class="fas fa-external-link-alt text-lg"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-[#999]">No projects added yet.</div>
                @endforelse
            </div>

            @if ($user->projects->count() > 0)
                <div class="mt-12 text-center reveal">
                    <x-button href="{{ route('projects.public.index') }}" variant="secondary">
                        View All Projects <i class="fas fa-arrow-right ml-2"></i>
                    </x-button>
                </div>
            @endif
        </div>
    </section>

    <!-- Certificates -->
    <section id="certificates"
        class="py-20 bg-[#f2f2f2] dark:bg-[#111] border-y border-[#e1e1e1] dark:border-[#383848] relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <h2 class="text-3xl font-bold font-serif text-[#222] dark:text-[#ddd] inline-block relative">
                    Certificates
                    <div class="absolute -bottom-2 left-1/4 w-1/2 h-1 bg-primary rounded"></div>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($user->certificates as $cert)
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
                            <p class="text-xs text-[#999] mb-4 flex-grow">{{ $cert->issue_date->format('M Y') }}</p>

                            @if ($cert->credential_url)
                                <a href="{{ $cert->credential_url }}" target="_blank"
                                    class="inline-flex items-center justify-center px-4 py-2 text-xs font-medium rounded bg-[#e1e1e1] dark:bg-[#383848] hover:bg-primary hover:text-white transition-colors mt-auto">
                                    Verify Credential &nearr;
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-[#999]">No certificates added yet.</div>
                @endforelse
            </div>

            @if ($user->certificates->count() > 0)
                <div class="mt-12 text-center reveal">
                    <x-button href="{{ route('certificates.public.index') }}" variant="secondary">
                        View All Certificates <i class="fas fa-arrow-right ml-2"></i>
                    </x-button>
                </div>
            @endif
        </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="py-20 relative z-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-card class="text-center reveal">
                <h2 class="text-3xl md:text-5xl font-bold font-serif mb-6 text-[#222] dark:text-[#ddd] inline-block">Let's
                    Work Together</h2>
                <p class="text-[#555] dark:text-[#a4a4a4] mb-8 max-w-2xl mx-auto">
                    I'm currently open for new opportunities. Whether you have a question or just want to say hi, I'll try
                    my best to get back to you!
                </p>

                <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mb-8">
                    @if ($user->profile && $user->profile->phone)
                        <div class="flex items-center gap-2 text-[#555] dark:text-[#ddd]">
                            <i class="fas fa-phone text-primary"></i>
                            <span>{{ $user->profile->phone }}</span>
                        </div>
                        <span class="hidden sm:block text-[#e1e1e1] dark:text-[#383848]">|</span>
                    @endif

                    <div class="flex items-center gap-2 text-[#555] dark:text-[#ddd]">
                        <i class="fas fa-envelope text-primary"></i>
                        <span>{{ $user->email }}</span>
                    </div>
                </div>

                <x-button href="mailto:{{ $user->email }}">
                    Say Hello
                </x-button>
            </x-card>
        </div>
    </section>

@endsection
