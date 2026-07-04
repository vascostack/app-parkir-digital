<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class History extends BaseController
{
    public function index()
    {
        // 1. Ambil id_user yang sedang login dari session
        $id_user = session()->get('id_user');
        $db = \Config\Database::connect();

        // 2. Ambil data riwayat dari tabel reservasi, join lengkap sampai ke kendaraan
        $dataHistory = $db->table('reservasi')
            ->select('reservasi.*, slot_parkir.kode_slot, lokasi_parkir.nama_lokasi, lokasi_parkir.alamat, kendaraan.no_polisi, kendaraan.jenis')
            ->join('slot_parkir', 'slot_parkir.id_slot = reservasi.id_slot', 'left')
            ->join('lokasi_parkir', 'lokasi_parkir.id_lokasi = slot_parkir.id_lokasi', 'left')
            ->join('kendaraan', 'kendaraan.id_kendaraan = reservasi.id_kendaraan', 'left') // <-- FIX: Join kendaraan biar gak kosong
            ->where('reservasi.id_user', $id_user)
            ->orderBy('reservasi.created_at', 'DESC') // Menampilkan yang paling baru di atas
            ->get()
            ->getResultArray();

        $data = [
            'title'   => 'Riwayat Reservasi Parkir',
            'history' => $dataHistory
        ];

        // 3. Panggil view history milik user
        return view('user/history', $data);
    }
}
