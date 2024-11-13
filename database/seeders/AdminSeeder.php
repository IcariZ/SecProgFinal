<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'MIsang',
            'email' => 'adminMisang@PIsang.com',
            'password' => Hash::make('y?q^M^?Vw(V26m6^]K]v'),
            'is_admin' => true,
        ]);
    }
}