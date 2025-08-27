<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
    public function up()
    {
        // Create table only if it doesn't exist
        if (!in_array('users', $this->db->listTables())) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'username' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'unique' => true,
                ],
                'password' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'role' => [
                    'type' => 'ENUM',
                    'constraint' => ['admin', 'doctor', 'nurse', 'receptionist', 'pharmacist', 'laboratorist', 'accountant', 'it_staff'],
                    'default' => 'receptionist',
                ],
                'email' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                ],
            ]);
        
            // Add primary key
            $this->forge->addKey('id', true);
            
            // Create the table
            $this->forge->createTable('users');
        } else {
            // Ensure 'email' column exists
            $result = $this->db->query(
                "SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'email'"
            )->getRow();

            if ((int) ($result->cnt ?? 0) === 0) {
                $this->forge->addColumn('users', [
                    'email' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 100,
                        'null'       => false,
                    ],
                ]);
            }
        }
    }

    public function down()
    {
        if (in_array('users', $this->db->listTables())) {
            $this->forge->dropTable('users');
        }
    }
}
