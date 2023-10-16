<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\YearSem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\LazyCollection;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Sulit Ralph',
            'username' => 'admin',
            'password' => Hash::make('12'),
            'role' => 'admin'
        ]);

        YearSem::create([
            'year' => '2023-2024',
            'semester' => '1'
        ]);
    }
}
