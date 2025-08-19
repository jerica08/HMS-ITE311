<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailToUsers extends Migration
{
    public function up()
    {
        // Check if the 'email' column exists; add it if missing
        $result = $this->db->query(
            "SELECT COUNT(*) AS cnt
             FROM INFORMATION_SCHEMA.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = 'users'
               AND COLUMN_NAME = 'email'"
        )->getRow();

        if ((int) ($result->cnt ?? 0) === 0) {
            $fields = [
                'email' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => false,
                    'after'      => 'role',
                ],
            ];

            $this->forge->addColumn('users', $fields);
        }
    }

    public function down()
    {
        // Drop the 'email' column if it exists
        $result = $this->db->query(
            "SELECT COUNT(*) AS cnt
             FROM INFORMATION_SCHEMA.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = 'users'
               AND COLUMN_NAME = 'email'"
        )->getRow();

        if ((int) ($result->cnt ?? 0) > 0) {
            $this->forge->dropColumn('users', 'email');
        }
    }
}


