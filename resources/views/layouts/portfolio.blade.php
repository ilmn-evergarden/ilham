@php $user = $user ?? App\Models\User::first(); @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    @hasSection('seo')
        @yield('seo')
    @else
        <x-seo title="{{ trim($__env->yieldContent('title')) }}" />
    @endif

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@300;400;500;600;700;800&family=Raleway:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('css/portfolio.css') }}" rel="stylesheet">
</head>
<body class="bg-white dark:bg-[#111] text-[#555] dark:text-[#a4a4a4] antialiased selection:bg-primary selection:text-white font-sans">
    
    <!-- Loader -->
    <div id="loader">
        <div class="spinner"></div>
    </div>



    <!-- Navbar -->
    <nav id="navbar" class="fixed w-full z-50 bg-white/90 dark:bg-[#111]/90 backdrop-blur-md border-b border-[#e1e1e1] dark:border-[#383848] transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-2xl font-bold font-serif text-[#222] dark:text-[#ddd] tracking-tight hover:text-primary dark:hover:text-primary-dark transition-colors">
                        {{ explode(' ', $user->name ?? 'Portfolio')[0] }}.
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ url('/') }}#about" class="text-sm font-medium text-[#222] dark:text-[#ddd] hover:text-primary dark:hover:text-primary transition-colors">About</a>
                    <a href="{{ url('/') }}#skills" class="text-sm font-medium text-[#222] dark:text-[#ddd] hover:text-primary dark:hover:text-primary transition-colors">Skills</a>
                    <a href="{{ url('/') }}#experience" class="text-sm font-medium text-[#222] dark:text-[#ddd] hover:text-primary dark:hover:text-primary transition-colors">Experience</a>
                    <a href="{{ url('/') }}#projects" class="text-sm font-medium text-[#222] dark:text-[#ddd] hover:text-primary dark:hover:text-primary transition-colors">Projects</a>
                    <a href="{{ route('blog.index') }}" class="text-sm font-medium text-[#222] dark:text-[#ddd] hover:text-primary dark:hover:text-primary transition-colors">Blog</a>
                    
                    <button id="theme-toggle" class="p-2 rounded-full text-[#555] dark:text-[#a4a4a4] hover:bg-[#f2f2f2] dark:hover:bg-[#383848] transition-colors" aria-label="Toggle Dark Mode">
                        <span id="theme-icon"></span>
                    </button>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2 rounded bg-primary text-white text-sm font-medium hover:bg-primary-dark transition-colors">Dashboard</a>
                    @else
                        <a href="{{ url('/') }}#contact" class="px-5 py-2 rounded bg-primary text-white text-sm font-medium hover:bg-primary-dark transition-colors">Contact</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="flex md:hidden items-center space-x-4">
                    <button id="theme-toggle-mobile" class="p-2 rounded-full hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors" aria-label="Toggle Dark Mode">
                        <i class="fas fa-moon"></i>
                    </button>
                    <button id="mobile-menu-btn" class="text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-[#111] border-t border-[#e1e1e1] dark:border-[#383848]">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ url('/') }}#about" class="block px-3 py-2 rounded-md text-base font-medium text-[#222] dark:text-[#ddd] hover:bg-[#f2f2f2] dark:hover:bg-[#383848]">About</a>
                <a href="{{ url('/') }}#skills" class="block px-3 py-2 rounded-md text-base font-medium text-[#222] dark:text-[#ddd] hover:bg-[#f2f2f2] dark:hover:bg-[#383848]">Skills</a>
                <a href="{{ url('/') }}#experience" class="block px-3 py-2 rounded-md text-base font-medium text-[#222] dark:text-[#ddd] hover:bg-[#f2f2f2] dark:hover:bg-[#383848]">Experience</a>
                <a href="{{ url('/') }}#projects" class="block px-3 py-2 rounded-md text-base font-medium text-[#222] dark:text-[#ddd] hover:bg-[#f2f2f2] dark:hover:bg-[#383848]">Projects</a>
                <a href="{{ route('blog.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-[#222] dark:text-[#ddd] hover:bg-[#f2f2f2] dark:hover:bg-[#383848]">Blog</a>
                <a href="{{ url('/') }}#contact" class="block px-3 py-2 rounded-md text-base font-medium text-primary dark:text-primary hover:bg-[#f2f2f2] dark:hover:bg-[#383848]">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#f2f2f2] dark:bg-[#111] border-t border-[#e1e1e1] dark:border-[#383848] mt-20 py-12 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0 text-center md:text-left">
                <span class="text-2xl font-bold font-serif text-[#222] dark:text-[#ddd] tracking-tight">
                    {{ explode(' ', $user->name ?? 'Portfolio')[0] }}.
                </span>
                <p class="text-sm text-[#555] dark:text-[#a4a4a4] mt-2">© {{ date('Y') }} {{ $user->name ?? 'All rights reserved.' }}.</p>
            </div>
            <div class="flex space-x-6">
                @if($user->profile && $user->profile->github)
                <a href="{{ $user->profile->github }}" target="_blank" class="text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors hover-lift">
                    <span class="sr-only">GitHub</span>
                    <i class="fab fa-github text-xl"></i>
                </a>
                @endif
                @if($user->profile && $user->profile->linkedin)
                <a href="{{ $user->profile->linkedin }}" target="_blank" class="text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors hover-lift">
                    <span class="sr-only">LinkedIn</span>
                    <i class="fab fa-linkedin text-xl"></i>
                </a>
                @endif
                @if($user->profile && $user->profile->instagram)
                <a href="{{ $user->profile->instagram }}" target="_blank" class="text-slate-400 hover:text-pink-600 dark:hover:text-pink-400 transition-colors hover-lift">
                    <span class="sr-only">Instagram</span>
                    <i class="fab fa-instagram text-xl"></i>
                </a>
                @endif
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/portfolio.js') }}"></script>
</body>
</html>
