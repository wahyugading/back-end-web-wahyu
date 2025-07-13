<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DummyUserSeeder extends Seeder
{

    public function run()
     {
    User::create([
        'name' => 'rahman',
        'email' => 'eve@example.com',
        'password' => Hash::make('evelyn')
    ]);
    }
}
