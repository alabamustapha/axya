<?php

namespace Tests\Unit;

use App\Doctor;
use App\User;
use App\Workplace;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Schema;
use Tests\TestCase;

class WorkplacesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user       = factory(User::class)->create();
        $this->doctor     = factory(Doctor::class)->create();
        $this->workplace  = factory(Workplace::class)->create();
    } 

    /** @test */
    public function documents_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('workplaces', 
          [
            'id','doctor_id','name','address','start_date','end_date',
          ]), 1);
    }

    /** @test */
    public function a_workplace_belongs_to_a_doctor()
    {
        $this->assertInstanceOf(Doctor::class, $this->workplace->doctor);
    }
}
