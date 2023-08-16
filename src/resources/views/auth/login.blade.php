@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}" />
@endsection

@section('content')
<div class="login-section">
    <form class="login-form" action="/login" method="POST">
    @csrf
        <div class="form-title">
            <h1 class="form-title__text">ログイン</h1>
        </div>
        
        <div class="login-content">
            <div class="login-item">
                <div class="login-input">
                    <input class="login-input__item" type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス" autofocus />
                </div>

                <div class="login-error">
                    @error('email')
                        {{ $errors->first('email') }}
                    @enderror
                </div>
            </div>

            <div class="login-item">
                <div class="login-input">
                    <input class="login-input__item" type="password" name="password" value="{{ old('password') }}" placeholder="パスワード" />
                </div>

                <div class="login-error">
                    @error('password')
                        {{ $errors->first('password') }}
                    @enderror
                </div>
            </div>

            <div class="login-item">
                <div class="login-button">
                    <button class="login-button__item">ログイン</button>
                </div>
            </div>

            <div class="login-item">
                <div class="register-comment">
                    <p class="register-comment__text">アカウントをお持ちでない方はこちらから</p>
                </div>

                <div class="register-link">
                    <a  class="register-link__text" href="/register">会員登録</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection