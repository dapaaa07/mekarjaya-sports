<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Attendance;
use App\Models\AgeCategory;
use App\Models\TrainingSchedule;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $selectedSchedule = null;
        if ($request->filled('schedule_id')) {
            $selectedSchedule = TrainingSchedule::find($request->schedule_id);
        }

        $date = $request->input('date', $selectedSchedule ? $selectedSchedule->schedule_date->toDateString() : now()->toDateString());
        
        $query = Player::where('status', 'aktif');

        if ($request->filled('year')) {
            $query->where('birth_year', $request->year);
        }

        if ($request->filled('ku')) {
            $cat = AgeCategory::where('code', $request->ku)->first();
            if ($cat) {
                $query->whereBetween('birth_year', [$cat->min_birth_year, $cat->max_birth_year]);
            }
        } elseif ($selectedSchedule && $selectedSchedule->target_ku !== 'Semua KU') {
            $cat = AgeCategory::where('code', $selectedSchedule->target_ku)->first();
            if ($cat) {
                $query->whereBetween('birth_year', [$cat->min_birth_year, $cat->max_birth_year]);
            }
        }

        $players = $query->orderBy('birth_year', 'desc')->orderBy('full_name', 'asc')->get();

        // Existing attendances for this date or schedule
        $attQuery = Attendance::whereDate('date', $date);
        if ($selectedSchedule) {
            $attQuery->where(function($q) use ($selectedSchedule) {
                $q->where('training_schedule_id', $selectedSchedule->id)->orWhereNull('training_schedule_id');
            });
        }

        $attendances = $attQuery->get()->keyBy('player_id');

        // Fetch schedules for selector / dropdown
        $todaySchedules = TrainingSchedule::whereDate('schedule_date', $date)->get();

        $availableYears = Player::select('birth_year')
            ->distinct()
            ->orderBy('birth_year', 'desc')
            ->pluck('birth_year');

        $ageCategories = AgeCategory::all();

        return view('admin.attendances.index', compact(
            'players', 
            'date', 
            'attendances', 
            'availableYears', 
            'ageCategories', 
            'selectedSchedule', 
            'todaySchedules'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
        ]);

        $date = $request->date;
        $scheduleId = $request->input('schedule_id');

        foreach ($request->attendance as $playerId => $status) {
            Attendance::updateOrCreate(
                ['player_id' => $playerId, 'date' => $date],
                [
                    'status' => $status,
                    'training_schedule_id' => $scheduleId ?: null
                ]
            );
        }

        if ($scheduleId) {
            $sched = TrainingSchedule::find($scheduleId);
            if ($sched && $sched->status === 'scheduled') {
                $sched->update(['status' => 'completed']);
            }
        }

        return redirect()->route('admin.attendances.index', [
            'date' => $date,
            'schedule_id' => $scheduleId
        ])->with('success', "Presensi sesi latihan tanggal " . date('d M Y', strtotime($date)) . " berhasil disimpan!");
    }
}
