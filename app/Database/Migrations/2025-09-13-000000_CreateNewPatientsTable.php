<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNewPatientsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => 191,
                'null' => false,
            ],
            'age' => [
                'type' => 'TINYINT',
                'constraint' => 3,
                'unsigned' => true,
                'null' => true,
            ],
            'gender' => [
                'type' => 'ENUM',
                'constraint' => ['male', 'female', 'other'],
                'null' => true,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
                'null' => true,
            ],
            'primary_condition' => [
                'type' => 'VARCHAR',
                'constraint' => 191,
                'null' => true,
            ],
            'room' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['stable', 'critical', 'admitted', 'discharged', 'emergency'],
                'default' => 'stable',
                'null' => false,
            ],
            'patient_type' => [
                'type' => 'ENUM',
                'constraint' => ['outpatient', 'inpatient'],
                'default' => 'outpatient',
                'null' => false,
            ],
            'last_visit' => [
                'type' => 'DATE',
                'null' => true,
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
        $this->forge->addKey('full_name');
        $this->forge->createTable('new_patients', true);
    }

    public function down()
    {
        $this->forge->dropTable('new_patients', true);
    }
}
