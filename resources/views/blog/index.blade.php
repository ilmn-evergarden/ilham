@extends('layouts.portfolio')

@section('seo')
    <x-seo title="Blog" description="Artikel & catatan terbaru." />
@endsection

@section('content')
<section class="py-24 relative min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Page heading --}}
        <div class="text-center mb-16 reveal">
            <h1 class="text-4xl md:text-5xl font-bold font-serif text-[#222] dark:text-[#ddd] inline-block relative mb-4">
                Blog
                <div class="absolute -bottom-2 left-1/4 w-1/2 h-1 bg-primary rounded"></div>
            </h1>
            <p class="text-[#555] dark:text-[#a4a4a4] max-w-2xl mx-auto">Artikel & catatan terbaru.</p>
        </div>

        {{-- Article grid --}}
        @if ($blogs->isEmpty())
            <x-empty-state title="Belum ada artikel" message="Belum ada artikel yang dipublikasikan saat ini." icon="fas fa-newspaper" />
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @foreach ($blogs as $blog)
                    <x-card class="flex flex-col p-0 overflow-hidden group reveal hover:-translate-y-1 transition-transform">
                        {{-- Thumbnail --}}
                        <a href="{{ route('blog.show', $blog->slug) }}" class="block relative h-48 overflow-hidden">
                            @if ($blog->thumbnail)
                                <img src="{{ Storage::url($blog->thumbnail) }}"
                                     alt="{{ $blog->title }}"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full h-full bg-[#f2f2f2] dark:bg-[#383848] flex items-center justify-center text-[#999]">
                                    <i class="fas fa-image text-3xl"></i>
                                </div>
                            @endif
                        </a>

                        <div class="p-6 flex flex-col flex-1">
                            {{-- Meta --}}
                            <p class="text-xs text-[#999] dark:text-[#a4a4a4] mb-3 tabular-nums flex items-center gap-2">
                                <i class="far fa-calendar-alt"></i>
                                {{ $blog->published_at?->translatedFormat('d M Y') }}
                            </p>

                            {{-- Title --}}
                            <h2 class="text-lg font-bold font-serif text-[#222] dark:text-[#ddd] leading-snug mb-3">
                                <a href="{{ route('blog.show', $blog->slug) }}"
                                   class="hover:text-primary transition-colors">
                                    {{ $blog->title }}
                                </a>
                            </h2>

                            {{-- Excerpt --}}
                            <p class="text-sm text-[#555] dark:text-[#a4a4a4] leading-relaxed flex-1 mb-4">
                                {{ Str::limit($blog->excerpt, 100) }}
                            </p>

                            {{-- CTA --}}
                            <div class="mt-auto border-t border-[#e1e1e1] dark:border-[#383848] pt-4">
                                <a href="{{ route('blog.show', $blog->slug) }}"
                                   class="text-sm font-medium text-primary hover:text-primary-dark flex items-center gap-2 transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($blogs->hasPages())
                <div class="mt-10 flex justify-center">
                    {{ $blogs->links() }}
                </div>
            @endif
        @endif
    </div>
</section>
@endsection
