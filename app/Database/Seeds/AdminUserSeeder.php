<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Admin users data
        $adminUsers = [
            // Primary System Administrator
            [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'email' => 'admin@hospital.com',
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'phone' => '+1234567890',
                'department' => 'Administration',
                'employee_id' => 'ADM001',
                'status' => 'active',
                'hire_date' => '2024-01-01',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            
           
          
           
        ];

        // Check if admin users already exist to avoid duplicates
        foreach ($adminUsers as $adminUser) {
            $existingUser = $this->db->table('users')
                ->where('username', $adminUser['username'])
                ->orWhere('email', $adminUser['email'])
                ->get()
                ->getRow();

            if (!$existingUser) {
                $this->db->table('users')->insert($adminUser);
                echo "Created admin user: {$adminUser['username']} ({$adminUser['email']})\n";
            } else {
                echo "Admin user already exists: {$adminUser['username']} - skipping\n";
            }
        }

    }
}
