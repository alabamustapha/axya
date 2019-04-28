<?php

namespace Tests\Unit;

use App\User;
use App\Region;
use App\City;
use App\AdminNotification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Schema;

class AdminNotificationsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->region     = factory(Region::class)->create();
        $this->city       = factory(City::class)->create();
        $this->user       = factory(User::class)->states('admin')->create();
        $this->receiver   = factory(User::class)->create();
        $this->adminNotif = factory(AdminNotification::class)->create([
            // 'user_id'     => $adminId,
            'as_notice'   => true,
            'as_email'    => true,
            'as_push'     => true,
            'as_text'     => true,
            'to'          => $this->faker->randomElement(['Doctors','Users','Everyone','Admins']),
            'region_id'   => $this->region->id,
            'city_id'     => $this->city->id,
            'receiver_id' => $this->receiver->id,
            'title'       => $this->faker->sentence,
            'content'     => $this->faker->paragraphs(1,3),
        ]);
    } 

    /** @test */
    public function admin_notifications_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('admin_notifications', 
          [
            'id', 'user_id','as_notice', 'as_email', 'as_push', 'as_text', 
            'to', 'region_id', 'city_id', 'receiver_id', 'search_email',
            'title', 'content',
          ]), 1);
    }

    /** @test */
    public function an_admin_notification_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->adminNotif->user);
    }

    /** @test */
    public function an_admin_notification_belongs_to_an_admin_user()
    {
        $this->assertTrue($this->adminNotif->user->isAdmin());
    }

    /** @test */
    public function an_admin_notification_belongs_to_a_region()
    {
        $this->assertInstanceOf(Region::class, $this->adminNotif->region);
    }

    /** @test */
    public function an_admin_notification_belongs_to_an_city()
    {
        $this->assertInstanceOf(City::class, $this->adminNotif->city);
    }

    /** @test  */
    public function a_user_has_as_notice_attribute()
    {
        $this->assertNotNull($this->adminNotif->as_notice);
    }

    /** @test  */
    public function a_user_has_as_email_attribute()
    {
        $this->assertNotNull($this->adminNotif->as_email);
    }

    /** @test  */
    public function a_user_has_as_push_attribute()
    {
        $this->assertNotNull($this->adminNotif->as_push);
    }

    /** @test  */
    public function a_user_has_as_text_attribute()
    {
        $this->assertNotNull($this->adminNotif->as_text);
    }

    /** @test  */
    public function a_user_has_to_attribute()
    {
        $this->assertNotNull($this->adminNotif->to);
    }

    /** @test  */
    public function a_user_has_region_id_attribute()
    {
        $this->assertNotNull($this->adminNotif->region_id);
    }

    /** @test  */
    public function a_user_has_city_id_attribute()
    {
        $this->assertNotNull($this->adminNotif->city_id);
    }

    /** @test  */
    public function a_user_has_title_attribute()
    {
        $this->assertNotNull($this->adminNotif->title);
    }

    /** @test  */
    public function a_user_has_content_attribute()
    {
        $this->assertNotNull($this->adminNotif->content);
    }
}
