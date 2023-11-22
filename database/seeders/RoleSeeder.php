<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Kirill', 
            'email'=> 'moder@gmail.com',
            'password' => bcrypt('123'),
            'role'=> 'moderator'
        ]);
        User::create([
            'name' => 'Kirill', 
            'email'=> 'reader@gmail.com',
            'password' => bcrypt('123'),
            'role'=> 'reader'
        ]);
    }
}
