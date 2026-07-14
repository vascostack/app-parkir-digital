<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'email'       => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'password'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'no_hp'       => ['type' => 'VARCHAR', 'constraint' => 20],
            'role'        => ['type' => 'ENUM', 'constraint' => ['admin', 'petugas', 'user']],
            'jadwal'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],

            // --- DUA BARIS TAMBAHAN BARU ---
            'eic_manager' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'jabatan'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],

            'status'      => ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif'], 'default' => 'aktif'],
        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
