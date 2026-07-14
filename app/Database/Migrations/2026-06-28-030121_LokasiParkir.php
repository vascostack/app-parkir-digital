<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLokasiParkirTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_lokasi'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode_gedung'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true], // Tambahan sesuaikan Model
            'nama_lokasi'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'alamat'           => ['type' => 'TEXT'],
            'jenis_lokasi'     => ['type' => 'ENUM', 'constraint' => ['Parkir', 'Penitipan']],
            'kapasitas_total'  => ['type' => 'INT', 'constraint' => 11],
            'penanggung_jawab' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true], // Tambahan sesuaikan Model
            'jam_operasional'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true], // Tambahan sesuaikan Model
            'status'           => ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif'], 'default' => 'aktif'],
        ]);
        $this->forge->addKey('id_lokasi', true);
        $this->forge->createTable('lokasi_parkir');
    }

    public function down()
    {
        $this->forge->dropTable('lokasi_parkir');
    }
}