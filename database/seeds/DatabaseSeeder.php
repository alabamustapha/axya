<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // private $tables = [
    //     'regions',
    //     'cities',
    //     'users',
    //     'specialties',
    //     'tags',
    //     'applications',
    //     'doctors',
    //     'workplaces',
    //     'days',
    //     'schedules',
    //     'appointments',
    //     'messages',
    //     'reviews',
    //     'transactions',
    //     'prescriptions',
    //     'drugs',
    //     'medications',
    //     'calendar_events',
    //     'bank_accounts',
    //     'payouts',
    // ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->removeFkConstraints();

        // Eloquent::unguard();

        // // https://laravel.com/docs/5.7/migrations#foreign-key-constraints
        // // $this->call(UsersTableSeeder::class);

        // factory(App\Region::class, 10)->create();
        // factory(App\City::class, 30)->create();
        // factory(App\User::class, 30)->create();
        // factory(App\Specialty::class, 5)->create();
        // factory(App\Tag::class, 250)->create();
        // factory(App\Application::class, 10)->create();

        // factory(App\Doctor::class, 15)->create();
        // factory(App\Workplace::class, 10)->create();
        // factory(App\Day::class, 7)->create();
        // factory(App\Schedule::class, 20)->create();
        // factory(App\Appointment::class, 500)->create();
        // factory(App\Message::class, 1500)->create();
        // factory(App\Review::class, 490)->create();
        // factory(App\Transaction::class, 60)->create();
        // factory(App\Prescription::class, 10)->create();
        // factory(App\Drug::class, 40)->create();
        // factory(App\Medication::class, 60)->create();
        // factory(App\CalendarEvent::class, 130)->create();
        // factory(App\BankAccount::class, 3)->create();
        // factory(App\Payout::class, 10)->create();
    }


    /**
     * NB: This truncates all tables, be careful.
     *
     * @return void
     */
    // public function removeFkConstraints()
    // {
    //     DB::statement('SET FOREIGN_KEY_CHECKS=0');

    //     foreach ($this->tables as $table) {
    //         DB::table($table)->truncate();
    //     }

    //     DB::statement('SET FOREIGN_KEY_CHECKS=1');
    // }
}
