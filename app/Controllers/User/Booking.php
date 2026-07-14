<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Writer\SvgWriter; 

class Booking extends BaseController
{
    // halaman utama booking slot
    public function index()
    {
        $id_user = session()->get('id_user');
        $db = \Config\Database::connect();

        $data = [
            'title'     => 'Booking Slot Parkir',
            'lokasi'    => $db->table('lokasi_parkir')->where('status', 'aktif')->get()->getResultArray(),
            'slot'      => $db->table('slot_parkir')->get()->getResultArray(),
            'kendaraan' => $db->table('kendaraan')->where('id_user', $id_user)->get()->getResultArray()
        ];

        return view('user/booking', $data);
    }

    // form data input booking
    public function process()
    {
        $id_user = session()->get('id_user');

        $id_slot          = $this->request->getPost('id_slot');
        $id_kendaraan     = $this->request->getPost('id_kendaraan');
        $waktu_kedatangan = $this->request->getPost('waktu_masuk');

        $timestamp_kedatangan = strtotime($waktu_kedatangan);
        $waktu_expired        = date('Y-m-d H:i:s', $timestamp_kedatangan + (2 * 3600));

        $db = \Config\Database::connect();
        $biaya_booking = 5000.00;

        $db->transStart();

        // Insert ke tabel RESERVASI
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
            'status_pembayaran' => 'belum_bayar',
            'status_reservasi'  => 'pending'
        ];
        $db->table('reservasi')->insert($dataReservasi);

        // Ambil ID reservasi yang baru saja disimpan
        $id_reservasi = $db->insertID();

        // Update status_slot di tabel slot_parkir 
        $db->table('slot_parkir')->where('id_slot', $id_slot)->update([
            'status_slot' => 'dipesan'
        ]);

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Gagal membuat reservasi.');
        }

        return redirect()->to('/user/booking/payment/' . $id_reservasi);
    }

    public function payment($id_reservasi)
    {
        $db = \Config\Database::connect();

        $reservasi = $db->table('reservasi')
            ->select('reservasi.*, slot_parkir.kode_slot, lokasi_parkir.nama_lokasi')
            ->join('slot_parkir', 'slot_parkir.id_slot = reservasi.id_slot')
            ->join('lokasi_parkir', 'lokasi_parkir.id_lokasi = slot_parkir.id_lokasi')
            ->where('reservasi.id_reservasi', $id_reservasi)
            ->get()
            ->getRowArray();

        if (!$reservasi) {
            return redirect()->to('/user/booking')->with('error', 'Data booking tidak ditemukan.');
        }

        // generete QR
        $qrContent = "PARKIR-DIGITAL-VASCO-" . $reservasi['id_reservasi'] . "-TOTAL-" . $reservasi['biaya_booking'];

        // Pengaturan properti QR 
        $qrCode = new QrCode(
            data: $qrContent,
            size: 250,
            margin: 10,
            foregroundColor: new Color(13, 35, 58),   // Warna Navy andalanmu
            backgroundColor: new Color(255, 255, 255) // Warna Putih background
        );
        
        // Panggil SvgWriter 
        $writer = new SvgWriter();
        
        // Jalankan proses render
        $result = $writer->write($qrCode);

        $data = [
            'reservasi'   => $reservasi,
            'qrCodeImage' => $result->getDataUri() // Formatnya otomatis jadi data:image/svg+xml;base64,...
        ];

        return view('user/payment', $data);
    }

    public function payProcess()
    {
        $id_reservasi = $this->request->getPost('id_reservasi');
        $jumlah       = $this->request->getPost('jumlah');

        $db = \Config\Database::connect();
        $db->transStart();

        $dataPembayaran = [
            'id_reservasi'      => $id_reservasi,
            'metode_pembayaran' => 'QRIS',
            'jumlah'            => $jumlah,
            'waktu_bayar'       => date('Y-m-d H:i:s'),
            'status_pembayaran' => 'berhasil'
        ];
        $db->table('pembayaran')->insert($dataPembayaran);

        $db->table('reservasi')
            ->where('id_reservasi', $id_reservasi)
            ->update([
                'status_pembayaran' => 'lunas',
                'status_reservasi'  => 'dibooking',
                'updated_at'        => date('Y-m-d H:i:s')
            ]);

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Simulasi pembayaran gagal.');
        }

        return redirect()->to('/user/history')->with('success', 'Pembayaran QRIS Berhasil disimulasikan! Slot parkir Anda aktif.');
    }
}