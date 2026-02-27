<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| トップページ
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});



/*
|--------------------------------------------------------------------------
| 認証が必要なページ
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // ダッシュボード
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');



    /*
    |--------------------------------------------------------------------------
    | 勤怠関連
    |--------------------------------------------------------------------------
    */

    // 勤怠トップ画面
    Route::get('/attendance', [AttendanceController::class, 'index'])
        ->name('attendance.index');

    // 出勤
    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])
        ->name('attendance.clock-in');

    // 退勤
    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])
        ->name('attendance.clock-out');

    // 休憩開始
    Route::post('/attendance/break-start', [AttendanceController::class, 'breakStart'])
        ->name('attendance.break-start');

    // 休憩終了
    Route::post('/attendance/break-end', [AttendanceController::class, 'breakEnd'])
        ->name('attendance.break-end');

    // 今月一覧
    Route::get('/attendance/list', [AttendanceController::class, 'list'])
        ->name('attendance.list')
        ->middleware('auth');

    Route::get('/attendance/{id}', [AttendanceController::class, 'show'])
        ->name('attendance.show')
        ->middleware('auth');
});