@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/logout.css') }}" />
@endsection

@section('js')
<script src="{{ asset('js/logout.js') }}" defer></script>
@endsection

@section('content')
<div class="logout-section">
    <div class="logout-content">
        <h2>ログアウト</h2>
        <p>
            本日もお疲れ様でした！<br />
            しっかりと休養をお取りください
        </p>
        <a href="/login" autofocus>ログイン画面へ</a>
    </div>
</div>
@endsection