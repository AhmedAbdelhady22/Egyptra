<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@egyptra.com');
        $password = env('ADMIN_PASSWORD', 'password');

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Egyptra Admin',
                'password' => $password,
                'is_super_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
