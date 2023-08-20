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
            <tr class="personal-row">
                <!-- 日付 -->
                <td class="personal-row__content day">
                    {{ $day->isoFormat('D日(dd)') }}
                    @php
                        if ($day->toDateString() === Carbon::now()->toDateString()) {
                            echo htmlspecialchars('　✔', ENT_QUOTES, 'UTF-8');
                        }
                        
                        $attendances = Attendance::where([['user_id', session('user_id')], ['date_at', $day]])->get();
                    @endphp
                </td>
                
                <!-- 勤務開始 -->
                <td class="personal-row__content">
                    @php
                        if (empty($attendances[0])) {
                            $non_att = '(出勤情報無)';
                            echo htmlspecialchars($non_att, ENT_QUOTES, 'UTF-8');
                        }

                        if (count($attendances) > 1) {
                            $keyword = 1;
                        } else {
                            $keyword = '';
                        }

                        foreach ($attendances as $attendance) {
                            if ($keyword >= 1) {
                                echo "[{$keyword}回目] ";
                                $keyword++;
                            }
                            $start = Carbon::parse($attendance->start_at);
                            echo htmlspecialchars($start->format('H:i:s'), ENT_QUOTES, 'UTF-8') . '<br />';
                        }
                    @endphp
                </td>
                
                <!-- 勤務終了 -->
                <td class="personal-row__content">
                    @php
                        if (count($attendances) > 1) {
                            $num = 1;
                        } else {
                            $num = '';
                        }
                        foreach ($attendances as $attendance) {
                            if (!empty($num)) {
                                echo "[{$num}回目] ";
                                $num++;
                            }
                            $end = Carbon::parse($attendance->end_at);
                            echo htmlspecialchars($end->format('H:i:s'), ENT_QUOTES, 'UTF-8') . '<br />';
                        }
                    @endphp
                </td>

                <!-- 休憩時間 -->
                <td class="personal-row__content rest-time">
                    @php
                        if (count($attendances) > 1) {
                            $num = 1;
                        } else {
                            $num = '';
                        }

                        foreach ($attendances as $attendance) {
                            if (!empty($num)) {
                                echo "[{$num}回目] ";
                                $num++;
                            }

                            $arrayBreak = [];
                            $arrayRestart = [];
                            
                            if (!empty($attendance->rests)) {
                                foreach ($attendance->rests as $item) {
                                    $arrayBreak[] = $item->break_at;
                                    $arrayRestart[] = $item->restart_at;
                                }
                                echo htmlspecialchars(Attendance::totalRes($arrayBreak, $arrayRestart), ENT_QUOTES, 'UTF-8') . '<br />';
                            }
                        }
                    @endphp

                    @foreach ($attendances as $attendance)
                    @if ($attendance->rests->first())
                    <!-- 休憩詳細 -->
                    <div class="rest-detail">
                        @php
                                $count = 1;
                                $count2 = 1;
                                foreach ($attendance->rests as $item) {
                                    $detail = "[{$count}回目({$count2})] " . $item->break_at . '～' . $item->restart_at;
                                    echo '<p>' . htmlspecialchars($detail, ENT_QUOTES, 'UTF-8') . '</p>';
                                    $count2++;
                                }
                                $count++;
                        @endphp
                    </div>
                    @endif
                    @endforeach
                </td>
                
                <!-- 勤務時間 -->
                <td class="personal-row__content">
                    @php
                        if (count($attendances) > 1) {
                            $num = 1;
                        } else {
                            $num = '';
                        }
                        

                        foreach ($attendances as $attendance) {
                            if (!empty($num)) {
                                echo "[{$num}回目] ";
                                $num++;
                            }
                            if (empty($attendance->rests)) {
                                echo htmlspecialchars(Carbon::parse('00:00:00')->format('H:i:s'), ENT_QUOTES, 'UTF-8') . '<br />';
                            } else {
                                echo htmlspecialchars(Carbon::parse(Attendance::totalAtt($attendance->start_at, $attendance->end_at))->format('H:i:s'), ENT_QUOTES, 'UTF-8') . '<br />';
                            }
                        }
                    @endphp
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection