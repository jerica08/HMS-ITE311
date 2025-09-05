<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPermissionFields extends Migration
{
    public function up()
    {
        $fields = [
            'read_access' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => false,
                'after' => 'updated_at'
            ],
            'write_access' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => false,
                'after' => 'read_access'
            ],
            'delete_access' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => false,
                'after' => 'write_access'
            ],
            'admin_access' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => false,
                'after' => 'delete_access'
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
        // Drop permission columns
        $columnsToRemove = ['admin_access', 'delete_access', 'write_access', 'read_access'];
        
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
