<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// DB読込
use Illuminate\Support\Facades\DB;
// Model読込
use App\Models\Attendance;
// Carbon読込
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1日前の日付を格納
        $baseDate = Carbon::now()->subDay(55);

        // レコードを3パターン(55日前まで)作成(550レコード)
        $base = 1;
        while ($base <= 55) {
            // 1パターンを10レコード作成
            for ($i = 1; $i <= 10; $i++) {
                $param = [
                    'user_id' => $i,
                    'start_at' => $baseDate->toDateString() . ' 09:00:00',
                    'end_at' => $baseDate->toDateString() . ' 18:00:00',
                    'date_at' => $baseDate->toDateString()
                ];
                DB::table('attendances')->insert($param);
            }
            // 日付を加算
            $baseDate = $baseDate->addDay();
            $base++;
        }
    }
}