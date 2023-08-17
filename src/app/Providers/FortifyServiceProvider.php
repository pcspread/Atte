<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // create処理：社員新規登録処理
        Fortify::createUsersUsing(CreateNewUser::class);

        // view表示：auth.register.blade.php
        Fortify::registerView(function() {
            return view('auth.register');
        });

        // view表示：auth.login.blade.php
        Fortify::loginView(function() {
            return view('auth.login');
        });

        // login回数制限：1分あたり10回まで
        RateLimiter::for('login', function(Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(10)->by($email . $request->ip());
        });

        // メール認証
        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });
    }
}
