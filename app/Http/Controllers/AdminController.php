<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Registration;
use App\Models\Attendance;
use App\Models\AgeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function loginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak cocok.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function dashboard()
    {
        $totalPlayers = Player::where('status', 'aktif')->count();
        $pendingRegistrations = Registration::where('status', 'pending')->count();
        
        // Attendance today
        $todayAtt = Attendance::whereDate('date', now()->toDateString())->count();
        $todayHadir = Attendance::whereDate('date', now()->toDateString())->where('status', 'hadir')->count();

        // SPP Summary
        $sppLunas = Player::where('status', 'aktif')->where('spp_status', 'Lunas')->count();
        $sppMenunggak = Player::where('status', 'aktif')->where('spp_status', 'Belum Bayar')->count();

        // Distribution by Birth Year (Core Pain Point Visualizer!)
        $playersByYear = Player::select('birth_year', DB::raw('count(*) as total'))
            ->where('status', 'aktif')
            ->groupBy('birth_year')
            ->orderBy('birth_year', 'desc')
            ->get();

        // Recent registrations
        $recentRegs = Registration::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPlayers',
            'pendingRegistrations',
            'todayAtt',
            'todayHadir',
            'sppLunas',
            'sppMenunggak',
            'playersByYear',
            'recentRegs'
        ));
    }
}
