<?php

namespace Tests\Feature;

use App\Day;
use App\Doctor;
use App\Schedule;
use App\Specialty;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SchedulesFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();
        
        $this->doc_user  = factory(User::class)->create();
        $this->specialty = factory(Specialty::class)->create();
        $this->doctor    = factory(Doctor::class)->create(
                            [
                                'id' => $this->doc_user, 
                                'user_id' => $this->doc_user->id
                            ]);
        $this->day       = factory(Day::class)->create();
        $this->schedule  = factory(Schedule::class)->create(
                            [
                                'doctor_id' => $this->doctor->id, 
                                'day_id' => $this->day->id
                            ]);
        $start_time = '5:00:00';
        $end_time   = '11:00:00';
        $this->data = [ 
            'doctor_id' => $this->doctor->id,
            'day_id'    => $this->day->id,
            'start_at'  => $start_time,
            'end_at'    => $end_time,
        ];
    } 

    /** @test */
    public function index_schedules_list_can_be_viewed()
    { 
        $this
            ->get(route('doctors.show', $this->doctor))
            ->assertStatus(200)
            ->assertSee($this->schedule->day->name)
            ->assertSee($this->schedule->start)
            ->assertSee($this->schedule->end)
            ;
    }

    /**  @test */
    public function store_a_schedule_can_be_created()
    {
        $this->actingAs($this->doc_user);

        $this
            ->post(route('schedules.store'), $this->data)
            ->assertStatus(302)
            // ->assertRedirect(route('doctors.show', $this->doctor))
            ;

        $this->assertDatabaseHas('schedules', $this->data);
    }

    /** @test */
    public function update_a_schedule_can_be_updated()
    {
        $this->actingAs($this->doc_user);

        // Create a Schedule
        $schedule = factory(Schedule::class)->create($this->data);
        $this->assertDatabaseHas('schedules', $this->data);

        // Update the Schedule's details
        $start_time = '6:00:00';
        $end_time   = '15:00:00';
        $updated_data = [ 
            'doctor_id' => $this->doctor->id,
            'day_id'    => $this->day->id,
            'start_at'  => $start_time,
            'end_at'    => $end_time,
        ]; 

        $this
            ->patch(route('schedules.update', $schedule), $updated_data)
            ->assertStatus(302)
            // ->assertRedirect(route('doctors.show', $this->doctor))
            ;

        $this->assertDatabaseHas('schedules', $updated_data);
    }

    /** @test */
    public function delete_a_schedule_can_be_removed()
    {
        $this->actingAs($this->doc_user);
        $schedule  = factory(Schedule::class)->create(['doctor_id' => $this->doctor->id]);

        $this
            ->delete(route('schedules.destroy', $schedule))
            ->assertStatus(302)
            ->assertRedirect(route('doctors.show', $this->doctor))
            ;

        $this->assertDatabaseMissing('schedules', $schedule->toArray());
    }
}
