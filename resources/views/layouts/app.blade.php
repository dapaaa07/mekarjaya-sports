<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mekar Jaya Sport Subang - Akademi SSB & Mini Soccer')</title>
    <meta name="description" content="Website Resmi Mekar Jaya Sport Subang. Akademi Sepak Bola (SSB) Pembinaan Usia Dini & Sewa Lapangan Mini Soccer Terfavorit di Subang.">
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-mekarjaya.jpg') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-mekarjaya.jpg') }}">
    
    <!-- Google Fonts: Inter (Saans substitute per DESIGN.md) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f5f1ec] text-[#111111] font-sans antialiased flex flex-col min-h-screen">

    <!-- Top Announcement Bar (Editorial Style) -->
    <div class="bg-[#111111] text-[#ffffff] py-2 text-xs border-b border-[#313130]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-2">
                <span class="bg-[#ff5600] text-white px-2 py-0.5 rounded text-[11px] font-semibold tracking-tight">INFO SSB</span>
                <span class="text-[#ebe7e1] text-xs font-normal">Pendaftaran Siswa Baru SSB Mekar Jaya Subang Angkatan {{ date('Y') }} Telah Dibuka</span>
            </div>
            <div class="flex items-center gap-4 text-xs text-[#9c9fa5]">
                <span><i class="fa-solid fa-location-dot text-[#ff5600] mr-1"></i> Cigadung & Lapangan Veteran Subang</span>
                <span class="hidden md:inline text-[#313130]">|</span>
                <a href="https://wa.me/6285133463626" target="_blank" class="hover:text-white transition-colors">
                    <i class="fa-brands fa-whatsapp text-[#16A34A] mr-1"></i> 0851-3346-3626
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar (DESIGN.md top-nav style) -->
    <header class="sticky top-0 z-50 bg-[#f5f1ec]/95 backdrop-blur-md border-b border-[#d3cec6] transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                <!-- Brand Logo (Official Partner Logo) -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Mekar Jaya Sports Logo" class="h-10 w-auto rounded-md object-contain border border-[#d3cec6]">
                    <div class="hidden sm:block">
                        <span class="font-bold text-base text-[#111111] tracking-tight block leading-tight">MEKARJAYA</span>
                        <span class="text-[10px] font-semibold text-[#ff5600] tracking-widest uppercase block">.SPORTS SUBANG</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-7 text-sm font-medium text-[#626260]">
                    <a href="{{ route('home') }}" class="hover:text-[#111111] transition-colors py-1">Beranda</a>
                    <a href="{{ route('home') }}#roster" class="hover:text-[#111111] transition-colors py-1 flex items-center gap-1.5 text-[#111111] font-semibold">
                        <i class="fa-solid fa-calendar-days text-[#ff5600] text-xs"></i> Roster Per Tahun
                    </a>
                    <a href="{{ route('parent.portal') }}" class="hover:text-[#111111] transition-colors py-1 text-[#111111] font-semibold flex items-center gap-1.5">
                        <i class="fa-solid fa-id-card text-[#16A34A]"></i> Portal Orang Tua
                    </a>
                    <a href="{{ route('home') }}#program" class="hover:text-[#111111] transition-colors py-1">Program KU</a>
                    <a href="{{ route('home') }}#pelatih" class="hover:text-[#111111] transition-colors py-1">Tim Pelatih</a>
                    <a href="{{ route('home') }}#mini-soccer" class="hover:text-[#111111] transition-colors py-1">Mini Soccer</a>
                </nav>

                <!-- Action Buttons (DESIGN.md button-primary & button-fin) -->
                <div class="hidden sm:flex items-center gap-3">
                    <a href="{{ route('login') }}" class="px-3.5 py-2 text-xs font-semibold text-[#626260] hover:text-[#111111] transition-colors">
                        <i class="fa-solid fa-lock mr-1 text-[#626260]"></i> Admin Portal
                    </a>
                    <a href="#pendaftaran" class="btn-fin text-xs py-2 px-4 shadow-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-user-plus text-xs"></i> Daftar Siswa
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button type="button" id="mobile-menu-btn" class="lg:hidden p-2 rounded-md text-[#111111] hover:bg-[#ebe7e1] focus:outline-none">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-[#d3cec6] bg-[#f5f1ec] px-4 pt-3 pb-6 space-y-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md font-medium text-[#111111] hover:bg-[#ebe7e1]">Beranda</a>
            <a href="{{ route('home') }}#roster" class="block px-3 py-2 rounded-md font-medium text-[#111111] hover:bg-[#ebe7e1]">Roster Pemain Per Tahun</a>
            <a href="{{ route('parent.portal') }}" class="block px-3 py-2 rounded-md font-medium text-[#111111] hover:bg-[#ebe7e1]">Portal Orang Tua & Rapor</a>
            <a href="{{ route('home') }}#program" class="block px-3 py-2 rounded-md font-medium text-[#111111] hover:bg-[#ebe7e1]">Program Kelompok Umur</a>
            <a href="{{ route('home') }}#pelatih" class="block px-3 py-2 rounded-md font-medium text-[#111111] hover:bg-[#ebe7e1]">Tim Pelatih</a>
            <a href="{{ route('home') }}#mini-soccer" class="block px-3 py-2 rounded-md font-medium text-[#111111] hover:bg-[#ebe7e1]">Tarif Mini Soccer</a>
            <a href="{{ route('home') }}#pendaftaran" class="block px-3 py-2 rounded-md font-medium text-[#111111] hover:bg-[#ebe7e1]">Pendaftaran Online</a>
            <div class="pt-3 border-t border-[#d3cec6] flex flex-col gap-2">
                <a href="{{ route('login') }}" class="w-full py-2.5 text-center rounded-md border border-[#d3cec6] bg-white text-[#111111] font-semibold text-xs">
                    <i class="fa-solid fa-lock text-[#626260] mr-1"></i> Admin Portal
                </a>
                <a href="#pendaftaran" class="w-full py-2.5 text-center rounded-md bg-[#ff5600] text-white font-semibold text-xs">
                    Daftar Siswa Baru
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer Section (DESIGN.md Editorial Footer style) -->
    <footer class="bg-[#111111] text-[#9c9fa5] pt-16 pb-12 border-t border-[#313130]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-[#313130]">
                
                <!-- Col 1: Brand Info -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Mekar Jaya Sports Logo" class="h-9 w-auto rounded-md object-contain border border-[#313130]">
                        <span class="font-bold text-base text-white tracking-tight">MEKARJAYA<span class="text-[#ff5600]">.SPORTS</span></span>
                    </div>
                    <p class="text-xs text-[#9c9fa5] leading-relaxed">
                        Akademi Sekolah Sepak Bola (SSB) berlisensi & Penyedia Lapangan Mini Soccer di Subang, Jawa Barat. Pembinaan karakter, teknik dasar, dan kompetisi usia dini.
                    </p>
                    <div class="flex items-center gap-2 pt-1">
                        <a href="https://facebook.com" target="_blank" class="w-8 h-8 rounded-md bg-[#313130] hover:bg-[#ff5600] text-white flex items-center justify-center transition-colors text-xs">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="https://instagram.com" target="_blank" class="w-8 h-8 rounded-md bg-[#313130] hover:bg-[#ff5600] text-white flex items-center justify-center transition-colors text-xs">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="https://wa.me/6285133463626" target="_blank" class="w-8 h-8 rounded-md bg-[#313130] hover:bg-[#16A34A] text-white flex items-center justify-center transition-colors text-xs">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div>
                    <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-4">Navigasi Utama</h4>
                    <ul class="space-y-2.5 text-xs text-[#9c9fa5]">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('home') }}#roster" class="hover:text-white transition-colors">Pencarian Pemain Per Tahun Lahir</a></li>
                        <li><a href="{{ route('parent.portal') }}" class="hover:text-white transition-colors">Portal Orang Tua & Rapor Digital</a></li>
                        <li><a href="{{ route('home') }}#program" class="hover:text-white transition-colors">Program Kelompok Umur (KU)</a></li>
                        <li><a href="{{ route('home') }}#pelatih" class="hover:text-white transition-colors">Profil Pelatih & Lisensi PSSI</a></li>
                        <li><a href="{{ route('home') }}#mini-soccer" class="hover:text-white transition-colors">Tarif Sewa Mini Soccer</a></li>
                    </ul>
                </div>

                <!-- Col 3: SSB Categories -->
                <div>
                    <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-4">Kelompok Umur (KU)</h4>
                    <ul class="space-y-2.5 text-xs text-[#9c9fa5]">
                        <li class="flex items-center justify-between border-b border-[#313130] pb-1.5">
                            <span>KU U-10 (2016-2017)</span>
                            <span class="text-[10px] bg-[#16A34A]/20 text-[#16A34A] px-2 py-0.5 rounded font-mono">Aktif</span>
                        </li>
                        <li class="flex items-center justify-between border-b border-[#313130] pb-1.5">
                            <span>KU U-12 (2014-2015)</span>
                            <span class="text-[10px] bg-[#16A34A]/20 text-[#16A34A] px-2 py-0.5 rounded font-mono">Aktif</span>
                        </li>
                        <li class="flex items-center justify-between border-b border-[#313130] pb-1.5">
                            <span>KU U-14 (2012-2013)</span>
                            <span class="text-[10px] bg-[#16A34A]/20 text-[#16A34A] px-2 py-0.5 rounded font-mono">Aktif</span>
                        </li>
                        <li class="flex items-center justify-between border-b border-[#313130] pb-1.5">
                            <span>KU U-16 (2010-2011)</span>
                            <span class="text-[10px] bg-[#16A34A]/20 text-[#16A34A] px-2 py-0.5 rounded font-mono">Aktif</span>
                        </li>
                        <li class="flex items-center justify-between">
                            <span>KU U-18 (2008-2009)</span>
                            <span class="text-[10px] bg-[#ff5600]/20 text-[#ff5600] px-2 py-0.5 rounded font-mono">Senior Muda</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Location & Contact -->
                <div class="space-y-3 text-xs">
                    <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-4">Kontak & Lokasi</h4>
                    <div class="flex gap-2 text-[#9c9fa5]">
                        <i class="fa-solid fa-map-pin text-[#ff5600] mt-0.5"></i>
                        <span><strong>Mini Soccer:</strong> Jl. Arief Rahman Hakim No.18, Cigadung, Subang.</span>
                    </div>
                    <div class="flex gap-2 text-[#9c9fa5]">
                        <i class="fa-solid fa-futbol text-[#16A34A] mt-0.5"></i>
                        <span><strong>Latihan SSB:</strong> Lapangan Veteran Dangdeur, Subang.</span>
                    </div>
                    <div class="flex gap-2 text-[#9c9fa5]">
                        <i class="fa-solid fa-phone text-[#ff5600] mt-0.5"></i>
                        <span>0851-3346-3626 (Sekretariat / WA)</span>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-[#7b7b78] gap-4">
                <p>&copy; {{ date('Y') }} Mekar Jaya Sport Subang. All rights reserved.</p>
                <p>Dikembangkan untuk Mitra SSB Subang.</p>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Toggle Script -->
    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
