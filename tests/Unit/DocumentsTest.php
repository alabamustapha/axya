<?php

namespace Tests\Unit;

use App\Document;
use App\User;
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

        $this->user     = factory(User::class)->create();
        $this->document = factory(Document::class)->create();
    } 

    /** @test */
    public function documents_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('documents', 
          [
            'id','user_id','description','url','documentable_id','documentable_type','expiry_date','mime','size' 
          ]), 1);
    }

    /** @test */
    public function a_document_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->document->user);
    }
}
