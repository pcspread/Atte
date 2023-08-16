@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}" />
@endsection

@section('content')
<div class="register-section">
    <form class="register-form" action="/register" method="POST">
    @csrf
        <div class="form-title">
            <h1 class="form-title__text">会員登録</h1>    
        </div>
        
        <div class="register-content">
            <div class="register-item">
                <div class="register-input">
                    <input class="register-input__item" type="name" name="name" value="{{ old('name') }}" placeholder="名前" autofocus />
                </div>

                <div class="register-error">
                    @error('name')
                        {{ $errors->first('name') }}
                    @enderror
                </div>
            </div>

            <div class="register-item">
                <div class="register-input">
                    <input class="register-input__item" type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス" />
                </div>

                <div class="register-error">
                    @error('email')
                        {{ $errors->first('email') }}
                    @enderror
                </div>
            </div>

            <div class="register-item">
                <div class="register-input">
                    <input class="register-input__item" type="password" name="password" value="{{ old('password') }}" placeholder="パスワード" />
                </div>

                <div class="register-error">
                    @error('password')
                        {{ $errors->first('password') }}
                    @enderror
                </div>
            </div>

            <div class="register-item">
                <div class="register-input">
                    <input class="register-input__item" type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="確認用パスワード" />
                </div>
            </div>

            <div class="register-item">
                <div class="register-button">
                    <button class="register-button__item">会員登録</button>
                </div>
            </div>

            <div class="register-item">
                <div class="login-comment">
                    <p class="login-comment__text">アカウントをお持ちの方はこちらから</p>
                </div>

                <div class="login-link">
                    <a class="login-link__text" href="/login">ログイン</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection