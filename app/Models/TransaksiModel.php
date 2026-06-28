<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id_transaksi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_reservasi', 'id_kendaraan', 'id_slot', 'id_petugas', 'waktu_masuk', 'waktu_keluar', 'durasi', 'total_biaya', 'status_transaksi'];
}