<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
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
        //model create
        //db insert
        //check if user is already exists
        if(!User::where('email','user@gmail.com')->exists()){
            User::create([
                'name' => 'user',
                'email' => 'user@gmail.com',
                // 'status' => 0,
                'password' => Hash::make(123)
            ]);
        }
        if(!User::where('email','author@gmail.com')->exists()){
            User::create([
                'name' => 'mohamed basem',
                'email' => 'author@gmail.com',
                // 'status' => 0,
                'password' => Hash::make(123),
                'role' => Role::Author->value,
            ]);
        }
        if(!User::where('email','author2@gmail.com')->exists()){
            User::create([
                'name' => 'salem ahmed',
                'email' => 'author2@gmail.com',
                // 'status' => 0,
                'password' => Hash::make(123),
                'role' => Role::Author->value,
            ]);
        }
        if(!User::where('email','admin@gmail.com')->exists()){
            User::create([
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                // 'status' => 0,
                'password' => Hash::make(123),
                'role' => Role::Admin->value,
            ]);
        }
    }
}
