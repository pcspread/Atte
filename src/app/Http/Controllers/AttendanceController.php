<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Model読込
use App\Models\Attendance;
use App\Models\User;
// Auth読込
use Illuminate\Support\Facades\Auth;
// Carbon読込
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * 社員出勤処理
     * @param void
     * @return redirect
     */
    public function store()
    {
        // 社員IDを取得
        $id = Auth::user()->id;

        // Carbon情報の取得
        $now = Carbon::now();

        // 格納する配列を用意
        $attendance = [
            'user_id' => $id,
            'start_at' => $now->__toString(),
            'date_at' => $now->toDateString()
        ];

        // create処理
        if ($id) {
            Attendance::create($attendance);
        }

        // 登録情報をセッション格納
        session()->put([
            'attendance' => Attendance::orderBy('id', 'desc')->first(),
            'comment' => '出勤中'
        ]);

        return redirect('/');
    }

    /**
     * 社員退勤処理
     * @param void
     * @return redirect
     */
    public function update()
    {
        // 現在のCarbon情報取得
        $now = Carbon::now();

        // セッション情報の格納
        $ses = session('attendance');

        // もし日付が超えていた場合
        if ($now->toDateString() !== $ses->date_at) {
            // 既存レコードのupdate処理
            Attendance::find($ses->id)->update([
                    // 前日の～23:59:59
                    'end_at' => $now->subDay()->toDateString() . ' 23:59:59',
                    'date_at' => $now->toDateString()
            ]);

            // 新規レコード追加処理
            Attendance::create([
                // 当日の00:00:00～
                'user_id' => $ses->user_id,
                'start_at' => $now->addDay()->toDateString() . ' 00:00:00',
                'end_at' => $now->__toString(),
                'date_at' => $now->toDateString()
            ]);
        } else {
            // 既存レコードのupdate処理
            Attendance::find($ses->id)->update([
                    'end_at' => $now->__toString()
            ]);
        }

        // セッションにコメント格納
        session()->put('comment', 'お疲れ様でした！');

        return redirect('/');
    }

    /**
     * 日付別勤怠ページ表示
     * @param void
     * @return view
     */
    public function listDate()
    {
        // アクセス時の日付を表示
        $now = Carbon::now()->toDateString();

        // 表示するデータの取得
        $users = User::paginate(5);
        // $users = User::with('attendances')->paginate(5);

        // dd($users[0]['start_at']);

        // セッションに必要情報を格納
        session()->put([
            'date' => $now,
            'users' => $users
        ]);

        return view('date');
    }
}
