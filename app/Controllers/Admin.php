<?php

namespace App\Controllers;

use App\Models\UsersModel; 
use App\Models\TransaksiModel; // 1. TAMBAHKAN INI

class Admin extends BaseController
{
    protected $userModel;
    protected $transaksiModel; // 2. TAMBAHKAN INI

    public function __construct()
    {
        // Inisialisasi model agar bisa digunakan di semua fungsi dalam controller ini
        $this->userModel = new UsersModel();
        $this->transaksiModel = new TransaksiModel(); // 3. TAMBAHKAN INI
    }

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
    

    public function tarif()
    {
        // Data palsu untuk UI (Nanti disesuaikan kalau DB tarif sudah fix)
        $data = [
            'tarif_mobil' => 10000,
            'tarif_motor' => 5000
        ];
        
        return view('admin/kelola_tarif', $data); 
    }

    // =====================================================================
    // FUNGSI UNTUK KELOLA PETUGAS (Sudah terhubung ke DB UsersModel)
    // =====================================================================

    public function petugas()
    {
        // Ambil data selain 'user' biasa (hanya admin & petugas)
        $petugas = $this->userModel->whereIn('role', ['admin', 'petugas'])->findAll();
        
        // Hitung total petugas yang statusnya 'aktif'
        $total_aktif = $this->userModel->whereIn('role', ['admin', 'petugas'])
                                       ->where('status', 'aktif')
                                       ->countAllResults();

        $data = [
            'petugas'     => $petugas,
            'total_aktif' => $total_aktif
        ];
        
        return view('admin/kelola_petugas', $data);
    }

    public function simpan_petugas()
    {
        $this->userModel->save([
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            // Hashing password agar aman di database
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'no_hp'    => $this->request->getPost('no_hp'),
            'role'     => $this->request->getPost('role'),
            'status'   => $this->request->getPost('status')
        ]);

        session()->setFlashdata('sukses', 'Data petugas berhasil ditambahkan!');
        return redirect()->to('admin/petugas');
    }

    public function update_petugas()
    {
        $id_user = $this->request->getPost('id_user');
        $password_baru = $this->request->getPost('password');
        
        $dataUpdate = [
            'nama'   => $this->request->getPost('nama'),
            'email'  => $this->request->getPost('email'),
            'no_hp'  => $this->request->getPost('no_hp'),
            'role'   => $this->request->getPost('role'),
            'status' => $this->request->getPost('status')
        ];

        // Jika password diisi pada modal edit, maka update dan hash password barunya
        if (!empty($password_baru)) {
            $dataUpdate['password'] = password_hash($password_baru, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id_user, $dataUpdate);

        session()->setFlashdata('sukses', 'Data petugas berhasil diperbarui!');
        return redirect()->to('admin/petugas');
    }

    public function hapus_petugas($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata('sukses', 'Data petugas berhasil dihapus!');
        return redirect()->to('admin/petugas');
    }

    // =====================================================================
    // FUNGSI UNTUK LAPORAN KELUAR
    // =====================================================================

    public function laporan()
    {
        // Tangkap inputan tanggal dari form filter (jika kosong, default 7 hari terakhir - hari ini)
        $start_date = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-7 days'));
        $end_date   = $this->request->getGet('end_date') ?? date('Y-m-d');

        // Ambil data dari database menggunakan fungsi getLaporan yang kita buat di Model
        $data_laporan = $this->transaksiModel->getLaporan($start_date, $end_date);
        
        // Hitung total pendapatan dari data yang terfilter
        $total_pendapatan = 0;
        foreach ($data_laporan as $row) {
            $total_pendapatan += $row['biaya'];
        }

        $data = [
            'start_date'       => $start_date,
            'end_date'         => $end_date,
            'total_pendapatan' => $total_pendapatan,
            'data_laporan'     => $data_laporan
        ];

        return view('admin/laporan_keluar', $data);
    }

    // Fungsi baru untuk halaman cetak (membuka tab baru)
    public function cetak_laporan()
    {
        $start_date = $this->request->getGet('start_date') ?? date('Y-m-d');
        $end_date   = $this->request->getGet('end_date') ?? date('Y-m-d');

        $data_laporan = $this->transaksiModel->getLaporan($start_date, $end_date);
        
        $total_pendapatan = 0;
        foreach ($data_laporan as $row) {
            $total_pendapatan += $row['biaya'];
        }

        $data = [
            'start_date'       => $start_date,
            'end_date'         => $end_date,
            'total_pendapatan' => $total_pendapatan,
            'data_laporan'     => $data_laporan
        ];

        return view('admin/cetak_laporan', $data);
    }
}