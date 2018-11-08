<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        // factory(App\User::class, 100)->create();
        // factory(App\Specialty::class, 5)->create();
        // factory(App\Tag::class, 50)->create();
        factory(App\Doctor::class, 30)->create();
    }
}
