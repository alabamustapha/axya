<?php

namespace Tests\Feature\Auth;

use App\Traits\UserLoginActivityRecording;
use App\User;
use App\Region;
use App\City;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker, UserLoginActivityRecording;

    /** Nice Guide
     *  https://medium.com/@DCzajkowski/testing-laravel-authentication-flow-573ea0a96318
     */
    public function setUp()
    {
        parent::setUp();

        $this->region     = factory(Region::class)->create();
        $this->city       = factory(City::class)->create();
        $this->user      = factory(User::class)->create([ 
          'password' => $this->password  = bcrypt($password = '123-456'),
        ]);
    } 

    
    /** @test */
    public function a_user_can_view_a_login_form()
    {
        $this->get(route('login'))
             ->assertStatus(200)
             ->assertViewIs('auth.login')
             ;
    }

    /** @test */
    public function a_user_cannot_view_a_login_form_when_authenticated()
    {
        // $this->user = factory(User::class)->make();

        $this->actingAs($this->user)
             ->get(route('login'))
             // ->assertRedirect(route('user_dashboard'))
             ->assertRedirect(route('home'))
             ;
    }

    /** @test */
    public function a_user_cannot_login_with_incorrect_password()
    {
        $user = factory(User::class)->create([ 'password' => bcrypt('123-456') ]);
        
        $response = 
            $this->from('/login')
                 ->post('/login', [ 'email' => $user->email, 'password' => 'invalid-password' ])
                 ->assertRedirect('/login')
                 ;
        // $response->assertSessionHasErrors('password');
        $this->assertFalse(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function a_user_can_login_with_correct_credentials()
    {
        $user = factory(User::class)->create([
          'password' => bcrypt($password = '123-456'), 
        ]);

        $this->post( route('login'), ['email'=> $user->email, 'password'=> $password] )
             // ->assertRedirect(route('home'))
             ->assertRedirect(route('user_dashboard'))
             ;
        $this->assertAuthenticatedAs($user);
    }


    /** @test */
    public function a_user_login_details_are_recorded()
    {
        $user = factory(User::class)->create(['password'=> bcrypt($password = '123-456')]);

        $this->post( route('login'), ['email'=> $user->email, 'password'=> $password] );
        $this->assertAuthenticatedAs($user);

        $loginData = $this->collectUserLoginData()->toArray();
        $this->assertDatabaseHas('user_logins', $loginData);
    }

    // /** @test */
    // public function a_user_logout_details_are_updated()
    // {
    //     $user = factory(User::class)->create();
    //     $this->actingAs($user);

    //     $this->post( route('logout') );

    //     $logoutData = $this->collectUserLogoutData()->toArray();
    //     dd($logoutData);

    //     $this->assertFalse($this->assertAuthenticatedAs($user));
    //     // $this->assertGuest();

    //     $this->assertDatabaseHas('user_logins', $logoutData);
    // }


    // /** @test */   
    // public function test_remember_me_functionality()
    // {
    //     $user = factory(User::class)->create([
    //         // 'id' => random_int(1, 100),
    //         'password' => bcrypt($password = '123-456'),
    //     ]);
        
        
    //     $response = $this->post('/login', [
    //         'email'    => $user->email,
    //         'password' => $password,
    //         'remember' => 'on',
    //     ]);
    //     $response->assertRedirect(route('user_dashboard'));

    //     // cookie assertion goes here
    //     // $cookieVal = vsprintf('%s|%s|%s', [
    //     //     $user->id,
    //     //     $user->getRememberToken(),
    //     //     $user->password,
    //     // ]);
    //     // // dd($cookieValue);
    //     // $response->assertCookie(Auth::guard()->getRecallerName(), $cookieVal);

    //     $this->assertAuthenticatedAs($user);
    // }
}
