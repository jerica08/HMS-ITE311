<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDoctorShiftsTable extends Migration
{
    public function up()
    {
        // Create doctor_shifts table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'doctor_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'shift_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'shift_type' => [
                'type' => 'ENUM',
                'constraint' => ['morning', 'afternoon', 'night', 'custom'],
                'null' => false,
            ],
            'start_time' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'end_time' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'department' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('doctor_id');
        $this->forge->addKey('shift_date');
        $this->forge->addKey('shift_type');
        
        // Create the table
        $this->forge->createTable('doctor_shifts', true);
        
        // Add foreign key constraint
        $this->db->query('ALTER TABLE doctor_shifts ADD CONSTRAINT fk_doctor_shift_user FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE');
    }

    public function down()
    {
        // Drop the table
        $this->forge->dropTable('doctor_shifts', true);
    }
}