<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CorrectionRequest;
use App\Models\Attendance;

class AdminController extends Controller
{

    // 管理者ログイン画面
    public function showLogin()
    {
        return view('admin.login');
    }

    // 管理者ログイン処理
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('/admin/requests');
        }

        return back()->withErrors([
            'email' => 'ログインできません'
        ]);
    }

    // 申請一覧（承認待ち / 承認済み）
    public function requests(Request $request)
    {
        $status = $request->query('status', 'pending');

        $requests = CorrectionRequest::with('attendance', 'user')
            ->where('status', $status)
            ->latest()
            ->get();

        return view('admin.requests', compact('requests', 'status'));
    }

    // 修正申請の承認
    public function approve($id)
    {
        $request = CorrectionRequest::findOrFail($id);

        $attendance = Attendance::findOrFail($request->attendance_id);

        // 勤怠を更新
        $attendance->clock_in = $request->requested_clock_in;
        $attendance->clock_out = $request->requested_clock_out;
        $attendance->save();

        // 申請ステータス更新
        $request->status = 'approved';
        $request->save();

        return redirect()->back();
    }
}