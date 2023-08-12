@php
use Carbon\Carbon;
@endphp

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/parsonal.css') }}">
@endsection

@section('content')
<div class="parsonal-section">
    <div class="parsonal-title">
        <div class="parsonal-main">
            <h2>勤怠情報</h2>
        </div>
    </div>

    <div class="parsonal-information">
        <div class="information-name">
            <h3>{{ (session('user')) ? session('user')->name . 'さん' : '表示できません' }}</h3>
        </div>

        <div class="information-date">
            <div class="date-sub">
                <a href="/attendance/parsonal?key={{ session('user')->id }}&date={{ Carbon::parse(session('date'))->subMonth()->format('Y-m') }}"><</a>
            </div>
            <div class="date-main">
                <h2>{{ session('date')->format('Y月m日') ?? '表示できません' }}</h2>
            </div>
            <div class="date-sub">
                <a href="/attendance/parsonal?key={{ session('user')->id }}&date={{ Carbon::parse(session('date'))->addMonth()->format('Y-m') }}">></a>
            </div>
        </div>
    </div>

    <div class="parsonal-content">    
        @if (session('attendances'))
        <table class="parsonal-table">
            <tr class="parsonal-row">
                <th class="parsonal-row__title">日付</th>
                <th class="parsonal-row__title">勤務開始</th>
                <th class="parsonal-row__title">勤務終了</th>
                <th class="parsonal-row__title">休憩時間</th>
                <th class="parsonal-row__title">勤務時間</th>
            </tr>
            
            @foreach (session('attendances') as $attendance)
            <tr class="parsonal-row">
                <td class="parsonal-row__content">
                    {{ Carbon::parse($attendance->date_at)->format('d日') }}
                </td>
                <td class="parsonal-row__content">
                    {{ Carbon::parse($attendance->start_at)->format('H:i:s') }}
                </td>
                <td class="parsonal-row__content">
                    {{ ($attendance->changeDate($attendance->end_at) === Carbon::now()->toTimeString()) ? '(勤務中)' : $attendance->changeDate($attendance->end_at) }}
                </td>
                <td class="parsonal-row__content">
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
                <td class="parsonal-row__content">
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
        <div class="parsonal-none">
            <p>勤怠情報がありません</p>
        </div>
        @endif
    </div>
</div>
@endsection