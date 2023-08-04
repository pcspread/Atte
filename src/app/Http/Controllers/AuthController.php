<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Model読込
use App\Models\Attendance;
use App\Models\Rest;
// Carbon読込
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * view表示
     * stamp.blade.php
     * @param void
     * @return view
     */
    public function index()
    {
        return view('stamp');
    }

    /**
     * logout処理
     * 退勤時間を更新
     * @param void
     * @return view
     */
    public function logout()
    {
        // Carbon情報の取得
        $now = Carbon::now();

        // セッションにattendance情報がある場合(勤務開始を押している)
        if (session('attendance')) {
            // レコード情報の取得
            $att_id = session('attendance')->id;
            $attRec = Attendance::find($att_id);

            // end_atがnullの場合は、現在時刻を挿入
            if ($attRec->end_at === null) {
                // 日付を超えている場合
                // if ($now->toTimeString() > '12:05:59') {
                if ($now->toDateString() !== session('attendance')->date_at) {
                    // 既存レコードの更新 ==============================
                    $attRec->update([
                        // 'end_at' => $now->subDay()->toDateString() . ' 12:05:59',
                        'end_at' => $now->subDay()->toDateString() . ' 23:59:59',
                        'date_at' => $now->toDateString()
                    ]);
                    // 新規レコードの追加 ==============================
                    Attendance::create([
                        'user_id' => $attRec->user_id,
                        // 'start_at' => $now->addDay()->toDateString() . ' 12:06:00', 
                        'start_at' => $now->addDay()->toDateString() . ' 00:00:00', 
                        'end_at' => $now->__toString(), 
                        'date_at' => $now->toDateString()
                    ]);
                } else {
                    $attRec->update([
                        'end_at' => $now->__toString()
                    ]);
                }
            }
        }

        // セッションにrest情報がある場合(休憩開始を押している)
        if (session('rest')) {
            // レコード情報の取得
            $res_id = session('rest')->id;
            $resRec = Rest::find($res_id);
            
            
            // restart_atがnullの場合は、現在時刻を挿入
            if ($resRec->restart_at === null) {
                // 日付を超えている場合
                // if ($now->toTimeString() > '12:05:59') {
                if ($now->toDateString() !== session('attendance')->date_at) {
                    // 既存レコードの更新 ==============================
                    $resRec->update([
                        // 'restart_at' => '12:05:59'
                        'restart_at' => '23:59:59'
                    ]);
                    // 新規レコードの追加 ==============================
                    Rest::create([
                        'attendance_id' => Attendance::orderBy('id', 'desc')->first()->id,
                        // 'break_at' => '12:06:00',
                        'break_at' => '00:00:00',
                        'restart_at' => $now->toTimeString()
                    ]);
                } else {
                    $resRec->update([
                        'restart_at' => $now->toTimeString()
                    ]);
                }
            }
        }

        // セッション情報の削除
        session()->flush();

        return view('auth.logout');
    }
}
