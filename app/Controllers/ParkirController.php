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
            'id_lokasi'        => 1,             // <--- Ditambahkan ID lokasi contoh
            'id_slot'          => 1,             // <--- Ditambahkan ID slot contoh
            'waktu_masuk'      => date('Y-m-d H:i:s'), 
            'status_transaksi' => 'Masuk'        
        ]);

        return redirect()->to('parkir/masuk')->with('success', 'Data kendaraan ' . $noPolisi . ' berhasil disimpan!');
    }
}