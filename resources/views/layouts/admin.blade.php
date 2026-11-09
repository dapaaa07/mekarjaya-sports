<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Mekar Jaya Sport Subang')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-mekarjaya.jpg') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-mekarjaya.jpg') }}">

    <!-- Typography: Helvetica + JetBrains Mono per De Stijl Abstrato -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Chart.js for Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FFFFFF] text-[#111111] font-sans antialiased flex flex-col lg:flex-row min-h-[100dvh]">

    <!-- Mobile Header Bar (< lg viewports) -->
    <div class="lg:hidden bg-[#111111] text-white px-4 py-3 border-b-2 border-[#111111] flex items-center justify-between sticky top-0 z-[100] dark-surface">
        <div class="flex items-center gap-3">
            <button type="button" id="admin-sidebar-toggle" aria-label="Buka menu navigasi admin" aria-expanded="false" aria-controls="admin-sidebar"
                    class="min-w-[44px] min-h-[44px] border-2 border-[#FFFFFF] bg-[#111111] hover:bg-[#FFFF00] hover:text-[#111111] text-white flex items-center justify-center transition-colors cursor-pointer">
                <i class="fa-solid fa-bars text-base" aria-hidden="true"></i>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Mekar Jaya Sports Logo" class="h-8 w-8 object-cover border border-[#FFFFFF]">
                <span class="font-bold text-sm text-white tracking-tight">MEKARJAYA<span class="text-[#FFFF00]">.SPORTS</span></span>
            </a>
        </div>
        <span class="text-xs font-mono font-bold text-[#111111] bg-[#FFFF00] px-2.5 py-1 border border-[#FFFFFF] uppercase">ADMIN</span>
    </div>

    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-[#111111]/70 z-[200] hidden lg:hidden transition-opacity"></div>

    <!-- Sidebar Navigation (De Stijl Structural Rail) -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-[300] w-64 min-h-[100dvh] h-[100dvh] bg-[#111111] text-white flex flex-col justify-between border-r-2 border-[#111111] flex-shrink-0 -translate-x-full lg:translate-x-0 transition-transform duration-300 overflow-hidden dark-surface">

        <!-- Mondrian Thin Top Ribbon -->
        <div class="grid grid-cols-12 h-2 border-b-2 border-[#FFFFFF] shrink-0" aria-hidden="true">
            <div class="col-span-5 bg-[#FF0000] border-r-2 border-[#111111]"></div>
            <div class="col-span-4 bg-[#0000FF] border-r-2 border-[#111111]"></div>
            <div class="col-span-3 bg-[#FFFF00]"></div>
        </div>

        <!-- Brand Logo -->
        <div class="h-16 flex items-center justify-between px-4 border-b-2 border-[#333333] flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 min-w-0">
                <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Mekar Jaya Sports Logo" class="h-9 w-9 object-cover border-2 border-[#FFFFFF] shrink-0">
                <div class="min-w-0">
                    <span class="font-bold text-white text-sm leading-tight block truncate">MEKARJAYA<span class="text-[#FFFF00]">.SPORTS</span></span>
                    <span class="text-[10px] font-mono font-bold text-[#D4D4D4] uppercase tracking-widest block">ADMIN PORTAL</span>
                </div>
            </a>
            <button type="button" id="close-sidebar-btn" aria-label="Tutup menu admin"
                    class="lg:hidden min-w-[44px] min-h-[44px] text-white hover:bg-[#FFFF00] hover:text-[#111111] border border-[#525252] flex items-center justify-center cursor-pointer">
                <i class="fa-solid fa-xmark text-base" aria-hidden="true"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav aria-label="Menu Admin" class="p-3 space-y-1.5 text-xs flex-1 overflow-y-auto min-h-0 custom-scrollbar">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 min-h-[44px] px-3.5 py-2 border-2 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#FF0000] text-[#000000] border-[#FFFFFF] font-bold' : 'text-[#D4D4D4] border-transparent hover:bg-[#262626] hover:text-white font-medium' }}">
                <i class="fa-solid fa-chart-pie w-4 text-center" aria-hidden="true"></i> Dashboard Utama
            </a>

            <!-- Core Solution Feature -->
            <a href="{{ route('admin.players.index') }}"
               class="flex items-center justify-between min-h-[44px] px-3.5 py-2 border-2 transition-colors {{ request()->routeIs('admin.players.*') ? 'bg-[#FF0000] text-[#000000] border-[#FFFFFF] font-bold' : 'text-[#D4D4D4] border-transparent hover:bg-[#262626] hover:text-white font-medium' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-users w-4 text-center" aria-hidden="true"></i> Data Pemain Per Tahun
                </div>
                <span class="bg-[#FFFF00] text-[#111111] text-[10px] font-mono px-1.5 py-0.5 uppercase font-bold border border-[#111111]">Utama</span>
            </a>

            <a href="{{ route('admin.registrations.index') }}"
               class="flex items-center justify-between min-h-[44px] px-3.5 py-2 border-2 transition-colors {{ request()->routeIs('admin.registrations.*') ? 'bg-[#FF0000] text-[#000000] border-[#FFFFFF] font-bold' : 'text-[#D4D4D4] border-transparent hover:bg-[#262626] hover:text-white font-medium' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-user-plus w-4 text-center" aria-hidden="true"></i> Pendaftaran Online
                </div>
                @php $pendingCnt = \App\Models\Registration::where('status', 'pending')->count(); @endphp
                @if($pendingCnt > 0)
                    <span class="bg-[#FFFF00] text-[#111111] font-mono font-bold text-xs px-2 py-0.5 border border-[#111111]">{{ $pendingCnt }}</span>
                @endif
            </a>

            <a href="{{ route('admin.schedules.index') }}"
               class="flex items-center gap-3 min-h-[44px] px-3.5 py-2 border-2 transition-colors {{ request()->routeIs('admin.schedules.*') ? 'bg-[#FF0000] text-[#000000] border-[#FFFFFF] font-bold' : 'text-[#D4D4D4] border-transparent hover:bg-[#262626] hover:text-white font-medium' }}">
                <i class="fa-solid fa-calendar-days w-4 text-center" aria-hidden="true"></i> Kelola Jadwal Latihan
            </a>

            <a href="{{ route('admin.attendances.index') }}"
               class="flex items-center gap-3 min-h-[44px] px-3.5 py-2 border-2 transition-colors {{ request()->routeIs('admin.attendances.*') ? 'bg-[#FF0000] text-[#000000] border-[#FFFFFF] font-bold' : 'text-[#D4D4D4] border-transparent hover:bg-[#262626] hover:text-white font-medium' }}">
                <i class="fa-solid fa-calendar-check w-4 text-center" aria-hidden="true"></i> Presensi Latihan
            </a>

            <a href="{{ route('admin.matches.index') }}"
               class="flex items-center gap-3 min-h-[44px] px-3.5 py-2 border-2 transition-colors {{ request()->routeIs('admin.matches.*') ? 'bg-[#FF0000] text-[#000000] border-[#FFFFFF] font-bold' : 'text-[#D4D4D4] border-transparent hover:bg-[#262626] hover:text-white font-medium' }}">
                <i class="fa-solid fa-trophy w-4 text-center" aria-hidden="true"></i> Match Center Laga
            </a>

            <a href="{{ route('admin.inventories.index') }}"
               class="flex items-center gap-3 min-h-[44px] px-3.5 py-2 border-2 transition-colors {{ request()->routeIs('admin.inventories.*') ? 'bg-[#FF0000] text-[#000000] border-[#FFFFFF] font-bold' : 'text-[#D4D4D4] border-transparent hover:bg-[#262626] hover:text-white font-medium' }}">
                <i class="fa-solid fa-boxes-packing w-4 text-center" aria-hidden="true"></i> Inventaris Peralatan
            </a>

            <a href="{{ route('home') }}" target="_blank"
               class="flex items-center gap-3 min-h-[44px] px-3.5 py-2 text-[#FFFF00] hover:bg-[#262626] transition-colors mt-5 border-t-2 border-[#333333] pt-4 font-bold">
                <i class="fa-solid fa-globe w-4 text-center" aria-hidden="true"></i> Website Publik
            </a>
        </nav>

        <!-- Sidebar User Footer -->
        <div class="p-4 border-t-2 border-[#333333] bg-[#111111] flex-shrink-0">
            <div class="flex items-center gap-2.5 mb-3 px-1">
                <div class="w-9 h-9 bg-[#0000FF] text-white font-mono font-bold flex items-center justify-center text-sm border-2 border-[#FFFFFF] shrink-0">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <span class="block text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <span class="block text-[11px] font-mono text-[#D4D4D4] truncate">Pengurus SSB</span>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full min-h-[44px] py-2 bg-[#222222] hover:bg-[#FF0000] hover:text-[#000000] text-white border-2 border-[#525252] hover:border-[#FFFFFF] text-xs font-bold transition-colors flex items-center justify-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-right-from-bracket text-xs" aria-hidden="true"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Layout -->
    <div class="flex-grow flex flex-col min-w-0 overflow-x-hidden lg:pl-64 bg-[#F4F4F4]">

        <!-- Top Navbar Header -->
        <header class="min-h-16 py-3.5 bg-white border-b-2 border-[#111111] px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sticky top-0 z-[50]">
            <div>
                <h1 class="font-bold text-[#111111] text-lg sm:text-xl leading-tight">@yield('page-header', 'Dashboard Sistem')</h1>
                <p class="text-xs font-mono text-[#525252]">Manajemen SSB Mekar Jaya Subang</p>
            </div>

            <div class="flex items-center gap-2.5 flex-wrap">
                <a href="{{ route('admin.players.print') }}" target="_blank" class="btn-secondary text-xs py-2 px-4">
                    <i class="fa-solid fa-print" aria-hidden="true"></i> <span>Cetak Roster</span>
                </a>
                <a href="{{ route('admin.players.create') }}" class="btn-primary text-xs py-2 px-4">
                    <i class="fa-solid fa-user-plus text-xs" aria-hidden="true"></i> <span>Tambah Pemain</span>
                </a>
            </div>
        </header>

        <!-- Main Workspace Area -->
        <main class="p-4 sm:p-6 lg:p-8 flex-grow bg-[#F4F4F4]">
            <!-- Flash & Validation Alerts -->
            @if(session('success'))
                <x-alert type="success" title="Berhasil" class="mb-6">
                    <p>{{ session('success') }}</p>
                </x-alert>
            @endif

            @if(session('info'))
                <x-alert type="info" title="Pemberitahuan" class="mb-6">
                    <p>{{ session('info') }}</p>
                </x-alert>
            @endif

            @if(session('warning'))
                <x-alert type="warning" title="Peringatan" class="mb-6">
                    <p>{{ session('warning') }}</p>
                </x-alert>
            @endif

            @if(session('error'))
                <x-alert type="error" title="Terjadi Kesalahan" class="mb-6">
                    <p>{{ session('error') }}</p>
                </x-alert>
            @endif

            @if($errors->any())
                <x-alert type="error" title="Mohon Periksa Kembali Form Anda" class="mb-6">
                    <ul class="list-disc list-inside space-y-1 text-xs">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            @yield('content')
        </main>

    </div>

    <!-- Mobile Drawer Toggle + Keyboard Escape Support -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('admin-sidebar-toggle');
            const closeBtn = document.getElementById('close-sidebar-btn');
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');

            function openSidebar() {
                if (!sidebar || !backdrop) return;
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'true');
            }

            function closeSidebar() {
                if (!sidebar || !backdrop) return;
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'false');
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);
            window.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeSidebar();
            });
        });
    </script>

</body>
</html>
