<?php

namespace Tests\Feature\Tweet;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;

class DeleteTest extends TestCase
{
    // DB初期化
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_delete_successed()
    {
        $user = User::factory()->create(); //ユーザー作成

        $tweet = Tweet::factory()->create(['user_id' => $user->id]); //つぶやき作成

        $this->actingAs($user); //指定したユーザーをログイン状態にする

        $response = $this->delete('/tweet/delete/' . $tweet->id); //つぶやきId指定

        $response->assertRedirect('/tweet');
    }
}
