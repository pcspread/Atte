<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// DB読込
use Illuminate\Support\Facades\DB;
// Model読込
use App\Models\User;
// Carbon読込
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 名前の要素を用意
        $array = ['一郎', '二郎', '三郎', '四郎', '五郎', '六郎', '七郎', '八郎', '九郎', '十郎'];

        // usersレコード作成準備
        for ($i = 1; $i <= 10; $i++) {
            $param = [
                'name' => "テスト{$array[$i - 1]}",
                'email' => "test{$i}@example.com",
                'password' => bcrypt('test7777'),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            DB::table('users')->insert($param);
        }
    }
}
