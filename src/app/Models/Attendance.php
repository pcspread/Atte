<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Model読込
use App\Models\Rest;

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
     * 勤務時間の計算
     */
    // public function totalAttTime()
    // {
    //     $end = $this->end_at;
    //     $start = $this->start_at;

    //     $total = $end - $start;
    //     return $total;
    // }

    /**
     * リレーション設定
     * restsテーブルから複数レコード取得
     */
    // public function rests()
    // {
    //     return $this->hasMany(Rest::class);
    // }
}
