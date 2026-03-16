<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::where('email', 'sarab@gmail.com')->delete();

        User::create([
            'name' => 'Sarab',
            'email' => 'sarab@gmail.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
