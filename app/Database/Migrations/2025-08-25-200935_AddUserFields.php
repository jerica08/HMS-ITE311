<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserFields extends Migration
{
    public function up()
    {
      
        $fields = [
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'email'
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'first_name'
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'last_name'
            ],
            'department' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'phone'
            ],
            'employee_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'unique' => true,
                'after' => 'department'
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive', 'suspended'],
                'default' => 'active',
                'after' => 'employee_id'
            ],
            'hire_date' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'status'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => 'CURRENT_TIMESTAMP',
                'after' => 'hire_date'
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                'after' => 'created_at'
            ]
        ];

        // Check and add each field if it doesn't exist
        foreach ($fields as $fieldName => $fieldConfig) {
            $result = $this->db->query(
                "SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.COLUMNS 
                 WHERE TABLE_SCHEMA = DATABASE() 
                 AND TABLE_NAME = 'users' 
                 AND COLUMN_NAME = '{$fieldName}'"
            )->getRow();

            if ((int) ($result->cnt ?? 0) === 0) {
                $this->forge->addColumn('users', [$fieldName => $fieldConfig]);
            }
        }
    }

    public function down()
    {
        // Drop added columns
        $columnsToRemove = [
            'updated_at', 'created_at', 'hire_date', 'status', 
            'employee_id', 'department', 'phone', 'last_name', 'first_name'
        ];
        
        foreach ($columnsToRemove as $column) {
            $result = $this->db->query(
                "SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.COLUMNS 
                 WHERE TABLE_SCHEMA = DATABASE() 
                 AND TABLE_NAME = 'users' 
                 AND COLUMN_NAME = '{$column}'"
            )->getRow();

            if ((int) ($result->cnt ?? 0) > 0) {
                $this->forge->dropColumn('users', $column);
            }
        }
    }
}
