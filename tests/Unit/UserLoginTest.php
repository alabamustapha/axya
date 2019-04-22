<?php

namespace Tests\Unit;

use App\User;
use App\Region;
use App\City;
use App\UserLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

class UserLoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->region     = factory(Region::class)->create();
        $this->city       = factory(City::class)->create();
        $this->user      = factory(User::class)->create();
        $this->userLogin = factory(UserLogin::class)->create();
    }

    /** @test  */
    public function test_users_database_has_expected_columns()
    {
        $this->assertTrue( Schema::hasColumns('user_logins', 
        [
            'id', 'user_id', 'ip', 'device', 'os', 'type', 'agent', 
            'logged_in_seconds', 'logged_in_minutes', 'logged_in_hours', 
            'last_activity_at', 'logged_out_at', 
            'browser', 'referer_page', 'exit_page', 'session_id',
        ]), 1);
    }

    /** @test */
    public function a_user_login_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->userLogin->user);
    }
}
