<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('experiences.index') }}"
               class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition">
                ← Experience
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tambah Pengalaman') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

                <form method="POST" action="{{ route('experiences.store') }}" id="exp-form">
                    @csrf

                    <div class="space-y-5">

                        {{-- Company --}}
                        <div>
                            <x-input-label for="company" :value="__('Nama Perusahaan / Instansi')" />
                            <x-text-input
                                id="company" name="company" type="text"
                                class="mt-1 block w-full"
                                :value="old('company')"
                                placeholder="e.g. PT ABC, Dinas Kominfo, Freelance"
                                required autofocus
                            />
                            <x-input-error :messages="$errors->get('company')" class="mt-2" />
                        </div>

                        {{-- Position --}}
                        <div>
                            <x-input-label for="position" :value="__('Posisi')" />
                            <x-text-input
                                id="position" name="position" type="text"
                                class="mt-1 block w-full"
                                :value="old('position')"
                                placeholder="e.g. Backend Developer, Web Developer Intern"
                                required
                            />
                            <x-input-error :messages="$errors->get('position')" class="mt-2" />
                        </div>

                        {{-- Employment Type --}}
                        <div>
                            <x-input-label for="employment_type" :value="__('Jenis Pengalaman')" />
                            <select id="employment_type" name="employment_type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm">
                                <option value="" disabled @selected(!old('employment_type'))>-- Pilih Jenis --</option>
                                @foreach (['Full Time','Part Time','Internship','Freelance','Contract','Volunteer','Organization','Others'] as $type)
                                    <option value="{{ $type }}" @selected(old('employment_type') === $type)>{{ $type }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('employment_type')" class="mt-2" />
                        </div>

                        {{-- Start Date --}}
                        <div>
                            <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                            <x-text-input
                                id="start_date" name="start_date" type="date"
                                class="mt-1 block w-full"
                                :value="old('start_date')"
                                required
                            />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>

                        {{-- Is Current checkbox --}}
                        <div class="flex items-center gap-3">
                            <input
                                id="is_current"
                                name="is_current"
                                type="checkbox"
                                value="1"
                                @checked(old('is_current'))
                                class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                onchange="toggleEndDate(this)"
                            >
                            <x-input-label for="is_current" :value="__('Masih bekerja / aktif di sini')" class="!mb-0 cursor-pointer" />
                        </div>

                        {{-- End Date (hidden when is_current) --}}
                        <div id="end-date-wrapper" class="{{ old('is_current') ? 'hidden' : '' }}">
                            <x-input-label for="end_date" :value="__('Tanggal Selesai')" />
                            <x-text-input
                                id="end_date" name="end_date" type="date"
                                class="mt-1 block w-full"
                                :value="old('end_date')"
                            />
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                        </div>

                        {{-- Description --}}
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi (opsional)')" />
                            <textarea
                                id="description" name="description" rows="4"
                                placeholder="Ceritakan tanggung jawab, pencapaian, atau teknologi yang digunakan..."
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm"
                            >{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('experiences.index') }}"
                               class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition">
                                Batal
                            </a>
                            <x-primary-button type="submit">
                                Simpan Pengalaman
                            </x-primary-button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        /**
         * Show/hide the end_date field based on the is_current checkbox.
         * When hiding, clear the value so it won't be submitted.
         */
        function toggleEndDate(checkbox) {
            var wrapper = document.getElementById('end-date-wrapper');
            var endDate = document.getElementById('end_date');
            if (checkbox.checked) {
                wrapper.classList.add('hidden');
                endDate.value = '';
                endDate.removeAttribute('required');
            } else {
                wrapper.classList.remove('hidden');
            }
        }

        // Run on page load to handle old() state after validation failure
        (function () {
            var cb = document.getElementById('is_current');
            if (cb && cb.checked) toggleEndDate(cb);
        })();
    </script>
    @endpush
</x-app-layout>
