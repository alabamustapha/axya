<?php

namespace Tests\Unit;

use App\Appointment;
use App\Doctor;
use App\Document;
use App\Message;
use App\Specialty;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Schema;
use Tests\TestCase;

class MessagesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user       = factory(User::class)->create();
        $this->specialty  = factory(Specialty::class)->create();
        $this->doctor     = factory(Doctor::class)->create();
        $this->appointment= factory(Appointment::class)->create();
        $this->message    = factory(Message::class)->create([
          'messageable_id'  => $this->appointment->id,
          'messageable_type'=> get_class($this->appointment)
        ]);
        $this->document   = factory(Document::class)->create();
    } 

    /** @test */
    public function messages_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('messages', 
          [
            'id','user_id','body','messageable_id','messageable_type'
          ]), 1);
    }

    /** @test */
    public function a_message_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->message->user);
    }

    /** @test */
    public function a_message_has_many_images()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->message->images); 
    }

    /** @test */
    public function a_message_has_many_documents()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->message->documents); 
    }

    /** @test */
    public function a_message_morphs_to_an_appointment()
    {
        $this->assertInstanceOf(Appointment::class, $this->message->messageable); 
    }
}