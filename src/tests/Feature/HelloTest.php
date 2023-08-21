<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
// Model読込
use App\Models\User;

class HelloTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHello()
    {
        // $this->assertTrue(true);

        /* ==================================================
        (1)基本的なテストの実施 20230821
        [結果]
        OK (1 test, 4 assertions)
        ================================================== */
        
        // $arr = [];
        // $this->assertEmpty($arr);
        
        // $txt = "Hello World";
        // $this->assertEquals('Hello World', $txt);
        
        // $n = random_int(0, 100);
        // $this->assertLessThan(100, $n);


        /* ==================================================
        (2)アクセステストの実施 20230821
        [結果]
        No application encryption key has been specified.
        ⇒アプリケーションキー再生成
        Application key set successfully.
        Expected response status code [200] but received 302.
        Failed asserting that 200 is identical to 302. 
        ⇒下記に修正＋TestCase.php修正
        OK (1 test, 3 assertions)
        ================================================== */
        // $user = User::first();

        // $response = $this->actingAs($user)->get('/');
        // $response->assertStatus(200);

        // $response = $this->get('/no_route');
        // $response->assertStatus(404);

        /* ==================================================
        (3)データベースのテストの実施 20230821
        [結果]
        OK (1 test, 2 assertions)
        ================================================== */
        // User::factory()->create([
        //     'name' => 'aaa',
        //     'email' => 'bbb@ccc.com',
        //     'password' => 'test1111'
        // ]);
        // $this->assertDatabaseHas('users', [
        //     'name' => 'aaa',
        //     'email' => 'bbb@ccc.com',
        //     'password' => 'test1111'
        // ]);
    }
}
