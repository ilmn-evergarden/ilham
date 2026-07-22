<x-app-layout title="Experiences">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Experience') }}
            </h2>
            <a href="{{ route('experiences.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition">
                + {{ __('Tambah Pengalaman') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- ── Flash Messages ────────────────────────────────────────── --}}
            @if (session('status') === 'experience-created')
                <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg text-sm text-green-700 dark:text-green-400 font-medium">
                    Data pengalaman berhasil ditambahkan.
                </div>
            @elseif (session('status') === 'experience-updated')
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg text-sm text-blue-700 dark:text-blue-400 font-medium">
                    Data pengalaman berhasil diperbarui.
                </div>
            @elseif (session('status') === 'experience-deleted')
                <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg text-sm text-red-700 dark:text-red-400 font-medium">
                    Data pengalaman berhasil dihapus.
                </div>
            @endif

            {{-- ── Search & Sort ─────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-4">
                <form method="GET" action="{{ route('experiences.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <x-text-input
                            name="search"
                            type="search"
                            class="w-full"
                            placeholder="Cari perusahaan atau posisi..."
                            :value="request('search')"
                        />
                    </div>

                    <div class="sm:w-52">
                        <select name="sort"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm">
                            <option value="desc" @selected($sort === 'desc')>Terbaru ke Terlama</option>
                            <option value="asc"  @selected($sort === 'asc')>Terlama ke Terbaru</option>
                        </select>
                    </div>

                    <x-primary-button type="submit">Filter</x-primary-button>

                    @if (request('search') || request('sort', 'desc') !== 'desc')
                        <a href="{{ route('experiences.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-md transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- ── Table ─────────────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                @if ($experiences->isEmpty())
                    <div class="p-12 text-center text-gray-500 dark:text-gray-400">
                        <p class="text-lg">Belum ada data pengalaman.</p>
                        <a href="{{ route('experiences.create') }}"
                           class="mt-2 inline-block text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                            Tambah pengalaman pertama kamu →
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left whitespace-nowrap">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wide">
                                <tr>
                                    <th class="px-4 py-3 w-10">#</th>
                                    <th class="px-4 py-3">Perusahaan / Instansi</th>
                                    <th class="px-4 py-3">Posisi</th>
                                    <th class="px-4 py-3">Jenis</th>
                                    <th class="px-4 py-3">Periode</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 w-28 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach ($experiences as $exp)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                            {{ ($experiences->currentPage() - 1) * $experiences->perPage() + $loop->iteration }}
                                        </td>

                                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">
                                            {{ $exp->company }}
                                        </td>

                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                            {{ $exp->position }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-sky-100 dark:bg-sky-900/40 text-sky-700 dark:text-sky-300 whitespace-nowrap">
                                                {{ $exp->employment_type }}
                                            </span>
                                        </td>

                                        {{-- Period --}}
                                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400 whitespace-nowrap tabular-nums text-xs">
                                            {{ $exp->start_date->translatedFormat('M Y') }}
                                            –
                                            {{ $exp->is_current ? 'Sekarang' : ($exp->end_date ? $exp->end_date->translatedFormat('M Y') : '—') }}
                                        </td>

                                        {{-- Status badge --}}
                                        <td class="px-4 py-3">
                                            @if ($exp->is_current)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>
                                                    Masih Bekerja
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 inline-block"></span>
                                                    Selesai
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-3 text-center">
                                            <div class="inline-flex items-center gap-1">
                                                <a href="{{ route('experiences.edit', $exp) }}"
                                                   class="px-2.5 py-1 text-xs font-medium rounded bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-900/60 transition">
                                                    Edit
                                                </a>
                                                <form method="POST"
                                                      action="{{ route('experiences.destroy', $exp) }}"
                                                      onsubmit="return confirm('Hapus pengalaman di \'{{ addslashes($exp->company) }}\'? Tindakan ini tidak dapat dibatalkan.')">
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

                    @if ($experiences->hasPages())
                        <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">
                            {{ $experiences->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
