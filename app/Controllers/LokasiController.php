<?php

namespace App\Controllers;

use App\Models\LokasiParkirModel;
use App\Models\SlotParkirModel;

class LokasiController extends BaseController
{
    protected $lokasiModel;
    protected $slotModel;

    public function __construct()
    {
        // Inisialisasi model
        $this->lokasiModel = new LokasiParkirModel();
        $this->slotModel   = new SlotParkirModel();
    }

    // =====================================================================
    // 1. FUNGSI UNTUK MENAMPILKAN HALAMAN UTAMA LOKASI
    // =====================================================================
    public function index()
    {
        $data = [
            'title'  => 'Manajemen Lokasi Parkir',
            'lokasi' => $this->lokasiModel->findAll() // Menarik semua data dari tabel lokasi_parkir
        ];

        // Memanggil file view kelola_lokasi.php
        return view('admin/kelola_lokasi', $data); 
    }

    // =====================================================================
    // 2. FUNGSI UNTUK MENYIMPAN LOKASI BARU (DARI MODAL TAMBAH)
    // =====================================================================
    public function store()
    {
        $this->lokasiModel->save([
            'nama_lokasi'     => $this->request->getPost('nama_lokasi'),
            'alamat'          => $this->request->getPost('alamat'),
            'jenis_lokasi'    => $this->request->getPost('jenis_lokasi'),
            'kapasitas_total' => $this->request->getPost('kapasitas_total'),
            'status'          => 'aktif' // Default status aktif saat baru dibuat
        ]);

        session()->setFlashdata('sukses', 'Lokasi gedung berhasil ditambahkan!');
        return redirect()->to('admin/lokasi');
    }

    // =====================================================================
    // 3. FUNGSI UNTUK UPDATE LOKASI (DARI MODAL EDIT)
    // =====================================================================
    public function update()
    {
        $id_lokasi = $this->request->getPost('id_lokasi');
        
        $this->lokasiModel->update($id_lokasi, [
            'nama_lokasi'     => $this->request->getPost('nama_lokasi'),
            'alamat'          => $this->request->getPost('alamat'),
            'jenis_lokasi'    => $this->request->getPost('jenis_lokasi'),
            'kapasitas_total' => $this->request->getPost('kapasitas_total'),
            'status'          => $this->request->getPost('status')
        ]);

        session()->setFlashdata('sukses', 'Data lokasi berhasil diperbarui!');
        return redirect()->to('admin/lokasi');
    }

    // =====================================================================
    // 4. FUNGSI UNTUK MENGHAPUS LOKASI
    // =====================================================================
    public function delete($id_lokasi)
    {
        // Opsional: Cek dulu apakah ada slot di lokasi ini, hapus slotnya juga biar tidak ada data nyangkut (Cascade)
        $this->slotModel->where('id_lokasi', $id_lokasi)->delete();
        
        // Hapus lokasi
        $this->lokasiModel->delete($id_lokasi);
        
        session()->setFlashdata('sukses', 'Lokasi beserta slot di dalamnya berhasil dihapus!');
        return redirect()->to('admin/lokasi');
    }

    // =====================================================================
    // 5. FUNGSI UNTUK MASUK KE HALAMAN KELOLA SLOT
    // =====================================================================
    public function slot($id_lokasi)
    {
        // Tarik data gedung spesifik yang diklik
        $lokasi = $this->lokasiModel->find($id_lokasi);
        
        // Tarik semua slot yang dimiliki oleh gedung tersebut
        $slot = $this->slotModel->where('id_lokasi', $id_lokasi)->findAll();

        $data = [
            'title'  => 'Kelola Slot Parkir - ' . $lokasi['nama_lokasi'],
            'lokasi' => $lokasi,
            'slot'   => $slot
        ];

        // Memanggil file view kelola_slot.php
        return view('admin/kelola_slot', $data);
    }

    // =====================================================================
    // 6. FUNGSI UNTUK MENYIMPAN SLOT BARU
    // =====================================================================
    public function store_slot()
    {
        $id_lokasi = $this->request->getPost('id_lokasi');
        
        $this->slotModel->save([
            'id_lokasi'   => $id_lokasi,
            'kode_slot'   => $this->request->getPost('kode_slot'),
            'jenis_slot'  => $this->request->getPost('jenis_slot'),
            'status_slot' => 'tersedia' // Default value saat slot baru dibuat
        ]);

        session()->setFlashdata('sukses', 'Slot berhasil ditambahkan!');
        // Redirect kembali ke halaman slot milik gedung tersebut
        return redirect()->to('admin/lokasi/slot/' . $id_lokasi);
    }

    // =====================================================================
    // 7. FUNGSI UNTUK UPDATE SLOT (DARI MODAL EDIT)
    // =====================================================================
    public function update_slot()
    {
        $id_slot   = $this->request->getPost('id_slot');
        $id_lokasi = $this->request->getPost('id_lokasi');
        
        $this->slotModel->update($id_slot, [
            'kode_slot'   => $this->request->getPost('kode_slot'),
            'jenis_slot'  => $this->request->getPost('jenis_slot'),
            'status_slot' => $this->request->getPost('status_slot')
        ]);

        session()->setFlashdata('sukses', 'Data slot berhasil diperbarui!');
        return redirect()->to('admin/lokasi/slot/' . $id_lokasi);
    }

    // =====================================================================
    // 8. FUNGSI UNTUK MENGHAPUS SLOT
    // =====================================================================
    public function delete_slot($id_slot, $id_lokasi)
    {
        $this->slotModel->delete($id_slot);
        
        session()->setFlashdata('sukses', 'Slot berhasil dihapus!');
        return redirect()->to('admin/lokasi/slot/' . $id_lokasi);
    }
}