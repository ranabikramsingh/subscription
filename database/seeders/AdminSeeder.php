<?php

namespace Database\Seeders;

use App\Models\{User};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::create([
            'name' => 'Admin',
            'email_verified_at' => now(),
            'email' => 'admin@gmail.com',
            'password' => Hash::make('pass@admin')
        ]);

        // Create additional user
        $user = User::create([
            'name' => 'Bikram',
            'email_verified_at' => now(),
            'email' => 'bikram1@gmail.com',
            'password' => Hash::make('Rana1@')
        ]);
    }
}
