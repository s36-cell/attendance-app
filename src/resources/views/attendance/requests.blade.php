@extends('layouts.app')
@section('content')


<div class="requests-container">

    <h1 class="page-title">申請一覧</h1>
    <div class="tabs">
        <a href="{{ route('attendance.requests',['status'=>'pending'])}}"
            class="{{ $status=='pending' ? 'active' : ''}}">
            承認待ち</a>
        <a href="{{ route('attendance.requests',['status'=>'approved'])}}"
            class="{{ $status=='approved' ? 'active' : ''}}">
            承認済み</a>
    </div>

    <table class="requests-table">
        <thead>
            <tr>
                <th>状態</th>
                <th>名前</th>
                <th>対象日時</th>
                <th>申請理由</th>
                <th>申請日時</th>
                <th>詳細</th>
            </tr>
        </thead>

        <tbody>
            @foreach($requests as $request)
                <tr>
                    <td>
                        @if($request->status === 'pending')
                            承認待ち
                        @else
                            承認済み
                        @endif
                    </td>

                    <td>
                        {{ $request->user->name }}
                    </td>

                    {{-- 対象日時 --}}
                    <td>
                        {{ \Carbon\Carbon::parse($request->attendance->work_date)->format('Y/m/d') }}
                    </td>

                    {{-- 理由 --}}
                    <td>
                        {{ $request->reason }}
                    </td>

                    {{-- 申請日時 --}}
                    <td>
                        {{ \Carbon\Carbon::parse($request->created_at)->format('Y/m/d') }}
                    </td>

                    {{-- 詳細リンク --}}
                    <td>
                        <a href="{{ route('attendance.show',$request->attendance_id) }}">
                            詳細
                        </a>
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection
