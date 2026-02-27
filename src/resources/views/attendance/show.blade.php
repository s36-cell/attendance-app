@extends('layouts.app')
@section('content')
<div class="attendance-wrapper">
    < class="list-card">
        <h2 class="attendance-detail-title">勤怠詳細</h2>

        <div class="attendance-detail-row">
            <span class="attendance-detail-label">日付:</span>
            <span class="attendance-detail-value">{{ \Carbon\Carbon::parse($attendance->work_date)->format('Y年m月d日') }}
            </span>
        </div>
        <div class="attendance-detail-row">
            <span class="attendance-detail-label">出勤</span>
            <span class="attendance-detail-value">{{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '未入力' }}</span>
        </div>
        <div class="attendance-detail-row">
            <span class="attendance-detail-label">退勤</span>
            <span class="attendance-detail-value">{{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '未入力' }}</span>
        </div>
        <div class="attendance-detail-row">
            <span class="attendance-detail-label">勤務時間</span>
            <span class="attendance-detail-value">{{ $attendance->work_time ? gmdate('H:i', $attendance->work_time) : '未入力' }}</span>
        </div>
        <div class="attendance-detail-row">
            <span class="attendance-detail-label">休憩時間</span>
            <span class="attendance-detail-value">{{ $attendance->break_time ? gmdate('H:i', $attendance->break_time) : '未入力' }}</span>
        </div>
        <div class="attendance-detail-row">
            <span class="attendance-detail-label">備考</span>
            <textarea class="attendance-textarea" rows="3">{{ old('note', $attendance->note) }}</textarea>
        </div>

        <div class="attendance-detail-row">
            <button class="attendance-detail-button">>修正申請</button>
        </div>
    </div>
</div>

<style>
/* ======================
   画面背景
====================== */

.attendance-detail-wrapper {
    background: #f3f4f6;
    min-height: calc(100vh - 80px);
    padding: 60px 0;

    display: flex;
    justify-content: center;
}



/* ======================
   白カード
====================== */

.attendance-detail-card {
    background: white;
    width: 700px;
    border-radius: 10px;
    padding: 40px 60px;
}



/* タイトル */

.attendance-detail-title {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 30px;
}



/* 行 */

.attendance-detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}



/* ラベル */

.attendance-detail-label {
    font-weight: bold;
    width: 120px;
}



/* 値 */

.attendance-detail-value {
    flex: 1;
    text-align: right;
}



/* テキストエリア */

.attendance-textarea {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
}



/* ボタン */

.attendance-detail-button-area {
    text-align: right;
    margin-top: 30px;
}

.attendance-detail-button {
    background: black;
    color: white;
    border: none;
    padding: 10px 30px;
    border-radius: 6px;
    cursor: pointer;
}

.attendance-detail-button:hover {
    opacity: 0.8;
}

</style>

@endsection