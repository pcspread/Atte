@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}" />
@endsection

@section('content')
<div class="register-section">
    <form class="register-form" action="/register" method="POST">
    @csrf
        <div class="form-title">
            会員登録
        </div>
        
        <div class="register-content">
            <!-- name -->
            <div class="register-item">
                <div class="register-input">
                    <input type="name" name="name" value="{{ old('name') }}" placeholder="名前" autofocus />
                </div>

                <div class="register-error">
                    @error('name')
                        {{ $errors->first('name') }}
                    @enderror
                </div>
            </div>

            <!-- email -->
            <div class="register-item">
                <div class="register-input">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス" />
                </div>

                <div class="register-error">
                    @error('email')
                        {{ $errors->first('email') }}
                    @enderror
                </div>
            </div>

            <!-- password -->
            <div class="register-item">
                <div class="register-input">
                    <input type="password" name="password" value="{{ old('password') }}" placeholder="パスワード" />
                </div>

                <div class="register-error">
                    @error('password')
                        {{ $errors->first('password') }}
                    @enderror
                </div>
            </div>

            <!-- password-confirmaion -->
            <div class="register-item">
                <div class="register-input">
                    <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="確認用パスワード" />
                </div>
            </div>

            <!-- button -->
            <div class="register-item">
                <div class="register-button">
                    <button>会員登録</button>
                </div>
            </div>

            <!-- loginへ -->
            <div class="register-item">
                <div class="login-comment">
                    <p>アカウントをお持ちの方はこちらから</p>
                </div>

                <div class="login-link">
                    <a href="/login">ログイン</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection