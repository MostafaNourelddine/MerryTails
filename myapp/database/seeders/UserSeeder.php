<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create default admin user with complex password
        User::create([
            'name' => 'MerryTails Admin',
            'email' => 'admin@merrytails.com',
            'password' => Hash::make('MerryTails@Admin2024!'),
            'is_admin' => true,
        ]);

        // Create default regular user with complex password
        User::create([
            'name' => 'MerryTails User',
            'email' => 'user@merrytails.com',
            'password' => Hash::make('MerryTails@User2024!'),
            'is_admin' => false,
        ]);

        $this->command->info('Default users created successfully!');
        $this->command->info('Admin: admin@merrytails.com / MerryTails@Admin2024!');
        $this->command->info('User: user@merrytails.com / MerryTails@User2024!');
    }
}
