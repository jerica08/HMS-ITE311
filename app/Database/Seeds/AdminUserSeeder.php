<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Ensure we have a staff record we can link to
        $staff = $db->table('staff')->where('email', 'admin@hospital.com')->get()->getRowArray();

        if (!$staff) {
            // Resolve role_id for Hospital Administrator (optional, helps keep staff consistent)
            $role = $db->table('role')->select('role_id')->where('role_name', 'Hospital Administrator')->get()->getRowArray();
            $adminRoleId = $role['role_id'] ?? null;

            $db->table('staff')->insert([
                'employee_id' => 'EMP001',
                'first_name'  => 'Admin',
                'last_name'   => 'User',
                'gender'      => 'male',
                'dob'         => '1980-01-01',
                'contact_no'  => '1234567890',
                'email'       => 'admin@hospital.com',
                'address'     => 'Hospital Address',
                'department'  => 'Administration',
                'role_id'     => $adminRoleId,
                'date_joined' => date('Y-m-d'),
            ]);

            $staffId = $db->insertID();
        } else {
            $staffId = (int) $staff['staff_id'];
        }

        // Upsert user row linked to that staff
        $user = $db->table('users')->where('username', 'admin')->get()->getRowArray();
        $userData = [
            'staff_id'   => $staffId,
            'email'      => 'admin@hospital.com',
            'first_name' => 'Admin',
            'last_name'  => 'User',
            'username'   => 'admin',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'role'       => 'admin',
            'status'     => 'active',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if ($user) {
            $db->table('users')->where('username', 'admin')->update($userData);
        } else {
            $db->table('users')->insert($userData);
        }
    }
}
