<?php

namespace Tests\Unit;

use App\Application;
use App\Document;
use App\Specialty;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Schema;
use Tests\TestCase;

class ApplicationsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user       = factory(User::class)->create();
        $this->specialty  = factory(Specialty::class)->create();
        $this->application= factory(Application::class)->create();
        $this->document   = factory(Document::class)->create();
    } 

    /** @test */
    public function applications_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('applications', 
          [
            'id','user_id','specialty_id','first_appointment',
            'workplace','workplace_address','workplace_start',
            'specialist_diploma','competences','malpraxis',
            'medical_college','medical_college_expiry',
          ]), 1);
    }

    /** @test */
    public function an_application_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->application->user);
    }

    /** @test */
    public function an_application_belongs_to_a_specialty()
    {
        $this->assertInstanceOf(Specialty::class, $this->application->specialty);
    }
}
