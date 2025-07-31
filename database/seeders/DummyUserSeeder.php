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
        'name' => 'raomi2',
        'email' => 'raomi@example.com',
        'password' => Hash::make('raomi')
    ]);
    }
}
