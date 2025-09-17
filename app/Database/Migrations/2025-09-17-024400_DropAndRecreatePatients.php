<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropAndRecreatePatients extends Migration
{
    public function up()
    {
        // Drop the existing patients table if it exists
        if ($this->db->tableExists('patients')) {
            $this->forge->dropTable('patients');
        }

        // Create new patients table with improved structure
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'patient_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'middle_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'date_of_birth' => [
                'type' => 'DATE',
            ],
            'age' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
            ],
            'gender' => [
                'type'       => 'ENUM',
                'constraint' => ['Male', 'Female', 'Other'],
            ],
            'civil_status' => [
                'type'       => 'ENUM',
                'constraint' => ['Single', 'Married', 'Divorced', 'Widowed', 'Separated'],
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'address' => [
                'type' => 'TEXT',
            ],
            'province' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'city' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'barangay' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'zip_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
            ],
            'insurance_provider' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'insurance_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'emergency_contact_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'emergency_contact_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
            ],
            'emergency_contact_relationship' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'medical_notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'allergies' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'blood_type' => [
                'type'       => 'ENUM',
                'constraint' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Active', 'Inactive', 'Discharged'],
                'default'    => 'Active',
            ],
            'patient_type' => [
                'type'       => 'ENUM',
                'constraint' => ['Inpatient', 'Outpatient', 'Emergency'],
                'default'    => 'Outpatient',
            ],
            'registration_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'last_visit' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);

        // Add primary key
        $this->forge->addKey('id', true);
        
        // Add indexes for better performance
        $this->forge->addUniqueKey('patient_id');
        $this->forge->addKey('last_name');
        $this->forge->addKey('phone');
        $this->forge->addKey('email');
        $this->forge->addKey('registration_date');
        $this->forge->addKey('status');

        // Create the table
        $this->forge->createTable('patients');
        
        // Add timestamp fields using raw SQL to avoid MySQL strict mode issues
        $this->db->query("ALTER TABLE patients ADD COLUMN created_at TIMESTAMP NULL DEFAULT NULL");
        $this->db->query("ALTER TABLE patients ADD COLUMN updated_at TIMESTAMP NULL DEFAULT NULL");
    }

    public function down()
    {
        $this->forge->dropTable('patients');
    }
}
