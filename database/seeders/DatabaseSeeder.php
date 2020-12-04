<?php

namespace Database\Seeders;

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
        \App\Models\Role::factory(2)->create();
        // \App\Models\User::factory(2)->create();

        \App\Models\Category::factory(4)->create();
        \App\Models\View::factory(6)->create();
        \App\Models\Room::factory(8)->create();
        
        $rooms = \App\Models\Room::all();
        \App\Models\User::all()->each(function ($user) use ($rooms) { 
            $user->rooms()->attach(
                $rooms->random(rand(1, \App\Models\Room::max('id')))->pluck('id')->toArray()
            ); 
        });
    }
}
