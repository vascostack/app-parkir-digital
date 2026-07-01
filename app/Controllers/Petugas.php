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
        $this->transaksiModel = new \App\Models\TransaksiModel();
        $this->kendaraanModel = new \App\Models\KendaraanModel(); 
        $this->lokasiModel    = new \App\Models\LokasiParkirModel();
        $this->slotModel      = new \App\Models\SlotParkirModel();
    }

    public function index()
    {
        // 1. Hitung Kendaraan di Lokasi (Status masih 'masuk')
        $data['parked_count'] = $this->transaksiModel->where('status_transaksi', 'masuk')->countAllResults();

        // 2. Hitung Total Transaksi Hari Ini (Berdasarkan tanggal hari ini)
        $data['today_transactions'] = $this->transaksiModel->where('DATE(waktu_masuk)', date('Y-m-d'))->countAllResults();

        // 3. Hitung Pendapatan Hari Ini (Status 'selesai' dan tanggal hari ini)
        $today_income = $this->transaksiModel->selectSum('total_biaya')
                                             ->where('status_transaksi', 'selesai')
                                             ->where('DATE(waktu_masuk)', date('Y-m-d'))
                                             ->first();
        $data['today_income'] = $today_income['total_biaya'] ?? 0;

        // 4. Ambil 5 Transaksi Terakhir (Join dengan tabel kendaraan)
        $data['recent_transactions'] = $this->transaksiModel
                                            ->select('transaksi.*, kendaraan.no_polisi')
                                            ->join('kendaraan', 'kendaraan.id_kendaraan = transaksi.id_kendaraan', 'left')
                                            ->orderBy('waktu_masuk', 'DESC')
                                            ->limit(5)
                                            ->findAll();

        $data['title'] = 'Dashboard Petugas';
        return view('petugas/dashboard', $data);
    }

    public function masuk()
    {
        $data = [
            'title'  => 'Form Kendaraan Masuk',
            'lokasi' => $this->lokasiModel->findAll(), 
            'slot'   => $this->slotModel->where('status_slot', 'tersedia')->findAll() 
        ];
        return view('petugas/masuk', $data);
    }

    public function cek_booking()
    {
        return redirect()->to('/petugas/masuk')->with('error', 'Fitur cek booking sedang dalam pengembangan!');
    }

    public function proses_masuk_langsung()
    {
        $no_polisi = $this->request->getPost('no_polisi');
        $jenis     = $this->request->getPost('jenis');
        $id_slot   = $this->request->getPost('id_slot');

        $merek     = $this->request->getPost('merek') ?? '-';
        $warna     = $this->request->getPost('warna') ?? '-';

        $kendaraan = $this->kendaraanModel->where('no_polisi', strtoupper($no_polisi))->first();
        
        if (!$kendaraan) {
            $this->kendaraanModel->insert([
                'id_user'   => null, 
                'no_polisi' => strtoupper($no_polisi), 
                'jenis'     => $jenis,
                'merek'     => $merek,
                'warna'     => $warna
            ]);
            $id_kendaraan = $this->kendaraanModel->getInsertID(); 
        } else {
            $id_kendaraan = $kendaraan['id_kendaraan'];
        }

        $dataTransaksi = [
            'id_reservasi'     => null, 
            'id_kendaraan'     => $id_kendaraan,
            'id_slot'          => $id_slot,
            'id_petugas'       => session()->get('id_user'), 
            'waktu_masuk'      => date('Y-m-d H:i:s'),
            'waktu_keluar'     => null,
            'durasi'           => null,
            'total_biaya'      => 0,
            'status_transaksi' => 'masuk' 
        ];
        $this->transaksiModel->insert($dataTransaksi);

        $this->slotModel->update($id_slot, ['status_slot' => 'terisi']);

        return redirect()->to('/petugas/masuk')->with('pesan', 'Kendaraan berhasil masuk!');
    }

    public function keluar()
{
    $data['kendaraan_parkir'] = $this->transaksiModel
        ->select('transaksi.*, kendaraan.no_polisi, kendaraan.jenis')
        ->join('kendaraan', 'kendaraan.id_kendaraan = transaksi.id_kendaraan')
        ->where('transaksi.status_transaksi', 'masuk')
        ->findAll();

    $data['title'] = 'Form Kendaraan Keluar';
    
    
    return view('petugas/keluar', $data);
}

    public function cek_keluar()
    {
        $no_polisi = $this->request->getPost('no_polisi');

        $data_parkir = $this->transaksiModel
            ->select('transaksi.*, kendaraan.no_polisi, kendaraan.jenis')
            ->join('kendaraan', 'kendaraan.id_kendaraan = transaksi.id_kendaraan')
            ->where('kendaraan.no_polisi', strtoupper($no_polisi))
            ->where('transaksi.status_transaksi', 'masuk') 
            ->first();

        if ($data_parkir) {
            $waktu_masuk  = strtotime($data_parkir['waktu_masuk']);
            $waktu_keluar = time(); 
            
            $selisih_detik = $waktu_keluar - $waktu_masuk;
            $durasi_jam    = ceil($selisih_detik / 3600);
            if ($durasi_jam == 0) $durasi_jam = 1; 

            $tarif_per_jam = ($data_parkir['jenis'] === 'mobil') ? 5000 : 2000;
            $total_biaya   = $durasi_jam * $tarif_per_jam;

            $data_parkir['durasi_prediksi']         = $durasi_jam;
            $data_parkir['waktu_keluar_sekarang'] = date('Y-m-d H:i:s', $waktu_keluar);
            $data_parkir['total_biaya_prediksi']  = $total_biaya;

            return redirect()->to('/petugas/keluar')->with('data_parkir', $data_parkir);
        } else {
            return redirect()->to('/petugas/keluar')->with('error', 'Kendaraan tidak ditemukan atau sudah keluar!');
        }
    }

    public function konfirmasi_keluar()
{
    // Mengambil ID dari form POST, bukan dari parameter URL
    $id_transaksi = $this->request->getPost('id_transaksi');

    // Validasi jika ID tidak dikirim
    if (!$id_transaksi) {
        return redirect()->to('/petugas/keluar')->with('error', 'Data tidak valid!');
    }

    $transaksi = $this->transaksiModel->find($id_transaksi);
    if (!$transaksi) {
        return redirect()->to('/petugas/keluar')->with('error', 'Data transaksi tidak ditemukan!');
    }

    $kendaraan = $this->kendaraanModel->find($transaksi['id_kendaraan']);

    // --- LOGIKA PERHITUNGAN ---
    $waktu_masuk  = strtotime($transaksi['waktu_masuk']);
    $waktu_keluar = time();
    $selisih_detik = $waktu_keluar - $waktu_masuk;
    $durasi_jam    = ceil($selisih_detik / 3600);
    if ($durasi_jam == 0) $durasi_jam = 1;
    $tarif_per_jam = ($kendaraan['jenis'] === 'mobil') ? 5000 : 2000;
    $total_biaya   = $durasi_jam * $tarif_per_jam;

    // --- UPDATE DATABASE ---
    $dataUpdate = [
        'status_transaksi' => 'selesai',
        'waktu_keluar'     => date('Y-m-d H:i:s', $waktu_keluar),
        'durasi'           => $durasi_jam,
        'total_biaya'      => $total_biaya
    ];
    $this->transaksiModel->update($id_transaksi, $dataUpdate);

    if ($transaksi['id_slot']) {
        $this->slotModel->update($transaksi['id_slot'], ['status_slot' => 'tersedia']);
    }

    // --- KIRIM KE VIEW STRUK ---
    $data['transaksi'] = array_merge($transaksi, $dataUpdate);
    $data['no_polisi'] = $kendaraan['no_polisi'];
    $data['jenis']     = $kendaraan['jenis'];

    return view('petugas/struk', $data); 
}
    public function transaksi()
    {
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

    // Fungsi untuk mendukung fitur pencarian otomatis di Select2
    public function search_kendaraan()
    {
        $search = $this->request->getGet('q');
        
        // Ambil data kendaraan berdasarkan pencarian no_polisi
        $kendaraan = $this->kendaraanModel
                         ->like('no_polisi', $search)
                         ->limit(10)
                         ->findAll();
        
        $results = [];
        foreach ($kendaraan as $row) {
            $results[] = [
                'id'   => $row['id_kendaraan'], // ID unik untuk form
                'text' => $row['no_polisi'] . ' (' . $row['jenis'] . ')' // Tampilan di dropdown
            ];
        }
        
        return $this->response->setJSON(['results' => $results]);
    }
}