<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\CorrectionRequest;

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
        abort_unless($attendance->user_id === auth()->id(), 403);
        $user = Auth::user();

        $pendingRequest = CorrectionRequest::where('attendance_id', $attendance->id)
            ->where('status', 'pending')
            ->exists();

        return view('attendance.show', compact('attendance' , 'user', 'pendingRequest'));
    }

    /* =======================
    勤怠修正申請
    ======================== */
    public function requestCorrection(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|max:255'],
        [
            'reason.required' => '備考を入力してください。',
            'reason.max' => '備考は255文字以内で入力してください。',
        ]);
        $attendance = Attendance::findOrFail($id);

        CorrectionRequest::create([
            'attendance_id' => $attendance->id,
            'user_id' => auth()->id(),
            'requested_clock_in' => request('requested_clock_in'),
            'requested_clock_out' => request('requested_clock_out'),
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('attendance.list')->with('success', '修正申請を送信しました。');
    }

    /* =======================
    勤怠修正申請の承認
    ======================== */
    public function requests(Request $request)
    {
        $status = $request->query('status', 'pending');

        $requests = CorrectionRequest::with('attendance', 'user')
            ->where('user_id', auth()->id())
            ->where('status', $status)
            ->latest()
            ->get();

        return view('attendance.requests', compact('requests', 'status'));
    }

    public function requestForm($id)
    {
        $attendance = Attendance::with('correctionRequest')
            ->findOrFail($id);
        if ($attendance->correctionRequest && $attendance->correctionRequest->status === 'pending') {
            return redirect()->route('attendance.show', $attendance->id)->with('error', '承認待ちのため修正はできません。');
        }

        return view('attendance.request', compact('attendance'));
    }
}