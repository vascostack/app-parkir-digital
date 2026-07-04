<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class BookingPetugas extends BaseController
{
    // 1. MENAMPILKAN HALAMAN MANAGEMENT DAFTAR RESERVASI USER
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Ambil data reservasi dengan join ke users (menggunakan kolom nama saja), slot_parkir, dan kendaraan
        $daftar_booking = $db->table('reservasi')
            ->select('reservasi.*, users.nama as nama_user, slot_parkir.kode_slot, kendaraan.no_polisi, kendaraan.jenis')
            ->join('users', 'users.id_user = reservasi.id_user', 'left')
            ->join('slot_parkir', 'slot_parkir.id_slot = reservasi.id_slot', 'left')
            ->join('kendaraan', 'kendaraan.id_kendaraan = reservasi.id_kendaraan', 'left')
            ->orderBy('reservasi.waktu_kedatangan', 'ASC')
            ->get()->getResultArray();

        $data = [
            'title'          => 'Management Booking User',
            'daftar_booking' => $daftar_booking
        ];

        return view('petugas/booking_masuk', $data);
    }

    // 2. TOMBOL AKSI: VALIDASI CHECK-IN & HITUNG DENDA JIKA TELAT
    public function proses_checkin_manual($id_reservasi)
    {
        $db = \Config\Database::connect();

        $reservasi = $db->table('reservasi')
            ->where('id_reservasi', $id_reservasi)
            ->get()->getRowArray();

        if (!$reservasi) {
            return redirect()->to('/petugas/bookingpetugas')->with('error', 'Data reservasi tidak ditemukan!');
        }

        if ($reservasi['status_reservasi'] === 'check-in') {
            return redirect()->to('/petugas/bookingpetugas')->with('error', 'User ini sudah melakukan check-in sebelumnya.');
        }

        // LOGIKA DENDA KETERLAMBATAN (Bandingkan waktu sekarang dengan waktu_expired)
        $waktu_sekarang = time();
        $waktu_expired  = strtotime($reservasi['waktu_expired']);
        $denda          = 0;
        $pesan_sukses   = 'User berhasil Check-In masuk ke Slot: ' . $reservasi['id_slot'];

        if ($waktu_sekarang > $waktu_expired) {
            $denda = 15000; // Mengatur denda Rp 15.000 jika telat datang
            $pesan_sukses = 'Check-In Berhasil! TAPI USER TERLAMBAT. Kenakan denda parkir sebesar Rp 15.000!';
        }

        $db->transStart();

        // Daftarkan data ke tabel transaksi aktif milik pos petugas
        $db->table('transaksi')->insert([
            'id_reservasi'     => $reservasi['id_reservasi'],
            'id_kendaraan'     => $reservasi['id_kendaraan'],
            'id_slot'          => $reservasi['id_slot'],
            'id_petugas'       => session()->get('id_user') ?? null,
            'waktu_masuk'      => date('Y-m-d H:i:s'),
            'waktu_keluar'     => null,
            'durasi'           => null,
            'total_biaya'      => $denda, // Nominal denda masuk sebagai total biaya awal kendaraan masuk
            'status_transaksi' => 'masuk'
        ]);

        // Perbarui status reservasi user menjadi check-in
        $db->table('reservasi')->where('id_reservasi', $id_reservasi)->update([
            'status_reservasi' => 'check-in',
            'updated_at'       => date('Y-m-d H:i:s')
        ]);

        // Mengunci status slot parkir terkait agar menjadi terisi
        $db->table('slot_parkir')->where('id_slot', $reservasi['id_slot'])->update([
            'status_slot' => 'terisi'
        ]);

        $db->transComplete();

        // Jika terkena denda, lemparkan notifikasi error/warning merah, jika lancar gunakan notifikasi sukses hijau
        if ($denda > 0) {
            return redirect()->to('/petugas/bookingpetugas')->with('error', $pesan_sukses);
        }

        return redirect()->to('/petugas/bookingpetugas')->with('pesan', $pesan_sukses);
    }
}