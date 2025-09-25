<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'employee_id' => 'EMP001',
            'first_name'  => 'Admin',
            'last_name'   => 'User',
            'gender'      => 'male',
            'dob'         => '1980-01-01',
            'contact_no'  => '1234567890',
            'email'       => 'admin@hospital.com',
            'address'     => 'Hospital Address',
            'department'  => 'Administration',
            'designation' => 'Administrator',
            'date_joined' => date('Y-m-d'),
        ];

        $this->db->table('staff')->insert($data);
    }
}
