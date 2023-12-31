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
use Carbon\CarbonPeriod;

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

        // 日付が超えていた場合の処理
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
        // クエリパラメータ(date)を取得
        $date = $request->date;

        // 当日の日付を取得
        $now = Carbon::now();

        // クエリパラメータがdate型でない場合(未関係の文字を入力された場合)
        if (!strptime($date, '%Y-%m-%d')) {
            // 当日のレコードを取得
            $attendances = Attendance::with('user', 'rests')->where('date_at', $now->toDateString())->paginate(5);
            // 当日の表示形式の変更
            $now = $now->format('Y/m/d');
        } else {
            // 該当日のレコードを取得
            $attendances = Attendance::with('user', 'rests')->where('date_at', $date)->paginate(5);
            // 表示用に該当日を格納
            $keyDate = Carbon::parse($date);
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
     * @return redirect,view
     */
    public function listUserPart(Request $request)
    {
        // クエリパラメータを取得
        $user_id = $request->id; // id
        $month = $request->month; // month
     
        // 当日の日付を取得
        $now = Carbon::now();

        // $user_idが無い、もしくは数字で無い場合(未関係の文字を入力された場合)
        // $monthが'Y-m'型で無い場合
        if (empty($user_id) || !is_numeric($user_id) || ($month && !Carbon::hasFormat($month, 'Y-m'))) {
            // 社員一覧ページへ
            return redirect('/attendance/list');
        }
        

        // 該当IDのレコードを取得
        $user = User::find($user_id);
        $users = User::where('id', '!=', $user_id)->get();

        // $monthがある場合
        if ($month) {
            // 該当日のレコードを取得
            $link = Carbon::parse($month);
            $attendances = Attendance::with('user', 'rests')->where([['user_id', $user_id], ['date_at', 'like', "%{$link->format('Y-m')}%"]])->orderBy('date_at', 'asc')->get();
            $now = Carbon::parse($month);
        } else {
            $attendances = Attendance::with('user', 'rests')->where([['user_id', $user_id], ['date_at', 'like', "%{$now->format('Y-m')}%"]])->orderBy('date_at', 'asc')->get();
        }

        
        // 該当月の全ての日を取得
        $baseDay = $now->copy();
        $days = CarbonPeriod::create($baseDay->startOfMonth()->toDateString(), $baseDay->endOfMonth()->toDateString())->toArray();
        

        // セッションに必要情報を格納
        session()->put([
            'user_id' => $user_id,
            'month' => $now,
            'days' => $days,
            'user' => $user,
            'users' => $users,
            'attendances' => $attendances ?? ''
        ]);
        

        return view('personal');
    }
}
