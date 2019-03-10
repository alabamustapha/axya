<?php

namespace Tests\Unit;

use App\SubscriptionPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Schema;
use Tests\TestCase;

class SubscriptionPlansTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->subscription_plan = factory(SubscriptionPlan::class)->create();
    } 

    /** @test */
    public function subscription_plans_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('subscription_plans', 
          [
            'id', 'name', 'slug', 'price', 'months_count', 'description', 'discount',
          ]), 1);
    }

    /** @test  */
    public function a_subscription_plan_has_name_attribute()
    {
        $this->assertNotNull($this->subscription_plan->name);
    }

    /** @test  */
    public function a_subscription_plan_has_price_attribute()
    {
        $this->assertNotNull($this->subscription_plan->price);
    }

    /** @test  */
    public function a_subscription_plan_has_description_attribute()
    {
        $this->assertNotNull($this->subscription_plan->description);
    }
}
