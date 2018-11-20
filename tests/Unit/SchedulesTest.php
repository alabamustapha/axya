<?php

namespace Tests\Unit;

use App\Day;
use App\Doctor;
use App\Schedule;
use App\Specialty;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Schema;
use Tests\TestCase;

class SchedulesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user      = factory(User::class)->create();
        $this->specialty = factory(Specialty::class)->create();
        $this->doctor    = factory(Doctor::class)->create();
        $this->day       = factory(Day::class)->create();
        $this->schedule  = factory(Schedule::class)->create();
    } 

    /** @test */
    public function schedules_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('schedules', 
          [
            'id','doctor_id','day_id','start_at','end_at', 
          ]), 1);
    }

    /** @test */
    public function a_schedule_belongs_to_a_doctor()
    {
        $this->assertInstanceOf(Doctor::class, $this->schedule->doctor);
    }

    /** @test */
    public function a_schedule_belongs_to_a_day()
    {
        $this->assertInstanceOf(Day::class, $this->schedule->day);
    }
}