@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/verify-email.css') }}" />
@endsection

@section('js')
<script src="{{ asset('js/verify-email.js') }}" defer></script>
@endsection

@section('content')
<div class="logout-section">
    <div class="logout-content">
        <h1 class="logout-content__title">メール認証中</h1>
        <p class="logout-content__caption">
            入力されたメールアドレスに確認メールを送信しました<br />
            確認メールが届きましたら、「Verify Email Address」を押して、登録を完了してください
        </p>
    </div>
</div>
@endsection