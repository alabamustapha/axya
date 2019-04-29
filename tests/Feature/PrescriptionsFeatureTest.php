<?php

namespace Tests\Feature;

use App\Appointment;
use App\Doctor;
use App\Message;
use App\Prescription;
use App\Specialty;
use App\User;
use App\Region;
use App\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PrescriptionsFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->region     = factory(Region::class)->create();
        $this->city       = factory(City::class)->create();
        $this->user        = factory(User::class)->states('verified')->create();
        $this->doc_user    = factory(User::class)->states(['verified','doctor'])->create();
        $this->specialty   = factory(Specialty::class)->create();
        $this->doctor      = factory(Doctor::class)->states('active')->create([ 
            'id' => $this->doc_user->id, 'user_id' => $this->doc_user->id,
        ]);
        $this->appointment = factory(Appointment::class)->states('chatable')->create([
          'user_id'   => $this->user->id, 'doctor_id' => $this->doctor->user_id,
        ]);

        $this->message     = factory(Message::class)->states('appointment')->create();

        $this->prescription= factory(Prescription::class)->create(['appointment_id' => $this->appointment->id]);

        $this->data = [ 
            'appointment_id' => $this->appointment->id,
            // 'message_id'     => $this->message->id,
            'usage'          => $this->faker->sentence,
            'comment'        => $this->faker->sentence,
        ];
    } 

    /** @test */
    public function index_a_user_prescriptions_list_can_be_viewed_by_self()
    {
        $this
            ->actingAs($this->user)
            ->get(route('prescriptions.index', $this->prescription->user))
            // ->dump()
            ->assertStatus(200)
            ->assertSee($this->prescription->doctor->name)
            ->assertSee($this->prescription->usage)
            ->assertSee($this->prescription->comment)
            // ->assertSee($this->prescription->drugs())
            ;
    }

    /** @test */
    public function index_a_doctor_prescriptions_list_can_be_viewed_by_attending_doctor()
    {
        $this
            ->actingAs($this->doc_user)
            ->get(route('dr_prescriptions', $this->prescription->doctor))
            ->assertStatus(200)
            ->assertSee($this->prescription->doctor->name)
            ->assertSee($this->prescription->usage)
            ->assertSee($this->prescription->comment)
            // ->assertSee($this->prescription->drugs())
            ;
    }

    /** @test */
    public function show_a_prescription_can_be_viewed_by_account_owner()
    {
        $this
            ->actingAs($this->user)
            ->get(route('prescriptions.show', $this->prescription))
            ->assertStatus(200)
            ->assertSee($this->prescription->doctor->name)
            ->assertSee($this->prescription->usage)
            ->assertSee($this->prescription->comment)
            ;
    }

    /** @test */
    public function show_a_prescription_cannot_be_viewed_by_non_account_owner()
    {
        $user = factory(User::class)->states('verified')->create();

        $this
            ->actingAs($user)
            ->get(route('prescriptions.show', $this->prescription))
            ->assertStatus(403)
            ->assertDontSee($this->prescription->doctor->name)
            ->assertDontSee($this->prescription->usage)
            ->assertDontSee($this->prescription->comment)
            ;
    }

    /** @test */
    public function show_a_prescription_can_be_viewed_by_attending_doctor()
    {
        $this
            ->actingAs($this->doc_user)
            ->get(route('prescriptions.show', $this->prescription))
            ->assertStatus(200)
            ->assertSee($this->prescription->user->name)
            ->assertSee($this->prescription->usage)
            ->assertSee($this->prescription->comment)
            ;
    }

    /**  @test */
    public function store_a_prescription_cannot_be_created_by_an_unverified_user()
    {
        $user = factory(User::class)->states('unverified')->create();

        $this
            ->actingAs($user)
            ->post(route('prescriptions.store'), $this->data)
            ->assertStatus(302) // Redirected to verify page
            ;

        $this->assertDatabaseMissing('prescriptions', $this->data);
    }

    /**  @test */
    public function store_a_prescription_can_be_created_by_a_doctor()
    {
        $this
            ->actingAs($this->doc_user)
            ->post(route('prescriptions.store'), $this->data)
            // ->assertStatus(200) //302
            ;

        $this->assertDatabaseHas('prescriptions', $this->data);
    }

    /**  @test */
    public function store_a_prescription_cannot_be_created_by_non_doctor()
    {
        $this
            ->actingAs($this->user)
            ->post(route('prescriptions.store'), $this->data)
            // ->assertStatus(403) ...302 Clash btw Middleware & Policy.
            ;

        $this->assertDatabaseMissing('prescriptions', $this->data);
    }

    /** @test */
    public function update_a_prescription_can_be_updated()
    {
        $user = factory(User::class)->states('verified')->create();

        // Update the Prescription's details
        $updated_data = [ 
            'appointment_id' => $this->appointment->id,
            // 'message_id' => $this->message->id,
            'usage'          => $this->faker->sentence .' updated.',
            'comment'        => $this->faker->sentence .' updated.',
        ]; 

        $this
            ->actingAs($this->doc_user)
            ->patch(route('prescriptions.update', $this->prescription), $updated_data)
            // ->assertStatus(200) // rq->expectsJson()
            ->assertStatus(302)
            ;

        $this->assertDatabaseHas('prescriptions', $updated_data);
    }

    // /** @test */
    // public function delete_a_prescription_can_be_removed()
    // {
    //     // Problems with $appends[]
    //     $this
    //         ->actingAs($this->doc_user)
    //         ->delete(route('prescriptions.destroy', $this->prescription))
    //         ;

    //     $this->assertDatabaseMissing('prescriptions', $this->prescription->toArray());
    // }
}
