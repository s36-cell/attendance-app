<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', today())
            ->first();

        return view('attendance.index', compact('attendance'));
    }

    /* =======================
        出勤
    ======================== */
    public function clockIn()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', today())
            ->first();

        // すでに出勤済なら何もしない
        if ($attendance) {
            return redirect()->back();
        }

        Attendance::create([
            'user_id'   => auth()->id(),
            'work_date' => today(),
            'clock_in'  => now(),
        ]);

        return redirect()->back();
    }

    /* =======================
       退勤
    ======================== */
    public function clockOut()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', today())
            ->first();

        if (!$attendance || $attendance->clock_out) {
            return redirect()->back();
        }

        // 休憩中は退勤不可
        if ($attendance->break_start && !$attendance->break_end) {
            return redirect()->back();
        }

        $attendance->update([
            'clock_out' => now(),
        ]);

        return redirect()->back();
    }

    /* =======================
       休憩開始
    ======================== */
    public function breakStart()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', today())
            ->first();

        if (!$attendance || $attendance->clock_out) {
            return redirect()->back();
        }

        // すでに休憩中なら不可
        if ($attendance->break_start && !$attendance->break_end) {
            return redirect()->back();
        }

        $attendance->update([
            'break_start' => now(),
            'break_end'   => null,
        ]);

        return redirect()->back();
    }

    /* =======================
       休憩終了
    ======================== */
    public function breakEnd()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('work_date', today())
            ->first();

        if (!$attendance) {
            return redirect()->back();
        }

        if (!$attendance->break_start || $attendance->break_end) {
            return redirect()->back();
        }

        $attendance->update([
            'break_end' => now(),
        ]);

        return redirect()->back();
    }

    /* =======================
    今月一覧
    ======================== */
    public function list()
    {
        $userId = auth()->id();

        $currentMonth = request('month')
            ? Carbon::createFromFormat('Y-m', request('month'))
            : Carbon::now();
        $start = $currentMonth->copy()->startOfMonth();
        $end   = $currentMonth->copy()->endOfMonth();
        $attendances = Attendance::where('user_id', $userId)
            ->whereBetween('work_date', [$start, $end])
            ->orderBy('work_date')
            ->get();
        return view('attendance.list', compact('attendances', 'currentMonth'));
    }
    /* =======================
    詳細
    ======================== */
    public function show($id)
    {
        $attendance = Attendance::findOrFail($id);

        return view('attendance.show', compact('attendance'));
    }
}