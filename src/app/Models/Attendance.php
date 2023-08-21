<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Carbon読込
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;
    
    
    // timestampsを無効にする
    public $timestamps = false;


    // 編集可能なカラムの設定
    protected $fillable = [
        'user_id', 'start_at', 'end_at', 'date_at'
    ];


    /**
     * リレーション設定
     * restsテーブルと関連付け
     * @param void
     * @return hasMany
     */
    public function rests()
    {
        return $this->hasMany(Rest::class);
    }


    /**
     * リレーション設定
     * usersテーブルと関係付け
     * @param void
     * @return belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * XSS対策としてのエスケープ処理
     * @param string $text エスケープ処理の対象データ
     * @return string $result
     */
    public static function xss($text)
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }


    /**
     * datetime型のデータをdateに変換する
     * @param $element
     * @return string time
     */
    public function changeDate($element)
    {
        return Carbon::parse($element)->format('H:i:s');
    }


    /**
     * 当日の日付の横にチェックマークを印字する
     * @param object $day 日付データ
     * @return string $result ✔マーク
     */
    public function displayTodayMark($day)
    {
        // 日付データが、サイト閲覧日と等しい場合
        if ($day->toDateString() === Carbon::now()->toDateString()) {
            return self::xss('✔');
        }
    }


    /**
     * 勤務開始時間の表示内容を作成する
     * @param object $attendances レコードオブジェクト 
     * @return array $arrayStart 勤務開始時間情報
     */
    public function displayStart($attendances)
    {
        // 表示データ用の変数を初期化
        $displayStart = '';

        // 勤務開始時間のデータが無い場合
        if (empty($attendances[0])) {
            $displayStart .= self::xss('(出勤情報無)');
        }

        // 勤務開始時間の件数計算用のデータを格納
        if (count($attendances) > 1) {
            $keyword = 1;
        } else {
            $keyword = '';
        }

        foreach ($attendances as $attendance) {
            // 勤務開始時間データが複数ある場合
            if ($keyword >= 1) {
                // 件数を格納
                $displayStart .= self::xss("[{$keyword}回目] ");
                $keyword++;
            }
            // 勤務開始時間を格納
            $displayStart .= self::xss(Carbon::parse($attendance->start_at)->format('H:i:s')) . '<br />';
        }

        return $displayStart;
    }


    /**
     * 勤務終了時間の表示内容を作成する
     * @param object $attendances レコードオブジェクト
     * @return array $arrayEnd 勤務終了時間情報
     * 
     */
    public function displayEnd($attendances)
    {
        // 表示データ用の変数を初期化
        $displayEnd = '';

        // 勤務終了時間の件数計算用のデータを格納
        if (count($attendances) > 1) {
            $num = 1;
        } else {
            $num = '';
        }

        foreach ($attendances as $attendance) {
            // 件数が多い場合
            if (!empty($num)) {
                $displayEnd .= self::xss("[{$num}回目] ");
                $num++;
            }
            // 勤務終了時間を格納
            $displayEnd .= self::xss(Carbon::parse($attendance->end_at)->format('H:i:s')) . '<br />';
        }

        return $displayEnd;
    }


    /**
     * 休憩合計時間を計算する
     * @param object $attendances レコードオブジェクト
     * @return array $displayRestTotal 休憩合計時間情報
     */
    public function displayRestTotal($attendances)
    {
        // 表示データ用の変数を初期化
        $displayRestTotal = '';

        // 休憩時間の回数計算用のデータを格納
        if (count($attendances) > 1) {
            $num = 1;
        } else {
            $num = '';
        }

        foreach ($attendances as $attendance) {
            // レコードが複数ある場合
            if (!empty($num)) {
                $displayRestTotal .= self::xss("[{$num}回目] ");
                $num++;
            }

            // 休憩時間を格納する配列を用意
            $arrayBreak = [];
            $arrayRestart = [];
            
            if (!empty($attendance->rests)) {
                // 休憩開始と終了時間を格納
                foreach ($attendance->rests as $item) {
                    $arrayBreak[] = $item->break_at;
                    $arrayRestart[] = $item->restart_at;
                }

                // ベースの時間を設定
                $base = Carbon::parse('00:00:00');

                // 休憩時間を格納する変数を初期化
                $result = '';
                
                // 休憩時間を全てベース時間に加算
                for ($i = 0; $i < count($arrayBreak); $i++) {            
                    // 休憩開始時間を格納
                    $breakTime = Carbon::parse($arrayBreak[$i]);

                    // 「休憩終了」が押されていない場合
                    if (is_null($arrayRestart[$i])) {
                        $result = '(休憩中)';
                    } else {
                        // 休憩終了時間を格納
                        $restartTime = Carbon::parse($arrayRestart[$i]);
                        // 休憩時間を計算
                        $total = $breakTime->diff($restartTime);
                        // 休憩時間を加算
                        $base = $base->add($total);
                    }
                }

                // 休憩中でない場合は、休憩時間を格納
                if ($result !== '(休憩中)') {
                    $result = $base->format('H:i:s');
                }        

                // 「休憩終了」が押されていない場合は、00:00:00を返す
                $displayRestTotal .= self::xss($result) . '<br />';
            }
        }

        return $displayRestTotal;
    }


    /**
     * 勤務合計時間を計算する
     * @param object $attendances レコードオブジェクト
     * @return string $displayAttTotal 勤務合計時間情報
     */
    public function displayAttTotal($attendances)
    {
        // 表示データ用の変数を初期化
        $displayAttTotal = '';

        // 勤務時間の回数計算用データを格納
        if (count($attendances) > 1) {
            $num = 1;
        } else {
            $num = '';
        }
        
        foreach ($attendances as $attendance) {
            // レコードが複数ある場合
            if (!empty($num)) {
                $displayAttTotal .= self::xss("[{$num}回目] ");
                $num++;
            }

            if (empty($attendance->rests)) {
                // 休憩時間レコードが無い場合
                $displayAttTotal .= self::xss(Carbon::parse('00:00:00')->format('H:i:s')) . '<br />';
            } else {
                // 休憩時間レコードがある場合
                $startTime = Carbon::parse($attendance->start_at);
                $endTime = Carbon::parse($attendance->end_at);
                // 勤務時間を計算
                $diff = $startTime->diff($endTime);
                $displayAttTotal .= self::xss($diff->format('%H:%I:%S')) . '<br />';
            }
        }

        return $displayAttTotal;
    }

    /**
     * 休憩時間詳細の表示内容を作成する
     * @param object $attendances レコードオブジェクト
     * @return string $displayRestDetail 休憩詳細情報
     */
    public function displayRestDetail($attendances)
    {
        // 表示データ用の変数を初期化
        $displayRestDetail = '';
        
        // 出勤の回数計算用の変数用意
        $count = 1;

        foreach ($attendances as $attendance) {
            // 出勤回数格納
            $displayRestDetail .= self::xss("[{$count}回目]") . '<br />';

            // 休憩情報レコードが無い場合
            if (!$attendance->rests->first()) {
            $displayRestDetail .= self::xss('休憩情報無') . '<br />';
            }

            // 休憩の回数計算用の変数用意
            $count2 = 1;
            
            // 休憩時間を格納
            foreach ($attendance->rests as $item) {
                $detail = "({$count2}) {$item->break_at}～{$item->restart_at}";
                $displayRestDetail .= '<p>' . self::xss($detail) . '</p>';
                $count2++;
            }
            $count++;
        }

        return $displayRestDetail;
    }


    /**
     * 該当日のレコードを抽出
     * @param int $id 該当社員のID
     * @param object $date 該当日 
     * @return void
     */
    public function dateMatch($id, $date) 
    {
        // 日付のフォーマット変更
        $format = Carbon::parse($date)->format('Y-m-d');
        
        // Attendance::where([['user_id', $id], ['date_at', $date]])->get();
        return Attendance::where([['user_id', $id], ['date_at', $date]])->first();
    }
}
