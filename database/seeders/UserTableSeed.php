<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Rodrigo Ajala de almeida',
            'email' => 'rodrigoajaladealmeida@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
        ]);

    }
}
