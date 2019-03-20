<?php

namespace Tests\Feature;

use App\User;
use App\BankAccount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BankAccountsFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user        = factory(User::class)->states(['verified','doctor'])->create();
        $this->bankAccount = factory(BankAccount::class)->create();

        $this->data = factory(BankAccount::class)->raw();
    } 

    /** @test */
    public function index_a_user_bank_accounts_list_can_be_viewed_by_self()
    {
        $this
            ->actingAs($this->user)
            ->get(route('bank_accounts.index'))
            ->assertStatus(200)
            ->assertSee($this->bankAccount->name)
            ->assertSee($this->bankAccount->account_name)
            ->assertSee($this->bankAccount->account_number)
            ;
    }

    /**  @test */
    public function store_a_bank_account_cannot_be_created_by_an_unverified_user()
    {
        $user = factory(User::class)->states('unverified')->create();
        
        $data = factory(BankAccount::class)->raw(['user_id'=> $user->id]);

        $this
            ->actingAs($user)
            ->post(route('bank_accounts.store'), $data)
            ->assertStatus(302) // Redirected to verify page
            ;

        $this->assertDatabaseMissing('bank_accounts', $data);
    }

    /**  @test */
    public function store_a_bank_account_can_be_created_by_a_verified_user()
    {
        $user = factory(User::class)->states('verified')->create();

        $data = factory(BankAccount::class)->raw(['user_id'=> $user->id]);

        $this
            ->actingAs($user)
            ->post(route('bank_accounts.store'), $data)
            // ->assertStatus(201) // rq->expectsJson()
            ;

        $this->assertDatabaseHas('bank_accounts', $data);
    }

    /** @test */
    public function update_a_bank_account_can_be_updated()
    {
        // Update the BankAccount details
        $updated_data = [
            'name'          => ucfirst($this->faker->word),
            'account_name'  => $this->faker->name, 
            'account_number'=> $this->faker->bankAccountNumber,
        ]; 

        $this
            // ->withoutExceptionHandling()
            ->actingAs($this->user)
            ->patch(route('bank_accounts.update', $this->bankAccount), $updated_data)
            ;

        $this->assertDatabaseHas('bank_accounts', $updated_data);
    }

    /** @test */
    public function delete_a_bank_account_can_be_removed()
    {
        $this
            ->actingAs($this->user)
            ->delete(route('bank_accounts.destroy', $this->bankAccount))
            ;

        $this->assertDatabaseMissing('bank_accounts', $this->bankAccount->toArray());
    }
}
