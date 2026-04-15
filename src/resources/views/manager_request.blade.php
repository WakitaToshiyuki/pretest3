@extends('layouts.manager_app') 
@section('css')
<link rel="stylesheet" href="{{ asset('css/manager_request.css') }}" />
@endsection 

@section('content')
<div class="layout">
    <h2 class="">申請一覧</h2>
    <table class="">
        <tr class="">
            <th>状態</th>
            <th>名前</th>
            <th>対象日時</th>
            <th>申請理由</th>
            <th>申請日時</th>
            <th>詳細</th>
        </tr>
        @foreach ($applications as $application)
        <tr class="">
            <td>{{ $application->status }}</td>
            <td>{{ $application->user->name }}</td>
            <td>{{ $application->work->date }}</td>
            <td>{{ $application->reason }}</td>
            <td>{{ $application->created_at }}</td>
            <td><a href="">詳細</a></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection