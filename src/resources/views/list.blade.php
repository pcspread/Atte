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
        @if (session('attendances')[0])
        <table class="list-table">
            <tr class="list-row">
                <th class="list-row__title">ID</th>
                <th class="list-row__title">社員名</th>
                <th class="list-row__title">メールアドレス</th>
                <th class="list-row__title"></th>
            </tr>
            
            @foreach (session('attendances') as $attendance)
            <tr class="list-row">
                <td class="list-row__content">{{ $attendance->user->name }}</td>
                <td class="list-row__content">
                    {{ $attendance->changelist($attendance->start_at) }}
                </td>
                <td class="list-row__content">
                    {{ $attendance->changelist($attendance->end_at) }}
                </td>
                <td class="list-row__content">
                </td>
            </tr>
            @endforeach
        </table>
        @else
        <div class="list-none">
            <p>社員情報がありません</p>
        </div>
        @endif
    </div>

    @if (session('attendances')[0])
    <div class="list-pagination">
        {{ session('attendances')->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
    </div>
    @endif
</div>
@endsection