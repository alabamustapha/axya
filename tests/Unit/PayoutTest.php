<?php

namespace Tests\Unit;

use App\User;
use App\Region;
use App\City;
use App\Payout;
use App\BankAccount;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Schema;

class PayoutTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->region     = factory(Region::class)->create();
        $this->city       = factory(City::class)->create();
        $this->user       = factory(User::class)->create();
        $this->bankAccount= factory(BankAccount::class)->create();
        $this->payout     = factory(Payout::class)->create();
    } 

    /** @test */
    public function payouts_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('payouts', 
          [
            'id', 'user_id', 'amount', 'status', 'transaction_id', 'processor_transaction_id', 'bank_account_id', 'confirmed_at',
          ]), 1);
    }

    /** @test */
    public function a_payout_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->payout->user);
    }

    /** @test */
    public function a_payout_belongs_to_a_bank_account()
    {
        $this->assertInstanceOf(BankAccount::class, $this->payout->bankAccount);
    }
}
