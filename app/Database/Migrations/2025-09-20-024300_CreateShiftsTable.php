<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateShiftsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'staff_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'shift_type' => [
                'type'       => 'ENUM',
                'constraint' => ['morning', 'afternoon', 'night', 'custom'],
                'default'    => 'morning',
            ],
            'start_time' => [
                'type' => 'TIME',
                'null' => false,
            ],
            'end_time' => [
                'type' => 'TIME',
                'null' => false,
            ],
            'department' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'repeat_weekly' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('staff_id');
        $this->forge->addForeignKey('staff_id', 'staff', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('shifts');
    }

    public function down()
    {
        $this->forge->dropTable('shifts');
    }
}
