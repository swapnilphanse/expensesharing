<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // DB::table('users')->insert([
        //     'id' => 24,
        //     'name' => Str::random(10),
        //     'phone' =>  preg_replace("/[^0-9]/","",$faker->phoneNumber),
        //     'email' => Str::random(10).'@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('secret'),
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

           $user = factory(App\User::class, 10)->create();
    }
}
