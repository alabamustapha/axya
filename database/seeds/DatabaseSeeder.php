<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints(); 
        // https://laravel.com/docs/5.7/migrations#foreign-key-constraints
        // $this->call(UsersTableSeeder::class);

        // factory(App\User::class, 30)->create();
        // factory(App\Specialty::class, 5)->create();
        // factory(App\Tag::class, 50)->create();
        // factory(App\Application::class, 10)->create();

        // factory(App\Doctor::class, 30)->create();
        factory(App\Workplace::class, 10)->create();
    }
}
