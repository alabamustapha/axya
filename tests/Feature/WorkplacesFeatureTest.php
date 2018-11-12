<?php

namespace Tests\Feature;

use App\Doctor;
use App\Specialty;
use App\Tag;
use App\User;
use App\Workplace;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkplacesFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();        

        $this->doc_user   = factory(User::class)->create();
        $this->specialty  = factory(Specialty::class)->create();
        $this->doctor     = factory(Doctor::class)
             ->create([
                    'id'      => $this->doc_user->id, 
                    'user_id' => $this->doc_user->id,
                ]);
        $this->workplace  = factory(Workplace::class)->create();

        $this->name = $this->faker->word;
        $this->data = [ 
            'name'       => $this->name,
            'doctor_id'  => $this->doctor->id,
            'address'    => $this->faker->address,
            'start_date' => $this->faker->dateTimeBetween('-3 year','-1 month'),
        ];
    }

    /**  @test */
    public function store_a_workplace_can_be_created_by_a_doctor()
    {
        $this->actingAs($this->doc_user);

        $this
            ->post(route('workplaces.store'), $this->data)
            ->assertStatus(302)
            ->assertRedirect(route('doctors.show', $this->doc_user))
            // ->assertSessionHas('success', $this->data['name'] .' created successfully')
            ;

        $this->assertDatabaseHas('workplaces', $this->data);
    }

    /** @test */
    public function update_a_workplace_can_be_updated_by_doctor()
    {
        $this->actingAs($this->doctor);

        // Create a Workplace
        $workplace = factory(Workplace::class)->create($this->data);
        $this->assertDatabaseHas('workplaces', $this->data);

        // Update the Workplace's details
        $upd_name = $this->data['name'] . ' upd';
        $updated_data = [ 
            'name'       => $upd_name,
            'address'    => $this->faker->address, 
            'start_date' => $this->faker->dateTimeBetween('-3 year','-1 month'),
            'end_date'   => $this->faker->dateTimeBetween('3 week','1 year'),
        ]; 

        $this
            ->patch(route('workplaces.update', $workplace), $updated_data)
            ->assertStatus(302)
            ->assertRedirect(route('doctors.show', $this->doc_user))
            // ->assertSessionHas('success', $updated_data['name'] .' updated successfully')
            ;

        $this->assertDatabaseHas('workplaces', $updated_data);
    }

    /** @test */
    public function delete_a_workplace_can_be_removed_by_admin()
    {
        $admin   = factory(User::class)->create(['acl' => '1']);
        $this->actingAs($admin);

        $this
            ->delete(route('workplaces.destroy', $this->workplace))
            ->assertStatus(302)
            ->assertRedirect(route('doctors.show', $this->doc_user))
            // ->assertSessionHas('success', $this->workplace->name .' deleted successfully')
            ;

        $this->assertDatabaseMissing('workplaces', $this->workplace->toArray());
    }
}
