@extends('layouts.manager_app') 
@section('css')
<link rel="stylesheet" href="{{ asset('css/manager_request_correct.css') }}" />
@endsection 

@section('content')
<div class="layout">
    <h2 class="">勤怠詳細</h2>
    <table class="">
        <tr>
            <th class="">名前</th>
            <td></td>
        </tr>
        <tr>
            <th class="">日付</th>
            <td></td>
        </tr>
        <tr>
            <th class="">出勤・退勤</th>
            <td></td>
        </tr>
        <tr>
            <th class="">備考</th>
            <td></td>
        </tr>
    </table>
</div>
@endsection