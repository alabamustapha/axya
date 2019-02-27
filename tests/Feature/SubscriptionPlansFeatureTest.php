<?php

namespace Tests\Feature;

use App\SubscriptionPlan;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionPlansFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();


        $this->subscriptionPlan = factory(SubscriptionPlan::class)->create();

        $this->admin = factory(User::class)->states('admin')->create();
        $this->name  = $this->faker->randomElement(['yearly', 'quarterly', 'monthly']); 
        $this->data  = [ 
            'name'        => $this->name, 
            'slug'        => str_slug($this->name),
            'description' => $this->faker->sentence, 
            'price'       => $this->faker->randomElement([1000, 2000, 3000]),
            'discount'    => $this->faker->numberBetween(3,8),
        ];
    } 

    /** @test */
    public function index_subscription_plans_list_can_be_viewed()
    { 
        $this
            ->get(route('subscription_plans.index'))
            ->assertStatus(200)
            ->assertSee($this->subscriptionPlan->name)
            ;
    }

    /** @test */
    public function show_a_single_subscription_plan_can_be_viewed() 
    {        
        $this
            ->actingAs($this->admin)
            ->get(route('subscription_plans.show', $this->subscriptionPlan))
            ->assertStatus(200)
            ->assertSee($this->subscriptionPlan->name);
    }

    /**  @test */
    public function store_a_subscription_plan_can_be_created_by_an_admin()
    {
        $this
            ->actingAs($this->admin)
            ->post(route('subscription_plans.store'), $this->data)
            ;

        $this->assertDatabaseHas('subscription_plans', $this->data);
    }

    /** @test */
    public function update_a_subscription_plan_can_be_updated()
    {
        $this->actingAs($this->admin);

        // Create a SubscriptionPlan
        $subscription_plan = factory(SubscriptionPlan::class)->create();

        // Update the SubscriptionPlan's details
        $upd_name = $this->faker->randomElement(['yearly', 'quarterly', 'monthly']); 
        $updated_data = [ 
            'name'        => $upd_name, 
            'slug'        => str_slug($upd_name), 
            'description' => $this->faker->sentence, 
            'price'       => $this->faker->randomElement([1000, 2000, 3000]),
            'discount'    => $this->faker->numberBetween(3,8),
        ]; 

        $this
            ->patch(route('subscription_plans.update', $subscription_plan), $updated_data);

        $this->assertDatabaseHas('subscription_plans', $updated_data);
    }

    /** @test */
    public function delete_a_subscription_plan_can_be_removed()
    {
        $this
            ->actingAs($this->admin)
            ->delete(route('subscription_plans.destroy', $this->subscriptionPlan))
            ;

        $this->assertDatabaseMissing('subscription_plans', $this->subscriptionPlan->toArray());
    }


    /** @test */
    public function an_admin_can_see_the_create_form_section_on_subscription_plan_index_page()
    {
        $this
            ->actingAs($this->admin)
            ->get(route('subscription_plans.index'))
            ->assertSee('Add New Subscription Plan')
            ;
    }

    /** @test */
    public function non_admin_cannot_see_the_create_form_section_on_subscription_plan_index_page()
    {
        $user = factory(User::class)->states('normal')->create();
        $this
            ->actingAs($user)
            ->get(route('subscription_plans.index'))
            ->assertStatus(200)
            ->assertDontSee('Add New Subscription Plan')
            ;
    }



    /** @test */
    public function an_admin_can_see_the_edit_and_create_form_sections_on_subscription_plan_main_page()
    {
        $this
            ->actingAs($this->admin)
            ->get(route('subscription_plans.show', $this->subscriptionPlan))
            ->assertStatus(200)
            ->assertSee('Update the Subscription Plan')
            ;
    }

    /** @test */
    public function non_admin_cannot_see_the_edit_form_and_section_on_subscription_plan_main_page()
    {
        $user = factory(User::class)->states('normal')->create();
        $this
            ->actingAs($user)
            ->get(route('subscription_plans.show', $this->subscriptionPlan))
            ->assertStatus(403)
            ->assertDontSee('Update the Subscription Plan')
            ;
    }
}
