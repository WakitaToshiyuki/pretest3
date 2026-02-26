@extends('layouts.user_app') 
@section('css')
<link rel="stylesheet" href="{{ asset('css/finish.css') }}" />
@endsection 

@section('content')
<div class="layout">
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
</div>

@endsection