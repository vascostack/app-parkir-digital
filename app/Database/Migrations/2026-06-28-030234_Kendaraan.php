<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKendaraanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kendaraan' => [
                'type'           => 'INT', 
                'constraint'     => 11, 
                'unsigned'       => true, 
                'auto_increment' => true
            ],
            'id_user' => [
                'type'       => 'INT', 
                'constraint' => 11, 
                'unsigned'   => true,
                'null'       => true, 
            ],
            'no_polisi' => [
                'type'       => 'VARCHAR', 
                'constraint' => 20, 
                'unique'     => true
            ],
            'jenis' => [
                'type'       => 'ENUM', 
                'constraint' => ['mobil', 'motor']
            ],
            'merek' => [
                'type'       => 'VARCHAR', 
                'constraint' => 100
            ],
            'warna' => [
                'type'       => 'VARCHAR', 
                'constraint' => 50
            ],
        ]);
        
        $this->forge->addKey('id_kendaraan', true);
        
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'SET NULL', 'CASCADE');
        
        $this->forge->createTable('kendaraan');
    }

    public function down()
    {
        $this->forge->dropTable('kendaraan');
    }
}