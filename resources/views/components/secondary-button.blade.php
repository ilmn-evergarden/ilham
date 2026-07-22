<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-[#f2f2f2] dark:bg-[#383848] border border-transparent rounded font-medium text-sm text-[#555] dark:text-[#ddd] hover:bg-[#e1e1e1] dark:hover:bg-[#555] focus:outline-none focus:ring-2 focus:ring-[#999] focus:ring-offset-2 dark:focus:ring-offset-[#111] disabled:opacity-25 transition-colors duration-150']) }}>
    {{ $slot }}
</button>
