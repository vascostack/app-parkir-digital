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
        // Load semua model yang dibutuhkan
        $this->transaksiModel = new TransaksiModel();
        $this->kendaraanModel = new KendaraanModel();
        $this->lokasiModel    = new LokasiParkirModel();
        $this->slotModel      = new SlotParkirModel();
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
        // Lempar data lokasi dan slot yang masih tersedia ke halaman masuk.php
        $data = [
            'title'  => 'Form Kendaraan Masuk',
            'lokasi' => $this->lokasiModel->where('status', 'aktif')->findAll(),
            'slot'   => $this->slotModel->where('status_slot', 'tersedia')->findAll()
        ];
        return view('petugas/masuk', $data);
    }

    // FUNGSI 1: Untuk memproses tombol "Cek Status Booking"
    public function cek_booking()
    {
        // (Bisa disesuaikan nanti saat tabel reservasi sudah dibuat halamannya)
        return redirect()->to('/petugas/masuk')->with('error', 'Fitur cek booking sedang dalam pengembangan!');
    }

    // FUNGSI 2: Untuk memproses tombol "Simpan Data Parkir" (Parkir Langsung)
    public function proses_masuk_langsung()
    {
        $no_polisi = $this->request->getPost('no_polisi');
        $jenis     = $this->request->getPost('jenis');
        $id_slot   = $this->request->getPost('id_slot');

        // 1. Cek apakah nomor polisi ini sudah pernah terdaftar di tabel kendaraan
        $kendaraan = $this->kendaraanModel->where('no_polisi', $no_polisi)->first();
        
        if (!$kendaraan) {
            // Jika belum ada, catat sebagai kendaraan baru
            $this->kendaraanModel->insert([
                'no_polisi' => $no_polisi,
                'jenis'     => $jenis,
            ]);
            $id_kendaraan = $this->kendaraanModel->getInsertID(); // Ambil ID barunya
        } else {
            // Jika sudah ada, pakai ID yang lama
            $id_kendaraan = $kendaraan['id_kendaraan'];
        }

        // 2. Simpan ke tabel transaksi
        $dataTransaksi = [
            'id_kendaraan'     => $id_kendaraan,
            'id_slot'          => $id_slot,
            'waktu_masuk'      => date('Y-m-d H:i:s'),
            'status_transaksi' => 'masuk'
        ];
        $this->transaksiModel->insert($dataTransaksi);

        // 3. Update status slot parkir menjadi "terisi"
        $this->slotModel->update($id_slot, ['status_slot' => 'terisi']);

        return redirect()->to('/petugas/dashboard')->with('success', 'Kendaraan berhasil masuk!');
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
            ->where('transaksi.status_transaksi', 'masuk')
            ->first();

        if ($data_parkir) {
            return redirect()->to('/petugas/keluar')->with('data_parkir', $data_parkir);
        } else {
            return redirect()->to('/petugas/keluar')->with('error', 'Kendaraan tidak ditemukan atau belum masuk!');
        }
    }

    // FUNGSI SELESAIKAN TRANSAKSI
    public function konfirmasi_keluar($id_transaksi)
    {
        $transaksi = $this->transaksiModel->find($id_transaksi);

        // Selesaikan transaksinya
        $data = [
            'status_transaksi' => 'selesai',
            'waktu_keluar'     => date('Y-m-d H:i:s')
        ];
        $this->transaksiModel->update($id_transaksi, $data);

        // Kosongkan kembali slot parkirnya agar bisa dipakai orang lain
        if ($transaksi && $transaksi['id_slot']) {
            $this->slotModel->update($transaksi['id_slot'], ['status_slot' => 'tersedia']);
        }

        return redirect()->to('/petugas/dashboard')->with('success', 'Transaksi selesai!');
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