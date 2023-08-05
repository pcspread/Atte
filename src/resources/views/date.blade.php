@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/date.css') }}">
@endsection

@section('js')
<script src="{{ asset('js/date.js') }}" defer></script>
@endsection

@section('content')
<div class="date-section">
    <div class="date-title">
        <div class="date-sub">
            <a href=""><</a>
        </div>
        <div class="date-main">
            <h2>{{ session('date') ?? '表示できません' }}</h2>
        </div>
        <div class="date-sub">
            <a href="">></a>
        </div>
    </div>

    <div class="date-content">
        <table class="date-table">
            <tr class="date-row">
                <th class="date-row__title">名前</th>
                <th class="date-row__title">勤務開始</th>
                <th class="date-row__title">勤務終了</th>
                <th class="date-row__title">休憩時間</th>
                <th class="date-row__title">勤務時間</th>
            </tr>

            @if (session('users'))
                @foreach (session('users') as $user)
                <tr class="date-row">
                    <td class="date-row__content">{{ $user->name }}</td>
                    <td class="date-row__content">10:00:00</td>
                    <td class="date-row__content">20:00:00</td>
                    <td class="date-row__content">00:30:00</td>
                    <td class="date-row__content">09:30:00</td>
                </tr>
                @endforeach
            @endif
        </table>
    </div>

    <div class="date-pagination">
        {{ session('users')->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>
@endsection