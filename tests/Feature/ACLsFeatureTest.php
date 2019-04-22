<?php

namespace Tests\Feature;

use App\Doctor;
use App\Specialty;
use App\User;
use App\Region;
use App\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ACLsFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->region     = factory(Region::class)->create();
        $this->city       = factory(City::class)->create();
        // Create a Super Admin
        $this->superadmin = factory(User::class)->states('superadmin')->create();
        $this->admin = factory(User::class)->states('admin')->create();
    } 

    /** @test */
    public function update_a_normal_user_can_be_updated_to_admin()
    {
        $this->actingAs($this->superadmin);

        // Create a User 
        $user = factory(User::class)->states('verified')->create();
        // $user->makeAdmin();

        // Update the User's details
        $updated_data = [ 'id' => $user->id, 'acl' => '1']; 

        $this
            ->patch(route('make-admin', $user), $updated_data)
            // ->assertStatus(302) // ->assertStatus(200)
            // ->assertRedirect(route('dashboard-admins'))
            ;

        $this->assertDatabaseHas('users', $updated_data);
    }

    /** @test */
    public function update_a_normal_user_can_be_updated_to_staff()
    {
        $this->actingAs($this->superadmin);

        // Create a User 
        $user = factory(User::class)->states('verified')->create();

        // Update the User's details
        $updated_data = [ 'id' => $user->id, 'acl' => '2']; 

        $this
            ->patch(route('make-staff', $user), $updated_data)
            // ->assertStatus(302) // ->assertStatus(200)
            // ->assertRedirect(route('dashboard-admins'))
            ;

        $this->assertDatabaseHas('users', $updated_data);
    }

    /** @test */
    public function update_a_staff_can_be_upgraded_to_admin()
    {
        $this->actingAs($this->superadmin);

        // Create a Staff
        $staff = factory(User::class)->states('staff')->create();

        // Update the Staff's details
        $updated_data = [ 'id' => $staff->id, 'acl' => '1']; 

        $this
            ->patch(route('make-admin', $staff), $updated_data)
            // ->assertStatus(302) // ->assertStatus(200)
            // ->assertRedirect(route('dashboard-admins'))
            ;

        $this->assertDatabaseHas('users', $updated_data);
    }

    /** @test */
    public function update_a_staff_can_be_demoted_to_normal_user()
    {
        $this->actingAs($this->superadmin);

        // Create a Staff
        $staff = factory(User::class)->states('staff')->create();

        // Update the Staff's details
        $updated_data = [ 'id' => $staff->id, 'acl' => '3']; 

        $this
            ->patch(route('make-normal', $staff), $updated_data)
            // ->assertStatus(302) // ->assertStatus(200)
            // ->assertRedirect(route('dashboard-admins'))
            ;

        $this->assertDatabaseHas('users', $updated_data);
    }

    /** @test */
    public function update_an_admin_can_be_demoted_to_normal_user()
    {
        $this->actingAs($this->superadmin);

        // Create an Admin
        $admin = factory(User::class)->states('admin')->create();

        // Update the User's details
        $updated_data = [ 'id' => $admin->id, 'acl' => '3']; 

        $this
            ->patch(route('make-normal', $admin), $updated_data)
            // ->assertStatus(302) // ->assertStatus(200)
            // ->assertRedirect(route('dashboard-admins'))
            ;

        $this->assertDatabaseHas('users', $updated_data);
    }

    /** @test */
    public function update_an_admin_can_be_demoted_to_staff()
    {
        $this->actingAs($this->superadmin);

        // Create an Admin
        $admin = factory(User::class)->states('admin')->create();

        // Update the User's details
        $updated_data = [ 'id' => $admin->id, 'acl' => '2']; 

        $this
            ->patch(route('make-staff', $admin), $updated_data)
            // ->assertStatus(302) // ->assertStatus(200)
            // ->assertRedirect(route('dashboard-admins'))
            ;

        $this->assertDatabaseHas('users', $updated_data);
    }



    /** @test */
    public function update_a_user_can_be_blocked()
    {
        $this->actingAs($this->admin);

        // Create a User
        $user = factory(User::class)->states('verified')->create(['blocked' => '0']);

        // Block the user
        $updated_data = [ 'id' => $user->id, 'blocked' => '1']; 

        $this
            ->patch(route('block_user', $user), $updated_data)
            ;

        $this->assertDatabaseHas('users', $updated_data);
    }

    /** @test */
    public function update_a_user_can_be_unblocked()
    {
        $this->actingAs($this->admin);

        // Create a User
        $user = factory(User::class)->states('verified')->create(['blocked' => '1']);

        // Unblock the user
        $updated_data = [ 'id' => $user->id, 'blocked' => '0']; 

        $this
            ->patch(route('unblock_user', $user), $updated_data)
            ;

        $this->assertDatabaseHas('users', $updated_data);
    }



    // /** @test */
    // public function update_a_doctors_license_can_be_revoked()
    // {
    //     // Create a Doctor
    //     $dr_user   = factory(User::class)->states('verified')->create();
    //     $specialty = factory(Specialty::class)->create();
    //     $doctor    = factory(Doctor::class)->states('active')->create(['id' =>$dr_user->id, 'revoked' => '0']);

    //     // Revoke a doctor's license.
    //     $updated_data = [ 'id' => $doctor->id, 'revoked' => '1']; 

    //     $this
    //         ->actingAs($this->admin)
    //         ->patch(route('revoke_license', $doctor), $updated_data)
    //         ;

    //     $this->assertDatabaseHas('doctors', $updated_data);
    // }

    // /** @test */
    // public function update_a_doctors_license_can_be_restored()
    // {
    //     // Create a Doctor
    //     $dr_user   = factory(User::class)->states('verified')->create();
    //     $specialty = factory(Specialty::class)->create();
    //     $doctor    = factory(Doctor::class)->states('active')->create(['id' =>$dr_user->id, 'revoked' => '1']);

    //     // Restore a doctor's license.
    //     $updated_data = [ 'id' => $doctor->id, 'revoked' => '0']; 

    //     $this
    //         ->actingAs($this->admin)
    //         ->patch(route('restore_license', $doctor), $updated_data)
    //         ;

    //     $this->assertDatabaseHas('doctors', $updated_data);
    // }
}
