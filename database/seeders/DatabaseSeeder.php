<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Ganti factory user dengan updateOrCreate agar tidak error jika sudah ada
        \App\Models\User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User']
        );

        // Tambah data budget contoh
        \App\Models\Budget::create([
            'budget_name' => 'Budget Makanan',
            'category' => 'Makanan',
            'amount' => 1000000,
            'period' => 'monthly',
            'month' => 4,
            'year' => 2025,
            'currency_id' => 1
        ]);
        \App\Models\Budget::create([
            'budget_name' => 'Budget Gaji',
            'category' => 'Gaji',
            'amount' => 5000000,
            'period' => 'yearly',
            'year' => 2025,
            'currency_id' => 1
        ]);
    }
}
