<?php

namespace Tests\Feature;

use App\Appointment;
use App\Doctor;
use App\Specialty;
use App\User;
use App\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewsFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user        = factory(User::class)->states('verified')->create();
        $this->specialty   = factory(Specialty::class)->create();
        $this->doctor      = factory(Doctor::class)->create();
        $this->appointment = factory(Appointment::class)->create([
            'user_id' => $this->user->id,
            'doctor_id' => $this->doctor->id
        ]);
        $this->review      = factory(Review::class)->create();

        $this->data = [ 
            'user_id'        => $this->user->id,
            'doctor_id'      => $this->doctor->id,
            'appointment_id' => $this->appointment->id,
            'comment'        => $this->faker->sentences(1,3),
            'rating'         => $this->faker->randomElement([1,2,3,4,5]),
        ];
    } 

    /** @test */
    public function index_a_user_reviews_list_can_be_viewed_by_self()
    {
        $this
            ->actingAs($this->user)
            ->get(route('reviews.index'))
            ->assertStatus(200)
            ->assertSee($this->review->user->name)
            ->assertSee($this->review->doctor->name)
            ->assertSee($this->review->comment)
            ;
    }

    /** @test */
    public function show_a_review_can_be_viewed_by_all_users()
    {
        $this
            // ->actingAs($this->user)
            ->get(route('reviews.show', $this->review))
            ->assertStatus(200)
            ->assertSee($this->review->user->name)
            ->assertSee($this->review->doctor->name)
            ->assertSee($this->review->comment)
            ;
    }

    /**  @test */
    public function store_a_review_cannot_be_created_by_an_unverified_user()
    {
        $user = factory(User::class)->states('unverified')->create();
        
        // An appointment/user-doctor necessitates creating new Appointment always
        $appointment = factory(Appointment::class)->create([ 'user_id'   => $user->id ]);
        
        $data = [
            'user_id'        => $appointment->user_id,
            'doctor_id'      => $appointment->doctor_id,
            'appointment_id' => $appointment->id,
            'comment'        => $this->faker->sentences(1,3),
            'rating'         => $this->faker->randomElement([1,2,3,4,5]),
        ];

        $this
            ->actingAs($user)
            ->post(route('reviews.store'), $data)
            ->assertStatus(302) // Redirected to verify page
            ;

        $this->assertDatabaseMissing('reviews', $data);
    }

    /**  @test */
    public function store_a_review_can_be_created_by_a_verified_user()
    {
        $user = factory(User::class)->states('verified')->create();
        $appointment = factory(Appointment::class)->create([ 'user_id'   => $user->id] );

        $data = [
            'user_id'        => $appointment->user_id,
            'doctor_id'      => $appointment->doctor_id,
            'appointment_id' => $appointment->id,
            'comment'        => $this->faker->sentences(1,3),
            'rating'         => $this->faker->randomElement([1,2,3,4,5]),
        ];

        $this
            ->actingAs($user)
            ->post(route('reviews.store'), $data)
            // ->assertStatus(201) // rq->expectsJson()
            ;

        $this->assertDatabaseHas('reviews', $data);
    }

    /**  @test */
    public function update_an_appointment_gets_reviewed_attribute_updated_after_its_review_is_created()
    {
        $user = factory(User::class)->states('verified')->create();
        $appointment = factory(Appointment::class)->create([ 'user_id'   => $user->id] );

        $data = [
            'user_id'        => $appointment->user_id,
            'doctor_id'      => $appointment->doctor_id,
            'appointment_id' => $appointment->id,
            'comment'        => $this->faker->sentences(1,3),
            'rating'         => $this->faker->randomElement([1,2,3,4,5]),
        ];

        $this
            ->actingAs($user)
            ->post(route('reviews.store'), $data)
            // ->assertStatus(201) // rq->expectsJson()
            ;

        $this->assertDatabaseHas('appointments', [ 
            'id' => $appointment->id, 
            'reviewed'   => '1'
        ]);
    }

    /** @test */
    public function update_a_review_can_be_updated()
    {
        $user = factory(User::class)->states('verified')->create();
        $appointment = factory(Appointment::class)->create([ 'user_id'   => $user->id] );

        $this->actingAs($user);

        // Create a Review
        $review = factory(Review::class)->create([
            'user_id'        => $appointment->user_id,
            'doctor_id'      => $appointment->doctor_id,
            'appointment_id' => $appointment->id,
            'comment'        => $this->faker->sentence,
            'rating'         => $this->faker->randomElement([1,2,3,4,5]),
        ]);

        // Update the Review's details
        $updated_data = [
            'user_id'        => $appointment->user_id,
            'doctor_id'      => $appointment->doctor_id,
            'appointment_id' => $appointment->id,
            'comment'        => $this->faker->sentences(3,5),
            'rating'         => $this->faker->randomElement([1,2,3,4,5]),
        ]; 

        $this
            ->patch(route('reviews.update', $review), $updated_data)
            ->assertStatus(200) // rq->expectsJson()
            ;

        $this->assertDatabaseHas('reviews', $updated_data);
    }

    /** @test */
    public function delete_a_review_can_be_removed()
    {
        $this
            ->actingAs($this->user)
            ->delete(route('reviews.destroy', $this->review))
            ;

        $this->assertDatabaseMissing('reviews', $this->review->toArray());
    }
}
