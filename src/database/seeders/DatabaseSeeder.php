<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // usersレコード作成(10件)
        $this->call(UserSeeder::class);

        // attendancesレコード作成(550件)
        $this->call(AttendanceSeeder::class);

        // restsレコード作成(550件)
        $this->call(RestSeeder::class);
    }
}
