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
        // 3日前の日付でattendanceレコード作成準備
        $baseDate = Carbon::now()->subDay();
        $baseDate = $baseDate->subDay();
        $threeDaysAgo = $baseDate->subDay();

        for ($i = 1; $i <= 10; $i++) {
            $param = [
                'user_id' => $i,
                'start_at' => $threeDaysAgo->toDateString() . ' 09:00:00',
                'end_at' => $threeDaysAgo->toDateString() . ' 18:00:00',
                'date_at' => $threeDaysAgo->toDateString()
            ];
            DB::table('attendances')->insert($param);
        }
        

        // 2日前の日付でattendanceレコード作成準備
        $twoDaysAgo = $threeDaysAgo->addDay();

        for ($i = 1; $i <= 10; $i++) {
            $param = [
                'user_id' => $i,
                'start_at' => $twoDaysAgo->toDateString() . ' 09:00:00',
                'end_at' => $twoDaysAgo->toDateString() . ' 18:00:00',
                'date_at' => $twoDaysAgo->toDateString()
            ];
            DB::table('attendances')->insert($param);
        }


        // 2日前の日付でattendanceレコード作成準備
        $yesterday = $twoDaysAgo->addDay();

        for ($i = 1; $i <= 10; $i++) {
            $param = [
                'user_id' => $i,
                'start_at' => $yesterday->toDateString() . ' 09:00:00',
                'end_at' => $yesterday->toDateString() . ' 18:00:00',
                'date_at' => $yesterday->toDateString() 
            ];
            DB::table('attendances')->insert($param);        
        }
    }
}