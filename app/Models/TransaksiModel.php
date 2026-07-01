<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id_transaksi';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
    'id_reservasi',    // sesuaikan jika di DB namamu id_booking, gunakan id_booking
    'id_kendaraan', 
    'id_slot', 
    'id_petugas', 
    'waktu_masuk', 
    'waktu_keluar', 
    'durasi',          // HARUS ADA, ini yang kita pakai buat hitung waktu
    'total_biaya', 
    'status_transaksi' // HARUS ADA, ini yang kita pakai buat filter dashboard
];
}