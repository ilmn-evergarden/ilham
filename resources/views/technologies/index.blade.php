@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout title="Technologies">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Technologies') }}
            </h2>
            <a href="{{ route('technologies.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition">
                + {{ __('Tambah Technology') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- ── Flash Messages ────────────────────────────────────────── --}}
            @if (session('status') === 'technology-created')
                <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg text-sm text-green-700 dark:text-green-400 font-medium">
                    Technology berhasil ditambahkan.
                </div>
            @elseif (session('status') === 'technology-updated')
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg text-sm text-blue-700 dark:text-blue-400 font-medium">
                    Technology berhasil diperbarui.
                </div>
            @elseif (session('status') === 'technology-deleted')
                <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg text-sm text-red-700 dark:text-red-400 font-medium">
                    Technology berhasil dihapus.
                </div>
            @elseif (session('error'))
                <div class="p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-lg text-sm text-amber-700 dark:text-amber-400 font-medium">
                    {{ session('error') }}
                </div>
            @endif

            {{-- ── Search & Sort ─────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-4">
                <form method="GET" action="{{ route('technologies.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <x-text-input name="search" type="search" class="w-full"
                            placeholder="Cari nama technology..." :value="request('search')" />
                    </div>
                    <div class="sm:w-44">
                        <select name="sort"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm">
                            <option value="asc"  @selected($sort === 'asc')>Nama A – Z</option>
                            <option value="desc" @selected($sort === 'desc')>Nama Z – A</option>
                        </select>
                    </div>
                    <x-primary-button type="submit">Filter</x-primary-button>
                    @if (request('search') || request('sort', 'asc') !== 'asc')
                        <a href="{{ route('technologies.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-md transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- ── Table ─────────────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                @if ($technologies->isEmpty())
                    <div class="p-12 text-center text-gray-500 dark:text-gray-400">
                        <p class="text-lg">Belum ada data technology.</p>
                        <a href="{{ route('technologies.create') }}"
                           class="mt-2 inline-block text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                            Tambah technology pertama →
                        </a>
                    </div>
                @else
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wide">
                            <tr>
                                <th class="px-4 py-3 w-10">#</th>
                                <th class="px-4 py-3 w-16 text-center">Icon</th>
                                <th class="px-4 py-3">Nama Technology</th>
                                <th class="px-4 py-3 w-32 text-center">Jumlah Project</th>
                                <th class="px-4 py-3 w-28 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($technologies as $tech)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                        {{ ($technologies->currentPage() - 1) * $technologies->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if ($tech->icon)
                                            <img src="{{ Storage::url($tech->icon) }}" alt="{{ $tech->name }}"
                                                 class="w-8 h-8 object-contain mx-auto">
                                        @else
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 text-xs font-bold mx-auto">
                                                {{ strtoupper(substr($tech->name, 0, 2)) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">
                                        {{ $tech->name }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-flex items-center justify-center min-w-[2rem] px-2 py-0.5 rounded-full text-xs font-medium
                                            {{ $tech->projects_count > 0
                                                ? 'bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300'
                                                : 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400' }}">
                                            {{ $tech->projects_count }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="inline-flex items-center gap-1">
                                            <a href="{{ route('technologies.edit', $tech) }}"
                                               class="px-2.5 py-1 text-xs font-medium rounded bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 hover:bg-amber-200 transition">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('technologies.destroy', $tech) }}"
                                                  onsubmit="return confirm('Hapus technology \'{{ addslashes($tech->name) }}\'?')">
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
                    @if ($technologies->hasPages())
                        <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">
                            {{ $technologies->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
