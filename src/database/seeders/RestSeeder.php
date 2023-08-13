<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// DB取得
use Illuminate\Support\Facades\DB;
// Model取得
use App\Models\Rest;
// Carbon取得
use Carbon\Carbon;

class RestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 各attendanceレコード用にrestsレコード作成(550レコード)
        $s = 0;
        while ($s <= 540) {
            // パターン1：45分休憩
            for ($i = $s + 1; $i <= $s + 3; $i++) {
                $param = [
                    'attendance_id' => $i,
                    'break_at' => '12:00:00',
                    'restart_at' => '12:45:00'
                ];
                DB::table('rests')->insert($param);
            }
            // パターン2：60分休憩
            for ($i = $s + 4; $i <= $s + 6; $i++) {
                $param = [
                    'attendance_id' => $i,
                    'break_at' => '12:00:00',
                    'restart_at' => '13:00:00'
                ];
                DB::table('rests')->insert($param);
            }
            // パターン3：65分休憩
            for ($i = $s + 7; $i <= $s + 10; $i++) {
                $param = [
                    'attendance_id' => $i,
                    'break_at' => '12:00:00',
                    'restart_at' => '13:05:00'
                ];
                DB::table('rests')->insert($param);
            }
            $s = $s + 10;
        }
    }
}
