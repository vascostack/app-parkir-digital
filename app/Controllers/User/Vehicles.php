<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class Vehicles extends BaseController
{
    public function index()
    {
        // 1. Ambil id_user yang sedang login dari session
        $id_user = session()->get('id_user');
        $db = \Config\Database::connect();

        // 2. Ambil semua data kendaraan milik user ini dari database
        $dataKendaraan = $db->table('kendaraan')
                            ->where('id_user', $id_user)
                            ->get()
                            ->getResultArray();

        $data = [
            'title'     => 'Kelola Kendaraan Saya',
            'kendaraan' => $dataKendaraan
        ];

        // 3. Panggil view kendaraan milikmu
        return view('user/vehicles', $data);
    }

    public function store()
    {
        // Fungsi ini untuk memproses form tambah kendaraan 
        $id_user = session()->get('id_user');

        $db = \Config\Database::connect();

        $dataInsert = [
            'id_user'    => $id_user,
            'no_polisi'  => strtoupper($this->request->getPost('no_polisi')),
            'merek'      => $this->request->getPost('merek'),
            'jenis'      => $this->request->getPost('jenis'),
        ];

        $db->table('kendaraan')->insert($dataInsert);

        return redirect()->to('/user/vehicles')->with('success', 'Kendaraan baru berhasil ditambahkan!');
    }
}