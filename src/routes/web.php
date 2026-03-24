<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;

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
Route::get('/home', function () {
    return redirect('/attendance');
});
Route::get('/dashboard', function () {
    return redirect('/attendance');
});




/*
|--------------------------------------------------------------------------
| 認証が必要なページ
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {




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
        ->name('attendance.list');


    Route::get('/attendance/{id}', [AttendanceController::class, 'show'])
        ->name('attendance.show');


    Route::post('/attendance/{id}/request', [AttendanceController::class, 'requestCorrection'])
        ->name('attendance.request');

    Route::get('/attendance/requests', [AttendanceController::class, 'requests'])
        ->name('attendance.requests');

    Route::get('/attendance/{id}/request-form', [AttendanceController::class, 'requestForm'])
        ->name('attendance.request.form');

    Route::get('/admin/login',[AdminController::class,'showLogin']);

    Route::post('/admin/login',[AdminController::class,'login'])->name('admin.login');

    Route::get('/admin/requests',[AdminController::class,'requests'])->name('admin.requests');

    Route::post('/admin/requests/{id}/approve',[AdminController::class,'approve'])->name('admin.requests.approve');

});