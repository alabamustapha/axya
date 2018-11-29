<?php

namespace Tests\Feature;

use App\User;
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

        $this->dr_user   = factory(User::class)->states('verified')->create();
        $this->specialty = factory(Specialty::class)->create();
        $this->doctor    = factory(Doctor::class)->create(['user_id'=> $this->dr_user->id]);
        $this->admin     = factory(User::class)->states('admin')->create();
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
            'rate'         => 10.56,//$this->faker->numberBetween(5.00,100.00),
            'available'    => $this->faker->randomElement([0,1]),
            'specialty_id' => $specialty2->id,
            'workplace_id' => $workplace2->id,
            'phone'        => $this->faker->e164Phonenumber,
            'email'        => $this->faker->email,
            'about'        => $this->faker->sentence,
            'location'     => $this->faker->address,
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
