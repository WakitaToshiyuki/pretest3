@extends('layouts.user_app') 
@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection 

@section('content')
<div class="layout">
    <div class="">
        <form action="/work" method="GET" class="">
        @csrf
            <div class="">
                <p class="">勤務外</p>
            </div>
            <p class="">{{$date}}({{$weekday}})</p>
            <p class="">{{$time}}</p>
            <button class="">出勤</button>
        </form>
    </div>
</div>

@endsection