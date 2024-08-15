<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            if (!User::where('email', 'wesley@gmail.com.br')->first()) {
                User::create([
                    'name' => 'Wesley',
                    'email' => 'wesley@gmail.com',
                    'password' => Hash::make('123456a', ['rounds' => 12]),
                ]);
            if (!User::where('email', 'rayane@gmail.com.br')->first()) {
                User::create([
                    'name' => 'Rayane',
                    'email' => 'rayane@gmail.com',
                    'password' => Hash::make('123456a', ['rounds' => 12]),
                ]);
            }
        }
    }
}
