<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function dashboard()
    {
        $db = \Config\Database::connect();

        // 1. DATA UNTUK CHART PENDAPATAN (Contoh 7 Hari Terakhir)
        // Jalankan query dinamis ke DB kamu, ini adalah struktur array final yang dibutuhkan View:
        $label_pendapatan = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
        $data_pendapatan  = [120000, 150000, 180000, 90000, 210000, 300000, 250000]; // Isi dengan rekap query sum total_biaya

        // 2. DATA UNTUK CHART PERBANDINGAN KENDARAAN (Mobil vs Motor)
        // Hitung total masing-masing jenis kendaraan yang aktif/pernah masuk
        $jumlah_mobil = $db->table('transaksi')->join('kendaraan', 'kendaraan.id_kendaraan = transaksi.id_kendaraan')->where('kendaraan.jenis', 'mobil')->countAllResults() ?? 0;
        $jumlah_motor = $db->table('transaksi')->join('kendaraan', 'kendaraan.id_kendaraan = transaksi.id_kendaraan')->where('kendaraan.jenis', 'motor')->countAllResults() ?? 0;

        // Taruh semua variabel metrik lama kamu di sini...
        $data = [
            'title'                 => 'Dashboard Admin',
            'pendapatan_hari_ini'   => 250000, // sesuaikan dengan query asli kamu
            'total_masuk_hari_ini'  => 42,
            'sedang_parkir'         => 15,
            'slot_tersisa'          => 25,
            'terakhir_keluar'       => [], // query data tabel kamu

            // OPER DATA CHART KE VIEW:
            'chart_revenue_labels'  => json_encode($label_pendapatan),
            'chart_revenue_data'    => json_encode($data_pendapatan),
            'chart_veh_mobil'       => $jumlah_mobil,
            'chart_veh_motor'       => $jumlah_motor,
        ];

        return view('admin/dashboard', $data); // ganti sesuai nama file view admin lu
    }
}
