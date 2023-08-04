<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Model読込
use App\Models\Rest;
use App\Models\Attendance;
// Auth読込
use Illuminate\Support\Facades\Auth;
// Carbon読込
use Carbon\Carbon;

class RestController extends Controller
{
    /**
     * 休憩開始処理
     * @param array $request 
     * @return view
     */
    public function store(Request $request)
    {
        // attendance_id情報を取得
        $id = $request->id;

        // 作成するレコード用の配列を用意
        $rest = [
            'attendance_id' => $id,
            'break_at' => Carbon::now()->toTimeString()
        ];

        // create処理
        if ($id) {
            Rest::create($rest);
        }

        // 登録情報をセッション格納
        session()->put([
            'rest' => Rest::orderBy('id', 'desc')->first(),
            'comment' => '休憩中'
        ]);

        return redirect('/');
    }

    /**
     * 休憩終了処理
     * @param void
     * @return view
     */
    public function update()
    {
        // Carbon情報を格納
        $now = Carbon::now();

        // セッション情報を格納
        $sesAtt = session('attendance');
        $sesRes = session('rest');

        // もし日付を超えている場合
        // if ($now->toTimeString() > '12:05:59') {
        if ($now->toDateString() !== $sesAtt->date_at) {
            // 既存レコードのupdate処理 ==============================
                // restレコード
                Rest::find($sesRes->id)->update([
                    // 'restart_at' => '12:05:59'
                    'restart_at' => '23:59:59'
                ]);
                // attendanceレコード
                Attendance::find($sesRes->attendance_id)->update([
                    // 'end_at' => $now->subDay()->toDateString() . ' 12:05:59',
                    'end_at' => $now->subDay()->toDateString() . ' 23:59:59',
                    'date_at' => $now->toDateString()
                ]);
            // 新しいレコードの追加処理 ==============================
                // attendanceレコード
                Attendance::create([
                    'user_id' => $sesAtt->user_id,
                    // 'start_at' => $now->addDay()->toDateString() . ' 12:06:00',
                    'start_at' => $now->addDay()->toDateString() . ' 00:00:00',
                    'date_at' => $now->toDateString()
                ]);
                // restレコード
                Rest::create([
                    'attendance_id' => Attendance::orderBy('id', 'desc')->first()->id,
                    // 'break_at' => '12:06:00',
                    'break_at' => '00:00:00',
                    'restart_at' => $now->toTimeString()
                ]);
            // セッション情報の更新 ==============================
            session()->put([
                'attendance' => Attendance::orderBy('id', 'desc')->first(),
                'rest' => rest::orderBy('id', 'desc')->first()
            ]);
        } else {
            // 既存レコードのupdate処理
            Rest::find($sesRes->id)->update([
                'restart_at' => $now->toTimeString()
            ]);
        }

        // セッションにコメント格納
        session()->put('comment', '出勤中');

        return redirect('/');
    }
}
