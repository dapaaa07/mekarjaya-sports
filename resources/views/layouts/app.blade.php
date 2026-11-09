<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mekar Jaya Sport Subang - Akademi SSB & Mini Soccer')</title>
    <meta name="description" content="Website Resmi Mekar Jaya Sport Subang. Akademi Sepak Bola (SSB) Pembinaan Usia Dini & Sewa Lapangan Mini Soccer di Subang.">

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-mekarjaya.jpg') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-mekarjaya.jpg') }}">

    <!-- Typography: Helvetica + JetBrains Mono per De Stijl Abstrato -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FFFFFF] text-[#111111] font-sans antialiased flex flex-col min-h-[100dvh]">

    <!-- Top Announcement Bar (Mondrian Dark Strip) -->
    <div class="bg-[#111111] text-[#FFFFFF] py-2.5 text-xs border-b-2 border-[#111111] dark-surface">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-2.5 flex-wrap justify-center sm:justify-start">
                <span class="bg-[#FFFF00] text-[#111111] px-2.5 py-0.5 border border-[#FFFFFF] text-xs font-mono font-bold tracking-tight uppercase">INFO SSB</span>
                <span class="text-[#FFFFFF] text-xs font-normal">Pendaftaran Siswa Baru SSB Mekar Jaya Subang Angkatan {{ date('Y') }} Dibuka</span>
            </div>
            <div class="flex flex-wrap items-center justify-center sm:justify-end gap-x-4 gap-y-1 text-xs text-[#D4D4D4]">
                <span class="whitespace-nowrap"><i class="fa-solid fa-location-dot text-[#FFFF00] mr-1" aria-hidden="true"></i> Cigadung & Lapangan Veteran Subang</span>
                <span class="hidden md:inline text-[#525252]" aria-hidden="true">|</span>
                <a href="https://wa.me/6285133463626" target="_blank" class="whitespace-nowrap hover:text-[#FFFF00] font-mono font-medium underline underline-offset-2 transition-colors">
                    <i class="fa-brands fa-whatsapp text-[#FFFF00] mr-1" aria-hidden="true"></i> 0851-3346-3626
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar (De Stijl Structural Canvas, z-index 100) -->
    <header class="sticky top-0 z-[100] bg-[#FFFFFF] border-b-2 border-[#111111]">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6">
            <div class="flex justify-between items-center min-h-[4.5rem] gap-4">

                <!-- Brand Logo (With Preserved Secret Admin Multi-Click Trigger) -->
                <a href="{{ route('home') }}" id="secret-logo-trigger" class="flex items-center gap-3 group select-none min-h-[44px]">
                    <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Mekar Jaya Sports Logo" class="h-11 w-11 object-cover border-2 border-[#111111]">
                    <div class="hidden sm:block">
                        <span class="font-bold text-base text-[#111111] tracking-tight block leading-tight">MEKARJAYA<span class="text-[#CC0000]">.SPORTS</span></span>
                        <span class="text-[11px] font-mono font-bold text-[#525252] tracking-wider uppercase block">SUBANG ACADEMY</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav aria-label="Navigasi Utama" class="hidden lg:flex items-center gap-6 text-sm font-medium text-[#111111]">
                    <a href="{{ route('home') }}" class="py-2 px-1 border-b-2 {{ request()->routeIs('home') ? 'border-[#FF0000] font-bold text-[#111111]' : 'border-transparent hover:border-[#111111]' }} transition-colors">Beranda</a>
                    <a href="{{ route('home') }}#roster" class="py-2 px-1 border-b-2 border-transparent hover:border-[#0000FF] transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-calendar-days text-xs text-[#0000FF]" aria-hidden="true"></i> Roster Per Tahun
                    </a>
                    <a href="{{ route('parent.portal') }}" class="py-2 px-1 border-b-2 {{ request()->routeIs('parent.portal') ? 'border-[#0000FF] font-bold text-[#0000FF]' : 'border-transparent hover:border-[#0000FF]' }} transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-id-card text-xs text-[#0000FF]" aria-hidden="true"></i> Portal Orang Tua
                    </a>
                    <a href="{{ route('home') }}#program" class="py-2 px-1 border-b-2 border-transparent hover:border-[#111111] transition-colors">Program KU</a>
                    <a href="{{ route('home') }}#pelatih" class="py-2 px-1 border-b-2 border-transparent hover:border-[#111111] transition-colors">Tim Pelatih</a>
                    <a href="{{ route('home') }}#mini-soccer" class="py-2 px-1 border-b-2 border-transparent hover:border-[#111111] transition-colors">Mini Soccer</a>
                    <a href="{{ route('home') }}#faq" class="py-2 px-1 border-b-2 border-transparent hover:border-[#111111] transition-colors">FAQ</a>
                </nav>

                <!-- Action CTA & Mobile Toggle -->
                <div class="flex items-center gap-2.5">
                    <a href="{{ route('home') }}#pendaftaran" class="hidden sm:inline-flex btn-primary text-xs sm:text-sm py-2.5 px-4">
                        <i class="fa-solid fa-user-plus text-xs" aria-hidden="true"></i> Daftar Siswa
                    </a>

                    <button type="button" id="mobile-menu-btn" aria-expanded="false" aria-controls="mobile-menu"
                            class="lg:hidden min-w-[44px] min-h-[44px] px-3 border-2 border-[#111111] bg-white hover:bg-[#FFFF00] text-[#111111] font-bold text-xs uppercase tracking-wider inline-flex items-center justify-center gap-2 transition-colors cursor-pointer">
                        <i class="fa-solid fa-bars text-base" aria-hidden="true"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <nav id="mobile-menu" aria-label="Menu Mobile" class="hidden lg:hidden border-t-2 border-[#111111] bg-white px-4 pt-3 pb-6 space-y-2">
            <a href="{{ route('home') }}" class="flex items-center min-h-[44px] px-3 py-2 border-2 border-[#111111] bg-[#F4F4F4] font-bold text-sm text-[#111111]">Beranda</a>
            <a href="{{ route('home') }}#roster" class="flex items-center min-h-[44px] px-3 py-2 border-2 border-[#111111] bg-[#FFFF00] text-[#111111] font-bold text-sm">Roster Pemain Per Tahun</a>
            <a href="{{ route('parent.portal') }}" class="flex items-center min-h-[44px] px-3 py-2 border-2 border-[#111111] bg-[#0000FF] text-white font-bold text-sm">Portal Orang Tua & Rapor</a>
            <a href="{{ route('home') }}#program" class="flex items-center min-h-[44px] px-3 py-2 border border-[#111111] font-medium text-sm text-[#111111] hover:bg-[#F4F4F4]">Program Kelompok Umur</a>
            <a href="{{ route('home') }}#pelatih" class="flex items-center min-h-[44px] px-3 py-2 border border-[#111111] font-medium text-sm text-[#111111] hover:bg-[#F4F4F4]">Tim Pelatih</a>
            <a href="{{ route('home') }}#mini-soccer" class="flex items-center min-h-[44px] px-3 py-2 border border-[#111111] font-medium text-sm text-[#111111] hover:bg-[#F4F4F4]">Tarif Mini Soccer</a>
            <a href="{{ route('home') }}#pendaftaran" class="flex items-center min-h-[44px] px-3 py-2 border border-[#111111] font-medium text-sm text-[#111111] hover:bg-[#F4F4F4]">Pendaftaran Online</a>
            <a href="{{ route('home') }}#faq" class="flex items-center min-h-[44px] px-3 py-2 border border-[#111111] font-medium text-sm text-[#111111] hover:bg-[#F4F4F4]">FAQ (Tanya Jawab)</a>
            <div class="pt-2">
                <a href="{{ route('home') }}#pendaftaran" class="w-full btn-primary text-sm">
                    Daftar Siswa Baru
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow bg-[#FFFFFF]">
        @yield('content')
    </main>

    <!-- Footer Section (Asymmetric Mondrian Architecture) -->
    <footer class="bg-[#111111] text-[#D4D4D4] border-t-4 border-[#111111] dark-surface">
        <!-- Mondrian Horizontal Divider Ribbon -->
        <div class="grid grid-cols-12 h-3 border-b-2 border-[#FFFFFF]" aria-hidden="true">
            <div class="col-span-4 bg-[#FF0000] border-r-2 border-[#111111]"></div>
            <div class="col-span-5 bg-[#FFFF00] border-r-2 border-[#111111]"></div>
            <div class="col-span-3 bg-[#0000FF]"></div>
        </div>

        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 pt-14 pb-10">
            <!-- Asymmetric 12-Col Split (5 / 3 / 4 instead of uniform 4 columns) -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 pb-10 border-b-2 border-[#333333]">

                <!-- Brand Manifesto Block (5 cols) -->
                <div class="md:col-span-5 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Mekar Jaya Sports Logo" class="h-11 w-11 object-cover border-2 border-[#FFFFFF]">
                        <div>
                            <span class="font-bold text-lg text-white tracking-tight block leading-none">MEKARJAYA<span class="text-[#FFFF00]">.SPORTS</span></span>
                            <span class="text-xs font-mono text-[#D4D4D4] uppercase tracking-wider">SUBANG ACADEMY</span>
                        </div>
                    </div>
                    <p class="text-sm text-[#D4D4D4] leading-relaxed max-w-md">
                        Sekolah Sepak Bola (SSB) berlisensi PSSI dan pengelola Lapangan Mini Soccer di Subang, Jawa Barat. Fokus pada pembinaan teknik dasar, kedisiplinan, dan keabsahan kelompok umur.
                    </p>
                    <div class="flex items-center gap-2 pt-2">
                        <a href="https://facebook.com" target="_blank" aria-label="Facebook Mekar Jaya Subang"
                           class="w-11 h-11 bg-[#1C1C1C] border-2 border-[#FFFFFF] hover:bg-[#0000FF] text-white flex items-center justify-center transition-colors text-sm">
                            <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
                        </a>
                        <a href="https://instagram.com" target="_blank" aria-label="Instagram Mekar Jaya Subang"
                           class="w-11 h-11 bg-[#1C1C1C] border-2 border-[#FFFFFF] hover:bg-[#FF0000] hover:text-[#000000] text-white flex items-center justify-center transition-colors text-sm">
                            <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                        </a>
                        <a href="https://wa.me/6285133463626" target="_blank" aria-label="WhatsApp Sekretariat SSB"
                           class="w-11 h-11 bg-[#FFFF00] border-2 border-[#FFFFFF] hover:bg-[#E6E600] text-[#111111] flex items-center justify-center transition-colors text-base">
                            <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <!-- Navigation Directory (3 cols) -->
                <div class="md:col-span-3">
                    <h4 class="text-white font-bold text-xs font-mono uppercase tracking-wider mb-4 border-l-4 border-[#FF0000] pl-2.5">Navigasi Halaman</h4>
                    <ul class="space-y-0.5 text-sm text-[#D4D4D4]">
                        <li><a href="{{ route('home') }}" class="inline-flex items-center min-h-[44px] hover:text-[#FFFF00] transition-colors">Beranda</a></li>
                        <li><a href="{{ route('home') }}#roster" class="inline-flex items-center min-h-[44px] hover:text-[#FFFF00] transition-colors">Roster Siswa Per Tahun</a></li>
                        <li><a href="{{ route('parent.portal') }}" class="inline-flex items-center min-h-[44px] hover:text-[#FFFF00] transition-colors">Portal Orang Tua & Rapor</a></li>
                        <li><a href="{{ route('home') }}#program" class="inline-flex items-center min-h-[44px] hover:text-[#FFFF00] transition-colors">Program Kelompok Umur</a></li>
                        <li><a href="{{ route('home') }}#pelatih" class="inline-flex items-center min-h-[44px] hover:text-[#FFFF00] transition-colors">Profil Tim Pelatih</a></li>
                        <li><a href="{{ route('home') }}#mini-soccer" class="inline-flex items-center min-h-[44px] hover:text-[#FFFF00] transition-colors">Tarif Sewa Mini Soccer</a></li>
                        <li><a href="{{ route('home') }}#faq" class="inline-flex items-center min-h-[44px] hover:text-[#FFFF00] transition-colors">FAQ & Tanya Jawab</a></li>
                        <li>
                            <button type="button" onclick="openPrivacyModal()" class="inline-flex items-center min-h-[44px] text-left underline underline-offset-2 text-white hover:text-[#FFFF00] transition-colors cursor-pointer">
                                Syarat & Ketentuan Privasi KK
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Location & Cohort Quick Reference (4 cols) -->
                <div class="md:col-span-4 space-y-5">
                    <div class="border-2 border-[#333333] p-4 bg-[#181818] space-y-3 text-sm">
                        <h4 class="text-white font-bold text-xs font-mono uppercase tracking-wider border-l-4 border-[#0000FF] pl-2.5">Lokasi & Kontak Resmi</h4>
                        <div class="flex gap-2.5 text-[#D4D4D4]">
                            <i class="fa-solid fa-map-pin text-[#FFFF00] mt-1 shrink-0" aria-hidden="true"></i>
                            <span><strong class="text-white">Mini Soccer:</strong> Jl. Arief Rahman Hakim No.18, Cigadung, Subang.</span>
                        </div>
                        <div class="flex gap-2.5 text-[#D4D4D4]">
                            <i class="fa-solid fa-futbol text-[#FFFF00] mt-1 shrink-0" aria-hidden="true"></i>
                            <span><strong class="text-white">Latihan SSB:</strong> Lapangan Veteran Dangdeur, Subang.</span>
                        </div>
                        <div class="flex gap-2.5 text-[#D4D4D4]">
                            <i class="fa-solid fa-phone text-[#FFFF00] mt-1 shrink-0" aria-hidden="true"></i>
                            <span class="font-mono text-white">0851-3346-3626 (Sekretariat / WA)</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-1.5 text-[11px] font-mono">
                        <span class="px-2 py-1 bg-[#FFFFFF] text-[#111111] font-bold">U-10 (2016-2017)</span>
                        <span class="px-2 py-1 bg-[#FFFF00] text-[#111111] font-bold">U-12 (2014-2015)</span>
                        <span class="px-2 py-1 bg-[#0000FF] text-white font-bold">U-14 (2012-2013)</span>
                        <span class="px-2 py-1 bg-[#FF0000] text-[#000000] font-bold">U-16 & U-18</span>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright (Preserved Secret Triple-Click Trigger & Legal Link) -->
            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-[#D4D4D4] gap-4">
                <p><span id="secret-footer-trigger" class="cursor-default select-none font-mono" title="Mekar Jaya Sports">&copy;</span> {{ date('Y') }} Mekar Jaya Sport Subang. Seluruh hak cipta dilindungi.</p>
                <div>
                    <button type="button" onclick="openPrivacyModal()" class="min-h-[44px] px-2 text-white hover:text-[#FFFF00] transition-colors underline underline-offset-2 cursor-pointer">
                        Syarat & Ketentuan serta Kebijakan Privasi Dokumen KK
                    </button>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Quick-Help Widget (WhatsApp Direct + Back-to-Top) -->
    <div id="floating-quick-help" class="fixed bottom-4 right-4 z-[200] flex flex-col items-end gap-2 no-print">
        <button type="button" id="btn-back-to-top" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
                aria-label="Kembali ke atas halaman"
                class="hidden min-w-[44px] min-h-[44px] px-3.5 bg-[#FFFFFF] text-[#111111] border-2 border-[#111111] hover:bg-[#FFFF00] font-mono font-bold text-xs items-center justify-center gap-1.5 shadow-[0_2px_8px_rgba(0,0,0,0.08)] transition-colors cursor-pointer">
            <i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
            <span class="hidden sm:inline">Atas</span>
        </button>

        <a id="btn-wa-help"
           href="https://wa.me/6285133463626?text={{ rawurlencode('Halo Pengurus SSB Mekar Jaya Subang, saya ingin bertanya mengenai pendaftaran siswa atau layanan.') }}"
           target="_blank"
           aria-label="Chat Pengurus SSB via WhatsApp"
           class="min-w-[44px] min-h-[44px] px-3.5 sm:px-4 bg-[#FFFF00] text-[#111111] border-2 border-[#111111] hover:bg-[#E6E600] font-bold text-xs inline-flex items-center justify-center gap-2 shadow-[0_2px_8px_rgba(0,0,0,0.08)] transition-colors">
            <i class="fa-brands fa-whatsapp text-base" aria-hidden="true"></i>
            <span class="hidden sm:inline">Butuh Bantuan? Chat WA</span>
        </a>
    </div>

    @include('components.privacy-modal')

    <!-- Core UI Interactions, Validation ARIA Sync & Preserved Secret Admin Access -->
    <script>
        // Mobile Drawer Toggle
        (function() {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            if (btn && menu) {
                btn.addEventListener('click', function() {
                    const isHidden = menu.classList.toggle('hidden');
                    btn.setAttribute('aria-expanded', isHidden ? 'false' : 'true');
                });
            }
        })();

        // Show/Hide Back-to-Top Button on Scroll >= 400px
        (function() {
            const backToTopBtn = document.getElementById('btn-back-to-top');
            if (!backToTopBtn) return;

            const toggleTopBtn = () => {
                if (window.scrollY > 400) {
                    backToTopBtn.classList.remove('hidden');
                    backToTopBtn.classList.add('inline-flex');
                } else {
                    backToTopBtn.classList.add('hidden');
                    backToTopBtn.classList.remove('inline-flex');
                }
            };

            window.addEventListener('scroll', toggleTopBtn, { passive: true });
            toggleTopBtn();
        })();

        // Sync aria-invalid with native :user-invalid state (Modern Web Guidance)
        (function() {
            const syncAria = (el) => {
                if (el && typeof el.matches === 'function' && el.classList.contains('ds-input')) {
                    el.setAttribute('aria-invalid', el.matches(':user-invalid') ? 'true' : 'false');
                }
            };
            document.addEventListener('blur', (e) => syncAria(e.target), true);
            document.addEventListener('input', (e) => {
                if (e.target && e.target.hasAttribute && e.target.hasAttribute('aria-invalid')) {
                    syncAria(e.target);
                }
            });
        })();

        // 1. Keyboard Shortcut: Ctrl + Shift + A or Ctrl + Alt + A
        window.addEventListener('keydown', function(e) {
            const isModifier = e.ctrlKey || e.metaKey;
            const isSecondary = e.shiftKey || e.altKey;
            if (isModifier && isSecondary && (e.key === 'a' || e.key === 'A')) {
                e.preventDefault();
                window.location.href = "{{ route('login') }}";
            }
        });

        // 2. Secret Triple-Click on Brand Logo
        let logoClicks = 0;
        let logoTimer = null;
        const logoTrigger = document.getElementById('secret-logo-trigger');
        if (logoTrigger) {
            logoTrigger.addEventListener('click', function(e) {
                logoClicks++;
                if (logoClicks >= 3) {
                    e.preventDefault();
                    e.stopPropagation();
                    clearTimeout(logoTimer);
                    logoClicks = 0;
                    window.location.href = "{{ route('login') }}";
                    return;
                }
                if (logoClicks === 1) {
                    e.preventDefault();
                    logoTimer = setTimeout(() => {
                        logoClicks = 0;
                        window.location.href = "{{ route('home') }}";
                    }, 350);
                } else {
                    e.preventDefault();
                }
            });
        }

        // 3. Secret Triple-Click on Footer Copyright Symbol
        let footerClicks = 0;
        let footerTimer = null;
        const footerTrigger = document.getElementById('secret-footer-trigger');
        if (footerTrigger) {
            footerTrigger.addEventListener('click', function(e) {
                e.preventDefault();
                footerClicks++;
                clearTimeout(footerTimer);
                if (footerClicks >= 3) {
                    footerClicks = 0;
                    window.location.href = "{{ route('login') }}";
                } else {
                    footerTimer = setTimeout(() => {
                        footerClicks = 0;
                    }, 800);
                }
            });
        }
    </script>
</body>
</html>
