<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Model読込
use App\Models\Attendance;
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
     * @param array $request
     * @return view
     */
    public function listDate(Request $request)
    {  
        // dd();
        // (Carbon::parse(session('date'))->subDay()->day === Carbon::parse(session('date'))->startOfMonth()->day) ? Carbon::parse(session('date'))->subMonth()->toDateString() : Carbon::parse(session('date'))->subDay()->toDateString()

        // 当日の日付を取得
        $now = Carbon::now();

        // dd([$request->key, $now->toDateString()]);
        // dd($now->toDateString());
        
        // // クエリパラメータがある場合
        // if (!empty($request->key)) {
        //     // 日付をクエリパラメータの指定日へ変更
        //     $now = Carbon::parse($now->year . '/' . $now->month . '/' . $request->key);
        // }

        // 日付をstring型に変更
        // $now = $now->toDateString();
    
        if ($request->key) {
            $attendances = Attendance::with('user', 'rests')->where('date_at', $request->key)->paginate(5);
            $keyDate = Carbon::parse($request->key);
            $now = $keyDate->format('Y/m/d');
        } else {
            // 表示する一覧データの取得
            $attendances = Attendance::with('user', 'rests')->where('date_at', $now->toDateString())->paginate(5);
            $now = $now->format('Y/m/d');
        }


        // セッションに必要情報を格納
        session()->put([
            'date' => $now,
            'attendances' => $attendances
        ]);

        return view('date');
    }
}
