@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout title="Certificates">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Certificates') }}
            </h2>
            <a href="{{ route('certificates.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition">
                + {{ __('Tambah Sertifikat') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- ── Flash Messages ──────────────────────────────────────────── --}}
            @if (session('status') === 'certificate-created')
                <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg text-sm text-green-700 dark:text-green-400 font-medium">
                    Sertifikat berhasil ditambahkan.
                </div>
            @elseif (session('status') === 'certificate-updated')
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg text-sm text-blue-700 dark:text-blue-400 font-medium">
                    Sertifikat berhasil diperbarui.
                </div>
            @elseif (session('status') === 'certificate-deleted')
                <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg text-sm text-red-700 dark:text-red-400 font-medium">
                    Sertifikat berhasil dihapus.
                </div>
            @endif

            {{-- ── Search & Sort ───────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-4">
                <form method="GET" action="{{ route('certificates.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <x-text-input name="search" type="search" class="w-full"
                            placeholder="Cari judul atau penerbit..."
                            :value="request('search')" />
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
                        <a href="{{ route('certificates.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-md transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- ── Table ───────────────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                @if ($certificates->isEmpty())
                    <div class="p-12 text-center text-gray-500 dark:text-gray-400">
                        <p class="text-lg">Belum ada sertifikat.</p>
                        <a href="{{ route('certificates.create') }}"
                           class="mt-2 inline-block text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                            Tambah sertifikat pertama →
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left whitespace-nowrap">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wide">
                                <tr>
                                    <th class="px-4 py-3 w-10">#</th>
                                    <th class="px-4 py-3 w-24">Preview</th>
                                    <th class="px-4 py-3">Judul</th>
                                    <th class="px-4 py-3">Penerbit</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Tanggal Terbit</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Masa Berlaku</th>
                                    <th class="px-4 py-3">Credential</th>
                                    <th class="px-4 py-3 w-28 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach ($certificates as $cert)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition align-middle">
                                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                            {{ ($certificates->currentPage() - 1) * $certificates->perPage() + $loop->iteration }}
                                        </td>

                                        {{-- Preview --}}
                                        <td class="px-4 py-3">
                                            @if ($cert->image)
                                                <img src="{{ Storage::url($cert->image) }}"
                                                     alt="{{ $cert->title }}"
                                                     class="w-16 h-12 object-cover rounded-md border border-gray-200 dark:border-gray-600 cursor-pointer"
                                                     onclick="openLightbox('{{ Storage::url($cert->image) }}')">
                                            @else
                                                <div class="w-16 h-12 rounded-md bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 dark:text-gray-500 text-xs">
                                                    N/A
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Title --}}
                                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100 max-w-xs">
                                            {{ $cert->title }}
                                        </td>

                                        {{-- Issuer --}}
                                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                            {{ $cert->issuer ?? '—' }}
                                        </td>

                                        {{-- Issue date --}}
                                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400 whitespace-nowrap tabular-nums">
                                            {{ $cert->issue_date?->format('d M Y') ?? '—' }}
                                        </td>

                                        {{-- Expiration --}}
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if ($cert->isLifetime())
                                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400">
                                                    Lifetime
                                                </span>
                                            @elseif ($cert->isExpired())
                                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400 tabular-nums">
                                                    {{ $cert->expiration_date->format('d M Y') }}
                                                    <span class="ml-0.5 opacity-70">(kedaluwarsa)</span>
                                                </span>
                                            @else
                                                <span class="text-gray-600 dark:text-gray-400 text-xs tabular-nums">
                                                    {{ $cert->expiration_date->format('d M Y') }}
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Credential --}}
                                        <td class="px-4 py-3">
                                            @if ($cert->credential_url)
                                                <a href="{{ $cert->credential_url }}" target="_blank" rel="noopener"
                                                   class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium rounded bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-400 hover:bg-indigo-200 transition">
                                                    🔗 Lihat Credential
                                                </a>
                                            @elseif ($cert->credential_id)
                                                <span class="text-xs text-gray-500 dark:text-gray-400 font-mono">{{ $cert->credential_id }}</span>
                                            @else
                                                <span class="text-gray-300 dark:text-gray-600 text-xs">—</span>
                                            @endif
                                        </td>

                                        {{-- Actions --}}
                                        <td class="px-4 py-3 text-center">
                                            <div class="inline-flex items-center gap-2 justify-center">
                                                <a href="{{ route('certificates.edit', $cert) }}"
                                                   class="text-xs font-medium text-slate-500 hover:text-amber-600 dark:text-slate-400 dark:hover:text-amber-400 transition-colors">
                                                    Edit
                                                </a>
                                                <span class="text-slate-300 dark:text-slate-700">|</span>
                                                <form method="POST" action="{{ route('certificates.destroy', $cert) }}"
                                                      onsubmit="return confirm('Hapus certificate \'{{ addslashes($cert->title) }}\'?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-xs font-medium text-slate-500 hover:text-red-600 dark:text-slate-400 dark:hover:text-red-400 transition-colors">
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

                    @if ($certificates->hasPages())
                        <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">
                            {{ $certificates->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>

    {{-- Simple lightbox --}}
    <div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80"
         onclick="closeLightbox()">
        <img id="lightbox-img" src="" alt="Preview"
             class="max-w-4xl max-h-screen object-contain rounded shadow-xl">
    </div>

    @push('scripts')
    <script>
        function openLightbox(src) {
            document.getElementById('lightbox-img').src = src;
            document.getElementById('lightbox').classList.remove('hidden');
            document.getElementById('lightbox').classList.add('flex');
        }
        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.getElementById('lightbox').classList.remove('flex');
        }
    </script>
    @endpush
</x-app-layout>
