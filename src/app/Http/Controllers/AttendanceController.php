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
     * @param array $request
     * @return view
     */
    public function listDate(Request $request)
    {
        // 当日の日付を取得
        $now = Carbon::now();

        // クエリパラメータがdate型でない場合
        if (!strptime($request->key, '%Y-%m-%d')) {
            // 当日のレコードを取得
            $attendances = Attendance::with('user', 'rests')->where('date_at', $now->toDateString())->paginate(5);
            // 当日の表示形式の変更
            $now = $now->format('Y/m/d');
        } else {
            // 該当日のレコードを取得
            $attendances = Attendance::with('user', 'rests')->where('date_at', $request->key)->paginate(5);
            // 表示用に該当日を格納
            $keyDate = Carbon::parse($request->key);
            $now = $keyDate->format('Y/m/d');
        }
        
        // セッションに必要情報を格納
        session()->put([
            'date' => $now,
            'attendances' => $attendances
        ]);

        return view('date');
    }

    /**
     * 社員一覧ページ表示
     * @param void
     * @return view
     */
    public function listUser()
    {
        // usersレコードを取得
        $users = User::all();

        return view('list', compact('users'));
    }

    /**
     * 社員別勤怠ページ表示
     * @param array $request
     * @return view
     */
    public function listUserPart(Request $request)
    {
        // 当日の日付を取得
        $now = Carbon::now();

        // クエリパラメータ(key)が無い、もしくは数字で無い場合
        if (empty($request->key) || !is_numeric($request->key)) {
            return redirect('/attendance/list');
        }

        // 該当IDのレコードを取得
        $user = User::find($request->key);
        $users = User::where('id', '!=', $request->key)->get();

        // クエリパラメータ(date)がある場合
        if ($request->date) {
            // 該当日のレコードを取得
            $link = Carbon::parse($request->date);
            $attendances = Attendance::with('user', 'rests')->where([['user_id', $request->key], ['date_at', 'like', "%{$link->format('Y-m')}%"]])->orderBy('date_at', 'asc')->get();
            $now = Carbon::parse($request->date);
        } else {
            $attendances = Attendance::with('user', 'rests')->where([['user_id', $request->key], ['date_at', 'like', "%{$now->format('Y-m')}%"]])->orderBy('date_at', 'asc')->get();
        }

        // セッションに必要情報を格納
        session()->put([
            'date' => $now,
            'user' => $user,
            'users' => $users,
            'attendances' => $attendances ?? ''
        ]);
        

        return view('personal');
    }

}
