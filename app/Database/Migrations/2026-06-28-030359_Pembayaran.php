<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePembayaranTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pembayaran'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_reservasi'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'metode_pembayaran' => ['type' => 'ENUM', 'constraint' => ['Tunai', 'QRIS', 'Transfer']],
            'jumlah'            => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'waktu_bayar'       => ['type' => 'DATETIME'],
            'status_pembayaran' => ['type' => 'ENUM', 'constraint' => ['pending', 'berhasil', 'gagal', 'refund'], 'default' => 'pending'],
        ]);
        $this->forge->addKey('id_pembayaran', true);
        $this->forge->addForeignKey('id_reservasi', 'reservasi', 'id_reservasi', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pembayaran');
    }

    public function down()
    {
        $this->forge->dropTable('pembayaran');
    }
}