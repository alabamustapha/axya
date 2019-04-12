<?php

namespace Tests\Feature;

use App\Appointment;
use App\Doctor;
use App\Document;
use App\Message;
use App\Specialty;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessagesFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user         = factory(User::class)->states('verified')->create();
        $this->specialty    = factory(Specialty::class)->create();
        $this->doctor       = factory(Doctor::class)->states('active')->create();
        $this->appointment  = factory(Appointment::class)->states('chatable')->create();
        $this->message      = factory(Message::class)->raw([
          'user_id'         => $this->user->id,
          'messageable_id'  => $this->appointment->id,
          'messageable_type'=> get_class($this->appointment)
        ]);

        $this->document   = factory(Document::class)->create();
    } 

    /** @test */
    public function index_a_user_messages_list_can_be_viewed_by_self()
    {
        $this
            ->actingAs($this->user)
            ->get(route('messages.index', $this->user))
            ->assertStatus(200)
            ->assertSee($this->user->name)
            // ->assertSee($this->appointment->doctor->name)
            // ->assertSee($this->appointment->description_preview)
            ->assertSee('Active Correspondence')
            ->assertSee('General Messaging Info')
            ;
    }

    /**  @test */
    public function store_a_message_cannot_be_created_by_an_unverified_user()
    {
        $user = factory(User::class)->states('unverified')->create();
        
        $this
            ->actingAs($user)
            ->post(route('messages.store', $this->appointment), $this->message)
            ;

        $this->assertDatabaseMissing('messages', $this->message);
    }

    /**  @test */
    public function store_a_message_can_be_created_by_a_verified_user()
    {
        $this
            ->actingAs($this->user)
            ->post(route('messages.store', $this->appointment), $this->message)
            ;

        $this->assertDatabaseHas('messages', $this->message);
    }

    // /** @test */
    // public function delete_a_message_can_be_removed()
    // {
    //     $this
    //         ->actingAs($this->user)
    //         ->delete(route('messages.destroy', $this->message))
    //         ;

    //     // $this->assertDatabaseMissing('messages', $this->message->toArray());
    //     // $this->assertDatabaseHas('messages', ['id'=> $this->message->id, 'deleted_at'=> $this->message->deleted_at]);
    //     // $this->assertNotNull($this->message->deleted_at);
    //     // $this->assertTrue($this->message->trashed());
    // }
}
