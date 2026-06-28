<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSlotParkirTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_slot'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_lokasi'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'kode_slot'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'jenis_slot'  => ['type' => 'ENUM', 'constraint' => ['mobil', 'motor']],
            'status_slot' => ['type' => 'ENUM', 'constraint' => ['tersedia', 'dipesan', 'terisi', 'maintenance'], 'default' => 'tersedia'],
        ]);
        $this->forge->addKey('id_slot', true);
        $this->forge->addForeignKey('id_lokasi', 'lokasi_parkir', 'id_lokasi', 'CASCADE', 'CASCADE');
        $this->forge->createTable('slot_parkir');
    }

    public function down()
    {
        $this->forge->dropTable('slot_parkir');
    }
}