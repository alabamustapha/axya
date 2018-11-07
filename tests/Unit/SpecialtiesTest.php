<?php

namespace Tests\Unit;

use App\Specialty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Schema;
use Tests\TestCase;

class SpecialtiesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();
        
        $this->specialty = factory(Specialty::class)->create();
    } 

    /** @test */
    public function specialties_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('specialties', 
          [
            'id','name','slug','description', 
          ]), 1);
    }

    /** @test */
    public function a_specialty_belongs_to_many_doctors()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->specialty->doctors); 
    }

    // /** @test */
    // public function a_specialty_belongs_to_many_tags()
    // {
    //     $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->specialty->tags); 
    // }
}