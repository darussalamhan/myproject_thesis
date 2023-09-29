<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Darussalam',
            'last_name' => 'Han',
            'email' => 'darussalamhan@gmail.com',
            'password' => 12345678,
            'is_admin' => true,
            'remember_token' => Str::random(60)
       ]);
        User::factory()->create([
            'name' => 'Admin',
            'last_name' => 'Utama',
            'email' => 'admin@gmail.com',
            'password' => 12345678,
            'is_admin' => true,
            'remember_token' => Str::random(60)
       ]);
        User::factory()->create([
            'name' => 'Kepala Desa',
            'last_name' => 'User',
            'email' => 'kepaladesa@gmail.com',
            'password' => 12345678,
            'is_admin' => false,
            'remember_token' => Str::random(60)
       ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
