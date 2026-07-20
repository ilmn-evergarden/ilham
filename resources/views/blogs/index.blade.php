@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout title="Blogs">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Blog') }}
            </h2>
            <a href="{{ route('blogs.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition">
                + {{ __('Tulis Artikel') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- ── Flash Messages ──────────────────────────────────────────── --}}
            @if (session('status') === 'blog-created')
                <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg text-sm text-green-700 dark:text-green-400 font-medium">
                    Artikel berhasil ditambahkan.
                </div>
            @elseif (session('status') === 'blog-updated')
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg text-sm text-blue-700 dark:text-blue-400 font-medium">
                    Artikel berhasil diperbarui.
                </div>
            @elseif (session('status') === 'blog-deleted')
                <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg text-sm text-red-700 dark:text-red-400 font-medium">
                    Artikel berhasil dihapus.
                </div>
            @endif

            {{-- ── Search & Filter ────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-4">
                <form method="GET" action="{{ route('blogs.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <x-text-input name="search" type="search" class="w-full"
                            placeholder="Cari judul artikel..."
                            :value="request('search')" />
                    </div>
                    <div class="sm:w-44">
                        <select name="status"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm">
                            <option value="">Semua Status</option>
                            <option value="Published" @selected(request('status') === 'Published')>Published</option>
                            <option value="Draft"     @selected(request('status') === 'Draft')>Draft</option>
                        </select>
                    </div>
                    <x-primary-button type="submit">Filter</x-primary-button>
                    @if (request('search') || request('status'))
                        <a href="{{ route('blogs.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-md transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- ── Table ───────────────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                @if ($blogs->isEmpty())
                    <div class="p-12 text-center text-gray-500 dark:text-gray-400">
                        <p class="text-lg">Belum ada artikel.</p>
                        <a href="{{ route('blogs.create') }}"
                           class="mt-2 inline-block text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                            Tulis artikel pertama →
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wide">
                                <tr>
                                    <th class="px-4 py-3 w-10">#</th>
                                    <th class="px-4 py-3 w-20">Thumb</th>
                                    <th class="px-4 py-3">Judul</th>
                                    <th class="px-4 py-3 w-28">Status</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Tanggal Publish</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Diperbarui</th>
                                    <th class="px-4 py-3 w-28 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach ($blogs as $blog)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition align-middle">
                                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                            {{ ($blogs->currentPage() - 1) * $blogs->perPage() + $loop->iteration }}
                                        </td>

                                        {{-- Thumbnail --}}
                                        <td class="px-4 py-3">
                                            @if ($blog->thumbnail)
                                                <img src="{{ Storage::url($blog->thumbnail) }}"
                                                     alt="{{ $blog->title }}"
                                                     class="w-14 h-10 object-cover rounded border border-gray-200 dark:border-gray-600">
                                            @else
                                                <div class="w-14 h-10 rounded bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 text-xs">
                                                    N/A
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Title & slug --}}
                                        <td class="px-4 py-3">
                                            <p class="font-medium text-gray-900 dark:text-gray-100 max-w-xs truncate">{{ $blog->title }}</p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 font-mono truncate max-w-xs">/blog/{{ $blog->slug }}</p>
                                        </td>

                                        {{-- Status badge --}}
                                        <td class="px-4 py-3">
                                            @if ($blog->status === 'Published')
                                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400">
                                                    Published
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                                                    Draft
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Published at --}}
                                        <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap tabular-nums">
                                            {{ $blog->published_at?->format('d M Y, H:i') ?? '—' }}
                                        </td>

                                        {{-- Updated at --}}
                                        <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap tabular-nums">
                                            {{ $blog->updated_at->format('d M Y') }}
                                        </td>

                                        {{-- Actions --}}
                                        <td class="px-4 py-3 text-center">
                                            <div class="inline-flex items-center gap-1">
                                                @if ($blog->status === 'Published')
                                                    <a href="{{ route('blog.show', $blog->slug) }}" target="_blank"
                                                       class="px-2.5 py-1 text-xs font-medium rounded bg-teal-100 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400 hover:bg-teal-200 transition">
                                                        View
                                                    </a>
                                                @endif
                                                <a href="{{ route('blogs.edit', $blog) }}"
                                                   class="px-2.5 py-1 text-xs font-medium rounded bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 hover:bg-amber-200 transition">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('blogs.destroy', $blog) }}"
                                                      onsubmit="return confirm('Hapus artikel \'{{ addslashes($blog->title) }}\'?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="px-2.5 py-1 text-xs font-medium rounded bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 hover:bg-red-200 transition">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($blogs->hasPages())
                        <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">
                            {{ $blogs->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
