<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id_transaksi';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'id_booking', 'id_kendaraan', 'id_slot', 'id_petugas', 
        'waktu_masuk', 'waktu_keluar', 'total_biaya', 'status_pembayaran'
    ];
}