<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;

    // timestampsを無効にする
    public $timestamps = false;

    // 編集可能なカラムの設定
    protected $fillable = [
        'attendance_id', 'break_at', 'restart_at'
    ];
}
