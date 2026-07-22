<x-app-layout title="Dashboard">
    <x-slot name="header">
        <h2 class="font-bold font-serif text-xl text-[#222] dark:text-[#ddd] leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <div class="text-[#555] dark:text-[#a4a4a4]">
                    {{ __("You're logged in!") }}
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
