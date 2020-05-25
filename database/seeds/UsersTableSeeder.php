<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'nickname' => 'Repent',
                'name' => 'Nyarko Isaac',
                'email' => 'admin@gmail.com',
                'user_type' => 'admin',
                'profile' => 'avatar.png',
                'password' => bcrypt('@Nyarko2018'),
                'location' => 'Kumasi Apemso',
                'title' => 'Lead Developer',
                'about' => 'Software developer at Trinity Software Center',
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'nickname' => 'Becky',
                'name' => 'Nyarko Rebecca',
                'email' => 'becky@gmail.com',
                'user_type' => 'admin',
                'profile' => 'avatar.png',
                'password' => bcrypt('@Nyarko2018'),
                'location' => 'Kumasi Apemso',
                'title' => 'Lead Developer',
                'about' => 'Software developer at Trinity Software Center',
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'nickname' => 'Nyarko',
                'name' => 'Nyarko Isaac',
                'email' => 'nyarko@gmail.com',
                'user_type' => 'admin',
                'profile' => 'avatar.png',
                'password' => bcrypt('@Nyarko2018'),
                'location' => 'Kumasi Apemso',
                'title' => 'Lead Developer',
                'about' => 'Software developer at Trinity Software Center',
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],

        ]);
    }
}
