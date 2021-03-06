<?php

namespace Tests\Unit;

use App\Doctor;
use App\Specialty;
use App\Transaction;
use App\Appointment;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Schema;
use Tests\TestCase;

class TransactionsFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user       = factory(User::class)->states(['verified','doctor'])->create();
        $this->specialty  = factory(Specialty::class)->create();
        $this->doctor     = factory(Doctor::class)->states('active')->create();
        $this->appointment= factory(Appointment::class)->create();
        $this->transaction= factory(Transaction::class)->create([
            'user_id'       => $this->user->id,      // Patient
            'doctor_id'     => $this->doctor->id,    // Attending Doctor
            'appointment_id'=> $this->appointment->id
        ]);
    } 

    /** @test */
    public function index_a_user_transactions_list_can_be_viewed_by_self()
    {
        $this
            ->actingAs($this->user)
            ->get(route('transactions.index', $this->transaction->user))
            ->assertStatus(200)
            ->assertSee($this->transaction->user->name)
            ->assertSee($this->transaction->doctor->name)
            ->assertSee($this->transaction->appointment->description)
            ->assertSee($this->transaction->amount)
            ->assertSee($this->transaction->status)
            ->assertSee($this->transaction->transaction_id)
            ;
    }

    /** @test */
    public function show_a_transaction_can_be_viewed_by_self() 
    {
        $this
            ->actingAs($this->user)
            ->get(route('transactions.show', [$this->transaction->user, $this->transaction]))
            ->assertStatus(200)
            ->assertSee($this->transaction->user->name)
            ->assertSee($this->transaction->doctor->name)
            ->assertSee($this->transaction->appointment->description)
            ->assertSee($this->transaction->amount)
            ->assertSee($this->transaction->status)
            ->assertSee($this->transaction->transaction_id)
            ;
    }

    /** @test */
    public function show_a_transaction_can_be_viewed_attending_doctor() 
    {
        // $user = factory(User::class)->states(['verified'])->create();
        $doc_user = factory(User::class)->states(['verified','doctor'])->create();
        $doc      = factory(Doctor::class)->states('active')->create([
                        'id'      => $doc_user->id,
                        'user_id' => $doc_user->id,
                    ]);

        $appointment= factory(Appointment::class)->create([
            'user_id'       => $this->user->id,   // Tranasction initiator
            'doctor_id'     => $doc->id,    // Attending Doctor
        ]);
        $transaction= factory(Transaction::class)->create([ 
                        'user_id'        => $appointment->user_id,
                        'appointment_id' => $appointment->id, ]);

        $this
            ->actingAs($doc_user)
            ->get(route('transactions.show', [$transaction->user, $transaction]))
            ->assertStatus(200)
            ->assertSee($transaction->user->name)
            ->assertSee($transaction->doctor->name)
            ->assertSee($transaction->appointment->description)
            ->assertSee($transaction->amount)
            ->assertSee($transaction->status)
            ->assertSee($transaction->transaction_id)
            ;
    }

    /** @test */
    public function show_a_transaction_can_be_viewed_an_admin() 
    {
        $admin = factory(User::class)->states('admin')->create();

        $this
            ->actingAs($admin)
            ->get(route('transactions.show', [$this->transaction->user, $this->transaction]))
            ->assertStatus(200)
            ->assertSee($this->transaction->user->name)
            ->assertSee($this->transaction->doctor->name)
            ->assertSee($this->transaction->appointment->description)
            ->assertSee($this->transaction->amount)
            ->assertSee($this->transaction->status)
            ->assertSee($this->transaction->transaction_id)
            ;
    }

    /** @test */
    public function show_a_transaction_cannot_be_viewed_by_unauthorized_users() 
    {
        $user = factory(User::class)->states('verified')->create();

        $this
            ->actingAs($user)
            ->get(route('transactions.show', [$this->transaction->user, $this->transaction]))
            // ->dump()
            // ->assertStatus(302)
            ->assertDontSee($this->transaction->user->name)
            ->assertDontSee($this->transaction->doctor->name)
            ;
    }

    // /**  @test */
    // public function store_a_transaction_can_be_created_by_a_verified_user()
    // {
    //     $user        = factory(User::class)->states('verified')->create();
    //     $appointment = factory(Appointment::class)->create(['user_id' => $user->id]);
    //     $newTransaction = factory(Transaction::class)->raw(['appointment_id' => $appointment->id]);

    //     $newTransaction = array_merge($newTransaction, [

    //         'amount'        => $appointment->doctor->rate * $appointment->no_of_sessions,
    //         'status'        => '0',
    //         'currency'      => 'RON',
    //     ]);

    //     // $data = [ 
    //     //     'user_id'       => $user->id,
    //     //     'doctor_id'     => $appointment->doctor_id,
    //     //     'appointment_id'=> $appointment->id,
    //     //     'transaction_id'=> $appointment->makeTransactionId(),
    //     // ];

    //     $this
    //         ->actingAs($user)
    //         ->post(route('transactions.store', $user), $newTransaction)
    //         ;
    //     // // Test here that Transaction Event is generated...

    //     // // Test here that Transaction Event is generated...
    //     // $createdEvent = $user
    //     //               ->calendar_events()
    //     //               ->create(\App\CalendarEvent::createTransactionEventData($appointment))
    //     //               ->toArray()
    //     //               ;
    //     // $createdPatientEvent = $user
    //     //             ->calendar_events()
    //     //             ->create(\App\CalendarEvent::patientAppointmentEventData($transaction))
    //     //             ;
    //     // $createdDoctorEvent = $doctor->user
    //     //             ->calendar_events()
    //     //             ->create(\App\CalendarEvent::doctorAppointmentEventData($transaction))
    //                 ;

    //     // $this->assertDatabaseHas('calendar_events', $createdEvent);

    //     $this->assertDatabaseHas('transactions', $newTransaction);
    //     // $this->assertDatabaseHas('calendar_events', $createdPatientEvent);
    //     // $this->assertDatabaseHas('calendar_events', $createdDoctorEvent);
    // }








    // /** @test */
    // public function show_a_new_transaction_form_contains_required_texts() 
    // {
    //     $this
    //         ->actingAs($this->user)
    //         ->get(route('transactions.create'))
    //         ->assertStatus(200)
    //         ->assertSee($this->transaction->user->name)
    //         ->assertSee($this->transaction->doctor->name)
    //         ->assertSee($this->transaction->appointment->description)
    //         ->assertSee($this->transaction->amount)
    //         ->assertDontSee($this->transaction->status)
    //         ->assertDontSee($this->transaction->transaction_id)
    //         ;
    // }

    // /** @test */
    // public function update_a_transaction_payment_satatus_can_be_updated()
    // {
    //     // $user = factory(User::class)->states('verified')->create();
    //     // create appointment
    //     // create transaction
    //     // make payment
    //     // ensure appropriate transaction attributes get updated
    //     // check transactions db for implemented update
    //     // ensure appropriate appointment attributes get updated
    //     // check appointments db for implemented update
    // }
}
