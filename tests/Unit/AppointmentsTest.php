<?php

namespace Tests\Unit;

use App\Appointment;
use App\Doctor;
use App\Document;
use App\Image;
use App\Specialty;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Schema;
use Tests\TestCase;

class AppointmentsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user       = factory(User::class)->create();
        $this->specialty  = factory(Specialty::class)->create();
        $this->doctor     = factory(Doctor::class)->states('active')->create();
        $this->appointment= factory(Appointment::class)->create();
        $this->image      = factory(Image::class)->create();
        $this->document   = factory(Document::class)->create();
    } 

    /** @test */
    public function appointments_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('appointments', 
          [
            'id','status','slug','user_id','doctor_id','day','from','to','description','sealed_at','reviewed','type','address','phone',
            'illness_duration','illness_history',
          ]), 1);
    }

    /** @test */
    public function an_appointment_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->appointment->user);
    }

    /** @test */
    public function an_appointment_belongs_to_a_doctor()
    {
        $this->assertInstanceOf(Doctor::class, $this->appointment->doctor);
    }

    /** @test */
    public function an_appointment_has_many_documents()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->appointment->documents); 
    }

    /** @test */
    public function an_appointment_morphs_many_messages()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->appointment->messages); 
    }

    /** @test */
    public function an_appointment_has_many_prescriptions()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->appointment->prescriptions); 
    }

    /** @test */
    public function an_appointment_has_many_transactions()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->user->transactions); 
    }
}