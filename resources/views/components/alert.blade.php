@if (session('success') || session('error'))
    <div id="flash-message" class="fixed top-20 right-4 z-50 transform transition-all duration-500 ease-out translate-y-0 opacity-100 starting:opacity-0 starting:translate-y-[-20px]" role="alert">
        <div class="glass p-4 rounded-xl flex items-center space-x-3 {{ session('success') ? 'border-green-500' : 'border-red-500' }} border-l-4 shadow-xl">
            @if(session('success'))
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                <div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white">Success</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-300">{{ session('success') }}</p>
                </div>
            @else
                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                <div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white">Error</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-300">{{ session('error') }}</p>
                </div>
            @endif
            <button type="button" onclick="document.getElementById('flash-message').remove()" class="text-slate-400 hover:text-slate-600 ml-4 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    
    <script>
        setTimeout(() => {
            const el = document.getElementById('flash-message');
            if(el) {
                el.style.opacity = '0';
                el.style.transform = 'translateY(-20px)';
                setTimeout(() => el.remove(), 500);
            }
        }, 5000);
    </script>
@endif
