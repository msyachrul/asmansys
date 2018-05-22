<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
        	'name' => 'admin',
        	'email' => 'admin@admin.com',
        	'password' => \Hash::make('admin'), // admin
        	'remember_token' => str_random(30),
        ]);
    }
}
