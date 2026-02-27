@extends('layouts.app')

@section('content')

<style>
body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background: #f3f4f6;
}

/* ========================
   中央配置
======================== */
.attendance-wrapper {
    height: calc(100vh - 80px);
    display: flex;
    justify-content: center;
    align-items: center;
}

/* カードなし（Figma仕様） */
.attendance-card {
    text-align: center;
}

/* ステータス */
.status {
    color: #696969;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 10px;
}

/* 日付 */
.date {
    font-size: 22px;
    margin-bottom: 10px;
}

/* 時刻 */
.time {
    font-size: 80px;
    font-weight: bold;
    margin: 20px 0;
}

/* ボタン */
.button-area button {
    background: #000;
    color: white;
    border: none;
    padding: 12px 40px;
    font-size: 18px;
    border-radius: 8px;
    cursor: pointer;
    margin: 5px;
}

.button-area button:hover {
    opacity: 0.8;
}

/* 勤務終了表示 */
.result-box {
    margin-top: 30px;
}

.work-time {
    font-size: 18px;
    font-weight: bold;
}

</style>



<div class="attendance-wrapper">
    <div class="attendance-card">

        {{-- ========================
            ステータス判定
        ======================== --}}
        @php
            $status = '勤務外';

            if ($attendance) {
                if ($attendance->clock_out) {
                    $status = '退勤済';
                } elseif ($attendance->break_start && !$attendance->break_end) {
                    $status = '休憩中';
                } else {
                    $status = '出勤中';
                }
            }
        @endphp



        <p class="status">{{ $status }}</p>

        <p class="date">
            {{ now()->format('Y年n月j日（D）') }}
        </p>

        <h1 class="time" id="clock">
            {{ now()->format('H:i') }}
        </h1>



        {{-- ========================
            ボタンエリア
        ======================== --}}
        <div class="button-area">

            {{-- 勤務外 → 出勤 --}}
            @if (!$attendance)
                <form method="POST" action="{{ route('attendance.clock-in') }}">
                    @csrf
                    <button type="submit">出勤</button>
                </form>
            @endif



            {{-- 出勤中 --}}
            @if ($attendance && !$attendance->clock_out)

                {{-- 休憩中 --}}
                @if ($attendance->break_start && !$attendance->break_end)
                    <form method="POST" action="{{ route('attendance.break-end') }}">
                        @csrf
                        <button type="submit">休憩戻</button>
                    </form>

                @else

                    <form method="POST" action="{{ route('attendance.break-start') }}">
                        @csrf
                        <button type="submit">休憩</button>
                    </form>

                    <form method="POST" action="{{ route('attendance.clock-out') }}">
                        @csrf
                        <button type="submit">退勤</button>
                    </form>
                @endif

            @endif

        </div>


        {{-- ========================
            勤務終了表示
        ======================== --}}
        @if ($attendance && $attendance->clock_out)

            <div class="result-box">
                <p>お疲れ様でした。</p>

                <p class="work-time">
                    勤務時間：{{ $attendance->working_hours }}
                </p>
            </div>

        @endif


    </div>
</div>


{{-- ========================
   リアルタイム時計
======================== --}}
<script>
function updateClock() {

    const now = new Date();

    const h = String(now.getHours()).padStart(2,'0');
    const m = String(now.getMinutes()).padStart(2,'0');

    document.getElementById('clock').textContent = h + ':' + m;
}

setInterval(updateClock, 1000);
updateClock();
</script>



@endsection