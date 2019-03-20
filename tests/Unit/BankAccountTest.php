<?php

namespace Tests\Unit;

use App\User;
use App\BankAccount;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Schema;

class BankAccountTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user       = factory(User::class)->create();
        $this->bankAccount= factory(BankAccount::class)->create();
    } 

    /** @test */
    public function bank_accounts_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('bank_accounts', 
          [
            'id', 'user_id', 'name', 'account_name', 'account_number',
          ]), 1);
    }

    /** @test */
    public function a_bank_account_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->bankAccount->user);
    }

    /** @test */
    public function a_bank_account_has_many_payouts()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->bankAccount->payouts); 
    }
}
