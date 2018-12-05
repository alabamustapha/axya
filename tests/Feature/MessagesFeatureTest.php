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
        $this->doctor       = factory(Doctor::class)->create();
        $this->appointment  = factory(Appointment::class)->create();
        $this->message      = factory(Message::class)->create([
          'user_id'         => $this->user->id,
          'messageable_id'  => $this->appointment->id,
          'messageable_type'=> get_class($this->appointment)
        ]);

        $this->document   = factory(Document::class)->create();

        $this->data = [ 
            'user_id'         => $this->user->id,
            'body'            => $this->faker->sentences(2,5),

            'messageable_id'  => $this->message->messageable_id,
            'messageable_type'=> $this->message->messageable_type,
        ];
    } 

    /** @test */
    public function index_a_user_messages_list_can_be_viewed_by_self()
    {
        $this
            ->actingAs($this->user)
            ->get(route('messages.index'))
            ->assertStatus(200)
            // ->assertSee($this->message->statusText())
            ->assertSee($this->user->name)
            ->assertSee($this->message->body)
            ->assertSee($this->message->created_at)
            ;
    }

    /**  @test */
    public function store_a_message_cannot_be_created_by_an_unverified_user()
    {
        $user = factory(User::class)->states('unverified')->create();
        
        $this->actingAs($user);
        
        $data = [ 
            'user_id'         => auth()->id(),
            'body'            => $this->faker->sentences(2,5),

            'messageable_id'  => $this->message->messageable_id,
            'messageable_type'=> $this->message->messageable_type,
        ];

        $this
            ->post(route('messages.store'), $data)
            ->assertStatus(302) // Redirected to verify page
            ;

        $this->assertDatabaseMissing('messages', $data);
    }

    /**  @test */
    public function store_a_message_can_be_created_by_a_verified_user()
    {
        $this
            ->actingAs($this->user)
            ->post(route('messages.store'), $this->data)
            ;

        $this->assertDatabaseHas('messages', $this->data);
    }

    /** @test */
    public function delete_a_message_can_be_removed()
    {
        $this
            ->actingAs($this->user)
            ->delete(route('messages.destroy', $this->message))
            ;

        $this->assertDatabaseMissing('messages', $this->message->toArray());
    }
}
