@extends('layouts.app')

@php
use Carbon\Carbon;
@endphp

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
            <a href="/attendance?key={{ 
                (Carbon::parse(session('date'))->day === Carbon::parse(session('date'))->startOfMonth()->day) ? Carbon::parse(session('date'))->subMonth()->endOfMonth()->toDateString() : Carbon::parse(session('date'))->subDay()->toDateString()
             }}"><</a>
        </div>
        <div class="date-main">
            <h2>{{ session('date') ?? '表示できません' }}</h2>
        </div>
        <div class="date-sub">
            <a href="/attendance?key={{
                (Carbon::parse(session('date'))->day === Carbon::parse(session('date'))->endOfMonth()->day) ? Carbon::parse(session('date'))->addMonth()->startOfMonth()->toDateString() : Carbon::parse(session('date'))->addDay()->toDateString()
            }}">></a>
        </div>
    </div>

    <div class="date-content">    
        @if (session('attendances')[0])
        <table class="date-table">
            <tr class="date-row">
                <th class="date-row__title">名前</th>
                <th class="date-row__title">勤務開始</th>
                <th class="date-row__title">勤務終了</th>
                <th class="date-row__title">休憩時間</th>
                <th class="date-row__title">勤務時間</th>
            </tr>
            
            @foreach (session('attendances') as $attendance)
            <tr class="date-row">
                <td class="date-row__content">{{ $attendance->user->name }}</td>
                <td class="date-row__content">
                    {{ $attendance->changeDate($attendance->start_at) }}
                </td>
                <td class="date-row__content">
                    {{ $attendance->changeDate($attendance->end_at) }}
                </td>
                <td class="date-row__content">
                    @php
                        $arrayBreak = [];
                        $arrayRestart = [];
                        foreach ($attendance->rests as $item) {
                            $arrayBreak[] .= $item->break_at;
                            $arrayRestart[] .= $item->restart_at;
                        }
                    @endphp
                    {{ $attendance->totalRes($arrayBreak, $arrayRestart) }}
                </td>
                <td class="date-row__content">
                    @php
                        $diffParent = Carbon::parse($attendance->totalAtt($attendance->start_at, $attendance->end_at));
                        $diffChild = Carbon::parse($attendance->totalRes($arrayBreak, $arrayRestart));
                        $diffTime = $diffParent->diff($diffChild);
                    @endphp
                    {{ $diffTime->format('%H:%I:%S') }}
                </td>
            </tr>
            @endforeach
        </table>
        @else
        <div class="date-none">
            <p>勤怠情報がありません</p>
        </div>
        @endif
    </div>
    
    @if (session('attendances')[0])
    <div class="date-pagination">
        {{ session('attendances')->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
    </div>
    @endif

</div>
@endsection