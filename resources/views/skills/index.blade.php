@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout title="Skills">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Skills') }}
            </h2>
            <a href="{{ route('skills.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition">
                + {{ __('Tambah Skill') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- ── Flash Messages ─────────────────────────────────────────── --}}
            @if (session('status') === 'skill-created')
                <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg text-sm text-green-700 dark:text-green-400 font-medium">
                    Skill berhasil ditambahkan.
                </div>
            @elseif (session('status') === 'skill-updated')
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg text-sm text-blue-700 dark:text-blue-400 font-medium">
                    Skill berhasil diperbarui.
                </div>
            @elseif (session('status') === 'skill-deleted')
                <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg text-sm text-red-700 dark:text-red-400 font-medium">
                    Skill berhasil dihapus.
                </div>
            @endif

            {{-- ── Search & Filter ─────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-4">
                <form method="GET" action="{{ route('skills.index') }}" class="flex flex-col sm:flex-row gap-3">
                    {{-- Search --}}
                    <div class="flex-1">
                        <x-text-input
                            name="search"
                            type="search"
                            class="w-full"
                            placeholder="Cari nama skill..."
                            :value="request('search')"
                        />
                    </div>

                    {{-- Category Filter --}}
                    <div class="sm:w-48">
                        <select name="category"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" @selected(request('category') === $cat)>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <x-primary-button type="submit">
                        Filter
                    </x-primary-button>

                    @if (request('search') || request('category'))
                        <a href="{{ route('skills.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-md transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- ── Skills Table ─────────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                @if ($skills->isEmpty())
                    <div class="p-12 text-center text-gray-500 dark:text-gray-400">
                        <p class="text-lg">Belum ada skill.</p>
                        <a href="{{ route('skills.create') }}" class="mt-2 inline-block text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                            Tambah skill pertama kamu →
                        </a>
                    </div>
                @else
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wide">
                            <tr>
                                <th class="px-4 py-3 w-10">#</th>
                                <th class="px-4 py-3">Nama Skill</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3 min-w-[200px]">Level</th>
                                <th class="px-4 py-3 w-16 text-center">Icon</th>
                                <th class="px-4 py-3 w-28 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($skills as $skill)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    {{-- Row number continues across pages --}}
                                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                        {{ ($skills->currentPage() - 1) * $skills->perPage() + $loop->iteration }}
                                    </td>

                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">
                                        {{ $skill->name }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300">
                                            {{ $skill->category }}
                                        </span>
                                    </td>

                                    {{-- Progress Bar --}}
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 bg-gray-200 dark:bg-gray-600 rounded-full h-2 overflow-hidden">
                                                <div class="bg-indigo-500 h-2 rounded-full transition-all"
                                                     style="width: {{ $skill->level }}%"></div>
                                            </div>
                                            <span class="text-xs text-gray-600 dark:text-gray-400 w-8 text-right shrink-0">
                                                {{ $skill->level }}%
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Icon --}}
                                    <td class="px-4 py-3 text-center">
                                        @if ($skill->icon)
                                            <img src="{{ Storage::url($skill->icon) }}"
                                                 alt="{{ $skill->name }}"
                                                 class="w-8 h-8 object-contain mx-auto rounded">
                                        @else
                                            <span class="text-gray-300 dark:text-gray-600 text-lg">—</span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-4 py-3 text-center">
                                        <div class="inline-flex items-center gap-1">
                                            <a href="{{ route('skills.edit', $skill) }}"
                                               class="px-2.5 py-1 text-xs font-medium rounded bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-900/60 transition">
                                                Edit
                                            </a>

                                            {{-- Delete with confirmation --}}
                                            <form method="POST"
                                                  action="{{ route('skills.destroy', $skill) }}"
                                                  onsubmit="return confirm('Hapus skill \'{{ addslashes($skill->name) }}\'? Tindakan ini tidak dapat dibatalkan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-2.5 py-1 text-xs font-medium rounded bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/60 transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    @if ($skills->hasPages())
                        <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">
                            {{ $skills->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
