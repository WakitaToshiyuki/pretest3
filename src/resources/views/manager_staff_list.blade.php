@extends('layouts.manager_app') 
@section('css')
<link rel="stylesheet" href="{{ asset('css/manager_staff_list.css') }}" />
@endsection 

@section('content')
<div class="layout">
    <h2 class="">スタッフ一覧</h2>
    <table class="">
        <tr class="">
            <th>名前</th>
            <th>メールアドレス</th>
            <th>月次勤怠</th>
        </tr>
        @foreach ($users as $user)
        <tr class="">
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <a href="{{ route('staff',['id'=>$user->id]) }}">詳細</a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection