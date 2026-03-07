<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'sarab@gmail.com'],
            [
                'name' => 'Sarab',
                'password' => '123456',
            ]
        );
    }
}
