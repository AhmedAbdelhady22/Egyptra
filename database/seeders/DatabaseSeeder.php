<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            PropertyTypeSeeder::class,
            LocationSeeder::class,
            PropertySeeder::class,
            ServiceSeeder::class,
            FinishingPackageSeeder::class,
            ProjectSeeder::class,
            BlogSeeder::class,
            PageSeeder::class,
            SettingsSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
