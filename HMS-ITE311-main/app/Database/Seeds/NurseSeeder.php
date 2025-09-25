<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NurseSeeder extends Seeder
{
    public function run()
    {
         $data = [
            [
                'username' => 'nurse',
                'password' => password_hash('nurse123', PASSWORD_DEFAULT),
                'role' => 'nurse',
                'email' => 'nurse123@gmail.com'
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
