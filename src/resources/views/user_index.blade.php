@extends('layouts.user_app') 
@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection 

@section('content')
<div class="layout">
    @if(isset($name) && $name === 'work')
        <div class="">
            <form action="/" method="POST" class="">
            @csrf
                <div class="">
                    <p class="">勤務中</p>
                </div>
                <p class="">{{$date}}({{$weekday}})</p>
                <p class="">{{$time}}</p>
                <div class="">
                    <button name="finish" class="">退勤</button>
                    <button name="rest" class="">休憩入</button>
                </div>
            </form>
        </div>
    @elseif(isset($name) && $name === 'rest')
        <div class="">
            <form action="/" method="POST" class="">
            @csrf
                <div class="">
                    <p class="">休憩中</p>
                </div>
                <p class="">{{$date}}({{$weekday}})</p>
                <p class="">{{$time}}</p>
                <button name="restart" class="">休憩戻</button>
            </form>
        </div>
    @elseif(isset($name) && $name === 'finish')
        <div class="">
            <div class="">
                <p class="">退勤済</p>
            </div>
            <p class="">{{$date}}({{$weekday}})</p>
            <p class="">{{$time}}</p>
            <div class="">
                <p>お疲れ様でした。</p>
            </div>
        </div>
    @else
        <div class="">
            <form action="/" method="POST" class="">
            @csrf
                <div class="">
                    <p class="">勤務外</p>
                </div>
                <p class="">{{$date->format('Y年m月d日')}}({{$weekday}})</p>
                <p class="">{{$time}}</p>
                <button name="start" class="">出勤</button>
            </form>
        </div>
    @endif
</div>

@endsection