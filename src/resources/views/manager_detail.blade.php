@extends('layouts.manager_app') 
@section('css')
<link rel="stylesheet" href="{{ asset('css/manager_detail.css') }}" />
@endsection 

@section('content')
<div class="layout">
    <h2 class="">勤怠詳細</h2>
    <table class="">
        <tr class="">
            <td class="">名前</td>
            <td class="">{{ $work->user->name }}</td>
        </tr>
        <tr class="">
            <td class="">日付</td>
            <td class="">{{\Carbon\Carbon::parse($date)->format('Y年')}}</td>
            <td class="">{{\Carbon\Carbon::parse($date)->format('n月j日')}}</td>
        </tr>
        @if($application->status === \App\Models\Application::STATUS_PENDING)
            <tr class="">
                <td class="">出勤・退勤</td>
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
                    <td class="">{{$applicationRestRow['label']}}</td>
                    <td>{{$applicationRestRow['start_time']}}</td>
                    <td>～</td>
                    <td>{{$applicationRestRow['finish_time']}}</td>
                </tr>
            @endforeach    
            <tr class="">
                <td class="">備考</td>
                <td class="">{{$application->reason}}</td>
            </tr>
            <p class="">*承認待ちのため修正はできません。</p>
        @else
            <form action="{{ route('request',['id'=>$work->date]) }}" method="POST">
            @csrf
                <tr class="">
                    <td class="">出勤・退勤</td>
                    <td class="">
                        <input type="text" class="" name="work_start_time" value="{{ \Carbon\Carbon::parse($work->start_time)->format('H:i')}}">
                    </td>
                    <td class="">～</td>
                    <td class="">
                        <input type="text" class="" name="work_finish_time" value="{{ \Carbon\Carbon::parse($work->finish_time)->format('H:i')}}">
                    </td>
                </tr>
                @foreach ($restRows as $restRow)
                    <tr class="">
                        <td class="">{{$restRow['label']}}</td>
                        <td class="">
                            <input type="text" class="" name="rest_start_time[]" value="{{$restRow['start_time']}}">
                        </td>
                        <td class="">～</td>
                        <td class="">
                            <input type="text" class="" name="rest_finish_time[]" value="{{$restRow['finish_time']}}">
                        </td>
                    </tr>
                @endforeach
                <tr class="">
                    <td class="">備考</td>
                    <td class="">
                        <textarea name="reason"></textarea>
                    </td>
                </tr>
                <tr class="">
                    <div class="">
                        <button class="">修正</button>
                    </div>
                </tr>
            </form>
        @endif
    </table>
</div>
@endsection