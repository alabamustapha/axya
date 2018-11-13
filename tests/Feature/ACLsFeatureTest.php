<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ACLsFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        // Create an Admin User
        $this->admin = factory(User::class)->create(['acl' => '1']);
    } 

    /** @test */
    public function update_a_normal_user_can_be_updated_to_admin()
    {
        $this->actingAs($this->admin);

        // Create a User
        $data = [ 'acl' => '3', 'gender' => 'Male' ]; 
        $user = factory(User::class)->create($data);
        $this->assertDatabaseHas('users', $data);

        // Update the User's details
        $updated_data = [ 'id' => $user->id, 'acl' => '1']; 

        $this
            ->patch(route('make-admin', $user), $updated_data)
            ->assertStatus(302)
            // ->assertRedirect(route('dashboard-admins'))
            ;

        $this->assertDatabaseHas('users', $updated_data);
    }

    /** @test */
    public function update_a_normal_user_can_be_updated_to_staff()
    {
        $this->actingAs($this->admin);

        // Create a User
        $data = [ 'acl' => '3', 'gender' => 'Male' ]; 
        $user = factory(User::class)->create($data);
        $this->assertDatabaseHas('users', $data);

        // Update the User's details
        $updated_data = [ 'id' => $user->id, 'acl' => '2']; 

        $this
            ->patch(route('make-staff', $user), $updated_data)
            ->assertStatus(302)
            // ->assertRedirect(route('dashboard-admins'))
            ;

        $this->assertDatabaseHas('users', $updated_data);
    }

    /** @test */
    public function update_a_staff_can_be_upgraded_to_admin()
    {
        $this->actingAs($this->admin);

        // Create a User
        $data = [ 'acl' => '2', 'gender' => 'Male' ]; 
        $user = factory(User::class)->create($data);
        $this->assertDatabaseHas('users', $data);

        // Update the User's details
        $updated_data = [ 'id' => $user->id, 'acl' => '1']; 

        $this
            ->patch(route('make-admin', $user), $updated_data)
            ->assertStatus(302)
            // ->assertRedirect(route('dashboard-admins'))
            ;

        $this->assertDatabaseHas('users', $updated_data);
    }

    /** @test */
    public function update_a_staff_can_be_demoted_to_normal_user()
    {
        $this->actingAs($this->admin);

        // Create a User
        $data = [ 'acl' => '2', 'gender' => 'Male' ]; 
        $user = factory(User::class)->create($data);
        $this->assertDatabaseHas('users', $data);

        // Update the User's details
        $updated_data = [ 'id' => $user->id, 'acl' => '3']; 

        $this
            ->patch(route('make-normal', $user), $updated_data)
            ->assertStatus(302)
            // ->assertRedirect(route('dashboard-admins'))
            ;

        $this->assertDatabaseHas('users', $updated_data);
    }

    /** @test */
    public function update_an_admin_can_be_demoted_to_normal_user()
    {
        $this->actingAs($this->admin);

        // Create a User
        $data = [ 'acl' => '1', 'gender' => 'Male' ]; 
        $user = factory(User::class)->create($data);
        $this->assertDatabaseHas('users', $data);

        // Update the User's details
        $updated_data = [ 'id' => $user->id, 'acl' => '3']; 

        $this
            ->patch(route('make-normal', $user), $updated_data)
            ->assertStatus(302)
            // ->assertRedirect(route('dashboard-admins'))
            ;

        $this->assertDatabaseHas('users', $updated_data);
    }

    /** @test */
    public function update_an_admin_can_be_demoted_to_staff()
    {
        $this->actingAs($this->admin);

        // Create a User
        $data = [ 'acl' => '1', 'gender' => 'Male' ]; 
        $user = factory(User::class)->create($data);
        $this->assertDatabaseHas('users', $data);

        // Update the User's details
        $updated_data = [ 'id' => $user->id, 'acl' => '2']; 

        $this
            ->patch(route('make-staff', $user), $updated_data)
            ->assertStatus(302)
            // ->assertRedirect(route('dashboard-admins'))
            ;

        $this->assertDatabaseHas('users', $updated_data);
    }
}
