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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-[#111111] min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md editorial-card p-8 border border-[#EAEAEA]">
        
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Mekar Jaya Sports Logo" class="h-16 w-auto rounded-xl object-contain mx-auto mb-3 border border-[#EAEAEA] shadow-sm">
            <h1 class="font-extrabold text-2xl text-[#111111]">Portal Pengurus SSB</h1>
            <p class="text-[#666666] text-xs font-semibold uppercase tracking-wider mt-1">MEKARJAYA.SPORTS SUBANG</p>
        </div>

        @if($errors->any())
            <x-alert type="error" title="Gagal Masuk" class="mb-6">
                <p>{{ $errors->first() }}</p>
            </x-alert>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <div>
                <label for="email" class="block font-semibold text-[#111111] uppercase tracking-wider text-[11px] mb-1.5">Alamat Email *</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[#666666]">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" id="email" name="email" required value="{{ old('email', 'admin@mekarjaya.com') }}"
                        placeholder="admin@mekarjaya.com"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-[#EAEAEA] bg-white text-[#111111] focus:outline-none focus:ring-2 focus:ring-[#FF6B00]">
                </div>
            </div>

            <div>
                <label for="password" class="block font-semibold text-[#111111] uppercase tracking-wider text-[11px] mb-1.5">Kata Sandi (Password) *</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[#666666]">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" id="password" name="password" required value="admin123"
                        placeholder="••••••••"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-[#EAEAEA] bg-white text-[#111111] focus:outline-none focus:ring-2 focus:ring-[#FF6B00]">
                </div>
            </div>

            <div class="flex items-center justify-between text-xs text-[#666666] pt-1">
                <label class="flex items-center gap-2 cursor-pointer font-medium">
                    <input type="checkbox" name="remember" class="rounded border-[#EAEAEA] text-[#FF6B00] focus:ring-[#FF6B00]">
                    <span>Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="w-full btn-primary py-3 text-xs flex items-center justify-center gap-2 shadow-sm font-semibold">
                <i class="fa-solid fa-right-to-bracket text-xs"></i> Masuk Ke Dashboard Admin
            </button>

            <div class="text-center pt-5 border-t border-[#EAEAEA]">
                <a href="{{ route('home') }}" class="text-xs text-[#666666] hover:text-[#111111] font-medium transition-colors">
                    &larr; Kembali ke Website Publik
                </a>
            </div>
        </form>

    </div>

</body>
</html>
