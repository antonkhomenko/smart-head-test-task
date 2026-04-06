<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(2)
            ->sequence(
                ['email' => 'admin1@mail.com', 'password' => bcrypt('password')],
                ['email' => 'admin2@mail.com', 'password' => bcrypt('password')]
            )
            ->create()
            ->each(fn($user) => $user->assignRole('admin'));

        User::factory()
            ->count(10)
            ->create()
            ->each(fn($user) => $user->assignRole('manager'));
    }
}
