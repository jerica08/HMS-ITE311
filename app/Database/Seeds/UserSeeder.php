<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Admin User
            [
                'username' => 'admin',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'email' => 'admin@hospital.com',
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'phone' => '+1234567890',
                'department' => 'Administration',
                'employee_id' => 'ADM001',
                'status' => 'active',
                'hire_date' => '2024-01-01'
            ],
            
            // Doctor Users
            [
                'username' => 'dr.smith',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'doctor',
                'email' => 'doctor@hospital.com',
                'first_name' => 'John',
                'last_name' => 'Smith',
                'phone' => '+1234567891',
                'department' => 'Cardiology',
                'employee_id' => 'DOC001',
                'status' => 'active',
                'hire_date' => '2024-01-15'
            ],
            [
                'username' => 'dr.johnson',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'doctor',
                'email' => 'doctor2@hospital.com',
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'phone' => '+1234567892',
                'department' => 'Pediatrics',
                'employee_id' => 'DOC002',
                'status' => 'active',
                'hire_date' => '2024-02-01'
            ],
            
            // Accountant Users
            [
                'username' => 'acc.martinez',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'accountant',
                'email' => 'accountant@hospital.com',
                'first_name' => 'Maria',
                'last_name' => 'Martinez',
                'phone' => '+1234567893',
                'department' => 'Finance',
                'employee_id' => 'ACC001',
                'status' => 'active',
                'hire_date' => '2024-01-20'
            ],
            [
                'username' => 'acc.wilson',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'accountant',
                'email' => 'accountant2@hospital.com',
                'first_name' => 'Robert',
                'last_name' => 'Wilson',
                'phone' => '+1234567894',
                'department' => 'Finance',
                'employee_id' => 'ACC002',
                'status' => 'active',
                'hire_date' => '2024-02-15'
            ],
            
            // Nurse Users
            [
                'username' => 'nurse.johnson',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'nurse',
                'email' => 'nurse@hospital.com',
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'phone' => '+1234567803',
                'department' => 'General Ward',
                'employee_id' => 'NUR001',
                'status' => 'active',
                'hire_date' => '2024-01-12'
            ],
            [
                'username' => 'nurse.williams',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'nurse',
                'email' => 'nurse2@hospital.com',
                'first_name' => 'Jennifer',
                'last_name' => 'Williams',
                'phone' => '+1234567804',
                'department' => 'ICU',
                'employee_id' => 'NUR002',
                'status' => 'active',
                'hire_date' => '2024-02-08'
            ],
            
            // Pharmacist Users
            [
                'username' => 'pharm.davis',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'pharmacist',
                'email' => 'pharmacist@hospital.com',
                'first_name' => 'Emily',
                'last_name' => 'Davis',
                'phone' => '+1234567895',
                'department' => 'Pharmacy',
                'employee_id' => 'PHR001',
                'status' => 'active',
                'hire_date' => '2024-01-25'
            ],
            [
                'username' => 'pharm.brown',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'pharmacist',
                'email' => 'pharmacist2@hospital.com',
                'first_name' => 'Michael',
                'last_name' => 'Brown',
                'phone' => '+1234567896',
                'department' => 'Pharmacy',
                'employee_id' => 'PHR002',
                'status' => 'active',
                'hire_date' => '2024-03-01'
            ],
            
            // Laboratory Staff Users
            [
                'username' => 'lab.garcia',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'laboratory_staff',
                'email' => 'laboratory_staff@hospital.com',
                'first_name' => 'Ana',
                'last_name' => 'Garcia',
                'phone' => '+1234567897',
                'department' => 'Laboratory',
                'employee_id' => 'LAB001',
                'status' => 'active',
                'hire_date' => '2024-02-10'
            ],
            [
                'username' => 'lab.taylor',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'laboratory_staff',
                'email' => 'laboratory_staff2@hospital.com',
                'first_name' => 'James',
                'last_name' => 'Taylor',
                'phone' => '+1234567898',
                'department' => 'Laboratory',
                'employee_id' => 'LAB002',
                'status' => 'active',
                'hire_date' => '2024-02-20'
            ],
            
            // IT Staff Users
            [
                'username' => 'it.anderson',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'it_staff',
                'email' => 'it_staff@hospital.com',
                'first_name' => 'David',
                'last_name' => 'Anderson',
                'phone' => '+1234567899',
                'department' => 'Information Technology',
                'employee_id' => 'IT001',
                'status' => 'active',
                'hire_date' => '2024-01-10'
            ],
            [
                'username' => 'it.thomas',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'it_staff',
                'email' => 'it_staff2@hospital.com',
                'first_name' => 'Lisa',
                'last_name' => 'Thomas',
                'phone' => '+1234567800',
                'department' => 'Information Technology',
                'employee_id' => 'IT002',
                'status' => 'active',
                'hire_date' => '2024-03-05'
            ],
            
            // Receptionist Users
            [
                'username' => 'rec.white',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'receptionist',
                'email' => 'receptionist@hospital.com',
                'first_name' => 'Jennifer',
                'last_name' => 'White',
                'phone' => '+1234567801',
                'department' => 'Front Desk',
                'employee_id' => 'REC001',
                'status' => 'active',
                'hire_date' => '2024-01-05'
            ],
            [
                'username' => 'rec.harris',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'role' => 'receptionist',
                'email' => 'receptionist2@hospital.com',
                'first_name' => 'Michelle',
                'last_name' => 'Harris',
                'phone' => '+1234567802',
                'department' => 'Front Desk',
                'employee_id' => 'REC002',
                'status' => 'active',
                'hire_date' => '2024-02-25'
            ]
        ];

        // Clear existing users (optional - remove this line if you want to keep existing data)
        $this->db->table('users')->truncate();
        
        // Insert new users
        $this->db->table('users')->insertBatch($data);
        
        echo "User seeder completed successfully! Created " . count($data) . " users.\n";
    }
}