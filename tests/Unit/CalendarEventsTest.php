<?php

namespace Tests\Unit;

use App\Appointment;
use App\CalendarEvent;
use App\Doctor;
use App\Medication;
use App\Message;
use App\Prescription;
use App\Specialty;
use App\Transaction;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Schema;
use Tests\TestCase;

class CalendarEventsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user           = factory(User::class)->create();
        $this->specialty      = factory(Specialty::class)->create();
        $this->doctor         = factory(Doctor::class)->create();
        $this->appointment    = factory(Appointment::class)->create();
        $this->transaction    = factory(Transaction::class)->create();
        $this->message        = factory(Message::class)->states('appointment')->create();
        $this->prescription   = factory(Prescription::class)->create();
        $this->medication     = factory(Medication::class)->create();
        $this->calendar_event = factory(CalendarEvent::class)->create();
    } 

    /** @test */
    public function calendar_events_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('calendar_events', 
          [
            'id', 'user_id', 'start', 'end', 'title', 'content', 'contentFull', 'class', 'icon', 'background', 'eventable_id', 'eventable_type',
          ]), 1);
    }

    /** @test */
    public function a_calendar_event_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->calendar_event->user);
    }

    /** @test */
    public function a_calendar_event_morphs_a_transaction()
    {
        $this->assertInstanceOf(Transaction::class, $this->calendar_event->eventable);
    }

    /** @test */
    public function a_calendar_event_morphs_an_appointment()
    {
        $this->assertInstanceOf(Appointment::class, $this->calendar_event->eventable);
    }

    /** @test */
    public function a_calendar_event_morphs_a_medication()
    {
        $this->assertInstanceOf(Medication::class, $this->calendar_event->eventable);
    }
}
