<?php

namespace Tests\Unit;


use App\Appointment;
use App\Doctor;
use App\Drug;
use App\Message;
use App\Prescription;
use App\Specialty;
use App\User;
use App\Medication;

use Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MedicationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->docUser      = factory(User::class)->states('verified')->create();
        $this->user         = factory(User::class)->states('verified')->create();
        $this->specialty    = factory(Specialty::class)->create();
        $this->doctor       = factory(Doctor::class)->states('active')->create(['id'=>$this->docUser, 'user_id'=>$this->docUser,]);
        $this->appointment  = factory(Appointment::class)->create();

        $this->message      = factory(Message::class)->states('appointment')->create();
        $this->prescription = factory(Prescription::class)->create();

        $this->medication         = factory(Medication::class)->create();
    } 

    /** @test */
    public function medications_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('medications', 
          [
            'user_id', 'title', 'prescription_id', 'appointment_id', 'description', 'start_date', 'start_time', 'end_date', 'notify_by', 'recurrence', 'recurrence_type',
          ]), 1);
    }

    /** @test */
    public function a_medication_belongs_to_a_user()
    {;
        $this->assertInstanceOf(User::class, $this->medication->user);
    }

    /** @test */
    public function a_medication_belongs_to_a_prescription()
    {
        $this->assertInstanceOf(Prescription::class, $this->medication->prescription);
    }

    /** @test */
    public function a_medication_belongs_to_an_appointment()
    {
        $this->assertInstanceOf(Appointment::class, $this->medication->appointment);
    }

    /** @test */
    public function a_has_description_attribute()
    {
        $this->assertNotNull($this->medication->description);
    }
}
