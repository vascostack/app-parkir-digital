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
        $hari_ini = date('Y-m-d');

        // =====================================================================
        // MEMANFAATKAN STRUKTUR MODEL ASLI (Sama seperti halaman laporan)
        // =====================================================================
        // Ambil semua data transaksi dari fungsi model yang sudah pasti jalan
        $semua_transaksi = $this->transaksiModel->getLaporan('1970-01-01', date('Y-m-d'));

        // Siapkan variabel penampung data metrik
        $pendapatan_hari_ini = 0;
        $total_masuk_hari_ini = 0;
        $sedang_parkir = 0;
        
        $jumlah_mobil = 0;
        $jumlah_motor = 0;

        // Array pembantu hitung tren pendapatan 7 hari terakhir
        $tren_7_hari = [];
        for ($i = 6; $i >= 0; $i--) {
            $tgl = date('Y-m-d', strtotime("-$i days"));
            $label_tgl = date('d %b', strtotime($tgl)); // Untuk format label chart
            
            // Format fallback penamaan lokal jika diperlukan
            $label_tgl = date('d M', strtotime($tgl)); 
            $tren_7_hari[$tgl] = [
                'label' => $label_tgl,
                'total' => 0
            ];
        }

        // Proses data real menggunakan PHP agar terhindar dari Error "Unknown Column"
        foreach ($semua_transaksi as $row) {
            // Ambil info tanggal dari waktu_masuk atau waktu_keluar
            $tgl_masuk = !empty($row['waktu_masuk']) ? date('Y-m-d', strtotime($row['waktu_masuk'])) : '';
            $tgl_keluar = !empty($row['waktu_keluar']) ? date('Y-m-d', strtotime($row['waktu_keluar'])) : '';

            // 1. Hitung Kendaraan Masuk Hari Ini
            if ($tgl_masuk === $hari_ini) {
                $total_masuk_hari_ini++;
            }

            // 2. Hitung Pendapatan & Data Tren Hari Ini (Hanya jika sudah keluar)
            if (!empty($row['waktu_keluar'])) {
                if ($tgl_keluar === $hari_ini) {
                    $pendapatan_hari_ini += $row['biaya'];
                }

                // Masukkan ke data tren jika masuk dalam rentang 7 hari terakhir
                if (array_key_exists($tgl_keluar, $tren_7_hari)) {
                    $tren_7_hari[$tgl_keluar]['total'] += $row['biaya'];
                }
            } else {
                // Jika waktu_keluar kosong/null berarti sedang parkir
                $sedang_parkir++;
            }

            // 3. Hitung Rasio Jenis Kendaraan
            if (isset($row['jenis'])) {
                if (strtolower($row['jenis']) === 'mobil') {
                    $jumlah_mobil++;
                } elseif (strtolower($row['jenis']) === 'motor') {
                    $jumlah_motor++;
                }
            }
        }

        // Pecah hasil tren 7 hari untuk kebutuhan Chart.js
        $label_pendapatan = [];
        $data_pendapatan  = [];
        foreach ($tren_7_hari as $tren) {
            $label_pendapatan[] = $tren['label'];
            $data_pendapatan[]  = $tren['total'];
        }

        // Slot kosong yang tersisa dari tabel slot_parkir (Query ini aman karena tidak pakai kolom biaya)
        $slot_tersisa = $db->table('slot_parkir')->where('status_slot', 'tersedia')->countAllResults();

        // 5 Transaksi terakhir keluar menggunakan data array dari model yang sudah diurutkan kelat
        $terakhir_keluar = [];
        $counter = 0;
        foreach ($semua_transaksi as $row) {
            if (!empty($row['waktu_keluar'])) {
                // Samakan format waktu seperti view: Jam:Menit (H:i)
                $row['waktu'] = date('H:i', strtotime($row['waktu_keluar']));
                $terakhir_keluar[] = $row;
                $counter++;
                if ($counter >= 5) break; // Ambil 5 data saja
            }
        }

        // =====================================================================
        // 4. SUSUNAN DATA (Variabel Persis Sama dengan Buatan Temen Lu)
        // =====================================================================
        $data = [
            'title'                 => 'Dashboard Admin',
            'pendapatan_hari_ini'   => $pendapatan_hari_ini,
            'total_masuk_hari_ini'  => $total_masuk_hari_ini,
            'sedang_parkir'         => $sedang_parkir,
            'slot_tersisa'          => $slot_tersisa,
            'terakhir_keluar'       => $terakhir_keluar,

            // Di-encode json di sini agar JavaScript di view langsung bisa baca tanpa error script
            'chart_revenue_labels'  => json_encode($label_pendapatan),
            'chart_revenue_data'    => json_encode($data_pendapatan),
            'chart_veh_mobil'       => $jumlah_mobil,
            'chart_veh_motor'       => $jumlah_motor,
        ];

        return view('admin/dashboard', $data);
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