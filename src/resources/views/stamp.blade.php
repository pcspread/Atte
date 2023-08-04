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
        <h2>
            {{ Auth::user()->name }}さん
            <span>
                @if (session('comment'))
                    {{ session('comment') }}
                @else
                    こんにちは！
                @endif
            </span>
        </h2>
    </div>

    <div class="stamp-content">
        <div class="stamp-attendance">
            <div class="stamp-item">
                <form action="/" method="POST">
                @csrf
                    <button class="stamp-item__start" type="{{ session('comment') === '出勤中' || session('comment') === '休憩中' ? 'button' : 'submit' }}">勤務開始</button>
                </form>
            </div>

            <div class="stamp-item">
                <form action="/" method="POST">
                @method('PATCH')
                @csrf
                    <!-- @if (session('attendance'))
                    <input type="hidden" name="id" value="{{ session('attendance')->id }}">
                    @endif -->
                    <button class="stamp-item__end" type="button">勤務終了</button>
                </form>
            </div>
        </div>
        
        <div class="stamp-rest">
            <div class="stamp-item">
                <form action="/rest" method="POST">
                @csrf
                    <!-- @if (session('attendance'))
                    <input type="hidden" name="id" value="{{ session('attendance')->id }}">
                    @endif -->
                    <button class="stamp-item__break" type="{{ session('comment') === '休憩中' ? 'button' : 'submit' }}">休憩開始</button>
                </form>
            </div>
            
            <div class="stamp-item">
                <form action="/rest" method="POST">
                @method('PATCH')
                @csrf
                    <button class="stamp-item__restart">休憩終了</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection