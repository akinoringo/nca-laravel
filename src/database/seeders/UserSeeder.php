<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'test@akinori.com',
            'password' => Hash::make('akinoringo123')
        ]);

        User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'test2@akinori.com',
            'password' => Hash::make('akinoringo123')
        ]);
    }
}
