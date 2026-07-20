<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('certificates.index') }}"
               class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition">
                ← Certificates
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tambah Sertifikat') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

                <form method="POST" action="{{ route('certificates.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-5">

                        {{-- Title --}}
                        <div>
                            <x-input-label for="title" :value="__('Judul Sertifikat')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                :value="old('title')"
                                placeholder="e.g. AWS Certified Developer"
                                required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        {{-- Issuer --}}
                        <div>
                            <x-input-label for="issuer" :value="__('Penerbit (Issuer)')" />
                            <x-text-input id="issuer" name="issuer" type="text" class="mt-1 block w-full"
                                :value="old('issuer')"
                                placeholder="e.g. Amazon Web Services, Udemy, Coursera"
                                required />
                            <x-input-error :messages="$errors->get('issuer')" class="mt-2" />
                        </div>

                        {{-- Issue date & Expiration date --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="issue_date" :value="__('Tanggal Terbit')" />
                                <x-text-input id="issue_date" name="issue_date" type="date"
                                    class="mt-1 block w-full"
                                    :value="old('issue_date')" required />
                                <x-input-error :messages="$errors->get('issue_date')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="expiration_date" :value="__('Tanggal Kedaluwarsa (kosongkan = Lifetime)')" />
                                <x-text-input id="expiration_date" name="expiration_date" type="date"
                                    class="mt-1 block w-full"
                                    :value="old('expiration_date')" />
                                <x-input-error :messages="$errors->get('expiration_date')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Credential ID & URL --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="credential_id" :value="__('Credential ID (opsional)')" />
                                <x-text-input id="credential_id" name="credential_id" type="text"
                                    class="mt-1 block w-full"
                                    :value="old('credential_id')"
                                    placeholder="e.g. ABC123XYZ" />
                                <x-input-error :messages="$errors->get('credential_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="credential_url" :value="__('Credential URL (opsional)')" />
                                <x-text-input id="credential_url" name="credential_url" type="url"
                                    class="mt-1 block w-full"
                                    :value="old('credential_url')"
                                    placeholder="https://..." />
                                <x-input-error :messages="$errors->get('credential_url')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Image --}}
                        <div>
                            <x-input-label for="image" :value="__('Gambar Sertifikat')" />
                            <div id="img-preview-wrap" class="hidden mt-2 mb-2">
                                <img id="img-preview" src="" alt="Preview"
                                     class="w-full max-h-40 object-contain rounded-md border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900">
                            </div>
                            <input id="image" name="image" type="file"
                                   accept="image/jpg,image/jpeg,image/png,image/webp"
                                   class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                          file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0
                                          file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700
                                          hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400"
                                   onchange="previewImg(this)" required>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPG, PNG, WebP. Maks 2 MB.</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        {{-- Description --}}
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi (opsional)')" />
                            <textarea id="description" name="description" rows="3"
                                placeholder="Deskripsi singkat tentang sertifikat ini..."
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm"
                            >{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('certificates.index') }}"
                               class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition">
                                Batal
                            </a>
                            <x-primary-button type="submit">Simpan Sertifikat</x-primary-button>
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
                var wrap    = document.getElementById('img-preview-wrap');
                var preview = document.getElementById('img-preview');
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
