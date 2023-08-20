@php
use Carbon\Carbon;
use App\Models\Attendance;
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
                <a class="information-name__list-link" href="/attendance/personal?id={{ $person['id'] }}">{{ $person['name'] }} さん</a>
                @endforeach
            </div>
        </div>

        <!-- 年月 -->
        <div class="information-date">
            <!-- 前月 -->
            <div class="information-date__sub">
                <a class="information-date__sub-link" href="/attendance/personal?id={{ session('user')->id }}&month={{ Carbon::parse(session('month'))->subMonth()->format('Y-m') }}"><</a>
            </div>
            <!-- 当月 -->
            <div class="information-date__main">
                <h3 class="information-date__main-title">{{ session('month')->format('Y月m日') ?? '表示できません' }}</h3>
            </div>
            <!-- 翌月 -->
            <div class="information-date__sub">
                <a class="information-date__sub-link" href="/attendance/personal?id={{ session('user')->id }}&month={{ Carbon::parse(session('month'))->addMonth()->format('Y-m') }}">></a>
            </div>
        </div>
    </div>

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
            
            @foreach (session('days') as $day)
            @php
                $record = Attendance::dateMatch(session('user_id'), $day);
            @endphp
            <tr class="personal-row">
                <!-- 日付 -->
                <td class="personal-row__content day">
                    {{ $day->isoFormat('D日(dd)') }}
                    @php
                        if ($day->toDateString() === Carbon::now()->toDateString()) {
                            echo htmlspecialchars('　✔', ENT_QUOTES, 'UTF-8');
                        }
                    @endphp
                </td>
                
                <!-- 勤務開始 -->
                <td class="personal-row__content">
                    {{ !empty($record->start_at) ? Carbon::parse($record->start_at)->format('H:i:s') : '( 勤怠情報無 )' }}
                </td>
                
                <!-- 勤務終了 -->
                <td class="personal-row__content">
                    @php
                        if (!empty($record->end_at)) {
                            echo htmlspecialchars(Carbon::parse($record->end_at)->format('H:i:s'), ENT_QUOTES, 'UTF-8');
                        } else {
                            if (!empty($record->start_at)) {
                                echo htmlspecialchars('(勤務中)', ENT_QUOTES, 'UTF_8');
                            }
                        }
                    @endphp
                </td>

                <!-- 休憩時間 -->
                <td class="personal-row__content rest-time">
                    @php
                        $arrayBreak = [];
                        $arrayRestart = [];
                        if (!empty($record->rests)) {
                            foreach ($record->rests as $item) {
                                $arrayBreak[] = $item->break_at;
                                $arrayRestart[] = $item->restart_at;
                            }
                            $restTime = Attendance::totalRes($arrayBreak, $arrayRestart);
                        } else {
                            $restTime = '';
                        }
                    @endphp
                    {{ $restTime }}

                    @if (!empty($record->rests))
                    <!-- 休憩詳細 -->
                    <div class="rest-detail">
                        @php
                            $count = 1;
                            foreach ($record->rests as $item) {
                                $detail = '(' . $count . ') ' . $item->break_at . '～' . $item->restart_at;
                                echo '<p>' . htmlspecialchars($detail, ENT_QUOTES, 'UTF-8') . '</p>';
                                $count++;
                            }
                        @endphp
                    </div>
                    @endif
                </td>
                
                <!-- 勤務時間 -->
                <td class="personal-row__content">
                @if (!empty($record->start_at))
                    @php
                        $diffParent = Carbon::parse(Attendance::totalAtt($record->start_at, $record->end_at));
                        
                        if (($restTime) === '(休憩中)') {
                            $diffChild = Carbon::parse('00:00:00');
                        } else {
                            $diffChild = Carbon::parse($restTime);
                        }

                        $diffTime = $diffParent->diff($diffChild);
                    @endphp
                    {{ (Attendance::changeDate($record->end_at) === Carbon::now()->toTimeString()) ? '(勤務中)' : $diffTime->format('%H:%I:%S') }}
                @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection