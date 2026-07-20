@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout title="Projects">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Projects') }}
            </h2>
            <a href="{{ route('projects.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition">
                + {{ __('Tambah Project') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- ── Flash Messages ──────────────────────────────────────────── --}}
            @if (session('status') === 'project-created')
                <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg text-sm text-green-700 dark:text-green-400 font-medium">
                    Project berhasil ditambahkan.
                </div>
            @elseif (session('status') === 'project-updated')
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg text-sm text-blue-700 dark:text-blue-400 font-medium">
                    Project berhasil diperbarui.
                </div>
            @elseif (session('status') === 'project-deleted')
                <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg text-sm text-red-700 dark:text-red-400 font-medium">
                    Project berhasil dihapus.
                </div>
            @endif

            {{-- ── Search & Filters ─────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-4">
                <form method="GET" action="{{ route('projects.index') }}" class="flex flex-col sm:flex-row gap-3 flex-wrap">
                    {{-- Search --}}
                    <div class="flex-1 min-w-[180px]">
                        <x-text-input name="search" type="search" class="w-full"
                            placeholder="Cari judul project..." :value="request('search')" />
                    </div>

                    {{-- Status filter --}}
                    <div class="sm:w-44">
                        <select name="status"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm">
                            <option value="">Semua Status</option>
                            @foreach ($statuses as $s)
                                <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Featured filter --}}
                    <div class="sm:w-40">
                        <select name="featured"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm">
                            <option value="">Semua</option>
                            <option value="1" @selected(request('featured') === '1')>Featured</option>
                            <option value="0" @selected(request('featured') === '0')>Tidak Featured</option>
                        </select>
                    </div>

                    <x-primary-button type="submit">Filter</x-primary-button>

                    @if (request('search') || request('status') || request()->filled('featured'))
                        <a href="{{ route('projects.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-md transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- ── Table ───────────────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                @if ($projects->isEmpty())
                    <div class="p-12 text-center text-gray-500 dark:text-gray-400">
                        <p class="text-lg">Belum ada project.</p>
                        <a href="{{ route('projects.create') }}"
                           class="mt-2 inline-block text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                            Tambah project pertama kamu →
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
                                    <th class="px-4 py-3 w-24">Featured</th>
                                    <th class="px-4 py-3">Technologies</th>
                                    <th class="px-4 py-3 w-28 whitespace-nowrap">Dibuat</th>
                                    <th class="px-4 py-3 w-28 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach ($projects as $project)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition align-top">
                                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400 pt-4">
                                            {{ ($projects->currentPage() - 1) * $projects->perPage() + $loop->iteration }}
                                        </td>

                                        {{-- Thumbnail --}}
                                        <td class="px-4 py-3">
                                            @if ($project->thumbnail)
                                                <img src="{{ Storage::url($project->thumbnail) }}"
                                                     alt="{{ $project->title }}"
                                                     class="w-14 h-14 object-cover rounded-md border border-gray-200 dark:border-gray-600">
                                            @else
                                                <div class="w-14 h-14 rounded-md bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 text-xs">
                                                    N/A
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Title & slug --}}
                                        <td class="px-4 py-3">
                                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $project->title }}</p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $project->slug }}</p>
                                        </td>

                                        {{-- Status badge --}}
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium whitespace-nowrap {{ \App\Models\Project::statusColour($project->status) }}">
                                                {{ $project->status }}
                                            </span>
                                        </td>

                                        {{-- Featured badge --}}
                                        <td class="px-4 py-3">
                                            @if ($project->featured)
                                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400">
                                                    ★ Featured
                                                </span>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-600 text-xs">—</span>
                                            @endif
                                        </td>

                                        {{-- Technology badges --}}
                                        <td class="px-4 py-3">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach ($project->technologies as $tech)
                                                    <span class="px-1.5 py-0.5 rounded text-xs font-medium bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 whitespace-nowrap">
                                                        {{ $tech->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>

                                        {{-- Created at --}}
                                        <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                            {{ $project->created_at->format('d M Y') }}
                                        </td>

                                        {{-- Actions --}}
                                        <td class="px-4 py-3 text-center">
                                            <div class="inline-flex items-center gap-1 flex-wrap justify-center">
                                                <a href="{{ route('projects.images.index', $project) }}"
                                                   class="px-2.5 py-1 text-xs font-medium rounded bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-400 hover:bg-violet-200 transition whitespace-nowrap">
                                                    🖼 Gallery
                                                </a>
                                                <a href="{{ route('projects.edit', $project) }}"
                                                   class="px-2.5 py-1 text-xs font-medium rounded bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 hover:bg-amber-200 transition">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('projects.destroy', $project) }}"
                                                      onsubmit="return confirm('Hapus project \'{{ addslashes($project->title) }}\'? Thumbnail dan semua relasi teknologi akan ikut dihapus.')">
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

                    @if ($projects->hasPages())
                        <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">
                            {{ $projects->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
