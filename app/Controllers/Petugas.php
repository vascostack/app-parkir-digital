<?php

namespace App\Controllers;

use App\Models\TransaksiModel;

class Petugas extends BaseController
{
    protected $transaksiModel;

    public function __construct()
    {
        // Load model transaksi
        $this->transaksiModel = new TransaksiModel();
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
        $data['title'] = 'Form Kendaraan Masuk';
        return view('petugas/masuk', $data);
    }

    // FUNGSI 1: Untuk memproses tombol "Cek Status Booking"
    public function cek_booking()
    {
        $kode = $this->request->getPost('kode_booking');
        
        // Logikanya: Cari di database reservasi
        // Nanti kalau database sudah ada, ini bisa disesuaikan lagi
        $booking = $this->transaksiModel->where('kode_booking', $kode)->first(); 

        if ($booking) {
            return redirect()->to('/petugas/masuk')->with('success', 'Booking ditemukan!');
        } else {
            return redirect()->to('/petugas/masuk')->with('error', 'Kode Booking tidak valid!');
        }
    }

    // FUNGSI 2: Untuk memproses tombol "Simpan Data Parkir" (Parkir Langsung)
    public function proses_masuk_langsung()
    {
        $data = [
            'no_polisi'        => $this->request->getPost('no_polisi'),
            'jenis_kendaraan'  => $this->request->getPost('jenis'), // Diambil dari select form
            'id_slot'          => $this->request->getPost('id_slot'),
            'waktu_masuk'      => date('Y-m-d H:i:s'),
            'status_transaksi' => 'masuk'
        ];

        $this->transaksiModel->save($data);
        return redirect()->to('/petugas/dashboard')->with('success', 'Kendaraan berhasil masuk!');
    }

    public function keluar()
    {
        $data['title'] = 'Form Kendaraan Keluar';
        // Ambil hasil pencarian dari session jika ada
        $data['parkir'] = session()->getFlashdata('data_parkir');
        return view('petugas/keluar', $data);
    }

    // FUNGSI CARI KENDARAAN KELUAR
    public function cek_keluar()
    {
        $no_polisi = $this->request->getPost('no_polisi');

        $data_parkir = $this->transaksiModel->where('no_polisi', $no_polisi)
                                            ->where('status_transaksi', 'masuk')
                                            ->first();

        if ($data_parkir) {
            return redirect()->to('/petugas/keluar')->with('data_parkir', $data_parkir);
        } else {
            return redirect()->to('/petugas/keluar')->with('error', 'Kendaraan tidak ditemukan atau belum masuk!');
        }
    }

    // FUNGSI SELESAIKAN TRANSAKSI
    public function konfirmasi_keluar($id)
    {
        $data = [
            'status_transaksi' => 'selesai',
            'waktu_keluar'     => date('Y-m-d H:i:s')
        ];

        $this->transaksiModel->update($id, $data);
        return redirect()->to('/petugas/dashboard')->with('success', 'Transaksi selesai!');
    }

    public function transaksi()
    {
        $data = [
            'title' => 'Data Transaksi',
            'transaksi' => $this->transaksiModel->orderBy('waktu_masuk', 'DESC')->findAll()
        ];
        return view('petugas/transaksi', $data);
    }
}