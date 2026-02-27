@extends('layouts.app')

@section('content')

<div class="attendance-wrapper">

    <div class="list-card">

        {{-- タイトル --}}
        <h2 class="page-title">勤怠一覧</h2>

        {{-- 月ナビ --}}
        <div class="month-nav">

            <a href="{{ route('attendance.list', ['month' => $currentMonth->copy()->subMonth()->format('Y-m')]) }}"
                class="month-btn">
                ← 前月
            </a>

            <div class="month-label">
                {{ $currentMonth->format('Y年n月') }}
            </div>

            <a href="{{ route('attendance.list', ['month' => $currentMonth->copy()->addMonth()->format('Y-m')]) }}"
                class="month-btn">
                次月 →
            </a>

        </div>

        {{-- 一覧テーブル --}}
        <table class="attendance-table">

            <thead>
                <tr>
                    <th>日付</th>
                    <th>出勤</th>
                    <th>退勤</th>
                    <th>休憩</th>
                    <th>合計</th>
                    <th>詳細</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($attendances as $attendance)

                    <tr>

                        {{-- 日付 --}}
                        <td>
                            {{ \Carbon\Carbon::parse($attendance->work_date)->format('m/d') }}
                            ({{ \Carbon\Carbon::parse($attendance->work_date)->isoFormat('ddd') }})
                        </td>

                        {{-- 出勤 --}}
                        <td>
                            {{ $attendance->clock_in
                                ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i')
                                : '-' }}
                        </td>

                        {{-- 退勤 --}}
                        <td>
                            {{ $attendance->clock_out
                                ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i')
                                : '-' }}
                        </td>

                        {{-- 休憩 --}}
                        <td>
                            {{ $attendance->break_time ?? '-' }}
                        </td>

                        {{-- 合計 --}}
                        <td>
                            {{ $attendance->work_time ?? '-' }}
                        </td>

                        {{-- 詳細ボタン --}}
                        <td>
                            <a href="{{ route('attendance.show', $attendance->id) }}"
                                class="detail-link">
                                詳細
                            </a>
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection