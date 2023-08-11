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
     */
    public function rests()
    {
        return $this->hasMany(Rest::class);
    }


    /**
     * リレーション設定
     * usersテーブルと関係付け
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * datetime型のデータをdateに変換する
     */
    public function changeDate($element)
    {
        return Carbon::parse($element)->format('H:i:s');
    }


    /**
     * 休憩時間を計算する
     */
    public function totalRes($arrayBreak, $arrayRestart)
    {
        // ベースの時間を設定
        $base = Carbon::parse('00:00:00');

        // 休憩時間を全てベース時間に加算
        for ($i = 0; $i < count($arrayBreak); $i++) {
            // 休憩開始時間を格納
            $breakTime = Carbon::parse($arrayBreak[$i]);

            // 「休憩終了」が押されていない場合
            if (empty($restartTime)) {
                // 休憩開始時間を格納
                $restartTime = $breakTime;
            } else {
                // 休憩終了時間を格納
                $restartTime = Carbon::parse($arrayRestart[$i]);
            }
            $total = $breakTime->diff($restartTime);

            $base = $base->add($total);
        }

        // 「休憩終了」が押されていない場合は、00:00:00を返す
        return $base->format('H:i:s');
    }


    /**
     * 勤務時間を計算する
     */
    public function totalAtt($start, $end)
    {
        $startTime = Carbon::parse($start);
        $endTime = Carbon::parse($end);
        $diff = $startTime->diff($endTime);
        return $diff->format('%H:%I:%S');
    }
}
