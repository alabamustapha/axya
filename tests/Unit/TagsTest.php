<?php

namespace Tests\Unit;

use App\Specialty;
use App\Tag;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Schema;
use Tests\TestCase;

class TagsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();
        
        $this->user = factory(User::class)->create();
        $this->specialty = factory(Specialty::class)->create();
        $this->tag       = factory(Tag::class)->create();
    } 

    /** @test */
    public function tags_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('tags', 
          [
            'id','name','slug','description','specialty_id','user_id','accepted_at' 
          ]), 1);
    }

    /** @test */
    public function a_tag_belongs_to_a_specialty()
    {
        $this->assertInstanceOf(Specialty::class, $this->tag->specialty); 
    }

    // /** @test */
    // public function a_tag_belongs_to_many_specialties()
    // {
    //     $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->tag->specialties); 
    // }
}