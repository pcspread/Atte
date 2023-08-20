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
     * datetime型のデータをdateに変換する
     * @param $element
     * @return string time
     */
    public function changeDate($element)
    {
        return Carbon::parse($element)->format('H:i:s');
    }


    /**
     * 休憩時間を計算する
     * @param array $arrayBreak:休憩開始時間の配列
     * @param array $arrayRestart:休憩終了時間の配列
     * @return string time:休憩時間
     */
    public function totalRes($arrayBreak, $arrayRestart)
    {
        // ベースの時間を設定
        $base = Carbon::parse('00:00:00');

        // 返す結果を初期化
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
        return $result;
    }


    /**
     * 勤務時間を計算する
     * @param string $start:勤務開始時間
     * @param string $end:勤務終了時間
     * @return string time:勤務時間
     */
    public function totalAtt($start, $end)
    {
        $startTime = Carbon::parse($start);
        $endTime = Carbon::parse($end);
        // 勤務時間を計算
        $diff = $startTime->diff($endTime);
        return $diff->format('%H:%I:%S');
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
