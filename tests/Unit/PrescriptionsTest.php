<?php

namespace Tests\Unit;

use App\Appointment;
use App\Doctor;
use App\Document;
use App\Drug;
use App\Image;
use App\Prescription;
use App\Specialty;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Schema;
use Tests\TestCase;

class PrescriptionsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user       = factory(User::class)->states('verified')->create();
        $this->specialty  = factory(Specialty::class)->create();
        $this->doctor     = factory(Doctor::class)->states('active')->create();
        $this->appointment= factory(Appointment::class)->create();
        $this->image      = factory(Image::class)->create();
        $this->document   = factory(Document::class)->create();

        $this->prescription = factory(Prescription::class)->create();
        $this->drug       = factory(Drug::class)->create();
    } 

    /** @test */
    public function prescriptions_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('prescriptions', 
          [
            'id','appointment_id','message_id','usage','comment'
          ]), 1);
    }

    /** @test */
    public function a_prescription_belongs_to_a_user()
    {
        // $this->assertInstanceOf(User::class, $this->prescription->appointment->user);
        $this->assertInstanceOf(User::class, $this->prescription->user);
    }

    /** @test */
    public function a_prescription_belongs_to_a_doctor()
    {
        // $this->assertInstanceOf(Doctor::class, $this->prescription->appointment->doctor);
        $this->assertInstanceOf(Doctor::class, $this->prescription->doctor);
    }

    /** @test */
    public function a_prescription_belongs_to_an_appointment()
    {
        $this->assertInstanceOf(Appointment::class, $this->prescription->appointment);
    }

    /** @test */
    public function a_prescription_has_many_drugs()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->prescription->drugs); 
    }
}
