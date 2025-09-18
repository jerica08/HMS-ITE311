<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStaffIdToUsers extends Migration
{
    public function up()
    {
        // Ensure staff_id column exists on users
        $exists = $this->db->query(
            "SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.COLUMNS\n             WHERE TABLE_SCHEMA = DATABASE()\n             AND TABLE_NAME = 'users'\n             AND COLUMN_NAME = 'staff_id'"
        )->getRow();

        if ((int) ($exists->cnt ?? 0) === 0) {
            $this->forge->addColumn('users', [
                'staff_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                    'after' => 'employee_id'
                ]
            ]);
        }

        // Add FK to staff(id) if staff table exists and FK not yet present
        $staffTableExists = $this->db->query(
            "SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.TABLES\n             WHERE TABLE_SCHEMA = DATABASE()\n             AND TABLE_NAME = 'staff'"
        )->getRow();

        if ((int) ($staffTableExists->cnt ?? 0) > 0) {
            // Check if FK already exists
            $fk = $this->db->query(
                "SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE\n                 WHERE TABLE_SCHEMA = DATABASE()\n                 AND TABLE_NAME = 'users'\n                 AND COLUMN_NAME = 'staff_id'\n                 AND REFERENCED_TABLE_NAME = 'staff'"
            )->getRow();

            if (!$fk) {
                $this->db->query(
                    "ALTER TABLE `users` ADD CONSTRAINT `fk_users_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff`(`id`) ON DELETE SET NULL ON UPDATE CASCADE"
                );
            }
        }
    }

    public function down()
    {
        // Drop FK if exists
        $fk = $this->db->query(
            "SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE\n             WHERE TABLE_SCHEMA = DATABASE()\n             AND TABLE_NAME = 'users'\n             AND COLUMN_NAME = 'staff_id'\n             AND REFERENCED_TABLE_NAME = 'staff'"
        )->getRow();

        if ($fk && isset($fk->CONSTRAINT_NAME)) {
            $this->db->query('ALTER TABLE `users` DROP FOREIGN KEY `'.$fk->CONSTRAINT_NAME.'`');
        }

        // Drop column if exists
        $exists = $this->db->query(
            "SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.COLUMNS\n             WHERE TABLE_SCHEMA = DATABASE()\n             AND TABLE_NAME = 'users'\n             AND COLUMN_NAME = 'staff_id'"
        )->getRow();

        if ((int) ($exists->cnt ?? 0) > 0) {
            $this->forge->dropColumn('users', 'staff_id');
        }
    }
}
