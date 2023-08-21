<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
// Seeder読込
// use Database\Seeders\UserSeeder;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // public function setUp(): void
    // {
    //     parent::setUp();

    //     // UserSeederを呼び出してデータ準備
    //     $this->seed(UserSeeder::class);
    // }
}
