<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStaffLinkToUsers extends Migration
{
    public function up()
    {
        // Add staff_id column if not exists and create FK to staff(id)
        $fields = [
            'staff_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id',
            ],
        ];

        // Add columns conditionally
        if (!$this->db->fieldExists('staff_id', 'users')) {
            $this->forge->addColumn('users', $fields);
        }

        // Ensure index exists
        try {
            $this->db->query('ALTER TABLE `users` ADD INDEX `idx_users_staff_id` (`staff_id`)');
        } catch (\Throwable $e) {
            // likely duplicate index, ignore
        }

        // Add foreign key only if it does not already exist
        try {
            $exists = $this->db->query(
                'SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = "users" AND CONSTRAINT_NAME = "fk_users_staff_id"'
            )->getResultArray();
            if (empty($exists)) {
                $this->db->query('ALTER TABLE `users` ADD CONSTRAINT `fk_users_staff_id` FOREIGN KEY (`staff_id`) REFERENCES `staff`(`id`) ON DELETE CASCADE ON UPDATE SET NULL');
            }
        } catch (\Throwable $e) {
            // ignore if not supported or already exists under different name
        }
    }

    public function down()
    {
        // Drop foreign key then column if they exist
        try {
            $this->forge->dropForeignKey('users', 'users_staff_id_foreign');
        } catch (\Throwable $e) {
        }

        if ($this->db->fieldExists('staff_id', 'users')) {
            $this->forge->dropColumn('users', 'staff_id');
        }
    }
}


