<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create default admin user for admin panel
        AdminUser::create([
            'name' => 'MerryTails Super Admin',
            'email' => 'merrytails_admin_2024@merrytails.com',
            'password' => Hash::make('MerryTails@Secure#Admin2024'),
            'role' => 'super_admin',
        ]);

        // Create additional admin user
        AdminUser::create([
            'name' => 'MerryTails Manager',
            'email' => 'manager@merrytails.com',
            'password' => Hash::make('MerryTails@Manager2024!'),
            'role' => 'manager',
        ]);

        $this->command->info('Admin users created successfully!');
        $this->command->info('Super Admin: merrytails_admin_2024@merrytails.com / MerryTails@Secure#Admin2024');
        $this->command->info('Manager: manager@merrytails.com / MerryTails@Manager2024!');
    }
}
