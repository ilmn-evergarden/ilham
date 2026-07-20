@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout title="Edit Blog">
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('blogs.index') }}"
               class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition">
                ← Blog
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Artikel') }}: <span class="text-indigo-600 dark:text-indigo-400">{{ $blog->title }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('blogs.update', $blog) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">

                    {{-- ── Basic Info ─────────────────────────────────── --}}
                    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 space-y-5">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 pb-3">
                            Informasi Artikel
                        </h3>

                        <div>
                            <x-input-label for="title" :value="__('Judul Artikel')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                :value="old('title', $blog->title)"
                                required autofocus oninput="syncSlug(this.value)" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="slug" :value="__('Slug')" />
                            <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full"
                                :value="old('slug', $blog->slug)" required />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">URL: <span class="font-mono">/blog/{{ $blog->slug }}</span></p>
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="excerpt" :value="__('Excerpt')" />
                            <textarea id="excerpt" name="excerpt" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm"
                                required>{{ old('excerpt', $blog->excerpt) }}</textarea>
                            <x-input-error :messages="$errors->get('excerpt')" class="mt-2" />
                        </div>
                    </div>

                    {{-- ── Thumbnail ───────────────────────────────────── --}}
                    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 space-y-4">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 pb-3">
                            Thumbnail
                        </h3>
                        @if ($blog->thumbnail)
                            <div class="mb-2">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Thumbnail saat ini:</p>
                                <img id="thumb-preview" src="{{ Storage::url($blog->thumbnail) }}"
                                     alt="{{ $blog->title }}"
                                     class="w-48 h-32 object-cover rounded-md border border-gray-200 dark:border-gray-600">
                            </div>
                        @else
                            <div id="thumb-preview-wrap" class="hidden mb-2">
                                <img id="thumb-preview" src="" alt="Preview"
                                     class="w-48 h-32 object-cover rounded-md border border-gray-200 dark:border-gray-600">
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

                    {{-- ── Content (WYSIWYG) ───────────────────────────── --}}
                    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 space-y-4">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 pb-3">
                            Konten Artikel
                        </h3>
                        <x-input-error :messages="$errors->get('content')" class="mb-2" />
                        <textarea id="content" name="content" rows="20"
                            class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm"
                        >{{ old('content', $blog->content) }}</textarea>
                    </div>

                    {{-- ── Publish Settings ────────────────────────────── --}}
                    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 space-y-5">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 pb-3">
                            Pengaturan Publish
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" required
                                        onchange="togglePublishedAt(this.value)"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm">
                                    <option value="Draft"     @selected(old('status', $blog->status) === 'Draft')>Draft</option>
                                    <option value="Published" @selected(old('status', $blog->status) === 'Published')>Published</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            @php $currentStatus = old('status', $blog->status); @endphp
                            <div id="published-at-wrapper" class="{{ $currentStatus === 'Published' ? '' : 'opacity-50' }}">
                                <x-input-label for="published_at" :value="__('Tanggal Publish')" />
                                <x-text-input id="published_at" name="published_at" type="datetime-local"
                                    class="mt-1 block w-full"
                                    :value="old('published_at', $blog->published_at?->format('Y-m-d\TH:i') ?? now()->format('Y-m-d\TH:i'))" />
                                <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- ── Submit ───────────────────────────────────────── --}}
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('blogs.index') }}"
                           class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition">
                            Batal
                        </a>
                        <x-primary-button type="submit">Simpan Perubahan</x-primary-button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">

    @push('scripts')
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
    <script>
        var _slugEdited = false;

        var easyMDE = new EasyMDE({
            element: document.getElementById('content'),
            spellChecker: false,
            autosave: { enabled: true, uniqueId: 'blog-edit-{{ $blog->id }}' },
            toolbar: [
                'bold','italic','heading','|',
                'quote','unordered-list','ordered-list','|',
                'link','image','|',
                'preview','side-by-side','fullscreen','|',
                'guide'
            ]
        });

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

        function togglePublishedAt(status) {
            var wrapper = document.getElementById('published-at-wrapper');
            wrapper.classList.toggle('opacity-50', status !== 'Published');
        }

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
