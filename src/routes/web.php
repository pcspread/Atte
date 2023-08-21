<?php

use Illuminate\Support\Facades\Route;

// Controller読込
use Laravel\Fortify\Http\Controllers;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * ==================================================
 * auth
 * ==================================================
 */
// Route::middleware(['auth', 'verified'])->group(function() {
// Route::middleware('verified')->group(function() {
    // Route::get('/dashboard', [AuthenticatedSessionController::class, 'index']);

    Route::middleware('auth')->group(function() {   
             
        // スタンプ(home)ページ表示
        Route::get('/', [AuthController::class, 'index'])->middleware('basicauth');
        
        // 社員出勤処理
        Route::post('/', [AttendanceController::class, 'store']);
        
        // 社員退勤処理
        Route::patch('/', [AttendanceController::class, 'update']);


        /**
         * ==================================================
         * rest 
         * ==================================================
         */
        // 休憩開始処理
        Route::post('/rest', [RestController::class, 'store']);

        // 休憩終了処理
        Route::patch('/rest', [RestController::class, 'update']);
        
        
        /**
         * ==================================================
         * attendance
         * ==================================================
         */
        Route::prefix('/attendance')->group(function() {
            // 日付別勤怠ページ表示
            Route::get('/', [AttendanceController::class, 'listDate']);
            
            // 社員一覧ページ表示
            Route::get('/list', [AttendanceController::class, 'listUser']);
            
            // 社員別勤怠ページ表示
            Route::get('/personal', [AttendanceController::class, 'listUserPart']);
        });

        
        // ログアウト処理
        Route::post('/logout', [AuthController::class, 'logout']);
    });
