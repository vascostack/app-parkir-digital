<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReservasiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_reservasi'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_kendaraan'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_slot'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'waktu_booking'    => ['type' => 'DATETIME'],
            'waktu_kedatangan' => ['type' => 'DATETIME'],
            'waktu_expired'    => ['type' => 'DATETIME'],
            'biaya_booking'    => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
            'status_pembayaran'=> ['type' => 'ENUM', 'constraint' => ['belum_bayar', 'lunas', 'refund'], 'default' => 'belum_bayar'],
            'status_reservasi' => ['type' => 'ENUM', 'constraint' => ['pending', 'dibooking', 'check_in', 'selesai', 'batal', 'expired'], 'default' => 'pending'],
        ]);
        $this->forge->addKey('id_reservasi', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kendaraan', 'kendaraan', 'id_kendaraan', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_slot', 'slot_parkir', 'id_slot', 'CASCADE', 'CASCADE');
        $this->forge->createTable('reservasi');
    }

    public function down()
    {
        $this->forge->dropTable('reservasi');
    }
}