<?php

namespace Tests\Feature;


use App\Appointment;
use App\Doctor;
use App\Drug;
use App\Message;
use App\Prescription;
use App\Specialty;
use App\User;
use App\Medication;

use Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MedicationFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->docUser      = factory(User::class)->states('verified')->create();
        $this->user         = factory(User::class)->states('verified')->create();
        $this->specialty    = factory(Specialty::class)->create();
        $this->doctor       = factory(Doctor::class)->states('active')->create(['id'=>$this->docUser, 'user_id'=>$this->docUser,]);
        $this->appointment  = factory(Appointment::class)->create();

        $this->message      = factory(Message::class)->states('appointment')->create();
        $this->medication = factory(Prescription::class)->create();

        $this->medication   = factory(Medication::class)->create();

        $this->data        = factory(Medication::class)->make(['user_id' => $this->user->id])->toArray();
        // $this->data         = factory(Medication::class)->raw(['user_id' => $this->user->id]);
    } 

    /** @test */
    public function index_a_user_medications_list_can_be_viewed_by_self()
    {
        $this
            ->actingAs($this->medication->user)
            ->get(route('medications.index'))//, $this->medication->user
            ->assertStatus(200)
            ->assertSee($this->medication->title)
            ->assertSee($this->medication->description)
            ->assertSee('Add New Medication')
            ;
    }

    /** @test */
    public function show_a_medication_page_can_be_accessed_by_creator()
    {
        $this
            ->actingAs($this->medication->user)
            ->get(route('medications.show', $this->medication))
            ->assertStatus(200)
            ->assertSee($this->medication->title)
            ->assertSee($this->medication->description)
            ->assertSee($this->medication->prescription->appointment->description)
            ->assertSee($this->medication->start)
            ->assertSee($this->medication->start_time)
            ->assertSee($this->medication->end)
            ->assertSee($this->medication->recurrence)
            ->assertSee($this->medication->recurrence_type)
            ->assertSee($this->medication->notify_by)
            ->assertSee('Update the Medication:')
            ;
    }

    /**  @test */
    public function store_a_medication_can_be_created_by_a_user()
    {
        $this
            ->actingAs($this->user)
            ->post(route('medications.store'), $this->data)
            ;

        $this->assertDatabaseHas('medications', $this->data);
    }

    /** @test */
    public function update_a_medication_can_be_updated()
    {
        // $user       = factory(User::class)->states('verified')->create();
        $medication = factory(Medication::class)->create($this->data);

        // Update the Prescription's details
        $updated_data = factory(Medication::class)->make([ 'user_id' => $this->user->id ])->toArray();

        $this
            ->actingAs($this->user)
            ->put(route('medications.update', $medication), $updated_data)
            ->assertStatus(302)
            ;

        $this->assertDatabaseHas('medications', $updated_data);
    }
}
