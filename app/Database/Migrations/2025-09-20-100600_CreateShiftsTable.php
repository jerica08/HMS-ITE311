<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateShiftsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'shift_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'staff_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => false,
                'comment'    => 'Employee ID from users table'
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'Foreign key to users table'
            ],
            'department' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'shift_type' => [
                'type'       => 'ENUM',
                'constraint' => ['morning', 'afternoon', 'evening', 'night', 'on_call', 'double'],
                'null'       => false,
            ],
            'shift_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'start_time' => [
                'type' => 'TIME',
                'null' => false,
            ],
            'end_time' => [
                'type' => 'TIME',
                'null' => false,
            ],
            'duration_hours' => [
                'type'       => 'DECIMAL',
                'constraint' => '4,2',
                'null'       => true,
                'comment'    => 'Calculated shift duration in hours'
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['scheduled', 'confirmed', 'in_progress', 'completed', 'cancelled', 'no_show'],
                'default'    => 'scheduled',
                'null'       => false,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'assigned_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'User ID of who assigned the shift'
            ],
            'location' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
                'comment'    => 'Specific ward, unit, or location'
            ],
            'break_time' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => true,
                'comment'    => 'Break time in minutes'
            ],
            'overtime_hours' => [
                'type'       => 'DECIMAL',
                'constraint' => '4,2',
                'null'       => true,
                'default'    => 0.00,
            ],
        ]);

        // Set primary key
        $this->forge->addKey('shift_id', true);
        
        // Add indexes for better performance
        $this->forge->addKey('staff_id');
        $this->forge->addKey('user_id');
        $this->forge->addKey('shift_date');
        $this->forge->addKey('department');
        $this->forge->addKey('status');
        $this->forge->addKey(['shift_date', 'staff_id']); // Composite index
        
        // Create the table
        $this->forge->createTable('shifts');
        
        // Add timestamp fields using raw SQL to avoid MySQL strict mode issues
        $this->db->query("ALTER TABLE shifts ADD COLUMN created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP");
        $this->db->query("ALTER TABLE shifts ADD COLUMN updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
        
        // Add foreign key constraints
        $this->db->query('ALTER TABLE shifts ADD CONSTRAINT fk_shifts_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE');
        $this->db->query('ALTER TABLE shifts ADD CONSTRAINT fk_shifts_assigned_by FOREIGN KEY (assigned_by) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE');
    }

    public function down()
    {
        // Drop foreign key constraints first
        $this->db->query('ALTER TABLE shifts DROP FOREIGN KEY IF EXISTS fk_shifts_user_id');
        $this->db->query('ALTER TABLE shifts DROP FOREIGN KEY IF EXISTS fk_shifts_assigned_by');
        
        // Drop the table
        $this->forge->dropTable('shifts');
    }
}
