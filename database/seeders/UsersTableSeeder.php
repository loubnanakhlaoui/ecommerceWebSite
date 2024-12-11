<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Loubna',
            'email' => 'loubna@example.com',
            'password' => 'loubna123', // Le mutateur s'occupera de hacher le mot de passe
        ]);

        User::create([
            'name' => 'Hanan',
            'email' => 'hanan@example.com',
            'password' => 'hanan123', // Le mutateur s'occupera de hacher le mot de passe
        ]);
    }
}
