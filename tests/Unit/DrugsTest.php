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

class DrugsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user       = factory(User::class)->states('verified')->create();
        $this->specialty  = factory(Specialty::class)->create();
        $this->doctor     = factory(Doctor::class)->create();
        $this->appointment= factory(Appointment::class)->create();
        $this->image      = factory(Image::class)->create();
        $this->document   = factory(Document::class)->create();

        $this->prescription   = factory(Prescription::class)->create();
        $this->drug       = factory(Drug::class)->create();
    } 

    /** @test */
    public function drugs_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('drugs', 
          [
            'id','prescription_id','name','manufacturer','dosage','usage','comment'
          ]), 1);
    }

    /** @test */
    public function a_drug_belongs_to_a_prescription()
    {
        $this->assertInstanceOf(Prescription::class, $this->drug->prescription);
    }
}
