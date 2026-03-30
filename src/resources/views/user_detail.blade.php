@extends('layouts.user_app') 
@section('css')
<link rel="stylesheet" href="{{ asset('css/user_detail.css') }}" />
@endsection 

@section('content')
<div class="layout">
    <h2 class="">勤怠詳細</h2>
    <table class="">
        <tr class="">
            <td class="">名前</td>
            <td class="">{{$user->name}}</td>
        </tr>
        <tr class="">
            <td class="">日付</td>
            <td class="">{{\Carbon\Carbon::parse($date)->format('Y年')}}</td>
            <td class="">{{\Carbon\Carbon::parse($date)->format('n月j日')}}</td>
        </tr>
        <form action="{{ route('request',['id'=>$date]) }}" method="POST">
            <tr class="">
                <td class="">出勤・退勤</td>
                <td class="">
                    <input type="text" class="" name="start_time" value="{{ \Carbon\Carbon::parse($work->start_time)->format('H:i')}}">
                </td>
                <td class="">～</td>
                <td class="">
                    <input type="text" class="" name="finish_time" value="{{ \Carbon\Carbon::parse($work->finish_time)->format('H:i')}}">
                </td>
            </tr>
            @foreach ($restRows as $restRow)
                <tr class="">
                    <td class="">{{$restRow['label']}}</td>
                    <td class="">
                        <input type="text" class="" name="start_time" value="{{$restRow['start_time']}}">
                    </td>
                    <td class="">～</td>
                    <td class="">
                        <input type="text" class="" name="finish_time" value="{{$restRow['finish_time']}}">
                    </td>
                </tr>
            @endforeach
            <tr class="">
                <td class="">備考</td>
                <td class="">
                    <textarea name=""></textarea>
                </td>
            </tr>
            <button class="">修正</button>
        </form>
    </table>
</div>

@endsection

