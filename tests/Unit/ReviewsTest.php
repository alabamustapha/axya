<?php

namespace Tests\Unit;

use App\Appointment;
use App\Doctor;
use App\Review;
use App\Specialty;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Schema;
use Tests\TestCase;

class ReviewsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user       = factory(User::class)->create();
        $this->specialty  = factory(Specialty::class)->create();
        $this->doctor     = factory(Doctor::class)->states('active')->create();
        $this->appointment= factory(Appointment::class)->create();
        $this->review     = factory(Review::class)->create();
    } 

    /** @test */
    public function reviews_database_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('reviews', 
          [
            'id','user_id','doctor_id','appointment_id','comment','rating'
          ]), 1);
    }

    /** @test */
    public function an_review_belongs_to_a_user()
    {
        $this->assertInstanceOf(User::class, $this->review->user);
    }

    /** @test */
    public function an_review_belongs_to_a_doctor()
    {
        $this->assertInstanceOf(Doctor::class, $this->review->doctor);
    }

    /** @test */
    public function an_review_belongs_to_an_appointment()
    {
        $this->assertInstanceOf(Appointment::class, $this->review->appointment);
    }
}