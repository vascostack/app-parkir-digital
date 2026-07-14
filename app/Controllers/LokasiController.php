<?php

namespace App\Controllers;

use App\Models\LokasiParkirModel;
use App\Models\SlotParkirModel;
use App\Models\UsersModel; 

class LokasiController extends BaseController
{
    protected $lokasiModel;
    protected $slotModel;
    protected $userModel; 

    public function __construct()
    {
        // Inisialisasi model
        $this->lokasiModel = new LokasiParkirModel();
        $this->slotModel   = new SlotParkirModel();
        $this->userModel   = new UsersModel(); 
    }

    public function index()
    {
        $data = [
            'title'        => 'Manajemen Lokasi Parkir',
            'lokasi'       => $this->lokasiModel->findAll(), 
            'list_petugas' => $this->userModel->whereIn('role', ['petugas', 'admin'])->findAll() 
        ];

        return view('admin/kelola_lokasi', $data); 
    }

   // tambah lokasi
    public function store()
    {
        $this->lokasiModel->save([
            'nama_lokasi'     => $this->request->getPost('nama_lokasi'),
            'alamat'          => $this->request->getPost('alamat'),
            'jenis_lokasi'    => $this->request->getPost('jenis_lokasi'),
            'kapasitas_total' => $this->request->getPost('kapasitas_total'),
            'kode_gedung'      => $this->request->getPost('kode_gedung'),
            'penanggung_jawab' => $this->request->getPost('penanggung_jawab'), // Tersimpan otomatis via dropdown
            'jam_operasional'  => $this->request->getPost('jam_operasional'),
            'status'          => 'aktif' // Default status aktif saat baru dibuat
        ]);

        session()->setFlashdata('sukses', 'Lokasi gedung berhasil ditambahkan!');
        return redirect()->to('admin/lokasi');
    }

    // perbarui lokasi
    public function update()
    {
        $id_lokasi = $this->request->getPost('id_lokasi');
        
        $this->lokasiModel->update($id_lokasi, [
            'kode_gedung'      => $this->request->getPost('kode_gedung'), // Ditambahkan agar data terupdate
            'nama_lokasi'     => $this->request->getPost('nama_lokasi'),
            'penanggung_jawab' => $this->request->getPost('penanggung_jawab'), // Ditambahkan agar data terupdate via dropdown
            'jam_operasional'  => $this->request->getPost('jam_operasional'),  // Ditambahkan agar data terupdate
            'alamat'          => $this->request->getPost('alamat'),
            'jenis_lokasi'    => $this->request->getPost('jenis_lokasi'),
            'kapasitas_total' => $this->request->getPost('kapasitas_total'),
            'status'          => $this->request->getPost('status')
        ]);

        session()->setFlashdata('sukses', 'Data lokasi berhasil diperbarui!');
        return redirect()->to('admin/lokasi');
    }

    // ha[us slot]
    public function delete($id_lokasi)
    {
        // Opsional: Cek dulu apakah ada slot di lokasi ini, hapus slotnya juga biar tidak ada data nyangkut (Cascade)
        $this->slotModel->where('id_lokasi', $id_lokasi)->delete();
        
        // Hapus lokasi
        $this->lokasiModel->delete($id_lokasi);
        
        session()->setFlashdata('sukses', 'Lokasi beserta slot di dalamnya berhasil dihapus!');
        return redirect()->to('admin/lokasi');
    }

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

        return view('admin/kelola_slot', $data);
    }

    // nyimpan slot
    public function store_slot()
    {
        $id_lokasi = $this->request->getPost('id_lokasi');
        
        $this->slotModel->save([
            'id_lokasi'   => $id_lokasi,
            'kode_slot'   => $this->request->getPost('kode_slot'),
            'jenis_slot'  => $this->request->getPost('jenis_slot'),
            'status_slot' => 'tersedia' 
        ]);

        session()->setFlashdata('sukses', 'Slot berhasil ditambahkan!');
        // Redirect kembali ke halaman slot milik gedung tersebut
        return redirect()->to('admin/lokasi/slot/' . $id_lokasi);
    }

    // update slot
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

    
    // hapus slot
    public function delete_slot($id_slot, $id_lokasi)
    {
        $this->slotModel->delete($id_slot);
        
        session()->setFlashdata('sukses', 'Slot berhasil dihapus!');
        return redirect()->to('admin/lokasi/slot/' . $id_lokasi);
    }
}