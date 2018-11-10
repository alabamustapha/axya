<?php

namespace Tests\Feature;

use App\Application;
use App\User;
use App\Specialty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApplicationsFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user      = factory(User::class)->create([
            'email_verified_at' =>  '1990-10-10']);
        $this->admin     = factory(User::class)->create([
            'acl' => '1',
            'email_verified_at' =>  '1990-10-10'
        ]);

        $this->specialty = factory(Specialty::class)->create();
        $this->application = factory(Application::class)->create();

        $this->name = $this->faker->word;
        $this->data = [ 
            // 'user_id'           => $this->user->id,
            // 'specialty_id'      => $this->specialty->id,
            // 'first_appointment' => $this->faker->dateTimeBetween('-10 year', '-1 year'),

            // 'workplace'         => $this->faker->words(1,3),
            // 'workplace_address' => $this->faker->address,
            // 'workplace_start'   => $this->faker->dateTimeBetween('-15 year', '-12 year'),
        ];
    } 

    /** @test */
    public function index_applications_list_can_be_viewed_by_an_admin()
    { 
        $this
            ->actingAs($this->admin)
            ->get(route('applications.index'))
            ->assertStatus(200)
            ->assertSee($this->application->user->name)
            ;
    }

    /** @test */
    public function index_applications_list_cannot_be_viewed_by_non_admins()
    { 
        $this
            ->actingAs($this->user)
            ->get(route('applications.index'))
            // ->assertStatus(302)
            ->assertDontSee($this->application->user->name)
            ;
    }

    /** @test */
    public function show_an_application_can_be_viewed_by_an_admin() 
    {        
        $this
            ->actingAs($this->admin)
            ->get(route('applications.show', $this->application))
            ->assertStatus(200)
            ->assertSee($this->application->user->name)
            ;
    }

    /** @test */
    public function show_an_application_can_be_viewed_by_applicant() 
    {        
        $this
            ->actingAs($this->user)
            ->get(route('applications.show', $this->application))
            ->assertStatus(200)
            ->assertSee($this->application->user->name)
            ;
    }

    /** @test */
    public function show_an_application_cannot_be_viewed_by_non_admin_or_non_applicant() 
    {        
        $other_user = factory(User::class)->create();
        $this
            ->actingAs($other_user)
            ->get(route('applications.show', $this->application))
            ->assertStatus(403)
            ->assertDontSee($this->application->user->name)
            ;
    }

    /**  @test */
    public function store_an_application_can_be_created()
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user)
            ->post(route('applications.store'), $this->data)
            ->assertStatus(302)
            // ->assertRedirect(route('applications.index'))
            // ->dump()
            // ->assertSessionHas('success', $user->name . ', your application was submitted successfully')
            ;

        $this->assertDatabaseHas('applications', $this->data);
    }

    /** @test */
    public function update_an_application_can_be_updated()
    {
        $this->actingAs($this->user);

        // Create a Application
        $application = factory(Application::class)->create($this->data);
        $this->assertDatabaseHas('applications', $this->data);

        // Update the Application's details
        // $specialty = factory(Specialty::class)->create();

        $updated_data = [ 
            'specialty_id'      => $this->specialty->id,
            'first_appointment' => $this->faker->dateTimeBetween('-10 year', '-1 year'),

            'workplace'         => $this->faker->words(1,3),
            'workplace_address' => $this->faker->address,
            'workplace_start'   => $this->faker->dateTimeBetween('-15 year', '-12 year'),

            // 'specialist_diploma'=> $this->file_url,
            // 'competences'       => $this->file_url2,
            // 'malpraxis'         => $this->file_url3,

            // 'medical_college'   => $this->file_url4,
            // 'medical_college_expiry' => $this->faker->dateTimeBetween('1 month', '12 month'),  
        ]; 

        $this
            ->patch(route('applications.update', $application), $updated_data)
            ->assertStatus(302)
            ->assertRedirect(route('applications.show', $application->id))
            // ->assertSessionHas('success', $updated_data['name'] .' updated successfully')
            ;

        $this->assertDatabaseHas('applications', $updated_data);
    }

    /** @test */
    public function delete_an_application_can_be_removed()
    {
        $this->actingAs($this->admin);

        $this
            ->delete(route('applications.destroy', $this->application))
            ->assertStatus(302)
            ->assertRedirect(route('applications.index'))
            // ->assertSessionHas('success', $this->application->name .' deleted successfully')
            ;

        $this->assertDatabaseMissing('applications', $this->application->toArray());
    }
}
