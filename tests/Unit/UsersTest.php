<?php

namespace Tests\Unit;

use App\Appointment;
use App\Doctor;
use App\Image;
use App\Message;
use App\Specialty;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->specialty = factory(Specialty::class)->create();
        $this->doctor = factory(Doctor::class)->states('active')->create();
    }

    /** @test  */
    public function test_users_database_has_expected_columns()
    {
        $this->assertTrue( Schema::hasColumns('users', 
        [
            'id','name','slug','email','email_verified_at','address','phone',
            'gender','avatar','acl','application_status','blocked','dob','weight','height',
            'allergies','chronics','password','last_four','terms','as_doctor',
            'admin_mode','admin_password','doctor_mode','doctor_password',
        ]), 1);
    }

    /** @test  */
    public function a_user_has_name_attribute()
    {
        $this->assertNotNull($this->user->name);
    }

    /** @test  */
    public function a_user_has_email_attribute()
    {
        $this->assertNotNull($this->user->email);
    }

    /** @test  */
    public function a_user_has_many_messages()
    {
        $appointment = factory(Appointment::class)->create();

        // Method 1:
        $message   = factory(Message::class)->create(['user_id' => $this->user->id]);        
        $this->assertTrue($this->user->messages->contains($message));

        // Method 2:
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->user->messages);
    }

    /** @test  */
    public function a_user_has_many_calendar_events()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->user->calendar_events);
    }

    /** @test  */
    public function a_user_has_many_bank_accounts()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->user->bankAccounts);
    }

    /** @test  */
    public function a_user_has_many_images()
    {
        $image   = factory(Image::class)->create(['user_id' => $this->user->id]);
        
        $this->assertTrue($this->user->images->contains($image));
    }

    /** @test */
    public function a_user_has_a_doctor_profile()
    {
        $this->assertInstanceOf(Doctor::class, $this->user->doctor); 
    }

    /** @test */
    public function a_user_has_many_doctors()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->user->doctors); 
    }

    /** @test */
    public function a_user_has_many_appointments()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->user->appointments); 
    }

    /** @test */
    public function a_user_has_many_transactions()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->user->transactions); 
    }

    /** @test */
    public function a_user_has_many_subscriptions()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->user->subscriptions); 
    }

    /** @test */
    public function a_user_has_many_prescriptions_through_an_appointnment()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->user->prescriptions); 
    }
}