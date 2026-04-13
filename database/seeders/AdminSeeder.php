<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = env('ADMIN_PASSWORD', Str::random(12));

        User::firstOrCreate(
            ['email' => 'admin@devportfolio.com'],
            [
                'name' => 'Platform Admin',
                'username' => 'admin',
                'email' => 'admin@devportfolio.com',
                'password' => Hash::make($password),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created: admin@devportfolio.com / password');
    }
}
