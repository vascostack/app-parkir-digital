<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\KendaraanModel;
use App\Models\LokasiParkirModel;
use App\Models\SlotParkirModel;

class Petugas extends BaseController
{
    protected $transaksiModel;
    protected $kendaraanModel;
    protected $lokasiModel;
    protected $slotModel;

    public function __construct()
    {
        // Panggil langsung menggunakan backslash (\) dan namespace lengkapnya
        $this->transaksiModel = new \App\Models\TransaksiModel();
        $this->kendaraanModel = new \App\Models\KendaraanModel(); // <-- Ini akan memaksa PHP mencari file secara presisi
        $this->lokasiModel    = new \App\Models\LokasiParkirModel();
        $this->slotModel      = new \App\Models\SlotParkirModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard Petugas',
        ];
        return view('petugas/dashboard', $data);
    }

    public function masuk()
    {
        $data = [
            'title'  => 'Form Kendaraan Masuk',
            'lokasi' => $this->lokasiModel->findAll(), 
            // SINKRON: Menggunakan status_slot sesuai migration
            'slot'   => $this->slotModel->where('status_slot', 'tersedia')->findAll() 
        ];
        return view('petugas/masuk', $data);
    }

    // FUNGSI 1: Untuk memproses tombol "Cek Status Booking"
    public function cek_booking()
    {
        return redirect()->to('/petugas/masuk')->with('error', 'Fitur cek booking sedang dalam pengembangan!');
    }

    // FUNGSI 2: Untuk memproses tombol "Simpan Data Parkir" (Parkir Langsung)
    public function proses_masuk_langsung()
    {
        $no_polisi = $this->request->getPost('no_polisi');
        $jenis     = $this->request->getPost('jenis');
        $id_slot   = $this->request->getPost('id_slot');

        // Ambil input tambahan dari form (wajib terisi sesuai ERD kendaraan)
        $merek     = $this->request->getPost('merek') ?? '-';
        $warna     = $this->request->getPost('warna') ?? '-';

        // 1. Cek apakah nomor polisi ini sudah pernah terdaftar di tabel kendaraan
        $kendaraan = $this->kendaraanModel->where('no_polisi', $no_polisi)->first();
        
        if (!$kendaraan) {
            // Menyisipkan id_user = 999 (Guest) agar database tidak error constraint
            $this->kendaraanModel->insert([
                'id_user'   => 999, 
                'no_polisi' => strtoupper($no_polisi), // Otomatis jadikan huruf kapital
                'jenis'     => $jenis,
                'merek'     => $merek,
                'warna'     => $warna
            ]);
            $id_kendaraan = $this->kendaraanModel->getInsertID(); // Ambil ID barunya secara presisi
        } else {
            // Jika sudah ada, pakai ID yang lama
            $id_kendaraan = $kendaraan['id_kendaraan'];
        }

        // 2. Simpan ke tabel transaksi (SINKRONISASI field sesuai TransaksiModel)
        $dataTransaksi = [
            'id_booking'        => null,
            'id_kendaraan'      => $id_kendaraan,
            'id_slot'           => $id_slot,
            'id_petugas'        => session()->get('id_user') ?? 2, // Default ke ID 2 jika session simulasi belum terbaca
            'waktu_masuk'       => date('Y-m-d H:i:s'),
            'waktu_keluar'      => null,
            'total_biaya'       => 0,
            'status_pembayaran' => 'belum_bayar' 
        ];
        $this->transaksiModel->insert($dataTransaksi);

        // 3. Update status slot parkir menjadi "terisi" (Kolom: status)
        $this->slotModel->update($id_slot, ['status' => 'terisi']);

        return redirect()->to('/petugas/masuk')->with('success', 'Kendaraan berhasil masuk!');
    }

    public function keluar()
    {
        $data['title'] = 'Form Kendaraan Keluar';
        $data['parkir'] = session()->getFlashdata('data_parkir');
        return view('petugas/keluar', $data);
    }

    // FUNGSI CARI KENDARAAN KELUAR
    public function cek_keluar()
    {
        $no_polisi = $this->request->getPost('no_polisi');

        // JOIN tabel transaksi dengan kendaraan untuk mencari berdasarkan no_polisi
        $data_parkir = $this->transaksiModel
            ->select('transaksi.*, kendaraan.no_polisi, kendaraan.jenis')
            ->join('kendaraan', 'kendaraan.id_kendaraan = transaksi.id_kendaraan')
            ->where('kendaraan.no_polisi', $no_polisi)
            ->where('transaksi.status_pembayaran', 'belum_bayar')
            ->first();

        if ($data_parkir) {
            // --- HITUNG OTOMATIS DURASI & TARIF SEMENTARA UNTUK PREVIEW DI VIEW ---
            $waktu_masuk  = strtotime($data_parkir['waktu_masuk']);
            $waktu_keluar = time(); // Jam sekarang saat dicek petugas
            
            // Hitung selisih jam (pembulatan ke atas menggunakan ceil)
            $selisih_detik = $waktu_keluar - $waktu_masuk;
            $durasi_jam    = ceil($selisih_detik / 3600);
            if ($durasi_jam == 0) $durasi_jam = 1; // Minimal hitung 1 jam

            // Set tarif standar (Misal: mobil 5000/jam, motor 2000/jam)
            $tarif_per_jam = ($data_parkir['jenis'] === 'mobil') ? 5000 : 2000;
            $total_biaya   = $durasi_jam * $tarif_per_jam;

            // Masukkan data kalkulasi ke dalam array agar bisa dibaca di halaman view keluar.php
            $data_parkir['durasi_prediksi']       = $durasi_jam;
            $data_parkir['waktu_keluar_sekarang'] = date('Y-m-d H:i:s', $waktu_keluar);
            $data_parkir['total_biaya_prediksi']  = $total_biaya;

            return redirect()->to('/petugas/keluar')->with('data_parkir', $data_parkir);
        } else {
            return redirect()->to('/petugas/keluar')->with('error', 'Kendaraan tidak ditemukan atau sudah keluar!');
        }
    }

    // FUNGSI SELESAIKAN TRANSAKSI
    public function konfirmasi_keluar($id_transaksi)
    {
        $transaksi = $this->transaksiModel->find($id_transaksi);
        if (!$transaksi) {
            return redirect()->to('/petugas/keluar')->with('error', 'Data transaksi tidak ditemukan!');
        }

        // Ambil data kendaraan untuk tahu jenisnya (hitung ulang untuk validasi final)
        $kendaraan = $this->kendaraanModel->find($transaksi['id_kendaraan']);

        $waktu_masuk  = strtotime($transaksi['waktu_masuk']);
        $waktu_keluar = time();
        
        $selisih_detik = $waktu_keluar - $waktu_masuk;
        $durasi_jam    = ceil($selisih_detik / 3600);
        if ($durasi_jam == 0) $durasi_jam = 1;

        $tarif_per_jam = ($kendaraan['jenis'] === 'mobil') ? 5000 : 2000;
        $total_biaya   = $durasi_jam * $tarif_per_jam;

        // Selesaikan transaksinya ke database
        $dataUpdate = [
            'status_pembayaran' => 'lunas',
            'waktu_keluar'      => date('Y-m-d H:i:s', $waktu_keluar),
            'total_biaya'       => $total_biaya
        ];
        $this->transaksiModel->update($id_transaksi, $dataUpdate);

        // Kosongkan kembali slot parkirnya agar bisa dipakai orang lain (Kolom: status)
        if ($transaksi['id_slot']) {
            $this->slotModel->update($transaksi['id_slot'], ['status' => 'tersedia']);
        }

        return redirect()->to('/petugas/keluar')->with('success', 'Transaksi selesai! Tagihan: Rp ' . number_format($total_biaya, 0, ',', '.'));
    }

    public function transaksi()
    {
        // Tampilkan semua riwayat transaksi beserta no_polisi nya
        $data = [
            'title' => 'Data Transaksi',
            'transaksi' => $this->transaksiModel
                ->select('transaksi.*, kendaraan.no_polisi')
                ->join('kendaraan', 'kendaraan.id_kendaraan = transaksi.id_kendaraan', 'left')
                ->orderBy('waktu_masuk', 'DESC')
                ->findAll()
        ];
        return view('petugas/transaksi', $data);
    }
}