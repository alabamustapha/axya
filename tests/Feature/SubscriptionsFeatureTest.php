<?php

namespace Tests\Unit;

use App\Doctor;
use App\Specialty;
use App\Subscription;
use App\SubscriptionPlan;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Schema;
use Tests\TestCase;

class SubscriptionsFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user       = factory(User::class)->states(['verified','doctor'])->create();
        $this->specialty  = factory(Specialty::class)->create();
        $this->doctor     = factory(Doctor::class)->states('active')->create();
        $this->subscription_plan = factory(SubscriptionPlan::class)->create();
        $this->subscription= factory(Subscription::class)->create([
            'user_id'       => $this->user->id,      // Subscribing User
            'doctor_id'     => $this->doctor->id,    // Subscriber
        ]);
    } 

    /** @test */
    public function index_a_user_subscriptions_list_can_be_viewed_by_self()
    {
        $this
            ->actingAs($this->user)
            ->get(route('subscriptions.index', $this->subscription->user))
            ->assertStatus(200)
            ->assertSee($this->subscription->doctor->name)
            ->assertSee($this->subscription->subscriptionPlan->name)
            ->assertSee($this->subscription->amount)
            ->assertSee($this->subscription->status)
            ->assertSee($this->subscription->transaction_id)
            ->assertSee($this->subscription->start)
            ->assertSee($this->subscription->end)
            ;
    }

    /** @test */
    public function show_a_subscription_can_be_viewed_by_self() 
    {
        $this
            ->actingAs($this->user)
            ->get(route('subscriptions.show', $this->subscription))
            ->assertStatus(200)
            ->assertSee($this->subscription->doctor->name)
            ->assertSee($this->subscription->subscriptionPlan->name)
            ->assertSee($this->subscription->amount)
            ->assertSee($this->subscription->status)
            ->assertSee($this->subscription->transaction_id)
            ->assertSee($this->subscription->start)
            ->assertSee($this->subscription->end)
            ;
    }

    /** @test */
    public function show_a_subscription_can_be_viewed_an_admin() 
    {
        $admin = factory(User::class)->states('admin')->create();

        $this
            ->actingAs($admin)
            ->get(route('subscriptions.show', $this->subscription))
            ->assertStatus(200)
            ->assertSee($this->subscription->doctor->name)
            ->assertSee($this->subscription->subscriptionPlan->name)
            ->assertSee($this->subscription->amount)
            ->assertSee($this->subscription->status)
            ->assertSee($this->subscription->transaction_id)
            ->assertSee($this->subscription->start)
            ->assertSee($this->subscription->end)
            ;
    }

    /** @test */
    public function show_a_subscription_cannot_be_viewed_a_non_doctor_or_non_admin() 
    {
        $user = factory(User::class)->states('verified')->create();

        $this
            ->actingAs($user)
            ->get(route('subscriptions.index', $this->subscription->user))
            // ->assertStatus(403)
            ->assertDontSee($this->subscription->doctor->name)
            ->assertDontSee($this->subscription->subscriptionPlan->name)
            ->assertDontSee($this->subscription->transaction_id)
            ;
    }
}
