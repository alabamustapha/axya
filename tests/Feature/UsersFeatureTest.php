<?php

namespace Tests\Feature;

use App\Doctor;
use App\Specialty;
use App\Appointment;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsersFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user        = factory(User::class)->create();
        $this->superadmin  = factory(User::class)->states('superadmin')->create();

        $this->doctorUser  = factory(User::class)->states(['verified', 'doctor'])->create();
        $this->specialty   = factory(Specialty::class)->create();
        $this->doctor      = factory(Doctor::class)->states('active')->create([
            'id'      => $this->doctorUser->id,
            'user_id' => $this->doctorUser->id
        ]);
        $this->appointment = factory(Appointment::class)->create([
          'user_id'   => $this->user->id,
          'doctor_id' => $this->doctorUser->id,
          'status'    => '1'
        ]);
    }

    /** @test */
    public function show_a_user_can_see_own_profile() 
    {
        $this
            ->actingAs($this->user)
            ->get( $this->user->link )
            ->assertSee($this->user->name)
            ->assertSee($this->user->age)
            ->assertSee($this->user->dob_text)
            ->assertSee($this->user->avatar_md)
            ->assertSee($this->user->gender)
            ->assertSee($this->user->height)
            ->assertSee($this->user->weight)
            ->assertSee($this->user->email)
            ->assertSee($this->user->phone)
            ->assertSee($this->user->address)
            ->assertSee($this->user->allergies)
            ->assertSee($this->user->chronics)
            // ->assertSee($this->user->age)
            ;
    }

    /** @test */
    public function show_a_superadmin_can_see_a_users_profile() 
    {
        $this
            ->actingAs($this->superadmin)
            ->get( $this->user->link )
            ->assertStatus(200)
            ->assertSee($this->user->name)
            ->assertSee($this->user->age)
            ->assertSee($this->user->dob_text)
            ;
    }

    /** @test */
    public function show_an_attending_doctor_can_see_a_users_profile() 
    {
        $this
            // ->withExceptionHandling()
            ->actingAs($this->doctorUser)
            ->get( $this->user->link )
            ->assertStatus(200)
            ->assertSee($this->user->name)
            ->assertSee($this->user->age)
            ->assertSee($this->user->dob_text)
            ;
    }

    /** @test */
    public function show_a_non_attending_doctor_cannot_see_a_users_profile() 
    {
        $doctorUser2 = factory(User::class)->states(['verified', 'doctor'])->create();
        $doctor      = factory(Doctor::class)->states('active')->create([
            'id'      => $doctorUser2->id,
            'user_id' => $doctorUser2->id
        ]);

        $this
            ->actingAs($doctorUser2)
            ->get( $this->user->link )
            // ->assertStatus(403)
            ->assertDontSee($this->user->name)
            ->assertDontSee($this->user->age)
            ->assertDontSee($this->user->dob_text)
            ;
    }

    /** @test */
    public function show_a_non_account_owner_or_non_doctor_non_admin_cannot_see_a_users_profile() 
    {
        $user       = factory(User::class)->create();
        $this
            ->actingAs($user)
            ->get( $this->user->link )
            ->assertStatus(403)
            ->assertDontSee($this->user->name)
            ->assertDontSee($this->user->dob_text)
            ;
    }

    /** @test */
    public function show_non_admins_non_account_owners_cannot_see_other_users_profile() 
    {
        $other_user = factory(User::class)->states('verified')->create();

        $this
            ->actingAs($other_user)
            ->get( $this->user->link )
            ->assertStatus(403)
            ->assertDontSee($this->user->name)
            ->assertDontSee($this->user->age)
            ;
    }
     
    /** @test */
    public function update_a_user_doctor_slug_is_updated_when_name_is_updated()
    {
        $user       = factory(User::class)->states('verified')->create();
        $specialty  = factory(Specialty::class)->create();
        $doctor     = factory(Doctor::class)->states('active')->create([
            'id'          => $user->id,
            'user_id'     => $user->id,
            'slug'        => $user->slug,
            'specialty_id'=> $specialty->id
        ]);
    
        // Update User name 
        $update_data = [
            'name'   => 'Justina Doe',
            'slug'   => str_slug('Justina Doe'), 
            'gender' => 'Female',
            'dob'    => '1990-09-09 00:00:00',
        ];

        $this
            ->actingAs($user)
            ->patch(route('users.update', $user), $update_data)
            ;

        $this->assertDatabaseHas('users', $update_data);
        $this->assertDatabaseHas('doctors', [
            'id'   => $user->id,
            'slug' => $update_data['slug'],
            'specialty_id'=>$specialty->id
        ]);
    }



    // test login
    // test logout
    // test password change/update
    // test isdoctor


     
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
