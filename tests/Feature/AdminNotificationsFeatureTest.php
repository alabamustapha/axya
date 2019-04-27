<?php

namespace Tests\Feature;

use App\AdminNotification;
use App\Doctor;
use App\Specialty;
use App\User;
use App\Region;
use App\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminNotificationsFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->region     = factory(Region::class)->create();
        $this->city       = factory(City::class)->create();
        $this->admin      = factory(User::class)->states('admin')->create();
        $this->receiver   = factory(User::class)->create();
        $this->adminNotif = factory(AdminNotification::class)->create();

        $this->data = factory(AdminNotification::class)->raw();
    } 

    /** @test */
    public function index_an_admin_notifications_list_can_be_viewed_by_admin()
    {
        $this
            ->actingAs($this->admin)
            ->get(route('dashboard-notifications'))
            ->assertStatus(200)
            ->assertSee($this->adminNotif->title)
            ->assertSee($this->adminNotif->content)
            ->assertSee($this->adminNotif->created_at)
            ;
    }

    /**  @test */
    public function store_an_admin_notification_cannot_be_created_by_non_admin_user()
    {
        $user = factory(User::class)->states('normal')->create();
        
        $data = factory(AdminNotification::class)->raw(['user_id'=> $user->id]);

        $this
            ->actingAs($user)
            ->post(route('admin_notifications.store'), $data)
            ->assertStatus(403) // Authorized access to form area.
            ;

        $this->assertDatabaseMissing('admin_notifications', $data);
    }

    /**  @test */
    public function store_admin_notification_can_be_created_by_an_admin_user()
    {
        $user = factory(User::class)->states('admin')->create();

        $data = factory(AdminNotification::class)->raw([ 'user_id' => $user->id, ]);

        $this
            ->actingAs($user)
            ->post(route('admin_notifications.store'), $data)
            // ->assertStatus(201)
            ;

        $this->assertDatabaseHas('admin_notifications', $data);
    }
}
