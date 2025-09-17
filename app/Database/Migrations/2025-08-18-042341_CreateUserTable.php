<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
    public function up()
    {
        // Create table only if it doesn't exist
       
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
    }
        public function down()
        {

            $this->forge->dropTable('users');
            
        }

}
