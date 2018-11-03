<?php

namespace Tests\Unit;

use App\Image;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test  */
    public function test_users_database_has_expected_columns()
    {
        $this->assertTrue( Schema::hasColumns('users', 
        [
            'id','name','slug','email','email_verified_at','address','phone','gender','avatar','acl','is_doctor','blocked','dob','weight','height','allergies','chronics','password','last_four','terms'
        ]), 1);
    }

    /** @test  */
    public function a_user_has_name_attribute()
    {
        $this->assertNotNull($this->user->name);
    }

    /** @test  */
    public function a_user_has_email_attribute()
    {
        $this->assertNotNull($this->user->email);
    }

    /** @test  */
    public function a_user_has_many_images()
    {
        $image   = factory(Image::class)->create(['user_id' => $this->user->id]);
        
        $this->assertTrue($this->user->images->contains($image));
    }
}