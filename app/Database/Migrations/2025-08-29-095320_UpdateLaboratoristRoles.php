<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateLaboratoristRoles extends Migration
{
    public function up()
    {
        // Update existing laboratory staff to have 'laboratorist' role
        $this->db->query("UPDATE users SET role = 'laboratorist' WHERE department = 'Laboratory' AND (role = '' OR role IS NULL)");
        
        // Check if we need to add a new laboratorist user
        $existingLaboratorist = $this->db->query("SELECT COUNT(*) as count FROM users WHERE role = 'laboratorist'")->getRow();
        
        if ($existingLaboratorist->count == 0) {
            // Add a new laboratorist user if none exist
            $data = [
                'username' => 'lab.rodriguez',
                'password' => password_hash('laboratorist123', PASSWORD_DEFAULT),
                'role' => 'laboratorist',
                'email' => 'laboratorist@hospital.com',
                'first_name' => 'Carlos',
                'last_name' => 'Rodriguez',
                'phone' => '+1234567810',
                'department' => 'Laboratory',
                'employee_id' => 'LAB003',
                'status' => 'active',
                'hire_date' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->db->table('users')->insert($data);
        }
    }

    public function down()
    {
        // Revert laboratorist roles back to empty for laboratory department users
        $this->db->query("UPDATE users SET role = '' WHERE department = 'Laboratory' AND role = 'laboratorist'");
        
        // Remove the added laboratorist user if it was created by this migration
        $this->db->query("DELETE FROM users WHERE username = 'lab.rodriguez' AND employee_id = 'LAB003'");
    }
}
