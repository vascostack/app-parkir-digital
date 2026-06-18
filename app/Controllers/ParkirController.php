<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KendaraanModel;
use App\Models\TransaksiModel;

class ParkirController extends BaseController
{
    protected $kendaraanModel;
    protected $transaksiModel;

    public function __construct()
    {
        // Inisialisasi model
        $this->kendaraanModel = new KendaraanModel();
        $this->transaksiModel = new TransaksiModel();
    }

    // 1. Menampilkan halaman Parkir Masuk
    public function masuk()
    {
        // Jika proteksi login masih dimatikan untuk testing, biarkan baris ini dikomentari
        // if (!session()->get('username')) {
        //     return redirect()->to('login');
        // }

        return view('parkir/masuk');
    }

    // 2. Memproses data form parkir masuk
    public function proses_masuk()
    {
        $noPolisi = strtoupper($this->request->getPost('no_polisi'));
        $jenis    = $this->request->getPost('jenis');
        
        $idUser   = session()->get('id_user') ?? 1; 

        // Cari tahu apakah kendaraan dengan plat tersebut sudah terdaftar
        $kendaraanAda = $this->kendaraanModel->where('no_polisi', $noPolisi)->first();
        
        if ($kendaraanAda) {
            $idKendaraan = $kendaraanAda['id_kendaraan'];
            
            $cekTransaksi = $this->transaksiModel->where('id_kendaraan', $idKendaraan)
                                                 ->where('waktu_keluar', null)
                                                 ->first();
            if ($cekTransaksi) {
                return redirect()->back()->with('error', 'Kendaraan dengan plat ini sudah berada di dalam area parkir!');
            }
        } else {
            // Jika kendaraan belum pernah masuk sistem, simpan data kendaraan baru
            $this->kendaraanModel->save([
                'id_user'   => $idUser,
                'no_polisi' => $noPolisi,
                'jenis'     => $jenis
            ]);
            
            $idKendaraan = $this->kendaraanModel->insertID();
        }
    
        // SEKARANG SUDAH AMAN: Kita tambahkan id_lokasi dan id_slot default 1 untuk bypass foreign key
        $this->transaksiModel->save([
            'id_user'          => $idUser,       
            'id_kendaraan'     => $idKendaraan,  
            'id_lokasi'        => 1,             // <--- ID lokasi contoh
            'id_slot'          => 1,             // <--- ID slot contoh
            'waktu_masuk'      => date('Y-m-d H:i:s'), 
            'status_transaksi' => 'Masuk'        
        ]);

        return redirect()->to('parkir/masuk')->with('success', 'Data kendaraan ' . $noPolisi . ' berhasil disimpan!');
    }

    // 3. Menampilkan halaman Parkir Keluar dengan Data Realtime (Dropdown & Tabel)
    public function keluar()
    {
        $db = \Config\Database::connect();

        // Mengambil semua data kendaraan yang STATUSNYA MASIH DI DALAM (waktu_keluar masih NULL)
        // Gabungkan table transaksi dan kendaraan menggunakan JOIN
        $data['kendaraan_aktif'] = $db->table('transaksi')
            ->join('kendaraan', 'kendaraan.id_kendaraan = transaksi.id_kendaraan')
            ->where('transaksi.waktu_keluar', null)
            ->get()
            ->getResultArray();

        return view('parkir/keluar', $data);
    }

    // 4. Memproses kendaraan keluar & menghitung biaya otomatis
    public function proses_keluar()
    {
        // Ambil ID Transaksi dari pilihan dropdown halaman keluar atau klik tombol tabel
        $idTransaksi = $this->request->getPost('id_transaksi');

        if (!$idTransaksi) {
            return redirect()->back()->with('error', 'Silakan pilih kendaraan yang akan keluar terlebih dahulu!');
        }

        // Ambil rincian data transaksi dan kendaraannya
        $db = \Config\Database::connect();
        $transaksi = $db->table('transaksi')
            ->join('kendaraan', 'kendaraan.id_kendaraan = transaksi.id_kendaraan')
            ->where('transaksi.id_transaksi', $idTransaksi)
            ->get()
            ->getRowArray();

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Data transaksi tidak ditemukan!');
        }

        // Proses Perhitungan Durasi Parkir
        $waktuMasuk  = new \DateTime($transaksi['waktu_masuk']);
        $waktuKeluar = new \DateTime(date('Y-m-d H:i:s'));
        $selisih     = $waktuMasuk->diff($waktuKeluar);
        
        // Konversi durasi ke total satuan jam (jika baru masuk hitung minimal 1 jam)
        $durasiJam = $selisih->h + ($selisih->days * 24);
        if ($selisih->i > 0 || $durasiJam == 0) { 
            $durasiJam++; // Bulatkan ke atas jika lewat beberapa menit
        }

        // Hitung Total Biaya Berdasarkan Aturan Tarif Jenis Kendaraan
        $totalBiaya = 0;
        if ($transaksi['jenis'] == 'Motor') {
            $totalBiaya = 2000 + (($durasiJam - 1) * 1000);
        } else if ($transaksi['jenis'] == 'Mobil') {
            $totalBiaya = 5000 + (($durasiJam - 1) * 2000);
        }

        // Update record transaksi di database MySQL menggunakan TransaksiModel
        $this->transaksiModel->update($idTransaksi, [
            'waktu_keluar'     => $waktuKeluar->format('Y-m-d H:i:s'),
            'durasi'           => $durasiJam,
            'total_biaya'      => $totalBiaya,
            'status_transaksi' => 'Selesai'
        ]);

        // Kembalikan status slot parkir menjadi 'Kosong' agar bisa dihuni kendaraan lain
        $db->table('slot_parkir')->where('id_slot', $transaksi['id_slot'])->update(['status_slot' => 'Kosong']);

        return redirect()->to('parkir/keluar')->with('success', 'Kendaraan <strong>' . $transaksi['no_polisi'] . '</strong> berhasil checkout!<br>Durasi: ' . $durasiJam . ' Jam.<br><strong>Total Biaya: Rp ' . number_format($totalBiaya, 0, ',', '.') . '</strong>');
    }
}