@props(['icon' => 'fas fa-inbox', 'title' => 'No Data Found', 'message' => 'There is no data available to show here.'])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center p-12 text-center glass rounded-2xl w-full']) }}>
    <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4 text-slate-400 shadow-inner">
        <i class="{{ $icon }} text-2xl"></i>
    </div>
    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 font-['Outfit']">{{ $title }}</h3>
    <p class="text-sm text-slate-500 dark:text-slate-400 max-w-md">{{ $message }}</p>
    
    @if(isset($action))
        <div class="mt-6">
            {{ $action }}
        </div>
    @endif
</div>
