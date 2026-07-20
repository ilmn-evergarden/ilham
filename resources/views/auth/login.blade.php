<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold font-serif text-[#222] dark:text-[#ddd]">Welcome Back</h2>
        <p class="text-sm text-[#999] mt-1">Please enter your details to sign in.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-5">
            <label for="email" class="block text-sm font-medium text-[#222] dark:text-[#ddd] mb-2">{{ __('Email') }}</label>
            <input id="email" class="w-full px-4 py-3 rounded bg-[#f9f9f9] dark:bg-[#1a1a24] border border-[#e1e1e1] dark:border-[#383848] text-[#555] dark:text-[#a4a4a4] focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-5">
            <label for="password" class="block text-sm font-medium text-[#222] dark:text-[#ddd] mb-2">{{ __('Password') }}</label>
            <input id="password" class="w-full px-4 py-3 rounded bg-[#f9f9f9] dark:bg-[#1a1a24] border border-[#e1e1e1] dark:border-[#383848] text-[#555] dark:text-[#a4a4a4] focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mb-8">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded bg-[#f9f9f9] dark:bg-[#1a1a24] border-[#e1e1e1] dark:border-[#383848] text-primary focus:ring-primary dark:focus:ring-primary" name="remember">
                <span class="ms-2 text-sm text-[#555] dark:text-[#a4a4a4]">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div>
            <button type="submit" class="w-full py-3 px-4 bg-primary text-white font-medium rounded hover:bg-primary-dark transition-colors flex justify-center items-center gap-2">
                {{ __('Log in') }} <i class="fas fa-sign-in-alt"></i>
            </button>
        </div>
    </form>
</x-guest-layout>
