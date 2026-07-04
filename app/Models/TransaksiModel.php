<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id_transaksi';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
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

    // ====================================================================
    // TAMBAHAN BARU: Fungsi untuk mengambil data laporan (Filter & Cetak)
    // ====================================================================
    public function getLaporan($start_date, $end_date)
    {
        return $this->select('transaksi.id_transaksi, transaksi.waktu_keluar, transaksi.total_biaya as biaya, kendaraan.no_polisi, kendaraan.jenis, users.nama as nama_petugas')
                    ->join('kendaraan', 'kendaraan.id_kendaraan = transaksi.id_kendaraan', 'left')
                    ->join('users', 'users.id_user = transaksi.id_petugas', 'left') 
                    ->where('transaksi.status_transaksi', 'selesai')
                    ->where('DATE(transaksi.waktu_keluar) >=', $start_date)
                    ->where('DATE(transaksi.waktu_keluar) <=', $end_date)
                    ->orderBy('transaksi.waktu_keluar', 'DESC')
                    ->findAll();
    }
}