@extends('layouts.app')

@section('content')

<div class="attendance-detail-container">

    <h1 class="page-title">勤怠詳細</h1>

    <div class="attendance-card">

    <table class="attendance-detail-table">

        <tr>
            <th>名前</th>
            <td>{{ $user->name }}</td>
        </tr>

        <tr>
            <th>日付</th>
            <td>{{ \Carbon\Carbon::parse($attendance->work_date)->format('Y年 n月j日') }}</td>
        </tr>

        <tr>
            <th>出勤・退勤</th>
            <td>
                {{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '' }}
                〜
                {{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '' }}
            </td>
        </tr>

        <tr>
            <th>休憩</th>
            <td>
                {{ $attendance->break_start ? \Carbon\Carbon::parse($attendance->break_start)->format('H:i') : '' }}
                〜
                {{ $attendance->break_end ? \Carbon\Carbon::parse($attendance->break_end)->format('H:i') : '' }}
            </td>
        </tr>

        <tr>
            <th>休憩2</th>
            <td>
                {{ $attendance->break2_start ? \Carbon\Carbon::parse($attendance->break2_start)->format('H:i') : '' }}
                〜
                {{ $attendance->break2_end ? \Carbon\Carbon::parse($attendance->break2_end)->format('H:i') : '' }}
            </td>
        </tr>

        <tr>
            <th>備考</th>
            <td>
                {{ $attendance->note ?? '' }}
            </td>
        </tr>

    </table>

    @if(session('error'))
        <p class="error-message">{{ session('error') }}</p>
    @endif

    @if ($attendance->correctionRequest && $attendance->correctionRequest->status === 'pending')
        <div class="edit-button-area">
        <button class="edit-button" disabled>
            修正
        </button>
        @else
        <div class="edit-button-area">
        <a href="{{ route('attendance.request.form', $attendance->id) }}" class="edit-button">
            修正
        </a>
        </div>
        @endif
    </div>
</div>
@endsection