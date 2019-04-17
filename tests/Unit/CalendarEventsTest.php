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
use App\Region;
use App\City;
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

        $this->region = factory(Region::class)->create();
        $this->city   = factory(City::class)->create();
        $this->user           = factory(User::class)->create();
        $this->specialty      = factory(Specialty::class)->create();
        $this->doctor         = factory(Doctor::class)->states('active')->create();
        $this->appointment    = factory(Appointment::class)->states('chatable')->create();
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
    public function a_calendar_event_morphs_to_a_transaction()
    {
        $calendar_event = factory(CalendarEvent::class)->create([
            'eventable_id'=> $this->transaction->id,
            'eventable_type'=> 'App\Transaction',
        ]);

        $this->assertInstanceOf(Transaction::class, $calendar_event->eventable);
    }

    /** @test */
    public function a_calendar_event_morphs_to_an_appointment()
    {
        $calendar_event = factory(CalendarEvent::class)->create([
            'eventable_id'=> $this->appointment->id,
            'eventable_type'=> 'App\Appointment',
        ]);

        $this->assertInstanceOf(Appointment::class, $calendar_event->eventable);
    }

    /** @test */
    public function a_calendar_event_morphs_to_a_medication()
    {
        $calendar_event = factory(CalendarEvent::class)->create([
            'eventable_id'=> $this->medication->id,
            'eventable_type'=> 'App\Medication',
        ]);

        $this->assertInstanceOf(Medication::class, $calendar_event->eventable);
    }
}
