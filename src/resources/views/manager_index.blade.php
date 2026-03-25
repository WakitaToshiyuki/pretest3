@extends('layouts.manager_app') 
@section('css')
<link rel="stylesheet" href="{{ asset('css/manager_index.css') }}" />
@endsection 

@section('content')
<h1>Manager</h1>
<div class="">
    <h2>勤怠一覧</h2>
    <div class="">
        <a href="{{ route('index', ['date' => $prevDay]) }}">前日</a>
        <p>{{$date->format('Y/m/d')}}</p>
        <a href="{{ route('index', ['date' => $nextDay]) }}">翌日</a>
    </div>
    <table class="list">
        <tr class="">
            <th>名前</th>
            <th>出勤</th>
            <th>退勤</th>
            <th>休憩</th>
            <th>合計</th>
            <th>詳細</th>
        </tr>
        @foreach ($works as $work)
        <tr class="">
            <td>{{ $work->user->name }}</td>
            <td>
                {{ \Carbon\Carbon::parse($work->start_time)->format('H:i') }}
            </td>
            <td>
                @if ($work->finish_time)
                    {{ \Carbon\Carbon::parse($work->finish_time)->format('H:i') }}
                @else
                    {{-- 空欄 --}}
                @endif
            </td>
            <td>{{ $totalrests[$work->id] ?? '' }}</td>
            <td>{{ $totalworks[$work->id] ?? '' }}</td>
            <td>
                <a href="{{ route('detail',['id'=>$date]) }}">詳細</a>
            </td>
        </tr>
        @endforeach

    </table>
</div>
@endsection