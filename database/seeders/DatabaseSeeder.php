<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // İlk ve tek admin hesabı: dışarıdan kayıt formuyla bu role verilemez,
        // sadece seeder üzerinden (veya DataGrip'ten manuel) atanır.
        User::query()->updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => 'password',
                'email_verified_at' => now(),
                'role' => 'admin',
            ]
        );

        SiteSetting::setMany([
            'linkedin_url' => null,
            'github_url' => null,
            'twitter_url' => null,
        ]);
    }
}
