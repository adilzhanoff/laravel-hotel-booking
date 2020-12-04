<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $json = File::get("data/users.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            User::create(array(
                'name' => $obj->name,
                'email' => $obj->email,
                'password' => Hash::make('12345678'),
                'role_id' => $obj->role_id
            ));
        }
    }
}
