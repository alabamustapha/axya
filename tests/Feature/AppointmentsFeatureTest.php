<?php

namespace Tests\Feature;

use App\Appointment;
use App\Doctor;
use App\Specialty;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppointmentsFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user        = factory(User::class)->states('verified')->create();
        $this->specialty   = factory(Specialty::class)->create();
        $this->doctor      = factory(Doctor::class)->states('active')->create();
        $this->appointment = factory(Appointment::class)->create(['user_id' => $this->user->id]);
        $this->sub_description = substr($this->appointment->description, 0,100);

        $this->user2       = factory(User::class)->states('verified')->create();
        $this->appointment2= factory(Appointment::class)->create(['user_id' => $this->user2->id]);

        $this->data = [ 
            'type'        => 'Home',
            'phone'       => $this->faker->e164PhoneNumber,
            'address'     => '565 Kshlerin Wells Suite 835\nRebekachester, PA 44034',

            'user_id'     => $this->user2->id,
            'slug'        => $this->user2->slug,
            'doctor_id'   => $this->doctor->id,
            'description' => 'Reiciendis inventore et omnis non asperiores.',

            'day'         => '2018-12-23 10:00:00',
            'from'        => '05:00 AM',
            'to'          => '11:00 PM',
        ];
    } 

    /** @test */
    public function index_a_user_appointments_list_can_be_viewed_by_self()
    {
        $this
            ->actingAs($this->user)
            ->get(route('appointments.index', $this->appointment->user))
            ->assertStatus(200)
            // ->assertSee($this->appointment->statusText())
            ->assertSee($this->appointment->doctor->name)
            ->assertSee($this->sub_description)
            ;
    }

    /** @test */
    public function show_an_appointment_can_be_viewed_by_creator()
    {
        $this
            ->actingAs($this->user)
            ->get(route('appointments.show', $this->appointment))
            ->assertStatus(200)
            // ->assertSee($this->appointment->statusText())
            ->assertSee($this->appointment->doctor->name)
            ->assertSee($this->appointment->from)
            ->assertSee($this->appointment->to)
            ->assertSee($this->sub_description)
            ;
    }

    /** @test */
    public function show_an_appointment_cannot_be_viewed_by_non_creator()
    {
        $user = factory(User::class)->states('verified')->create();

        $this
            ->actingAs($user)
            ->get(route('appointments.show', $this->appointment))
            ->assertStatus(403)
            ->assertDontSee($this->appointment->from)
            ->assertDontSee($this->appointment->to)
            ->assertDontSee($this->sub_description)
            ;
    }

    /**  @test */
    public function store_an_appointment_cannot_be_created_by_an_unverified_user()
    {
        $user = factory(User::class)->states('unverified')->create();
        
        $data = [ 
            'type'        => 'Online',
            'user_id'     => $user->id,
            'doctor_id'   => $this->doctor->id,
            'description' => $this->faker->sentence,

            'day'         => $this->faker->dateTimeBetween('-50 day', '-1day'),
            'from'        => '05:00 AM',
            'to'          => '11:00 PM',
        ];

        $this
            ->actingAs($user)
            ->post(route('appointments.store'), $data)
            ->assertStatus(302) // Redirected to verify page
            ;

        $this->assertDatabaseMissing('appointments', $data);
    }

    /**  @test */
    public function store_an_appointment_can_be_created_by_a_verified_user()
    {
        $user = factory(User::class)->states('verified')->create();

        $data = [ 
            'type'        => 'Home',
            'phone'       => $this->faker->e164PhoneNumber,
            'address'     => $this->faker->address,

            'user_id'     => $user->id,
            'slug'        => str_slug(date('Y-m-d')). $user->slug,
            'doctor_id'   => $this->doctor->id,
            'description'=> $this->faker->sentence,

            'day'         => date('Y-m-d'),
            'from'        => '05:00 AM',
            'to'          => '11:00 PM',
        ];
        // Caters for Concatenation to 2400 ::formatHourTo2400();
        $data_edited = $data;
        $data_edited = array_merge($data_edited, [
            'day'         => date('Y-m-d') .' 00:00:00',
            'from'        => date('Y-m-d') .' 05:00',
            'to'          => date('Y-m-d') .' 23:00',
        ]);

        $this
            ->actingAs($user)
            ->post(route('appointments.store'), $data)
            ;

        $this->assertDatabaseHas('appointments', $data_edited);
    }

    /** @test */
    public function update_an_appointment_can_be_updated()
    {
        $user = factory(User::class)->states('verified')->create();

        $this->actingAs($user);

        // Create an Appointment
        $appointment = factory(Appointment::class)->create([
            'user_id'     => $user->id,
            'doctor_id'   => $this->doctor->id,
            'status'      => $this->faker->numberBetween(0,5),
        ]);

        // Update the Appointment's details
        $updated_data = [ 
            'type'        => 'Online',

            'user_id'     => $user->id,
            'doctor_id'   => $this->doctor->id,
            'description' => $this->faker->sentence,
            
            'illness_duration' => '2 weeks',
            'illness_history'  => $this->faker->sentence,

            'day'         => date('Y-m-d'),
            'from'        => '06:00 AM',
            'to'          => '12:00 PM',
        ]; 
        // Caters for Concatenation to 2400 ::formatHourTo2400();
        $data_edited = $updated_data;
        $data_edited = array_merge($data_edited, [
            'day'         => date('Y-m-d') .' 00:00:00',
            'from'        => date('Y-m-d') .' 06:00',
            'to'          => date('Y-m-d') .' 12:00',
        ]);

        $this
            ->patch(route('appointments.update', $appointment), $updated_data)
            ->assertStatus(302)
            ;

        $this->assertDatabaseHas('appointments', $data_edited);
    }

    /** @test */
    public function delete_an_appointment_can_be_removed()
    {
        $this
            ->actingAs($this->user2)
            ->delete(route('appointments.destroy', $this->appointment2))
            ;

        $this->assertDatabaseMissing('appointments', $this->appointment2->toArray());
    }
}
