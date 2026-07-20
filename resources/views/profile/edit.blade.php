@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout title="Profile">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Success notification --}}
            @if (session('status') === 'profile-updated')
                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg">
                    <p class="text-sm font-medium text-green-700 dark:text-green-400">
                        {{ __('Profil berhasil disimpan.') }}
                    </p>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">

                    {{-- ── Photo & Basic Info ─────────────────────────────────── --}}
                    <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                            {{ __('Informasi Dasar') }}
                        </h3>

                        <div class="flex flex-col sm:flex-row gap-8">
                            {{-- Photo Preview & Upload --}}
                            <div class="flex flex-col items-center gap-4 sm:w-48 shrink-0">
                                <div class="w-36 h-36 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600">
                                    @if ($profile->photo)
                                        <img
                                            id="photo-preview"
                                            src="{{ Storage::url($profile->photo) }}"
                                            alt="Foto Profil"
                                            class="w-full h-full object-cover"
                                        >
                                    @else
                                        <img
                                            id="photo-preview"
                                            src=""
                                            alt="Foto Profil"
                                            class="w-full h-full object-cover hidden"
                                        >
                                        <div id="photo-placeholder" class="w-full h-full flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="w-full">
                                    <x-input-label for="photo" :value="__('Upload Foto')" class="mb-1" />
                                    <input
                                        id="photo"
                                        name="photo"
                                        type="file"
                                        accept="image/jpg,image/jpeg,image/png,image/webp"
                                        class="block w-full text-sm text-gray-500 dark:text-gray-400
                                               file:mr-3 file:py-1.5 file:px-3
                                               file:rounded-md file:border-0
                                               file:text-sm file:font-medium
                                               file:bg-indigo-50 file:text-indigo-700
                                               hover:file:bg-indigo-100
                                               dark:file:bg-indigo-900/30 dark:file:text-indigo-400"
                                        onchange="previewPhoto(this)"
                                    >
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPG, PNG, WebP. Maks 2 MB.</p>
                                    <x-input-error :messages="$errors->get('photo')" class="mt-1" />
                                </div>
                            </div>

                            {{-- Profession & Bio --}}
                            <div class="flex-1 space-y-4">
                                <div>
                                    <x-input-label for="profession" :value="__('Profesi')" />
                                    <x-text-input
                                        id="profession"
                                        name="profession"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :value="old('profession', $profile->profession)"
                                        placeholder="e.g. Full Stack Developer"
                                    />
                                    <x-input-error :messages="$errors->get('profession')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="bio" :value="__('Bio')" />
                                    <textarea
                                        id="bio"
                                        name="bio"
                                        rows="5"
                                        placeholder="Ceritakan sedikit tentang dirimu..."
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm"
                                    >{{ old('bio', $profile->bio) }}</textarea>
                                    <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── CV ───────────────────────────────────────────────── --}}
                    <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Curriculum Vitae') }}
                        </h3>

                        @if ($profile->cv)
                            <div class="mb-3 flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-5 h-5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM6 20V4h5v7h7v9H6z"/>
                                </svg>
                                <span>CV tersimpan:</span>
                                <a
                                    href="{{ Storage::url($profile->cv) }}"
                                    target="_blank"
                                    class="text-indigo-600 dark:text-indigo-400 hover:underline"
                                >
                                    {{ __('Lihat CV saat ini') }}
                                </a>
                            </div>
                        @endif

                        <div>
                            <x-input-label for="cv" :value="__('Upload CV (PDF)')" class="mb-1" />
                            <input
                                id="cv"
                                name="cv"
                                type="file"
                                accept="application/pdf"
                                class="block w-full text-sm text-gray-500 dark:text-gray-400
                                       file:mr-3 file:py-1.5 file:px-3
                                       file:rounded-md file:border-0
                                       file:text-sm file:font-medium
                                       file:bg-indigo-50 file:text-indigo-700
                                       hover:file:bg-indigo-100
                                       dark:file:bg-indigo-900/30 dark:file:text-indigo-400"
                            >
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format PDF. Maks 5 MB. Kosongkan jika tidak ingin mengubah.</p>
                            <x-input-error :messages="$errors->get('cv')" class="mt-2" />
                        </div>
                    </div>

                    {{-- ── Contact ──────────────────────────────────────────── --}}
                    <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Kontak') }}
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="phone" :value="__('Nomor Telepon')" />
                                <x-text-input
                                    id="phone"
                                    name="phone"
                                    type="text"
                                    class="mt-1 block w-full"
                                    :value="old('phone', $profile->phone)"
                                    placeholder="+62 812 3456 7890"
                                />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="location" :value="__('Lokasi')" />
                                <x-text-input
                                    id="location"
                                    name="location"
                                    type="text"
                                    class="mt-1 block w-full"
                                    :value="old('location', $profile->location)"
                                    placeholder="Jakarta, Indonesia"
                                />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- ── Social Media ─────────────────────────────────────── --}}
                    <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Media Sosial & Tautan') }}
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="github" :value="__('GitHub')" />
                                <x-text-input
                                    id="github"
                                    name="github"
                                    type="url"
                                    class="mt-1 block w-full"
                                    :value="old('github', $profile->github)"
                                    placeholder="https://github.com/username"
                                />
                                <x-input-error :messages="$errors->get('github')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="linkedin" :value="__('LinkedIn')" />
                                <x-text-input
                                    id="linkedin"
                                    name="linkedin"
                                    type="url"
                                    class="mt-1 block w-full"
                                    :value="old('linkedin', $profile->linkedin)"
                                    placeholder="https://linkedin.com/in/username"
                                />
                                <x-input-error :messages="$errors->get('linkedin')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="instagram" :value="__('Instagram')" />
                                <x-text-input
                                    id="instagram"
                                    name="instagram"
                                    type="url"
                                    class="mt-1 block w-full"
                                    :value="old('instagram', $profile->instagram)"
                                    placeholder="https://instagram.com/username"
                                />
                                <x-input-error :messages="$errors->get('instagram')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="website" :value="__('Website')" />
                                <x-text-input
                                    id="website"
                                    name="website"
                                    type="url"
                                    class="mt-1 block w-full"
                                    :value="old('website', $profile->website)"
                                    placeholder="https://yourwebsite.com"
                                />
                                <x-input-error :messages="$errors->get('website')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- ── Submit ───────────────────────────────────────────── --}}
                    <div class="flex items-center justify-end gap-4">
                        <x-primary-button>
                            {{ __('Simpan Profil') }}
                        </x-primary-button>
                    </div>

                </div>{{-- end space-y-6 --}}
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        /**
         * Show a live preview of the selected photo before uploading.
         */
        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var preview     = document.getElementById('photo-preview');
                    var placeholder = document.getElementById('photo-placeholder');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
</x-app-layout>
