<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
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
    static $password;
    return [
        'nickname' => 'Repent',
        'name' => 'Nyarko Isaac',
        'email' => 'admin@gmail.com',
        'user_type' => 'admin',
        'profile' => 'avatar.png',
        'password' => $password ?: $password = bcrypt('@Nyarko2018'),
        'location' => 'Kumasi Apemso',
        'title' => 'Lead Developer',
        'about' => 'Software developer at Trinity Software Center',
        'remember_token' => Str::random(10),
    ];
});


$factory->define(User::class, function (Faker $faker) {
    static $password;
    return [
        'nickname' => 'Becky',
        'name' => 'Nyarko Rebecca',
        'email' => 'becky@gmail.com',
        'user_type' => 'admin',
        'profile' => 'avatar.png',
        'password' => $password ?: $password = bcrypt('@Nyarko2018'),
        'location' => 'Kumasi Apemso',
        'title' => 'Lead Developer',
        'about' => 'Software developer at Trinity Software Center',
        'remember_token' => Str::random(10),
    ];
});

