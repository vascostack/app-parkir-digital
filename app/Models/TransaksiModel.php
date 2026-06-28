<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi'; // Nama tabel di database
    protected $primaryKey = 'id_transaksi'; // Primary Key di tabel

    protected $allowedFields = [
        'id_reservasi', 
        'id_kendaraan', 
        'id_slot', 
        'id_petugas', 
        'waktu_masuk', 
        'waktu_keluar', 
        'durasi', 
        'total_biaya', 
        'status_transaksi'
    ];

    protected $useTimestamps = false; // Set true kalau kamu punya kolom created_at/updated_at
}