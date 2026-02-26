@extends('layouts.user_app') 
@section('css')
<link rel="stylesheet" href="{{ asset('css/rest.css') }}" />
@endsection 

@section('content')
<div class="layout">
    <div class="">
        <form action="" class="">
        @csrf
            <div class="">
                <p class="">休憩中</p>
            </div>
            <p class="">{{$date}}({{$weekday}})</p>
            <p class="">{{$time}}</p>
            <button class="">休憩戻</button>
        </form>
    </div>
</div>

@endsection