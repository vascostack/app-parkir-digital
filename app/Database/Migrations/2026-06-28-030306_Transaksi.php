<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_transaksi'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_reservasi'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_kendaraan'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_slot'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_petugas'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'waktu_masuk'      => ['type' => 'DATETIME'],
            'waktu_keluar'     => ['type' => 'DATETIME', 'null' => true],
            'durasi'           => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'total_biaya'      => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'status_transaksi' => ['type' => 'ENUM', 'constraint' => ['masuk', 'selesai'], 'default' => 'masuk'],
        ]);
        $this->forge->addKey('id_transaksi', true);
        $this->forge->addForeignKey('id_reservasi', 'reservasi', 'id_reservasi', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_kendaraan', 'kendaraan', 'id_kendaraan', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_slot', 'slot_parkir', 'id_slot', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_petugas', 'users', 'id_user', 'SET NULL', 'CASCADE');
        $this->forge->createTable('transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}