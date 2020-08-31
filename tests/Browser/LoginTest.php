<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public function test_change_language_en()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_URL') . '/login')
                ->click('#en')
                ->assertPathIs('/login')
                ->assertSeeIn('.title', 'Login')
                ->assertSeeIn('form', 'Email')
                ->assertSeeIn('form', 'Password')
                ->assertSeeIn('form', 'Remember Me')
                ->assertSeeIn('form', 'Forgot your password');
        });
    }

    public function test_change_language_vi()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_URL') . '/login')
                ->click('#vi')
                ->assertPathIs('/login')
                ->assertSeeIn('.title', 'Đăng nhập')
                ->assertSeeIn('form', 'E-mail')
                ->assertSeeIn('form', 'Mật khẩu')
                ->assertSeeIn('form', 'Nhớ mật khẩu')
                ->assertSeeIn('form', 'Quên mất khẩu?');
        });
    }

    public function test_login_fail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_URL') . '/login')
                ->type('email', 'stephon.mohr@yahoo.com')
                ->type('password', '123')
                ->press('#btn-login')
                ->assertPathIs('/login');
        });
    }

    public function test_login_success()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_URL') . '/login')
                ->type('email', 'stephon.mohr@yahoo.com')
                ->type('password', 'password')
                ->press('#btn-login')
                ->assertPathIs('/home');
        });
    }
}
