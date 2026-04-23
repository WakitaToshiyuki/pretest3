@extends('layouts.manager_app') 
@section('css')
<link rel="stylesheet" href="{{ asset('css/manager_request_correct.css') }}" />
@endsection 

@section('content')
<div class="layout">
    <form action="{{ route('approve',['attendance_correct_request_id'=>$application]) }}" method="POST">
    @csrf
        <h2 class="">勤怠詳細</h2>
        <table class="">
            <tr>
                <th class="">名前</th>
                <td class="">{{$application->user->name}}</td>
            </tr>
            <tr>
                <th class="">日付</th>
                <td class="">{{\Carbon\Carbon::parse($application->work->date)->format('Y年')}}</td>
                <td class="">{{\Carbon\Carbon::parse($application->work->date)->format('n月j日')}}</td>
            </tr>
            <tr>
                <th class="">出勤・退勤</th>
                <td class="">
                    {{ \Carbon\Carbon::parse($application->update_start_time)->format('H:i')}}
                </td>
                <td class="">～</td>
                <td class="">
                    {{ \Carbon\Carbon::parse($application->update_finish_time)->format('H:i')}}
                </td>
            </tr>
            @foreach($applicationRestRows as $applicationRestRow)
                <tr class="">
                    <th class="">{{$applicationRestRow['label']}}</th>
                    <td>{{$applicationRestRow['start_time']}}</td>
                    <td>～</td>
                    <td>{{$applicationRestRow['finish_time']}}</td>
                </tr>
            @endforeach    
            <tr>
                <th class="">備考</th>
                <td class="">{{$application->reason}}</td>
            </tr>
        </table>
        <div class="">
            <button>承認</button>
        </div>
    </form>
</div>
@endsection