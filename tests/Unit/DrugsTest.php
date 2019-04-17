<?php

namespace Tests\Unit;

use App\Appointment;
use App\Doctor;
use App\Document;
use App\Drug;
use App\Image;
use App\Message;
use App\Prescription;
use App\Specialty;
use App\User;
use App\Region;
use App\City;
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

        $this->region = factory(Region::class)->create();
        $this->city   = factory(City::class)->create();
        $this->user       = factory(User::class)->states('verified')->create();
        $this->specialty  = factory(Specialty::class)->create();
        $this->doctor     = factory(Doctor::class)->states('active')->create();
        $this->appointment= factory(Appointment::class)->states('chatable')->create();
        $this->image      = factory(Image::class)->create();
        $this->document   = factory(Document::class)->create();

        $this->message      = factory(Message::class)->states('appointment')->create();
        $this->prescription = factory(Prescription::class)->create();
        $this->drug         = factory(Drug::class)->create();
    } 

    /** @test */
    public function drugs_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('drugs', 
          [
            'id','prescription_id','name','manufacturer','dosage','usage','comment','texture'
          ]), 1);
    }

    /** @test */
    public function a_drug_belongs_to_a_prescription()
    {
        $this->assertInstanceOf(Prescription::class, $this->drug->prescription);
    }
}
