@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => true,
])

@php
    $typeConfig = [
        'success' => [
            'border' => 'border-emerald-200/90 border-l-4 border-l-emerald-500',
            'iconBg' => 'bg-emerald-50 text-emerald-600 border border-emerald-200/80',
            'icon' => 'fa-solid fa-circle-check',
            'titleColor' => 'text-emerald-950',
            'textColor' => 'text-slate-600',
            'badge' => 'SUKSES',
            'badgeColor' => 'bg-emerald-100 text-emerald-800',
        ],
        'error' => [
            'border' => 'border-rose-200/90 border-l-4 border-l-rose-500',
            'iconBg' => 'bg-rose-50 text-rose-600 border border-rose-200/80',
            'icon' => 'fa-solid fa-circle-exclamation',
            'titleColor' => 'text-rose-950',
            'textColor' => 'text-slate-600',
            'badge' => 'PERHATIAN',
            'badgeColor' => 'bg-rose-100 text-rose-800',
        ],
        'warning' => [
            'border' => 'border-amber-200/90 border-l-4 border-l-amber-500',
            'iconBg' => 'bg-amber-50 text-amber-600 border border-amber-200/80',
            'icon' => 'fa-solid fa-triangle-exclamation',
            'titleColor' => 'text-amber-950',
            'textColor' => 'text-slate-600',
            'badge' => 'PERINGATAN',
            'badgeColor' => 'bg-amber-100 text-amber-800',
        ],
        'info' => [
            'border' => 'border-orange-200/90 border-l-4 border-l-[#FF6B00]',
            'iconBg' => 'bg-orange-50 text-[#FF6B00] border border-orange-200/80',
            'icon' => 'fa-solid fa-circle-info',
            'titleColor' => 'text-neutral-900',
            'textColor' => 'text-slate-600',
            'badge' => 'INFORMASI',
            'badgeColor' => 'bg-orange-100 text-[#FF6B00]',
        ],
    ];

    $cfg = $typeConfig[$type] ?? $typeConfig['info'];
@endphp

<div role="alert" {{ $attributes->merge(['class' => 'alert-box relative bg-white ' . $cfg['border'] . ' rounded-2xl p-4 sm:p-5 shadow-sm transition-all duration-200 ease-out flex items-start gap-3.5 sm:gap-4']) }}>
    <!-- Icon Container -->
    <div class="w-10 h-10 rounded-xl {{ $cfg['iconBg'] }} flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
        <i class="{{ $cfg['icon'] }} text-base sm:text-lg"></i>
    </div>

    <!-- Alert Content -->
    <div class="flex-grow min-w-0 pr-1 sm:pr-2">
        @if($title)
            <div class="flex items-center gap-2 mb-1 flex-wrap">
                <h4 class="font-bold text-sm sm:text-base {{ $cfg['titleColor'] }} tracking-tight">{{ $title }}</h4>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $cfg['badgeColor'] }} uppercase tracking-wider">{{ $cfg['badge'] }}</span>
            </div>
        @endif
        <div class="text-xs sm:text-sm {{ $cfg['textColor'] }} leading-relaxed">
            {{ $slot }}
        </div>
    </div>

    <!-- Dismiss Button -->
    @if($dismissible)
        <button type="button" 
                onclick="dismissAlert(this)"
                class="shrink-0 p-1.5 -mr-1 -mt-1 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-slate-300 cursor-pointer" 
                aria-label="Tutup notifikasi">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    @endif
</div>

<script>
    if (typeof window.dismissAlert === 'undefined') {
        window.dismissAlert = function(button) {
            const alert = button.closest('.alert-box') || button.closest('[role="alert"]');
            if (alert) {
                alert.style.transition = 'all 0.2s ease-out';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-6px)';
                setTimeout(() => { alert.remove(); }, 200);
            }
        };
    }
</script>
