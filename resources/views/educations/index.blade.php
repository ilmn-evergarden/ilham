<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Education') }}
            </h2>
            <a href="{{ route('educations.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition">
                + {{ __('Tambah Pendidikan') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- ── Flash Messages ────────────────────────────────────────── --}}
            @if (session('status') === 'education-created')
                <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg text-sm text-green-700 dark:text-green-400 font-medium">
                    Data pendidikan berhasil ditambahkan.
                </div>
            @elseif (session('status') === 'education-updated')
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg text-sm text-blue-700 dark:text-blue-400 font-medium">
                    Data pendidikan berhasil diperbarui.
                </div>
            @elseif (session('status') === 'education-deleted')
                <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg text-sm text-red-700 dark:text-red-400 font-medium">
                    Data pendidikan berhasil dihapus.
                </div>
            @endif

            {{-- ── Search & Sort ─────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-4">
                <form method="GET" action="{{ route('educations.index') }}" class="flex flex-col sm:flex-row gap-3">
                    {{-- Search --}}
                    <div class="flex-1">
                        <x-text-input
                            name="search"
                            type="search"
                            class="w-full"
                            placeholder="Cari nama sekolah atau universitas..."
                            :value="request('search')"
                        />
                    </div>

                    {{-- Sort --}}
                    <div class="sm:w-52">
                        <select name="sort"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm">
                            <option value="desc" @selected($sort === 'desc')>Terbaru ke Terlama</option>
                            <option value="asc"  @selected($sort === 'asc')>Terlama ke Terbaru</option>
                        </select>
                    </div>

                    <x-primary-button type="submit">Filter</x-primary-button>

                    @if (request('search') || request('sort', 'desc') !== 'desc')
                        <a href="{{ route('educations.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-md transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- ── Education Table ──────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                @if ($educations->isEmpty())
                    <div class="p-12 text-center text-gray-500 dark:text-gray-400">
                        <p class="text-lg">Belum ada data pendidikan.</p>
                        <a href="{{ route('educations.create') }}"
                           class="mt-2 inline-block text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                            Tambah pendidikan pertama kamu →
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wide">
                                <tr>
                                    <th class="px-4 py-3 w-10">#</th>
                                    <th class="px-4 py-3">Jenjang</th>
                                    <th class="px-4 py-3">Nama Sekolah / Universitas</th>
                                    <th class="px-4 py-3">Jurusan</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Tahun Masuk</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Tahun Lulus</th>
                                    <th class="px-4 py-3 w-28 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach ($educations as $edu)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                            {{ ($educations->currentPage() - 1) * $educations->perPage() + $loop->iteration }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-violet-100 dark:bg-violet-900/40 text-violet-700 dark:text-violet-300 whitespace-nowrap">
                                                {{ $edu->level }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">
                                            {{ $edu->school_name }}
                                        </td>

                                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                            {{ $edu->major ?? '—' }}
                                        </td>

                                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400 tabular-nums">
                                            {{ $edu->start_year }}
                                        </td>

                                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400 tabular-nums">
                                            {{ $edu->end_year ?? 'Sekarang' }}
                                        </td>

                                        <td class="px-4 py-3 text-center">
                                            <div class="inline-flex items-center gap-1">
                                                <a href="{{ route('educations.edit', $edu) }}"
                                                   class="px-2.5 py-1 text-xs font-medium rounded bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-900/60 transition">
                                                    Edit
                                                </a>
                                                <form method="POST"
                                                      action="{{ route('educations.destroy', $edu) }}"
                                                      onsubmit="return confirm('Hapus data pendidikan \'{{ addslashes($edu->school_name) }}\'? Tindakan ini tidak dapat dibatalkan.')">
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
                    </div>

                    {{-- Pagination --}}
                    @if ($educations->hasPages())
                        <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">
                            {{ $educations->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
