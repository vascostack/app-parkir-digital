<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi'; 
    protected $primaryKey       = 'id_transaksi'; 
    protected $useAutoIncrement = true;
    
    // Pastikan semua kolom yang mau diisi terdaftar di sini
    protected $allowedFields    = ['id_user', 'id_kendaraan', 'id_lokasi', 'id_slot', 'waktu_masuk', 'waktu_keluar', 'durasi', 'total_biaya', 'metode_pembayaran', 'status_transaksi'];
}