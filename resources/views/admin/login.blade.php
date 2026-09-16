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
<body class="bg-[#f5f1ec] text-[#111111] min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md editorial-card p-8">
        
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Mekar Jaya Sports Logo" class="h-14 w-auto rounded-md object-contain mx-auto mb-3 border border-[#d3cec6]">
            <h1 class="font-bold text-xl text-[#111111]">Portal Pengurus SSB</h1>
            <p class="text-[#626260] text-xs mt-0.5">MEKARJAYA.SPORTS SUBANG</p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-3 bg-[#ebe7e1] border border-[#c41c1c] text-[#c41c1c] text-xs rounded-md">
                <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <div>
                <label for="email" class="block font-medium text-[#626260] uppercase mb-1">Alamat Email *</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#626260]">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" id="email" name="email" required value="{{ old('email', 'admin@mekarjaya.com') }}"
                        placeholder="admin@mekarjaya.com"
                        class="w-full pl-9 pr-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                </div>
            </div>

            <div>
                <label for="password" class="block font-medium text-[#626260] uppercase mb-1">Kata Sandi (Password) *</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#626260]">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" id="password" name="password" required value="admin123"
                        placeholder="••••••••"
                        class="w-full pl-9 pr-3.5 py-2.5 rounded-md border border-[#d3cec6] bg-white text-[#111111] focus:outline-none focus:ring-1 focus:ring-[#111111]">
                </div>
            </div>

            <div class="flex items-center justify-between text-xs text-[#626260] pt-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-[#d3cec6] text-[#111111] focus:ring-[#111111]">
                    <span>Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="w-full btn-fin py-3 text-xs flex items-center justify-center gap-2">
                <i class="fa-solid fa-right-to-bracket text-xs"></i> Masuk Ke Dashboard Admin
            </button>

            <div class="text-center pt-4 border-t border-[#ebe7e1]">
                <a href="{{ route('home') }}" class="text-xs text-[#626260] hover:text-[#111111] font-medium">
                    &larr; Kembali ke Website Publik
                </a>
            </div>
        </form>

    </div>

</body>
</html>
