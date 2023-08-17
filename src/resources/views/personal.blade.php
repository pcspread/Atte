@php
use Carbon\Carbon;
@endphp

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/personal.css') }}" />
@endsection

@section('js')
<script src="{{ asset('js/personal.js') }}" defer></script>
@endsection

@section('content')
<div class="personal-section">
    <div class="personal-title">
        <h1 class="personal-title__text">勤怠情報</h1>
    </div>

    <div class="personal-information">
        <!-- 社員名 -->
        <div class="information-name">
            <h2 class="information-name__main">{{ (session('user')) ? session('user')->name . 'さん' : '表示できません' }}🔽</h2>

            <div class="information-name__list">
                @foreach (session('users') as $person)
                <a class="information-name__list-link" href="/attendance/personal?key={{ $person['id'] }}">{{ $person['name'] }} さん</a>
                @endforeach
            </div>
        </div>

        <!-- 年月 -->
        <div class="information-date">
            <div class="information-date__sub">
                <a class="information-date__sub-link" href="/attendance/personal?key={{ session('user')->id }}&date={{ Carbon::parse(session('date'))->subMonth()->format('Y-m') }}"><</a>
            </div>
            <div class="information-date__main">
                <h3 class="information-date__main-title">{{ session('date')->format('Y月m日') ?? '表示できません' }}</h3>
            </div>
            <div class="information-date__sub">
                <a class="information-date__sub-link" href="/attendance/personal?key={{ session('user')->id }}&date={{ Carbon::parse(session('date'))->addMonth()->format('Y-m') }}">></a>
            </div>
        </div>
    </div>

    @if (count(session('attendances')) > 0)
    <div class="personal-content">    
        <table class="personal-table">
            <tr class="personal-row">
                <th class="personal-row__title">日付</th>
                <th class="personal-row__title">勤務開始</th>
                <th class="personal-row__title">勤務終了</th>
                <th class="personal-row__title rest-caption">休憩時間※
                    <div class="caption-content">
                        各休憩時間の上にマウスをのせると、休憩時間の詳細が表示されます
                    </div>
                </th>
                <th class="personal-row__title">勤務時間</th>
            </tr>
            
            @foreach (session('attendances') as $attendance)
            <tr class="personal-row">
                <!-- 日付 -->
                <td class="personal-row__content">
                    {{ Carbon::parse($attendance->date_at)->isoFormat('D日(dd)') }}
                </td>
                
                <!-- 勤務開始 -->
                <td class="personal-row__content">
                    {{ Carbon::parse($attendance->start_at)->format('H:i:s') }}
                </td>
                
                <!-- 勤務終了 -->
                <td class="personal-row__content">
                    {{ ($attendance->changeDate($attendance->end_at) === Carbon::now()->toTimeString()) ? '(勤務中)' : $attendance->changeDate($attendance->end_at) }}
                </td>

                <!-- 休憩時間 -->
                <td class="personal-row__content rest-time">
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
                    
                    <!-- 休憩詳細 -->
                    <div class="rest-detail">
                        (休憩詳細)
                        @php
                        $count = 1;
                        foreach ($attendance->rests as $item) {
                            $detail = '(' . $count . ') ' . $item->break_at . '～' . $item->restart_at;
                            echo '<br />' . htmlspecialchars($detail, ENT_QUOTES, 'UTF-8');
                            $count++;
                        }
                        @endphp
                    </div>
                </td>
                
                <!-- 勤務時間 -->
                <td class="personal-row__content">
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
    </div>
    @else
    <div class="personal-none">
        <p class="personal-none__text">勤怠情報がありません</p>
    </div>
    @endif
</div>
@endsection