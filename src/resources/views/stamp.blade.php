@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/stamp.css') }}" />
@endsection

@section('js')
<script src="{{ asset('js/stamp.js') }}" defer></script>
@endsection

@section('content')
<div class="stamp-section">
    <div class="stamp-title">
        <h1 class="stamp-title__text">
            {{ Auth::user()->name }}さん
            <span class="stamp-title__text-caption">
                @if (session('comment'))
                    {{ session('comment') }}
                @else
                    こんにちは！
                @endif
            </span>
        </h1>
    </div>

    <div class="stamp-content">
        <div class="stamp-attendance">
            <!-- 勤務開始 -->
            <div class="stamp-item">
                <form class="stamp-item__form" action="/" method="POST">
                @csrf
                    <button class="stamp-item__start" type="{{ session('comment') === '出勤中' || session('comment') === '休憩中' ? 'button' : 'submit' }}">勤務開始</button>
                </form>
            </div>

            <!-- 勤務終了 -->
            <div class="stamp-item">
                <form class="stamp-item__form" action="/" method="POST">
                @method('PATCH')
                @csrf
                    <button class="stamp-item__end" type="button">勤務終了</button>
                </form>
            </div>
        </div>
        
        <div class="stamp-rest">
            <!-- 休憩開始 -->
            <div class="stamp-item">
                <form class="stamp-item__form" action="/rest" method="POST">
                @csrf
                    <button class="stamp-item__break" type="{{ session('comment') === '休憩中' ? 'button' : 'submit' }}">休憩開始</button>
                </form>
            </div>

            <!-- 休憩終了 -->
            <div class="stamp-item">
                <form class="stamp-item__form" action="/rest" method="POST">
                @method('PATCH')
                @csrf
                    <button class="stamp-item__restart">休憩終了</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection