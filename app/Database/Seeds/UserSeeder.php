<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user'   => 999, 
                'nama'      => 'GUEST / NON-MEMBER',
                'email'     => 'guest@primeparking.com',
                'password'  => password_hash('guest123', PASSWORD_BCRYPT),
                'no_hp'     => '0000000000',
                'role'      => 'user',
                'status'    => 'aktif',
            ],
            [
                'id_user'   => 1,
                'nama'      => 'Admin Utama',
                'email'     => 'admin@primeparking.com',
                'password'  => password_hash('admin123', PASSWORD_BCRYPT),
                'no_hp'     => '08123456789',
                'role'      => 'admin',
                'status'    => 'aktif',
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}