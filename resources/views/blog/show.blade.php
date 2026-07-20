@extends('layouts.portfolio')

@section('seo')
    <x-seo title="{{ $blog->title }} | Blog" description="{{ Str::limit(strip_tags($blog->excerpt), 160) }}" image="{{ $blog->thumbnail }}" />
    {{-- Markdown → HTML rendering --}}
    <link rel="stylesheet" href="https://unpkg.com/@tailwindcss/typography@0.5.13/src/index.css">
@endsection

@section('content')
<section class="py-24 relative min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row gap-10 items-start">

        {{-- ── Main article ─────────────────────────────────────────── --}}
        <article class="flex-1 min-w-0 w-full reveal">

            {{-- Breadcrumb --}}
            <nav class="text-xs text-[#999] dark:text-[#a4a4a4] mb-8 flex items-center gap-2 font-medium">
                <a href="{{ route('blog.index') }}" class="hover:text-primary transition-colors">Blog</a>
                <i class="fas fa-chevron-right text-[10px]"></i>
                <span class="text-[#555] dark:text-[#ddd] truncate">{{ $blog->title }}</span>
            </nav>

            {{-- Thumbnail --}}
            @if ($blog->thumbnail)
                <div class="rounded-lg overflow-hidden mb-10 shadow-lg">
                    <img src="{{ Storage::url($blog->thumbnail) }}"
                         alt="{{ $blog->title }}"
                         class="w-full h-auto max-h-[500px] object-cover">
                </div>
            @endif

            {{-- Meta --}}
            <div class="flex flex-wrap items-center gap-4 mb-6 text-sm text-[#999] dark:text-[#a4a4a4]">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                        {{ substr($blog->user->name, 0, 1) }}
                    </div>
                    <span class="font-medium text-[#222] dark:text-[#ddd]">{{ $blog->user->name }}</span>
                </div>
                <span>·</span>
                <time datetime="{{ $blog->published_at?->toDateString() }}" class="flex items-center gap-1.5">
                    <i class="far fa-calendar-alt"></i>
                    {{ $blog->published_at?->translatedFormat('d M Y') }}
                </time>
            </div>

            {{-- Title --}}
            <h1 class="text-3xl md:text-5xl font-bold text-[#222] dark:text-[#ddd] font-serif leading-tight mb-8">
                {{ $blog->title }}
            </h1>

            {{-- Excerpt --}}
            @if($blog->excerpt)
            <p class="text-lg md:text-xl text-[#555] dark:text-[#a4a4a4] leading-relaxed border-l-4 border-primary pl-6 mb-10 italic">
                {{ $blog->excerpt }}
            </p>
            @endif

            {{-- Content — rendered as HTML (EasyMDE stores Markdown) --}}
            <div class="prose prose-lg dark:prose-invert max-w-none text-[#555] dark:text-[#a4a4a4]">
                {!! nl2br(e($blog->content)) !!}
            </div>

        </article>

        {{-- ── Sidebar: recent posts ────────────────────────────────── --}}
        @if ($recent->isNotEmpty())
            <aside class="w-full lg:w-80 shrink-0 reveal">
                <x-card class="sticky top-28">
                    <h3 class="text-lg font-bold text-[#222] dark:text-[#ddd] font-serif mb-6 flex items-center gap-2">
                        <i class="fas fa-history text-primary"></i> Artikel Terbaru
                    </h3>
                    <ul class="space-y-6">
                        @foreach ($recent as $post)
                            <li class="flex items-start gap-4 group">
                                @if ($post->thumbnail)
                                    <div class="w-20 h-16 rounded overflow-hidden shrink-0 border border-[#e1e1e1] dark:border-[#383848]">
                                        <img src="{{ Storage::url($post->thumbnail) }}"
                                             alt="{{ $post->title }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('blog.show', $post->slug) }}"
                                       class="text-sm font-bold font-serif text-[#222] dark:text-[#ddd] group-hover:text-primary transition-colors leading-snug line-clamp-2 mb-1">
                                        {{ $post->title }}
                                    </a>
                                    <p class="text-xs text-[#999] dark:text-[#a4a4a4]">
                                        {{ $post->published_at?->translatedFormat('d M Y') }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </x-card>
            </aside>
        @endif

    </div>
</section>
@endsection
