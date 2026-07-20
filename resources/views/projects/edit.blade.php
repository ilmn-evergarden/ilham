@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('projects.index') }}"
               class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition">
                ← Projects
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Project') }}: <span class="text-indigo-600 dark:text-indigo-400">{{ $project->title }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('projects.update', $project) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">

                    {{-- ── Basic Info ─────────────────────────────────── --}}
                    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 space-y-5">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 pb-3">
                            Informasi Dasar
                        </h3>

                        <div>
                            <x-input-label for="title" :value="__('Judul Project')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                :value="old('title', $project->title)"
                                required autofocus oninput="syncSlug(this.value)" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="slug" :value="__('Slug')" />
                            <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full"
                                :value="old('slug', $project->slug)" required />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Bisa diedit secara manual.</p>
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="5"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm"
                                required>{{ old('description', $project->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                    </div>

                    {{-- ── Thumbnail ───────────────────────────────────── --}}
                    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 space-y-4">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 pb-3">
                            Thumbnail
                        </h3>

                        @if ($project->thumbnail)
                            <div class="mb-2">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Thumbnail saat ini:</p>
                                <img id="thumb-preview"
                                     src="{{ Storage::url($project->thumbnail) }}"
                                     alt="{{ $project->title }}"
                                     class="w-40 h-28 object-cover rounded-md border border-gray-200 dark:border-gray-600">
                            </div>
                        @else
                            <div id="thumb-preview-wrap" class="hidden mb-2">
                                <img id="thumb-preview" src="" alt="Preview"
                                     class="w-40 h-28 object-cover rounded-md border border-gray-200 dark:border-gray-600">
                            </div>
                        @endif

                        <input id="thumbnail" name="thumbnail" type="file" accept="image/*"
                               class="block w-full text-sm text-gray-500 dark:text-gray-400
                                      file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0
                                      file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700
                                      hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400"
                               onchange="previewThumb(this)">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPG, PNG, WebP. Maks 2 MB. Kosongkan jika tidak ingin mengubah.</p>
                        <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                    </div>

                    {{-- ── URLs & Status ───────────────────────────────── --}}
                    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 space-y-5">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 pb-3">
                            URL & Status
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="github_url" :value="__('GitHub URL (opsional)')" />
                                <x-text-input id="github_url" name="github_url" type="url" class="mt-1 block w-full"
                                    :value="old('github_url', $project->github_url)" placeholder="https://github.com/..." />
                                <x-input-error :messages="$errors->get('github_url')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="demo_url" :value="__('Demo URL (opsional)')" />
                                <x-text-input id="demo_url" name="demo_url" type="url" class="mt-1 block w-full"
                                    :value="old('demo_url', $project->demo_url)" placeholder="https://demo.example.com" />
                                <x-input-error :messages="$errors->get('demo_url')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm">
                                    @foreach (\App\Models\Project::statuses() as $s)
                                        <option value="{{ $s }}" @selected(old('status', $project->status) === $s)>{{ $s }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                                <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full"
                                    :value="old('start_date', $project->start_date?->format('Y-m-d'))" />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="end_date" :value="__('Tanggal Selesai')" />
                                <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full"
                                    :value="old('end_date', $project->end_date?->format('Y-m-d'))" />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center gap-3 pt-1">
                            <input id="featured" name="featured" type="checkbox" value="1"
                                   @checked(old('featured', $project->featured))
                                   class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <x-input-label for="featured" :value="__('Tandai sebagai Featured Project')" class="!mb-0 cursor-pointer" />
                        </div>
                    </div>

                    {{-- ── Technologies ─────────────────────────────────── --}}
                    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 pb-3 mb-4">
                            Technologies <span class="text-red-500">*</span>
                        </h3>
                        <x-input-error :messages="$errors->get('technologies')" class="mb-3" />
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                            @foreach ($technologies as $tech)
                                <label class="flex items-center gap-2 p-2 rounded-md border border-gray-200 dark:border-gray-700 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 cursor-pointer transition
                                    has-[:checked]:border-indigo-400 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-900/30">
                                    <input type="checkbox" name="technologies[]" value="{{ $tech->id }}"
                                           @checked(in_array($tech->id, old('technologies', $selectedTechIds)))
                                           class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 shrink-0">
                                    <span class="text-sm text-gray-700 dark:text-gray-300 leading-tight">{{ $tech->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- ── Submit ───────────────────────────────────────── --}}
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('projects.index') }}"
                           class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition">
                            Batal
                        </a>
                        <x-primary-button type="submit">Simpan Perubahan</x-primary-button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        var _slugEdited = false;

        // Only auto-sync slug while user hasn't manually edited it
        function syncSlug(title) {
            if (_slugEdited) return;
            var slug = title.toLowerCase().trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('slug').value = slug;
        }

        document.getElementById('slug').addEventListener('input', function () {
            _slugEdited = true;
        });

        // Thumbnail preview
        function previewThumb(input) {
            if (input.files && input.files[0]) {
                var reader  = new FileReader();
                var preview = document.getElementById('thumb-preview');
                var wrap    = document.getElementById('thumb-preview-wrap');
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    if (wrap) wrap.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
</x-app-layout>
