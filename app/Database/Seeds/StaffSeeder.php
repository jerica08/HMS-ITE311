<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run()
    {
        // Check if staff table has data to avoid duplicates
        $db = \Config\Database::connect();
        $count = $db->table('staff')->countAllResults();
        
        if ($count > 0) {
            echo "Staff table already has data. Skipping seeder.\n";
            return;
        }

        $data = [
            [
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'email' => 'sarah.johnson@hospital.com',
                'phone' => '+1-555-0101',
                'department' => 'Cardiology',
                'role' => 'doctor',
                'employee_id' => 'DOC001',
                'status' => 'active',
                'hire_date' => '2023-01-15',
                'notes' => 'Cardiologist with 10+ years experience',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Chen',
                'email' => 'michael.chen@hospital.com',
                'phone' => '+1-555-0102',
                'department' => 'Emergency',
                'role' => 'nurse',
                'employee_id' => 'NUR001',
                'status' => 'active',
                'hire_date' => '2023-03-20',
                'notes' => 'Emergency department head nurse',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'first_name' => 'Emily',
                'last_name' => 'Rodriguez',
                'email' => 'emily.rodriguez@hospital.com',
                'phone' => '+1-555-0103',
                'department' => 'Laboratory',
                'role' => 'laboratorist',
                'employee_id' => 'LAB001',
                'status' => 'active',
                'hire_date' => '2023-02-10',
                'notes' => 'Senior lab technician',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Thompson',
                'email' => 'david.thompson@hospital.com',
                'phone' => '+1-555-0104',
                'department' => 'Pharmacy',
                'role' => 'pharmacist',
                'employee_id' => 'PHR001',
                'status' => 'active',
                'hire_date' => '2023-04-05',
                'notes' => 'Clinical pharmacist',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'first_name' => 'Lisa',
                'last_name' => 'Anderson',
                'email' => 'lisa.anderson@hospital.com',
                'phone' => '+1-555-0105',
                'department' => 'Administration',
                'role' => 'receptionist',
                'employee_id' => 'REC001',
                'status' => 'active',
                'hire_date' => '2023-05-12',
                'notes' => 'Front desk receptionist',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'first_name' => 'James',
                'last_name' => 'Wilson',
                'email' => 'james.wilson@hospital.com',
                'phone' => '+1-555-0106',
                'department' => 'IT Department',
                'role' => 'it_staff',
                'employee_id' => 'IT001',
                'status' => 'active',
                'hire_date' => '2023-06-01',
                'notes' => 'System administrator',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Garcia',
                'email' => 'maria.garcia@hospital.com',
                'phone' => '+1-555-0107',
                'department' => 'Accounting',
                'role' => 'accountant',
                'employee_id' => 'ACC001',
                'status' => 'active',
                'hire_date' => '2023-07-15',
                'notes' => 'Senior accountant',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'first_name' => 'Robert',
                'last_name' => 'Brown',
                'email' => 'robert.brown@hospital.com',
                'phone' => '+1-555-0108',
                'department' => 'Emergency',
                'role' => 'doctor',
                'employee_id' => 'DOC002',
                'status' => 'active',
                'hire_date' => '2023-08-01',
                'notes' => 'Emergency medicine specialist',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'first_name' => 'Jennifer',
                'last_name' => 'Davis',
                'email' => 'jennifer.davis@hospital.com',
                'phone' => '+1-555-0109',
                'department' => 'Cardiology',
                'role' => 'nurse',
                'employee_id' => 'NUR002',
                'status' => 'active',
                'hire_date' => '2023-09-10',
                'notes' => 'Cardiac care nurse',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'first_name' => 'Kevin',
                'last_name' => 'Miller',
                'email' => 'kevin.miller@hospital.com',
                'phone' => '+1-555-0110',
                'department' => 'Laboratory',
                'role' => 'laboratorist',
                'employee_id' => 'LAB002',
                'status' => 'active',
                'hire_date' => '2023-10-05',
                'notes' => 'Lab technician - hematology',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        // Insert the data
        $this->db->table('staff')->insertBatch($data);
        
        echo "Inserted " . count($data) . " staff records successfully.\n";
    }
}
