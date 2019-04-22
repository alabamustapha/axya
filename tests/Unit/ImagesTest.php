<?php

namespace Tests\Unit;

use App\Image;
use App\User;
use App\Region;
use App\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Schema;
use Tests\TestCase;

class ImagesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->region     = factory(Region::class)->create();
        $this->city       = factory(City::class)->create();
        $this->image = factory(Image::class)->create();
    } 

    /** @test */
    public function images_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('images', 
          [
            'id','user_id','caption',
            'url','medium_url','thumbnail_url',
            'imageable_id','imageable_type','cover',
            'mime','size', 
          ]), 1);
    }

    /** @test */
    public function an_image_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->image->user);
    }
}
