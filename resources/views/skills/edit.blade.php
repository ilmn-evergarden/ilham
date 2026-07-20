@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout title="Edit Skill">
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('skills.index') }}"
               class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition">
                ← Skills
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Skill') }}: <span class="text-indigo-600 dark:text-indigo-400">{{ $skill->name }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

                <form method="POST" action="{{ route('skills.update', $skill) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">

                        {{-- Name --}}
                        <div>
                            <x-input-label for="name" :value="__('Nama Skill')" />
                            <x-text-input
                                id="name"
                                name="name"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('name', $skill->name)"
                                required autofocus
                            />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Category --}}
                        <div>
                            <x-input-label for="category" :value="__('Kategori')" />
                            <x-text-input
                                id="category"
                                name="category"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('category', $skill->category)"
                                required
                            />
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        {{-- Level --}}
                        <div>
                            <x-input-label for="level" :value="__('Level (0 – 100)')" />
                            <div class="mt-1 flex items-center gap-4">
                                <input
                                    id="level"
                                    name="level"
                                    type="range"
                                    min="0" max="100" step="1"
                                    value="{{ old('level', $skill->level) }}"
                                    class="flex-1 accent-indigo-600"
                                    oninput="document.getElementById('level-display').textContent = this.value + '%'"
                                >
                                <span id="level-display"
                                      class="w-12 text-center text-sm font-semibold text-gray-700 dark:text-gray-300 tabular-nums">
                                    {{ old('level', $skill->level) }}%
                                </span>
                            </div>
                            <div class="mt-2 bg-gray-200 dark:bg-gray-600 rounded-full h-2 overflow-hidden">
                                <div id="level-bar"
                                     class="bg-indigo-500 h-2 rounded-full transition-all"
                                     style="width: {{ old('level', $skill->level) }}%"></div>
                            </div>
                            <x-input-error :messages="$errors->get('level')" class="mt-2" />
                        </div>

                        {{-- Icon --}}
                        <div>
                            <x-input-label for="icon" :value="__('Icon')" />

                            @if ($skill->icon)
                                <div class="mt-2 mb-3 flex items-center gap-3">
                                    <img src="{{ Storage::url($skill->icon) }}"
                                         id="icon-preview"
                                         alt="{{ $skill->name }}"
                                         class="w-12 h-12 object-contain rounded border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 p-1">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Icon saat ini. Upload baru untuk mengganti.</span>
                                </div>
                            @else
                                <div class="mt-2 mb-3">
                                    <img id="icon-preview"
                                         src=""
                                         alt="preview"
                                         class="hidden w-12 h-12 object-contain rounded border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 p-1">
                                </div>
                            @endif

                            <input
                                id="icon"
                                name="icon"
                                type="file"
                                accept="image/*"
                                class="block w-full text-sm text-gray-500 dark:text-gray-400
                                       file:mr-3 file:py-1.5 file:px-3
                                       file:rounded-md file:border-0
                                       file:text-sm file:font-medium
                                       file:bg-indigo-50 file:text-indigo-700
                                       hover:file:bg-indigo-100
                                       dark:file:bg-indigo-900/30 dark:file:text-indigo-400"
                                onchange="previewIcon(this)"
                            >
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPG, PNG, WebP, SVG. Maks 1 MB. Kosongkan jika tidak ingin mengubah.</p>
                            <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('skills.index') }}"
                               class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition">
                                Batal
                            </a>
                            <x-primary-button type="submit">
                                Simpan Perubahan
                            </x-primary-button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Sync progress bar with range slider
        const range = document.getElementById('level');
        const bar   = document.getElementById('level-bar');
        range.addEventListener('input', () => {
            bar.style.width = range.value + '%';
        });

        // Preview newly selected icon
        function previewIcon(input) {
            if (input.files && input.files[0]) {
                var reader  = new FileReader();
                var preview = document.getElementById('icon-preview');
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
</x-app-layout>
