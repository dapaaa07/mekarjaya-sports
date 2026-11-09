@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => true,
])

@php
    $typeConfig = [
        'success' => [
            'accentBorder' => 'border-l-[6px] border-l-[#166534]',
            'iconBox' => 'bg-[#DCFCE7] text-[#14532D] border-2 border-[#111111]',
            'icon' => 'fa-solid fa-circle-check',
            'badge' => 'SUKSES',
            'badgeClass' => 'bg-[#166534] text-white border border-[#111111]',
        ],
        'error' => [
            'accentBorder' => 'border-l-[6px] border-l-[#FF0000]',
            'iconBox' => 'bg-[#FF0000] text-[#000000] border-2 border-[#111111]',
            'icon' => 'fa-solid fa-triangle-exclamation',
            'badge' => 'PERHATIAN',
            'badgeClass' => 'bg-[#FF0000] text-[#000000] border border-[#111111]',
        ],
        'warning' => [
            'accentBorder' => 'border-l-[6px] border-l-[#111111]',
            'iconBox' => 'bg-[#FFFF00] text-[#111111] border-2 border-[#111111]',
            'icon' => 'fa-solid fa-circle-exclamation',
            'badge' => 'PERINGATAN',
            'badgeClass' => 'bg-[#FFFF00] text-[#111111] border border-[#111111]',
        ],
        'info' => [
            'accentBorder' => 'border-l-[6px] border-l-[#0000FF]',
            'iconBox' => 'bg-[#0000FF] text-white border-2 border-[#111111]',
            'icon' => 'fa-solid fa-circle-info',
            'badge' => 'INFORMASI',
            'badgeClass' => 'bg-[#0000FF] text-white border border-[#111111]',
        ],
    ];

    $cfg = $typeConfig[$type] ?? $typeConfig['info'];
@endphp

<div role="alert" {{ $attributes->merge(['class' => 'alert-box relative bg-white border-2 border-[#111111] ' . $cfg['accentBorder'] . ' p-4 sm:p-5 shadow-[0_2px_8px_rgba(0,0,0,0.08)] flex items-start gap-3.5 sm:gap-4']) }}>
    <!-- Geometric Status Block -->
    <div class="w-11 h-11 {{ $cfg['iconBox'] }} flex items-center justify-center shrink-0">
        <i class="{{ $cfg['icon'] }} text-base sm:text-lg" aria-hidden="true"></i>
    </div>

    <!-- Alert Content -->
    <div class="flex-grow min-w-0 pr-1">
        @if($title)
            <div class="flex items-center gap-2.5 mb-1 flex-wrap">
                <h4 class="font-bold text-sm sm:text-base text-[#111111] tracking-tight">{{ $title }}</h4>
                <span class="text-[11px] font-mono font-bold px-2 py-0.5 {{ $cfg['badgeClass'] }} uppercase tracking-wider">{{ $cfg['badge'] }}</span>
            </div>
        @endif
        <div class="text-xs sm:text-sm text-[#525252] leading-relaxed">
            {{ $slot }}
        </div>
    </div>

    <!-- Dismiss Button (44px accessible hit target) -->
    @if($dismissible)
        <button type="button"
                onclick="dismissAlert(this)"
                class="shrink-0 w-11 h-11 -mr-1.5 -mt-1.5 bg-white text-[#111111] border-2 border-transparent hover:border-[#111111] hover:bg-[#FFFF00] transition-colors flex items-center justify-center cursor-pointer"
                aria-label="Tutup notifikasi">
            <i class="fa-solid fa-xmark text-base" aria-hidden="true"></i>
        </button>
    @endif
</div>

<script>
    if (typeof window.dismissAlert === 'undefined') {
        window.dismissAlert = function(button) {
            const alert = button.closest('.alert-box') || button.closest('[role="alert"]');
            if (alert) {
                alert.style.transition = 'opacity 200ms ease-out, transform 200ms ease-out';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-6px)';
                setTimeout(() => { alert.remove(); }, 200);
            }
        };
    }
</script>
