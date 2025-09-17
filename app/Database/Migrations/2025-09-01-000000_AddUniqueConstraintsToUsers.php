<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUniqueConstraintsToUsers extends Migration
{
    public function up()
    {
        // Add unique constraint to email column if it doesn't exist
        $result = $this->db->query(
            "SELECT COUNT(*) AS cnt
             FROM INFORMATION_SCHEMA.STATISTICS
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = 'users'
               AND COLUMN_NAME = 'email'
               AND NON_UNIQUE = 0"
        )->getRow();

        if ((int) ($result->cnt ?? 0) === 0) {
            // First, make sure all existing emails are unique (remove duplicates if any)
            $this->db->query("
                DELETE t1 FROM users t1
                INNER JOIN users t2
                WHERE t1.id > t2.id
                  AND t1.email = t2.email
                  AND t1.email IS NOT NULL
                  AND t1.email != ''
            ");

            // Add unique index to email
            $this->db->query("ALTER TABLE users ADD UNIQUE KEY unique_email (email)");
        }
    }

    public function down()
    {
        // Remove unique constraint from email
        $result = $this->db->query(
            "SELECT COUNT(*) AS cnt
             FROM INFORMATION_SCHEMA.STATISTICS
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = 'users'
               AND COLUMN_NAME = 'email'
               AND NON_UNIQUE = 0"
        )->getRow();

        if ((int) ($result->cnt ?? 0) > 0) {
            $this->db->query("ALTER TABLE users DROP INDEX unique_email");
        }
    }
}
