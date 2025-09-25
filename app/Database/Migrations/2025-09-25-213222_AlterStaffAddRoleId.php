<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterStaffAddRoleId extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        // Check existing columns
        $fields = $db->getFieldData('staff');
        $fieldNames = array_map(static fn($f) => $f->name, $fields);

        // 1) Add role_id as NULLable first (after department) if it does not exist
        if (!in_array('role_id', $fieldNames, true)) {
            $this->forge->addColumn('staff', [
                'role_id' => [
                    'type' => 'INT',
                    'unsigned' => true,
                    'null' => true,
                    'after' => 'department',
                ],
            ]);
        }

        // 2) Backfill role_id based on existing staff.role enum mapping to role.role_name
        // Make sure role_id is nullable before clean up (in case a previous run made it NOT NULL)
        $this->forge->modifyColumn('staff', [
            'role_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
        ]);
        // Reset all current values to NULL to avoid orphans, then map strictly from role table
        $db->query('UPDATE staff SET role_id = NULL');
        $db->query(<<<'SQL'
            UPDATE staff s
            JOIN role r ON r.role_name = CASE s.role
                WHEN 'admin' THEN 'Hospital Administrator'
                WHEN 'doctor' THEN 'Doctor'
                WHEN 'nurse' THEN 'Nurse'
                WHEN 'receptionist' THEN 'Receptionist'
                WHEN 'laboratorist' THEN 'Laboratory Staff'
                WHEN 'pharmacist' THEN 'Pharmacist'
                WHEN 'accountant' THEN 'Accountant'
                WHEN 'it_staff' THEN 'IT Staff'
                ELSE ''
            END
            SET s.role_id = r.role_id
        SQL);

        // 3) Ensure InnoDB engine on both tables (required for FKs)
        $db->query("ALTER TABLE role ENGINE=InnoDB");
        $db->query("ALTER TABLE staff ENGINE=InnoDB");

        // 4) Add foreign key constraint if not present
        $fkExists = $db->query("SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'staff' AND CONSTRAINT_NAME = 'fk_staff_role'")->getResult();
        if (empty($fkExists)) {
            // Clean up any orphan role_id values that don't exist in role table
            $db->query(<<<'SQL'
                UPDATE staff s
                LEFT JOIN role r ON r.role_id = s.role_id
                SET s.role_id = NULL
                WHERE r.role_id IS NULL AND s.role_id IS NOT NULL
            SQL);
            // Also safeguard: remove zero or invalid values using NOT EXISTS
            $db->query(<<<'SQL'
                UPDATE staff s
                SET s.role_id = NULL
                WHERE s.role_id = 0
                   OR NOT EXISTS (SELECT 1 FROM role r WHERE r.role_id = s.role_id)
            SQL);
            // Ensure index exists on staff(role_id) before adding FK
            $db->query("CREATE INDEX IF NOT EXISTS idx_staff_role_id ON staff(role_id)");

            // CodeIgniter's addForeignKey signature uses onUpdate then onDelete
            // We need ON DELETE RESTRICT, ON UPDATE CASCADE
            $this->forge->addForeignKey('role_id', 'role', 'role_id', 'CASCADE', 'RESTRICT', 'fk_staff_role');
            $this->forge->processIndexes('staff');
        }

        // 5) Enforce NOT NULL once backfilled
        // Verify no NULLs remain before enforcing
        $nulls = $db->query('SELECT COUNT(*) AS cnt FROM staff WHERE role_id IS NULL')->getRow()->cnt ?? 0;
        if ($nulls == 0) {
            $this->forge->modifyColumn('staff', [
                'role_id' => [
                    'type' => 'INT',
                    'unsigned' => true,
                    'null' => false,
                ],
            ]);
        }

        // 6) Drop the old 'designation' column if it exists
        if (in_array('designation', $fieldNames, true)) {
            $this->forge->dropColumn('staff', 'designation');
        }
    }

    public function down()
    {
        // Reverse operations: re-add designation (if missing), drop FK (if exists), drop role_id (if exists)
        $db = \Config\Database::connect();

        $fields = $db->getFieldData('staff');
        $fieldNames = array_map(static fn($f) => $f->name, $fields);

        if (!in_array('designation', $fieldNames, true)) {
            $this->forge->addColumn('staff', [
                'designation' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'after' => 'department',
                ],
            ]);
        }

        // Drop foreign key if exists
        $fkExists = $db->query("SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'staff' AND CONSTRAINT_NAME = 'fk_staff_role'")->getResult();
        if (!empty($fkExists)) {
            $this->forge->dropForeignKey('staff', 'fk_staff_role');
        }

        // Backfill designation from role if desired
        if (in_array('role_id', $fieldNames, true)) {
            $db->query(<<<'SQL'
                UPDATE staff s
                LEFT JOIN role r ON r.role_id = s.role_id
                SET s.designation = r.role_name
            SQL);
        }

        if (in_array('role_id', $fieldNames, true)) {
            $this->forge->dropColumn('staff', 'role_id');
        }
    }
}
