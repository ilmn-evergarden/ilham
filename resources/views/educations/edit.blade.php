<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('educations.index') }}"
               class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition">
                ← Education
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Pendidikan') }}: <span class="text-indigo-600 dark:text-indigo-400">{{ $education->school_name }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

                <form method="POST" action="{{ route('educations.update', $education) }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">

                        {{-- Level / Jenjang --}}
                        <div>
                            <x-input-label for="level" :value="__('Jenjang Pendidikan')" />
                            <select id="level" name="level" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm">
                                <option value="" disabled>-- Pilih Jenjang --</option>
                                @foreach (['SD', 'SMP', 'SMA', 'SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3', 'Lainnya'] as $lvl)
                                    <option value="{{ $lvl }}" @selected(old('level', $education->level) === $lvl)>{{ $lvl }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('level')" class="mt-2" />
                        </div>

                        {{-- School Name --}}
                        <div>
                            <x-input-label for="school_name" :value="__('Nama Sekolah / Universitas')" />
                            <x-text-input
                                id="school_name"
                                name="school_name"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('school_name', $education->school_name)"
                                required autofocus
                            />
                            <x-input-error :messages="$errors->get('school_name')" class="mt-2" />
                        </div>

                        {{-- Major --}}
                        <div>
                            <x-input-label for="major" :value="__('Jurusan (opsional)')" />
                            <x-text-input
                                id="major"
                                name="major"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('major', $education->major)"
                            />
                            <x-input-error :messages="$errors->get('major')" class="mt-2" />
                        </div>

                        {{-- Start Year & End Year --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="start_year" :value="__('Tahun Masuk')" />
                                <x-text-input
                                    id="start_year"
                                    name="start_year"
                                    type="number"
                                    class="mt-1 block w-full"
                                    :value="old('start_year', $education->start_year)"
                                    min="1900"
                                    max="{{ date('Y') + 1 }}"
                                    required
                                />
                                <x-input-error :messages="$errors->get('start_year')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="end_year" :value="__('Tahun Lulus (kosongkan jika masih aktif)')" />
                                <x-text-input
                                    id="end_year"
                                    name="end_year"
                                    type="number"
                                    class="mt-1 block w-full"
                                    :value="old('end_year', $education->end_year)"
                                    min="1900"
                                    max="{{ date('Y') + 10 }}"
                                />
                                <x-input-error :messages="$errors->get('end_year')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Description --}}
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi (opsional)')" />
                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm"
                            >{{ old('description', $education->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('educations.index') }}"
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
</x-app-layout>
