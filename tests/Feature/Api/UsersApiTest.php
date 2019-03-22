<?php

namespace Tests\Feature;

use App\Doctor;
use App\Specialty;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsersApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user       = factory(User::class)->create();
        $this->superadmin = factory(User::class)->states('superadmin')->create();
    }

    /** @test */
    public function store__it_can_create_a_user()
    {
        $name = $this->faker->name;
        $password = Hash::make('secret');
        $data = [
            'name'     => $name,
            'slug'     => str_slug($name),
            'email'    => $this->faker->safeEmail,
            'gender'   => $this->faker->randomElement(['Female', 'Male', 'Other']),
            'dob'      => '1990-09-09',
            'terms'    => '1',
        ];

        // 'terms' is required for submission but hidden in collections.
        $data_edited = $data;
        unset($data_edited['terms']);

        $this
            ->post(route('users_api.store'), $data)
            ->assertStatus(201)
            ->assertJson($data_edited)
            ;
    }

    /** @test */
    public function show__a_superdmin_can_see_users_list() 
    {
        $this
            ->actingAs($this->superadmin, 'api')
            ->get(route('users_api.index'))
            ->assertSee($this->user->name)
            ->assertSee($this->user->age)
            ;
    }

    /** @test */
    public function show__a_user_can_see_own_profile() 
    {
        $this
            ->actingAs($this->user, 'api')
            ->get(route('users_api.show', $this->user))
            ->assertSee($this->user->name)
            ->assertSee($this->user->age)
            ;
    }

    /** @test */
    public function show__a_superadmin_can_see_a_users_profile() 
    {
        $this
            ->actingAs($this->superadmin, 'api')
            ->get(route('users_api.show', $this->user))
            ->assertStatus(200)
            ->assertSee($this->user->name)
            ->assertSee($this->user->age)
            ;
    }

    /** @test */
    public function show__non_admins_non_account_owners_cannot_see_other_users_profile() 
    {
        $other_user = factory(User::class)->create([ 'acl' => '3', ]);

        $this
            ->actingAs($other_user, 'api')
            ->get(route('users_api.show', $this->user))
            ->assertStatus(401)
            ->assertDontSee($this->user->name)
            ->assertDontSee($this->user->age)
            ;
    }
     
    /** @test */
    public function update__a_user_doctor_slug_is_updated_when_name_is_updated()
    {
        $user       = factory(User::class)->states('verified')->create();
        $specialty  = factory(Specialty::class)->create();
        $doctor     = factory(Doctor::class)->states('active')->create([
            'id'  => $user->id,
            'user_id'  => $user->id,
            'slug'     => $user->slug,
            'specialty_id'=>$specialty->id
        ]);
    
        // Update User name 
        $update_data = [
            'name'   => 'Justina Doe',
            'slug'   => str_slug('Justina Doe'), 
            'gender' => 'Female',
            'dob'    => '1990-09-09 00:00:00',
        ];

        $this
            ->actingAs($user, 'api')
            ->patch(route('users_api.update', $user), $update_data)
            ->assertStatus(200)
            ;

        $this->assertDatabaseHas('users', $update_data);
        $this->assertDatabaseHas('doctors', [
            'id'   => $user->id,
            'slug' => $update_data['slug']
        ]);
    }
     
    // /** @test */
    // public function delete_a_user_can_be_destroyed()
    // {
    //     // $other_user = factory(User::class)->create();
    //     // $this->actingAs($other_user);
        
    //     $this->actingAs($this->user);

    //     $this
    //         ->delete(route('users_api.destroy', $this->user))
    //         ->assertStatus(204)
    //         ;

    //     $this->assertDatabaseMissing('users', $this->user->toArray());
    // }
}
