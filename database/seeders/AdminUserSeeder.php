<?php

// AdminUserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminUser;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        AdminUser::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' =>'adminTest',
        ]);
    }
}
