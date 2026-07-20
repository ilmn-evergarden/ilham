@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout title="Edit Project Image">
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('projects.images.index', $project) }}"
               class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition">
                ← Gallery
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Gambar — <span class="text-indigo-600 dark:text-indigo-400">{{ $project->title }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

                <form method="POST" action="{{ route('images.update', $image) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">

                        {{-- Current image preview --}}
                        <div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gambar saat ini:</p>
                            <img id="img-preview"
                                 src="{{ Storage::url($image->image) }}"
                                 alt="{{ $image->caption ?? 'Image' }}"
                                 class="w-full max-h-56 object-contain rounded-md border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900">
                        </div>

                        {{-- Replace image --}}
                        <div>
                            <x-input-label for="image" :value="__('Ganti Gambar (opsional)')" />
                            <input
                                id="image" name="image" type="file"
                                accept="image/jpg,image/jpeg,image/png,image/webp"
                                class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                       file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0
                                       file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700
                                       hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400"
                                onchange="previewImg(this)"
                            >
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPG, PNG, WebP. Maks 2 MB. Kosongkan jika tidak ingin mengubah.</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        {{-- Caption --}}
                        <div>
                            <x-input-label for="caption" :value="__('Caption (opsional)')" />
                            <x-text-input id="caption" name="caption" type="text"
                                class="mt-1 block w-full"
                                :value="old('caption', $image->caption)"
                                placeholder="Deskripsi singkat gambar ini" />
                            <x-input-error :messages="$errors->get('caption')" class="mt-2" />
                        </div>

                        {{-- Sort order --}}
                        <div>
                            <x-input-label for="sort_order" :value="__('Urutan Tampil')" />
                            <x-text-input id="sort_order" name="sort_order" type="number"
                                class="mt-1 block w-full"
                                :value="old('sort_order', $image->sort_order)"
                                min="0" placeholder="0" />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Angka lebih kecil ditampilkan lebih dulu.</p>
                            <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('projects.images.index', $project) }}"
                               class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition">
                                Batal
                            </a>
                            <x-primary-button type="submit">Simpan Perubahan</x-primary-button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImg(input) {
            if (input.files && input.files[0]) {
                var reader  = new FileReader();
                var preview = document.getElementById('img-preview');
                reader.onload = function (e) { preview.src = e.target.result; };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
</x-app-layout>
