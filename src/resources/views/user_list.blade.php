@extends('layouts.user_app') 
@section('css')
<link rel="stylesheet" href="{{ asset('css/user_list.css') }}" />
@endsection 

@section('content')
<div class="layout">
    <p>勤怠一覧</p>
    <div class="">
        <a href="{{ route('test', ['month' => $prevMonth]) }}">前月</a>
        <p>{{$month->format('Y/m')}}</p>
        <a href="{{ route('test', ['month' => $nextMonth]) }}">翌月</a>
    </div>
    <table class="list">
        <tr class="">
            <th>日付</th>
            <th>出勤</th>
            <th>退勤</th>
            <th>休憩</th>
            <th>合計</th>
            <th>詳細</th>
        </tr>
        @foreach ($dates as $date)
            @php
                $key = $date->toDateString();
                $work = $works[$key];
            @endphp
        <tr class="">
            <td>{{ $date->format('n月j日') }}</td>
            <td>{{ $work->start_time ?? '' }}</td>
            <td>{{ $work->finish_time ?? '' }}</td>
            <td>{{ $totalrest[$key] ?? '' }}</td>
            <td>{{ $totalwork[$key] ?? '' }}</td>
            <td>詳細</td>
        </tr>
        @endforeach

    </table>
</div>

@endsection

