<?php

namespace Tests\Unit;

use App\Application;
use App\Document;
use App\Specialty;
use App\User;
use App\Region;
use App\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Schema;
use Tests\TestCase;

class DocumentsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->region = factory(Region::class)->create();
        $this->city   = factory(City::class)->create();
        $this->user         = factory(User::class)->create();
        $this->specialty    = factory(Specialty::class)->create();
        $this->application  = factory(Application::class)->create();
        $this->document     = factory(Document::class)->create();
    } 

    /** @test */
    public function documents_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('documents', 
          [
            'id','user_id','description','url','documentable_id','documentable_type','expiry_date','mime','size','unique_id','mime_type' 
          ]), 1);
    }

    /** @test */
    public function a_document_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->document->user);
    }
}
