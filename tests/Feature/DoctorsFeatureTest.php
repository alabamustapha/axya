<?php

namespace Tests\Feature;

use App\Appointment;
use App\Review;
use App\User;
use App\Region;
use App\City;
use App\Doctor;
use App\Specialty;
use App\Workplace;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DoctorsFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->region    = factory(Region::class)->create();
        $this->city      = factory(City::class)->create();
        $this->dr_user   = factory(User::class)->states(['verified','doctor'])->create();
        $this->specialty = factory(Specialty::class)->create();
        $this->doctor    = factory(Doctor::class)->states('active')->create(['user_id'=> $this->dr_user->id]);
        $this->admin     = factory(User::class)->states('admin')->create();
    } 

    /** @test */
    public function show_a_doctors_profile_can_be_viewed_by_all_users()
    {
        $this
            // ->actingAs($this->user)
            ->get(route('doctors.show', $this->doctor))
            ->assertStatus(200)
            ->assertSee($this->doctor->name)
            ->assertSee($this->doctor->specialty->name)
            ->assertSee($this->doctor->rate)
            ;
    }

    /** @test */
    public function show_a_doctors_reviews_can_be_seen_on_the_profile_page()
    {
        $appointment = factory(Appointment::class)->create([ 'doctor_id'   => $this->doctor->id] );

        // Create a Review
        $review = factory(Review::class)->create([ 'appointment_id' => $appointment->id, ]);

        $this
            // ->actingAs($this->user)
            ->get(route('doctors.show', $this->doctor))
            ->assertStatus(200)
            ->assertSee($review->user->name)
            ->assertSee($review->comment)
            ;
    }

    /** @test */
    public function update_a_doctor_can_be_updated()
    {
        // Create a models used in update
        $workplace  = factory(Workplace::class)->create(['current'=> '1']);
        $workplace2 = factory(Workplace::class)->create();
        $specialty2 = factory(Specialty::class)->create(['name'=> 'Spec', 'slug'=> 'spec']);

        // Update the Doctor's details
        $updated_data = [           
            'rate'           => 10.56,//$this->faker->numberBetween(5.00,100.00),
            'available'      => $this->faker->randomElement([0,1]),
            'specialty_id'   => $specialty2->id,
            'workplace_id'   => $workplace2->id,
            'phone'          => $this->faker->e164Phonenumber,
            'email'          => $this->faker->email,
            'about'          => $this->faker->sentence,
            'work_address'   => $this->faker->address,

            'main_language'  => $this->faker->randomElement([1,2,3,4]),
            'country_id'     => $this->faker->randomElement([1,2]),
            'rate'           => $this->faker->numberBetween(5,9999),
            'session'        => $this->faker->numberBetween(30,100),
            // Education
            'graduate_school'=> $this->faker->catchPhrase,
            'degree'         => $this->faker->sentence,
        ]; 
        $data_edited = $updated_data;
        unset($data_edited['workplace_id']);

        $this
            ->actingAs($this->dr_user)
            ->patch(route('doctors.update', $this->doctor), $updated_data)
            // ->dump()
            ->assertStatus(302)
            ;

        $this->assertDatabaseHas('doctors', $data_edited);
        $this->assertDatabaseHas('workplaces', [
            'id'=> $workplace2->id, 
            'doctor_id'=> $this->doctor->id, 
            'current'=> '1'
        ]);
        $this->assertDatabaseHas('workplaces', [
            'id'=> $workplace->id, 
            'doctor_id'=> $this->doctor->id, 
            'current'=> '0'
        ]);
    }
}
