<?php

namespace App\Http\Controllers;

use App\Models\TrainingSchedule;
use App\Models\AgeCategory;
use App\Models\Coach;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = TrainingSchedule::query()->orderBy('schedule_date', 'desc')->orderBy('start_time', 'asc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('ku')) {
            $query->where(function($q) use ($request) {
                $q->where('target_ku', $request->ku)->orWhere('target_ku', 'Semua KU');
            });
        }

        $schedules = $query->paginate(15)->withQueryString();
        $ageCategories = AgeCategory::all();

        return view('admin.schedules.index', compact('schedules', 'ageCategories'));
    }

    public function create()
    {
        $ageCategories = AgeCategory::all();
        $coaches = Coach::all();
        return view('admin.schedules.create', compact('ageCategories', 'coaches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'schedule_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string|max:255',
            'target_ku' => 'required|string',
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);

        TrainingSchedule::create([
            'title' => $request->title,
            'schedule_date' => $request->schedule_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'target_ku' => $request->target_ku,
            'coach_in_charge' => $request->coach_in_charge,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal latihan berhasil ditambahkan!');
    }

    public function edit(TrainingSchedule $schedule)
    {
        $ageCategories = AgeCategory::all();
        $coaches = Coach::all();
        return view('admin.schedules.edit', compact('schedule', 'ageCategories', 'coaches'));
    }

    public function update(Request $request, TrainingSchedule $schedule)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'schedule_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string|max:255',
            'target_ku' => 'required|string',
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);

        $schedule->update([
            'title' => $request->title,
            'schedule_date' => $request->schedule_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'target_ku' => $request->target_ku,
            'coach_in_charge' => $request->coach_in_charge,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal latihan berhasil diperbarui!');
    }

    public function destroy(TrainingSchedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal latihan berhasil dihapus!');
    }
}
