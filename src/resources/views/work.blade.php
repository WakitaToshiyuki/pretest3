@extends('layouts.user_app') 
@section('css')
<link rel="stylesheet" href="{{ asset('css/work.css') }}" />
@endsection 

@section('content')
<div class="layout">
    <div class="">
        <form action="" class="">
        @csrf
            <div class="">
                <p class="">勤務中</p>
            </div>
            <p class="">{{$date}}({{$weekday}})</p>
            <p class="">{{$time}}</p>
            <div class="">
            <button class="">退勤</button>
            <button class="">休憩入</button>
        </div>
        </form>
    </div>
</div>

@endsection