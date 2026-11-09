<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Portal Admin - Mekar Jaya Sport Subang</title>

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-mekarjaya.jpg') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-mekarjaya.jpg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F4F4] text-[#111111] font-sans min-h-[100dvh] flex items-center justify-center p-4 sm:p-6">

    <div class="w-full max-w-md bg-white border-2 border-[#111111] shadow-[0_2px_8px_rgba(0,0,0,0.08)] overflow-hidden">

        <!-- Mondrian Primary Top Ribbon -->
        <div class="grid grid-cols-12 h-3 border-b-2 border-[#111111]" aria-hidden="true">
            <div class="col-span-5 bg-[#FF0000] border-r-2 border-[#111111]"></div>
            <div class="col-span-4 bg-[#0000FF] border-r-2 border-[#111111]"></div>
            <div class="col-span-3 bg-[#FFFF00]"></div>
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            <!-- Header -->
            <div class="flex items-center gap-4 border-b-2 border-[#111111] pb-5">
                <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Mekar Jaya Sports Logo" class="h-14 w-14 object-cover border-2 border-[#111111] shrink-0">
                <div>
                    <h1 class="font-bold text-2xl text-[#111111] tracking-tight leading-tight">Portal Pengurus SSB</h1>
                    <p class="text-[#525252] text-xs font-mono font-bold uppercase tracking-wider mt-1">MEKARJAYA.SPORTS SUBANG</p>
                </div>
            </div>

            @if($errors->any())
                <x-alert type="error" title="Gagal Masuk">
                    <p>{{ $errors->first() }}</p>
                </x-alert>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Alamat Email *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[#525252] pointer-events-none">
                            <i class="fa-solid fa-envelope text-sm" aria-hidden="true"></i>
                        </span>
                        <input type="email" id="email" name="email" required autocomplete="username" value="{{ old('email', 'admin@mekarjaya.com') }}"
                               autocorrect="off" autocapitalize="off" spellcheck="false"
                               placeholder="admin@mekarjaya.com"
                               class="ds-input pl-10">
                    </div>
                </div>

                <div>
                    <label for="password" class="block font-bold text-[#111111] uppercase tracking-wider text-xs mb-1.5">Kata Sandi (Password) *</label>
                    <div class="relative flex items-stretch">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[#525252] pointer-events-none">
                            <i class="fa-solid fa-lock text-sm" aria-hidden="true"></i>
                        </span>
                        <input type="password" id="password" name="password" required autocomplete="current-password" value="admin123"
                               placeholder="Masukkan kata sandi"
                               class="ds-input pl-10 pr-14">
                        <button type="button" id="toggle-password" aria-pressed="false" aria-label="Tampilkan kata sandi"
                                class="absolute inset-y-0 right-0 min-w-[48px] px-3 bg-[#F4F4F4] hover:bg-[#FFFF00] text-[#111111] border-2 border-[#111111] flex items-center justify-center transition-colors cursor-pointer">
                            <i id="toggle-password-icon" class="fa-solid fa-eye text-sm" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs text-[#525252] pt-1">
                    <label class="flex items-center gap-2.5 cursor-pointer font-medium min-h-[44px]">
                        <input type="checkbox" name="remember" class="w-4 h-4 accent-[#0000FF] border-2 border-[#111111]">
                        <span class="text-[#111111]">Ingat Saya di Perangkat Ini</span>
                    </label>
                </div>

                <button type="submit" class="w-full btn-primary py-3 text-sm font-bold">
                    <i class="fa-solid fa-right-to-bracket text-xs" aria-hidden="true"></i> Masuk Ke Dashboard Admin
                </button>

                <div class="text-center pt-4 border-t-2 border-[#111111]">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 min-h-[44px] px-3 text-xs font-mono font-bold text-[#111111] hover:text-[#0000FF] underline underline-offset-2 transition-colors">
                        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Kembali ke Website Publik
                    </a>
                </div>
            </form>
        </div>

    </div>

    <script>
        (function() {
            const toggleBtn = document.getElementById('toggle-password');
            const pwdInput = document.getElementById('password');
            const icon = document.getElementById('toggle-password-icon');
            if (!toggleBtn || !pwdInput || !icon) return;

            toggleBtn.addEventListener('click', function() {
                const isMasked = pwdInput.getAttribute('type') === 'password';
                pwdInput.setAttribute('type', isMasked ? 'text' : 'password');
                toggleBtn.setAttribute('aria-pressed', isMasked ? 'true' : 'false');
                toggleBtn.setAttribute('aria-label', isMasked ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
                icon.classList.toggle('fa-eye', !isMasked);
                icon.classList.toggle('fa-eye-slash', isMasked);
            });
        })();
    </script>

</body>
</html>
