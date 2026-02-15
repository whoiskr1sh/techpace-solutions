<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SalesUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'sales@local'],
            [
                'name' => 'Sales User',
                'password' => Hash::make('password'),
                'role' => 'sales',
            ]
        );
    }
}
