<?php

namespace Tests\Unit;

use App\Doctor;
use App\Image;
use App\Specialty;
use App\User;
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

        $this->image  = factory(Image::class)->create();
        $this->user   = factory(User::class)->create();
        $this->specialty = factory(Specialty::class)->create();
        $this->doctor = factory(Doctor::class)->create();
    } 

    /** @test */
    public function doctors_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('doctors', 
          [
            'id','user_id',/*'specialty_id',*/'graduate_school','verified_by','verified_at', 
          ]), 1);
    }

    /** @test */
    public function a_doctor_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->doctor->user);
    }

    /** @test */
    public function a_doctor_has_many_patients()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->doctor->patients); 
    }

    // /** @test */
    // public function a_doctor_belongs_to_a_specialty()
    // {
    //     $this->assertInstanceOf(Specialty::class, $this->doctor->specialty);
    // }

    /** @test */
    public function a_doctor_belongs_to_many_specialties()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->doctor->specialties); 
    }
}