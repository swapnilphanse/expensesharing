<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    
    $p = preg_replace("/[^0-9]/","",$faker->phoneNumber);
    $phone = substr($p,0,10);
    
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' =>  $phone,
        'email_verified_at' => now(),
        'password' => Hash::make('secret'), // password
        'remember_token' => Str::random(10),
    ];
});
