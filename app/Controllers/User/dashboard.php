<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        // Pastikan session user aman
        $id_user = session()->get('id_user');
        $db = \Config\Database::connect();

        // Ambil data kendaraan user untuk ringkasan info widget (jika diperlukan)
        $jumlah_kendaraan = $db->table('kendaraan')->where('id_user', $id_user)->countAllResults();

        // Ambil riwayat reservasi terakhir milik user ini
        $riwayat_reservasi = $db->table('reservasi')
            ->join('slot_parkir', 'slot_parkir.id_slot = reservasi.id_slot')
            ->join('lokasi_parkir', 'lokasi_parkir.id_lokasi = slot_parkir.id_lokasi')
            ->where('reservasi.id_user', $id_user)
            ->orderBy('reservasi.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $data = [
            'title'             => 'Dashboard Pengendara',
            'jumlah_kendaraan'  => $jumlah_kendaraan,
            'reservasi_terakhir'=> $riwayat_reservasi
        ];

        // Arahkan ke file view dashboard milik user kamu
        return view('user/dashboard', $data); 
    }
}