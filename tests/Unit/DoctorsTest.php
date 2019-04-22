<?php

namespace Tests\Unit;

use App\Doctor;
use App\Image;
use App\Specialty;
use App\User;
use App\Region;
use App\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Schema;
use Tests\TestCase;

class DoctorsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->region = factory(Region::class)->create();
        $this->city   = factory(City::class)->create();
        $this->image  = factory(Image::class)->create();
        $this->user   = factory(User::class)->create();
        $this->specialty = factory(Specialty::class)->create();
        $this->doctor = factory(Doctor::class)->states('active')->create();
    } 

    /** @test */
    public function doctors_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('doctors', 
          [
            'id','user_id','email','phone','slug','about',
            'main_language','second_language','other_languages',
            'country_id','state_id','home_address','work_address','location',
            'region_id','city_id',        
            'rate','session','first_appointment','available','subscription_ends_at',
            'graduate_school','degree','residency','specialty_id',
            'verified_at','verified_by','revoked', 'serialized_schedules',
          ]), 1);
    }

    /** @test */
    public function a_doctor_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->doctor->user);
    }

    /** @test */
    public function a_doctor_has_many_schedules()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->doctor->schedules); 
    }

    // /** @test */
    // public function a_doctor_has_many_patients()
    // {
    //     $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->doctor->patients); 
    // }

    /** @test */
    public function a_doctor_has_many_workplaces()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->doctor->workplaces); 
    }

    /** @test */
    public function a_doctor_belongs_to_a_specialty()
    {
        $this->assertInstanceOf(Specialty::class, $this->doctor->specialty);
    }

    // /** @test */
    // public function a_doctor_belongs_to_many_specialties()
    // {
    //     $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->doctor->specialties); 
    // }

    /** @test */
    public function a_doctor_has_many_appointments()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->doctor->appointments); 
    }

    /** @test */
    public function a_doctor_has_many_transactions()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->doctor->transactions); 
    }

    /** @test */
    public function a_doctor_has_many_subscriptions()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->doctor->subscriptions); 
    }

    /** @test */
    public function a_doctor_has_many_prescriptions_through_an_appointnment()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->doctor->prescriptions); 
    }

    /** @test */
    public function a_doctor_belongs_to_a_region()
    {
        $this->assertInstanceOf(Region::class, $this->doctor->region);
    }

    /** @test */
    public function a_doctor_belongs_to_a_city()
    {
        $this->assertInstanceOf(City::class, $this->doctor->city);
    }
}