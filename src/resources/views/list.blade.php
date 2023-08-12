@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('content')
<div class="list-section">
    <div class="list-title">
        <div class="list-main">
            <h2>社員一覧</h2>
        </div>
    </div>

    <div class="list-content">    
        <table class="list-table">
            <tr class="list-row">
                <th class="list-row__title">ID</th>
                <th class="list-row__title">社員名</th>
                <th class="list-row__title">メールアドレス</th>
                <th class="list-row__title"></th>
            </tr>
            
            @if ($users)
                @foreach ($users as $user)
                <tr class="list-row">
                    <td class="list-row__content">
                        {{ $user['id'] }}
                    </td>
                    <td class="list-row__content">
                        {{ $user['name'] }}
                    </td>
                    <td class="list-row__content">
                        {{ $user['email'] }}
                    </td>
                    <td class="list-row__content">
                        <div class="list-row__link">
                            <a href="/attendance/parsonal?key={{ $user['id'] }}">勤怠詳細</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>
@endsection