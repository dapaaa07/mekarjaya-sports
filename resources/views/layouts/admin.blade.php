<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Mekar Jaya Sport Subang')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-mekarjaya.jpg') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-mekarjaya.jpg') }}">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Chart.js for Radar & Bar Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f5f1ec] text-[#111111] font-sans antialiased flex flex-col lg:flex-row min-h-screen">

    <!-- Mobile Header Bar (< lg viewports) -->
    <div class="lg:hidden bg-[#111111] text-white px-4 py-3 border-b border-[#313130] flex items-center justify-between sticky top-0 z-40">
        <div class="flex items-center gap-3">
            <button id="admin-sidebar-toggle" class="text-white text-lg p-1.5 focus:outline-none rounded-md hover:bg-[#313130]">
                <i class="fa-solid fa-bars"></i>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Mekar Jaya Sports Logo" class="h-7 w-auto rounded object-contain">
                <span class="font-bold text-sm text-white">MEKARJAYA<span class="text-[#ff5600]">.SPORTS</span></span>
            </a>
        </div>
        <span class="text-[10px] font-mono text-[#9c9fa5] uppercase bg-[#313130] px-2 py-0.5 rounded">ADMIN</span>
    </div>

    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-black/60 z-40 hidden lg:hidden transition-opacity"></div>

    <!-- Sidebar Navigation (Responsive: Off-canvas on mobile, fixed 100vh viewport on desktop) -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 h-screen bg-[#111111] text-white flex flex-col justify-between border-r border-[#313130] flex-shrink-0 -translate-x-full lg:translate-x-0 transition-transform duration-300 overflow-hidden">
        <!-- Brand Logo (Fixed Header) -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-[#313130] flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo-mekarjaya.jpg') }}" alt="Mekar Jaya Sports Logo" class="h-8 w-auto rounded-md object-contain border border-[#313130]">
                <div>
                    <span class="font-bold text-white text-sm leading-tight block">MEKARJAYA<span class="text-[#ff5600]">.SPORTS</span></span>
                    <span class="text-[9px] font-mono text-[#9c9fa5] uppercase tracking-widest block">ADMIN PORTAL</span>
                </div>
            </a>
            <button id="close-sidebar-btn" class="lg:hidden text-[#9c9fa5] hover:text-white p-1">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Navigation Links (Scrolls independently if content overflows) -->
        <nav class="p-3 space-y-1 text-xs font-medium flex-1 overflow-y-auto min-h-0 custom-scrollbar">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-md transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#ff5600] text-white font-semibold' : 'text-[#9c9fa5] hover:bg-[#313130] hover:text-white' }}">
                <i class="fa-solid fa-chart-pie w-4 text-center"></i> Dashboard Utama
            </a>

            <!-- Core Solution Feature -->
            <a href="{{ route('admin.players.index') }}" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-md transition-colors {{ request()->routeIs('admin.players.*') ? 'bg-[#ff5600] text-white font-semibold' : 'text-[#9c9fa5] hover:bg-[#313130] hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-users w-4 text-center"></i> Data Pemain Per Tahun
                </div>
                <span class="bg-[#313130] text-[#ff5600] text-[9px] font-mono px-1.5 py-0.5 rounded uppercase">Utama</span>
            </a>

            <a href="{{ route('admin.registrations.index') }}" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-md transition-colors {{ request()->routeIs('admin.registrations.*') ? 'bg-[#ff5600] text-white font-semibold' : 'text-[#9c9fa5] hover:bg-[#313130] hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-user-plus w-4 text-center"></i> Pendaftaran Online
                </div>
                @php $pendingCnt = \App\Models\Registration::where('status', 'pending')->count(); @endphp
                @if($pendingCnt > 0)
                    <span class="bg-[#ff5600] text-white font-bold text-[10px] px-2 py-0.5 rounded-full">{{ $pendingCnt }}</span>
                @endif
            </a>

            <a href="{{ route('admin.schedules.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-md transition-colors {{ request()->routeIs('admin.schedules.*') ? 'bg-[#ff5600] text-white font-semibold' : 'text-[#9c9fa5] hover:bg-[#313130] hover:text-white' }}">
                <i class="fa-solid fa-calendar-days w-4 text-center"></i> Kelola Jadwal Latihan
            </a>

            <a href="{{ route('admin.attendances.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-md transition-colors {{ request()->routeIs('admin.attendances.*') ? 'bg-[#ff5600] text-white font-semibold' : 'text-[#9c9fa5] hover:bg-[#313130] hover:text-white' }}">
                <i class="fa-solid fa-calendar-check w-4 text-center"></i> Presensi Latihan
            </a>

            <a href="{{ route('admin.matches.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-md transition-colors {{ request()->routeIs('admin.matches.*') ? 'bg-[#ff5600] text-white font-semibold' : 'text-[#9c9fa5] hover:bg-[#313130] hover:text-white' }}">
                <i class="fa-solid fa-trophy w-4 text-center"></i> Match Center Laga
            </a>

            <a href="{{ route('admin.inventories.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-md transition-colors {{ request()->routeIs('admin.inventories.*') ? 'bg-[#ff5600] text-white font-semibold' : 'text-[#9c9fa5] hover:bg-[#313130] hover:text-white' }}">
                <i class="fa-solid fa-boxes-packing w-4 text-center"></i> Inventaris Peralatan
            </a>

            <a href="{{ route('home') }}" target="_blank"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-md text-[#9c9fa5] hover:bg-[#313130] hover:text-white transition-colors mt-6 border-t border-[#313130]">
                <i class="fa-solid fa-globe w-4 text-center"></i> Website Publik
            </a>
        </nav>

        <!-- Sidebar User Footer (Always Pinned at Bottom of Viewport) -->
        <div class="p-3 border-t border-[#313130] bg-[#111111] flex-shrink-0">
            <div class="flex items-center gap-2.5 mb-2.5 px-1">
                <div class="w-8 h-8 rounded bg-[#313130] text-white font-bold flex items-center justify-center text-xs border border-[#ff5600]">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <span class="block text-xs font-semibold text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <span class="block text-[10px] text-[#9c9fa5] truncate">Pengurus SSB</span>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-2 bg-[#313130] hover:bg-[#c41c1c] text-white rounded-md text-xs font-medium transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-from-bracket text-xs"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Layout (Padded by lg:pl-64 to accommodate fixed sidebar) -->
    <div class="flex-grow flex flex-col min-w-0 overflow-x-hidden lg:pl-64">
        
        <!-- Top Navbar Header -->
        <header class="min-h-16 py-3 bg-[#f5f1ec] border-b border-[#d3cec6] px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sticky top-0 z-30">
            <div>
                <h1 class="font-bold text-[#111111] text-base sm:text-lg leading-tight">@yield('page-header', 'Dashboard Sistem')</h1>
                <p class="text-xs text-[#626260]">Manajemen SSB Mekar Jaya Subang</p>
            </div>

            <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                <a href="{{ route('admin.players.print') }}" target="_blank" class="btn-secondary text-xs py-1.5 sm:py-2 px-3 flex items-center gap-1.5">
                    <i class="fa-solid fa-print text-[#111111]"></i> <span class="hidden xs:inline">Cetak Roster</span>
                </a>
                <a href="{{ route('admin.players.create') }}" class="btn-fin text-xs py-1.5 sm:py-2 px-3 flex items-center gap-1.5">
                    <i class="fa-solid fa-user-plus text-xs"></i> <span>Tambah Pemain</span>
                </a>
            </div>
        </header>

        <!-- Main Workspace Area -->
        <main class="p-4 sm:p-6 lg:p-8 flex-grow">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-[#ebe7e1] border border-[#16A34A] text-[#111111] rounded-md text-xs flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-[#16A34A] text-base"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div class="mb-6 p-4 bg-[#ebe7e1] border border-[#ff5600] text-[#111111] rounded-md text-xs flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-info-circle text-[#ff5600] text-base"></i>
                        <span class="font-medium">{{ session('info') }}</span>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    <!-- Mobile Drawer Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('admin-sidebar-toggle');
            const closeBtn = document.getElementById('close-sidebar-btn');
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);
        });
    </script>

</body>
</html>
