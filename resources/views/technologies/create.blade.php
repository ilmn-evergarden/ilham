<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('technologies.index') }}"
               class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition">
                ← Technologies
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tambah Technology') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

                <form method="POST" action="{{ route('technologies.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-5">

                        {{-- Name --}}
                        <div>
                            <x-input-label for="name" :value="__('Nama Technology')" />
                            <x-text-input
                                id="name" name="name" type="text"
                                class="mt-1 block w-full"
                                :value="old('name')"
                                placeholder="e.g. Laravel, Vue.js, Docker"
                                required autofocus
                            />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Icon --}}
                        <div>
                            <x-input-label for="icon" :value="__('Icon (opsional)')" />
                            <div id="icon-preview-wrap" class="hidden mt-2 mb-3">
                                <img id="icon-preview" src="" alt="preview"
                                     class="w-12 h-12 object-contain rounded border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 p-1">
                            </div>
                            <input
                                id="icon" name="icon" type="file" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                       file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0
                                       file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700
                                       hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400"
                                onchange="previewIcon(this)"
                            >
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPG, PNG, WebP, SVG. Maks 1 MB.</p>
                            <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('technologies.index') }}"
                               class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition">
                                Batal
                            </a>
                            <x-primary-button type="submit">Simpan Technology</x-primary-button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewIcon(input) {
            if (input.files && input.files[0]) {
                var reader  = new FileReader();
                var wrap    = document.getElementById('icon-preview-wrap');
                var preview = document.getElementById('icon-preview');
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    wrap.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
</x-app-layout>
