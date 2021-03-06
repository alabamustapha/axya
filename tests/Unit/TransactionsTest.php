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

class TransactionsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user       = factory(User::class)->create();
        $this->specialty  = factory(Specialty::class)->create();
        $this->doctor     = factory(Doctor::class)->states('active')->create();
        $this->appointment= factory(Appointment::class)->create();
        $this->transaction= factory(Transaction::class)->create();
    } 

    /** @test */
    public function transactions_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('transactions', 
          [
            'id',
            'user_id','doctor_id','appointment_id',
            'amount','currency',
            'channel','transaction_id','processor_id','processor_trxn_id','status',
            'confirmed_at','cancelled_at'
          ]) , 1);
    }

    /** @test */
    public function a_transaction_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->transaction->user);
    }
    
    /** @test */
    public function a_transaction_belongs_to_a_doctor()
    {
        $this->assertInstanceOf(Doctor::class, $this->transaction->doctor);
    }

    /** @test */
    public function a_transaction_belongs_to_a_appointment()
    {
        $this->assertInstanceOf(Appointment::class, $this->transaction->appointment);
    }

    /** @test */
    public function a_transaction_morphs_many_calendar_events()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->transaction->calendar_events); 
    }
}
