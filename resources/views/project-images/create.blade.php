<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('projects.images.index', $project) }}"
               class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition">
                ← Gallery
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Upload Gambar — <span class="text-indigo-600 dark:text-indigo-400">{{ $project->title }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

                <form method="POST" action="{{ route('projects.images.store', $project) }}" enctype="multipart/form-data"
                      id="upload-form">
                    @csrf

                    <div class="space-y-5">

                        {{-- Multiple file upload --}}
                        <div>
                            <x-input-label for="images" :value="__('Pilih Gambar')" />
                            <input
                                id="images" name="images[]" type="file"
                                accept="image/jpg,image/jpeg,image/png,image/webp"
                                multiple required
                                class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                       file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0
                                       file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700
                                       hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400"
                                onchange="buildPreviews(this)"
                            >
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPG, PNG, WebP. Maks 2 MB per gambar. Bisa pilih banyak sekaligus.</p>
                            <x-input-error :messages="$errors->get('images')" class="mt-2" />
                            <x-input-error :messages="$errors->get('images.*')" class="mt-1" />
                        </div>

                        {{-- Dynamic preview + per-file caption & sort_order fields --}}
                        <div id="preview-container" class="space-y-4 hidden">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Preview & Detail Gambar</p>
                            <div id="preview-list" class="space-y-3"></div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('projects.images.index', $project) }}"
                               class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition">
                                Batal
                            </a>
                            <x-primary-button type="submit">Upload Gambar</x-primary-button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        /**
         * Build live preview cards for each selected file.
         * Each card has its own caption & sort_order input
         * named captions[0], sort_orders[0], etc.
         */
        function buildPreviews(input) {
            var container = document.getElementById('preview-container');
            var list      = document.getElementById('preview-list');
            list.innerHTML = '';

            if (!input.files || input.files.length === 0) {
                container.classList.add('hidden');
                return;
            }

            container.classList.remove('hidden');

            Array.from(input.files).forEach(function (file, index) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var card = document.createElement('div');
                    card.className = 'flex items-start gap-4 p-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40';
                    card.innerHTML = `
                        <img src="${e.target.result}" alt="preview"
                             class="w-24 h-16 object-cover rounded-md border border-gray-300 dark:border-gray-600 shrink-0">
                        <div class="flex-1 space-y-2">
                            <p class="text-xs font-medium text-gray-700 dark:text-gray-300 truncate">${file.name}</p>
                            <input type="text" name="captions[${index}]"
                                   placeholder="Caption (opsional)"
                                   class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-1.5">
                            <input type="number" name="sort_orders[${index}]"
                                   placeholder="Urutan (opsional, default: otomatis)"
                                   min="0"
                                   class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-1.5">
                        </div>`;
                    list.appendChild(card);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
    @endpush
</x-app-layout>
