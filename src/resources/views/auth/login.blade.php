@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}" />
@endsection

@section('content')
<div class="login-section">
    <form class="login-form" action="/login" method="POST">
    @csrf
        <div class="form-title">
            ログイン
        </div>
        
        <div class="login-content">
            <!-- email -->
            <div class="login-item">
                <div class="login-input">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス" autofocus />
                </div>

                <div class="login-error">
                    @error('email')
                        {{ $errors->first('email') }}
                    @enderror
                </div>
            </div>

            <!-- password -->
            <div class="login-item">
                <div class="login-input">
                    <input type="password" name="password" value="{{ old('password') }}" placeholder="パスワード" />
                </div>

                <div class="login-error">
                    @error('password')
                        {{ $errors->first('password') }}
                    @enderror
                </div>
            </div>

            <!-- button -->
            <div class="login-item">
                <div class="login-button">
                    <button>ログイン</button>
                </div>
            </div>

            <!-- registerへ -->
            <div class="login-item">
                <div class="register-comment">
                    <p>アカウントをお持ちでない方はこちらから</p>
                </div>

                <div class="register-link">
                    <a href="/register">会員登録</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection