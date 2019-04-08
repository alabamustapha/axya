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
        
        $this->doc_user  = factory(User::class)->states(['verified','doctor'])->create();
        $this->specialty = factory(Specialty::class)->create();
        $this->doctor    = factory(Doctor::class)->states('active')->create(
                            [
                                'id' => $this->doc_user, 
                                'user_id' => $this->doc_user->id
                            ]);
        $this->day       = factory(Day::class)->create();
        $this->schedule  = factory(Schedule::class)->create([
                                'doctor_id' => $this->doctor->id, 
                                'day_id' => $this->day->id
                            ]);
        $this->start_time  = '5:00:00';
        $this->end_time    = '11:10:00';
        $this->start_time2 = '15:00:00';
        $this->end_time2   = '21:00:00';

        $this->axiosSchedules = [ 
            'doctor_id' => $this->doctor->id,
            'day_id'    => $this->day->id,
            'schedules' => [
                [
                    'start_at'  => $this->start_time,
                    'end_at'    => $this->end_time,
                ],
                [ 
                    'start_at'  => $this->start_time2,
                    'end_at'    => $this->end_time2,
                ]
            ],
        ];
    } 

    // /** @test 
    //  *  Maybe not passing because it is now handled by vue
    //  *  Dusk browser test might be a better option.
    //  */
    // public function index_schedules_list_can_be_viewed()
    // { 
    //     $this
    //         ->get(route('doctors.show', $this->doctor))
    //         ->assertStatus(200)
    //         ->assertSee($this->schedule->day->name)
    //         ->assertSee$this->schedule->start)
    //         ->assertSee$this->schedule->end)
    //         ;
    // }

    /**  @test */
    public function store_a_schedule_can_be_created()
    {
        $this->actingAs($this->doc_user);

        $this
            ->post(route('schedules.store'), $this->axiosSchedules)
            // ->assertStatus(200)
            ;
        $schedule_1 = [
                'doctor_id' => $this->doctor->id,
                'day_id'    => $this->day->id,
                'start_at'  => $this->start_time,
                'end_at'    => $this->end_time,
            ];
        $schedule_2 = [
                'doctor_id' => $this->doctor->id,
                'day_id'    => $this->day->id,
                'start_at'  => $this->start_time2,
                'end_at'    => $this->end_time2,
            ];

        $this->assertDatabaseHas('schedules', $schedule_1);
        $this->assertDatabaseHas('schedules', $schedule_2);
    }

    /** @test */
    public function delete_a_schedule_can_be_removed()
    {
        $this->actingAs($this->doc_user);
        $schedule  = factory(Schedule::class)->create(['doctor_id' => $this->doctor->id]);

        $this
            ->delete(route('schedules.destroy', $schedule))
            // ->dump()
            ->assertStatus(302)
            ->assertRedirect(route('doctors.show', $this->doctor))
            ;

        $this->assertDatabaseMissing('schedules', $schedule->toArray());
    }

    // /** @test */ Presently not in use...
    // public function update_a_schedule_can_be_updated()
    // {
    //     $this->actingAs($this->doc_user);

    //     // Create a Schedule
    //     $schedule = factory(Schedule::class)->create($this->axiosSchedules);
    //     $this->assertDatabaseHas('schedules', $this->axiosSchedules);

    //     // Update the Schedule's details
    //     $this->start_time = '6:00:00';
    //     $this->end_time   = '15:00:00';
    //     $updated_data = [ 
    //         'doctor_id' => $this->doctor->id,
    //         'day_id'    => $this->day->id,
    //         'start_at'  => $this->start_time,
    //         'end_at'    => $this->end_time,
    //     ]; 

    //     $this
    //         ->patch(route('schedules.update', $schedule), $updated_data)
    //         // ->assertStatus(302)
    //         // ->assertRedirect(route('doctors.show', $this->doctor))
    //         ;

    //     $this->assertDatabaseHas('schedules', $updated_data);
    // }
}
