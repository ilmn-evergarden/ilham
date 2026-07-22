@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout title="Project Images">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('projects.index') }}"
                   class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition">
                    ← Projects
                </a>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Gallery — <span class="text-indigo-600 dark:text-indigo-400">{{ $project->title }}</span>
                </h2>
            </div>
            <a href="{{ route('projects.images.create', $project) }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition">
                + Upload Gambar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- ── Flash ──────────────────────────────────────────────────── --}}
            @if (session('status') === 'images-uploaded')
                <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg text-sm text-green-700 dark:text-green-400 font-medium">
                    Gambar berhasil diunggah.
                </div>
            @elseif (session('status') === 'image-updated')
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg text-sm text-blue-700 dark:text-blue-400 font-medium">
                    Gambar berhasil diperbarui.
                </div>
            @elseif (session('status') === 'image-deleted')
                <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg text-sm text-red-700 dark:text-red-400 font-medium">
                    Gambar berhasil dihapus.
                </div>
            @endif

            {{-- ── Project info card ──────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-4 flex items-center gap-4">
                @if ($project->thumbnail)
                    <img src="{{ Storage::url($project->thumbnail) }}"
                         alt="{{ $project->title }}"
                         class="w-20 h-14 object-cover rounded-md border border-gray-200 dark:border-gray-600 shrink-0">
                @endif
                <div>
                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $project->title }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $project->slug }}</p>
                    <span class="mt-1 inline-block px-2 py-0.5 rounded-full text-xs font-medium {{ \App\Models\Project::statusColour($project->status) }}">
                        {{ $project->status }}
                    </span>
                </div>
                <div class="ml-auto text-sm text-gray-500 dark:text-gray-400">
                    <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $images->total() }}</span> gambar
                </div>
            </div>

            {{-- ── Images table ────────────────────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                @if ($images->isEmpty())
                    <div class="p-12 text-center text-gray-500 dark:text-gray-400">
                        <p class="text-lg">Belum ada gambar di gallery ini.</p>
                        <a href="{{ route('projects.images.create', $project) }}"
                           class="mt-2 inline-block text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                            Upload gambar pertama →
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left whitespace-nowrap">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wide">
                                <tr>
                                    <th class="px-4 py-3 w-10">#</th>
                                    <th class="px-4 py-3 w-28">Preview</th>
                                    <th class="px-4 py-3">Caption</th>
                                    <th class="px-4 py-3 w-24 text-center">Urutan</th>
                                    <th class="px-4 py-3 w-28 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach ($images as $image)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition align-middle">
                                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                            {{ ($images->currentPage() - 1) * $images->perPage() + $loop->iteration }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <img src="{{ Storage::url($image->image) }}"
                                                 alt="{{ $image->caption ?? 'Image' }}"
                                                 class="w-20 h-14 object-cover rounded-md border border-gray-200 dark:border-gray-600 cursor-pointer"
                                                 onclick="openLightbox('{{ Storage::url($image->image) }}')">
                                        </td>

                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                            {{ $image->caption ?? '—' }}
                                        </td>

                                        <td class="px-4 py-3 text-center tabular-nums text-gray-600 dark:text-gray-400">
                                            {{ $image->sort_order }}
                                        </td>

                                        <td class="px-4 py-3 text-center">
                                            <div class="inline-flex items-center gap-1">
                                                <a href="{{ route('images.edit', $image) }}"
                                                   class="px-2.5 py-1 text-xs font-medium rounded bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 hover:bg-amber-200 transition">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('images.destroy', $image) }}"
                                                      onsubmit="return confirm('Hapus gambar ini? Tindakan tidak dapat dibatalkan.')">
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

                    @if ($images->hasPages())
                        <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">
                            {{ $images->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>

    {{-- Simple lightbox overlay --}}
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
