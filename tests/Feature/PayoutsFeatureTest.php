<?php

namespace Tests\Feature;

use App\Doctor;
use App\Payout;
use App\Specialty;
use App\User;
use App\BankAccount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PayoutsFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user        = factory(User::class)->states(['verified','doctor'])->create();
        $this->bankAccount = factory(BankAccount::class)->create();
        $this->specialty   = factory(Specialty::class)->create();
        $this->doctor      = factory(Doctor::class)->states('active')->create(['user_id'=> $this->user->id]);
        $this->payout      = factory(Payout::class)->create();

        $this->data = factory(Payout::class)->raw(['status' => '1']);
    } 

    /** @test */
    public function index_a_user_payouts_list_can_be_viewed_by_self()
    {//dd($this->payout);
        $this
            // ->withoutExceptionHandling()
            ->actingAs($this->user)
            ->get(route('transactions.index', $this->user->doctor))
            ->assertStatus(200)
            // ->assertSee('Payout History')
            ->assertSee($this->payout->user->current_balance)
            ->assertSee($this->payout->user->total_earning)
            // ->assertSee($this->payout->amount)
            // ->assertSee($this->payout->bankAccount->account_number)
            // ->assertSee($this->payout->confirmed_at)
            // ->assertSee($this->payout->transaction_id)
            ;
    }

    // /** @test */
    // public function show_a_payout_cannot_be_viewed_by_other_users()
    // {
    //     $user = factory(User::class)->states('verified')->create();
    //     $this
    //         ->actingAs($user)
    //         ->get(route('payouts.show', $this->payout))
    //         ->assertStatus(403)
    //         ->assertSee($this->payout->amount)
    //         ->assertSee($this->payout->bank_account->account_number)
    //         ->assertSee($this->payout->confirmed_at)
    //         ->assertSee($this->payout->transaction_id)
    //         ;
    // }

    /**  @test */
    public function store_a_payout_cannot_be_created_by_an_unverified_user()
    {
        $user = factory(User::class)->states('unverified')->create();
        
        $data = factory(Payout::class)->raw(['user_id'=> $user->id]);

        $this
            ->actingAs($user)
            ->post(route('payouts.store'), $data)
            ->assertStatus(302) // Redirected to verify page
            ;

        $this->assertDatabaseMissing('payouts', $data);
    }

    // /**  @test */
    // public function store_a_payout_can_be_created_by_a_verified_user()
    // {
    //     $user = factory(User::class)->states('verified')->create();

    //     $data = factory(Payout::class)->raw(['user_id'=> $user->id]);

    //     $this
    //         ->actingAs($user)
    //         ->post(route('payouts.store'), $data)
    //         // ->assertStatus(201) // rq->expectsJson()
    //         ;

    //     $this->assertDatabaseHas('payouts', $data);
    // }
}
