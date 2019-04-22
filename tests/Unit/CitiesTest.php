<?php

namespace Tests\Unit;

use App\Doctor;
use App\Specialty;
use App\User;
use App\Region;
use App\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CitiesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->region     = factory(Region::class)->create();
        $this->city       = factory(City::class)->create();
        $this->user       = factory(User::class)->create();
        $this->specialty  = factory(Specialty::class)->create();
        $this->doctor     = factory(Doctor::class)->states('active')->create();
    }

    /** @test  */
    public function test_cities_database_has_expected_columns()
    {
        $this->assertTrue( Schema::hasColumns('cities', 
        [
            'id','name', 'slug', 'region_id',
        ]), 1);
    }

    /** @test  */
    public function a_city_has_name_attribute()
    {
        $this->assertNotNull($this->city->name);
    }

    /** @test  */
    public function a_city_has_slug_attribute()
    {
        $this->assertNotNull($this->city->slug);
    }

    /** @test  */
    public function a_city_has_many_users()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->city->users);
    }

    /** @test  */
    public function a_city_has_many_doctors()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->city->doctors);
    }

    /** @test */
    public function a_city_belongs_to_a_region()
    {
        $this->assertInstanceOf(Region::class, $this->city->region);
    }
}