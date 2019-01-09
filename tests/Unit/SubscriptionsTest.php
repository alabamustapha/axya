<?php

namespace Tests\Unit;

use App\Doctor;
use App\Specialty;
use App\Subscription;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Schema;
use Tests\TestCase;

class SubscriptionsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user       = factory(User::class)->create();
        $this->specialty  = factory(Specialty::class)->create();
        $this->doctor     = factory(Doctor::class)->create();
        $this->subscription= factory(Subscription::class)->create();
    } 

    /** @test */
    public function subscriptions_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('subscriptions', 
          [
            'id','user_id','doctor_id','type','start','end',
            'amount','currency',
            'channel','transaction_id','processor_id','processor_trxn_id','status',
            'confirmed_at','cancelled_at',
          ]) , 1);
    }

    /** @test */
    public function a_subscription_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->subscription->user);
    }
    
    /** @test */
    public function a_subscription_belongs_to_a_doctor()
    {
        $this->assertInstanceOf(Doctor::class, $this->subscription->doctor);
    }
}
