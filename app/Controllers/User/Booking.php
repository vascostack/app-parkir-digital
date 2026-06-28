<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class Booking extends BaseController
{
    public function index()
    {
        $id_user = session()->get('id_user');
        $db = \Config\Database::connect();

        // Kita ambil data sesuai skema database mutlak milikmu
        $data = [
            'title'     => 'Booking Slot Parkir',
            'lokasi'    => $db->table('lokasi_parkir')->where('status', 'aktif')->get()->getResultArray(),
            'slot'      => $db->table('slot_parkir')->get()->getResultArray(),
            'kendaraan' => $db->table('kendaraan')->where('id_user', $id_user)->get()->getResultArray()
        ];

        return view('user/booking', $data);
    }

    public function process()
    {
        $id_user = session()->get('id_user');
        
        // Tangkap data dari form view
        $id_slot          = $this->request->getPost('id_slot');
        $id_kendaraan     = $this->request->getPost('id_kendaraan');
        $waktu_kedatangan = $this->request->getPost('waktu_masuk'); // Diambil dari input datetime-local

        // Hitung waktu expired otomatis (Contoh: 2 jam setelah rencana kedatangan jika tidak datang)
        $timestamp_kedatangan = strtotime($waktu_kedatangan);
        $waktu_expired        = date('Y-m-d H:i:s', $timestamp_kedatangan + (2 * 3600));

        $db = \Config\Database::connect();

        // Ambil nominal atau set tarif flat untuk biaya_booking (Misal kita set flat dulu Rp 5.000 atau sesuaikan)
        $biaya_booking = 5000.00; 

        // 1. Insert ke tabel RESERVASI sesuai skema migration mutlak
        $dataReservasi = [
            'id_user'           => $id_user,
            'id_kendaraan'      => $id_kendaraan,
            'id_slot'           => $id_slot,
            'waktu_booking'     => date('Y-m-d H:i:s'),
            'waktu_kedatangan'  => $waktu_kedatangan,
            'waktu_expired'     => $waktu_expired,
            'biaya_booking'     => $biaya_booking,
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'status_pembayaran' => 'belum_bayar', // Sesuai enum migration
            'status_reservasi'  => 'pending'      // Sesuai enum migration
        ];
        $db->table('reservasi')->insert($dataReservasi);

        // 2. Update status_slot di tabel slot_parkir menjadi 'dipesan' (enum: tersedia, dipesan, terisi, maintenance)
        $db->table('slot_parkir')->where('id_slot', $id_slot)->update([
            'status_slot' => 'dipesan'
        ]);

        return redirect()->to('/user/dashboard')->with('success', 'Reservasi berhasil dibuat! Silakan lakukan pembayaran.');
    }
}