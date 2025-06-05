<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testSuccessfulLogin(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create(); //testユーザ作成
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('LOG IN') //ログインボタン押下
                ->assertPathIs('/tweet')
                ->assertSee('つぶやきアプリ');
        });
    }
}
