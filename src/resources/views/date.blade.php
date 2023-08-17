@php
use Carbon\Carbon;
@endphp

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/date.css') }}" />
@endsection

@section('js')
<script src="{{ asset('js/date.js') }}" defer></script>
@endsection

@section('content')
<div class="date-section">
    <div class="date-title">
        <!-- 前日 -->
        <div class="date-title__sub">
            <a class="date-title__sub-link" href="/attendance?date={{ Carbon::parse(session('date'))->subDay()->toDateString() }}"><</a>
        </div>

        <!-- 当日 -->
        <div class="date-title__main">
            <h1 class="date-title__main-text">{{ session('date') ?? '表示できません' }}</h1>
        </div>

        <!-- 翌日 -->
        <div class="date-title__sub">
            <a class="date-title__sub-link" href="/attendance?date={{ Carbon::parse(session('date'))->addDay()->toDateString() }}">></a>
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
                <!-- 名前 -->
                <td class="date-row__content">
                    {{ $attendance->user->name }}
                </td>

                <!-- 勤務開始 -->
                <td class="date-row__content">
                    {{ $attendance->changeDate($attendance->start_at) }}
                </td>
                
                <!-- 勤務終了 -->
                <td class="date-row__content">
                    {{ ($attendance->changeDate($attendance->end_at) === Carbon::now()->toTimeString()) ? '(勤務中)' : $attendance->changeDate($attendance->end_at) }}
                </td>
                
                <!-- 休憩時間 -->
                <td class="date-row__content">
                    @php
                        $arrayBreak = [];
                        $arrayRestart = [];
                        foreach ($attendance->rests as $item) {
                            $arrayBreak[] = $item->break_at;
                            $arrayRestart[] = $item->restart_at;
                        }
                        $restTime = $attendance->totalRes($arrayBreak, $arrayRestart);
                    @endphp
                    {{ $restTime }}
                </td>
                
                <!-- 勤務時間 -->
                <td class="date-row__content">
                    @php
                        $diffParent = Carbon::parse($attendance->totalAtt($attendance->start_at, $attendance->end_at));
                       
                        if (($restTime) === '(休憩中)') {
                            $diffChild = Carbon::parse('00:00:00');
                        } else {
                            $diffChild = Carbon::parse($restTime);
                        }

                        $diffTime = $diffParent->diff($diffChild);
                    @endphp
                    {{ ($attendance->changeDate($attendance->end_at) === Carbon::now()->toTimeString()) ? '(勤務中)' : $diffTime->format('%H:%I:%S') }}
                </td>
            </tr>
            @endforeach
        </table>
        @else
        <div class="date-none">
            <p class="date-none__text">勤怠情報がありません</p>
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