<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\TransaksiModel;

class Admin extends BaseController
{
    protected $userModel;
    protected $transaksiModel;

    public function __construct()
    {
        $this->userModel = new UsersModel();
        $this->transaksiModel = new TransaksiModel();
    }

    public function dashboard()
    {
        $db = \Config\Database::connect();
        $hari_ini = date('Y-m-d');

        $semua_transaksi = $this->transaksiModel->getLaporan('1970-01-01', date('Y-m-d'));

        $pendapatan_hari_ini = 0;
        $total_masuk_hari_ini = 0;
        $sedang_parkir = 0;
        
        $jumlah_mobil = 0;
        $jumlah_motor = 0;

        $tren_7_hari = [];
        for ($i = 6; $i >= 0; $i--) {
            $tgl = date('Y-m-d', strtotime("-$i days"));
            $label_tgl = date('d M', strtotime($tgl)); 
            $tren_7_hari[$tgl] = [
                'label' => $label_tgl,
                'total' => 0
            ];
        }

        foreach ($semua_transaksi as $row) {
            $tgl_masuk = !empty($row['waktu_masuk']) ? date('Y-m-d', strtotime($row['waktu_masuk'])) : '';
            $tgl_keluar = !empty($row['waktu_keluar']) ? date('Y-m-d', strtotime($row['waktu_keluar'])) : '';

            if ($tgl_masuk === $hari_ini) {
                $total_masuk_hari_ini++;
            }

            if (!empty($row['waktu_keluar'])) {
                if ($tgl_keluar === $hari_ini) {
                    $pendapatan_hari_ini += $row['biaya'];
                }

                if (array_key_exists($tgl_keluar, $tren_7_hari)) {
                    $tren_7_hari[$tgl_keluar]['total'] += $row['biaya'];
                }
            } else {
                $sedang_parkir++;
            }

            if (isset($row['jenis'])) {
                if (strtolower($row['jenis']) === 'mobil') {
                    $jumlah_mobil++;
                } elseif (strtolower($row['jenis']) === 'motor') {
                    $jumlah_motor++;
                }
            }
        }

        $label_pendapatan = [];
        $data_pendapatan  = [];
        foreach ($tren_7_hari as $tren) {
            $label_pendapatan[] = $tren['label'];
            $data_pendapatan[]  = $tren['total'];
        }

        $slot_tersisa = $db->table('slot_parkir')->where('status_slot', 'tersedia')->countAllResults();

        $terakhir_keluar = [];
        $counter = 0;
        foreach ($semua_transaksi as $row) {
            if (!empty($row['waktu_keluar'])) {
                $row['waktu'] = date('H:i', strtotime($row['waktu_keluar']));
                $terakhir_keluar[] = $row;
                $counter++;
                if ($counter >= 5) break;
            }
        }

        $data = [
            'title'                 => 'Dashboard Admin',
            'pendapatan_hari_ini'   => $pendapatan_hari_ini,
            'total_masuk_hari_ini'  => $total_masuk_hari_ini,
            'sedang_parkir'         => $sedang_parkir,
            'slot_tersisa'          => $slot_tersisa,
            'terakhir_keluar'       => $terakhir_keluar,
            'chart_revenue_labels'  => json_encode($label_pendapatan),
            'chart_revenue_data'    => json_encode($data_pendapatan),
            'chart_veh_mobil'       => $jumlah_mobil,
            'chart_veh_motor'       => $jumlah_motor,
        ];

        return view('admin/dashboard', $data);
    }

    public function tarif()
    {
        $data = [
            'tarif_mobil' => 10000,
            'tarif_motor' => 5000
        ];

        return view('admin/kelola_tarif', $data);
    }

    // =====================================================================
    // MANAJEMEN PETUGAS (Fungsi disesuaikan dengan struktur URL View)
    // =====================================================================

    // URL: localhost/admin/petugas
    public function petugas()
    {
        $petugas = $this->userModel->whereIn('role', ['admin', 'petugas'])->findAll();

        $total_aktif = $this->userModel->whereIn('role', ['admin', 'petugas'])
            ->where('status', 'aktif')
            ->countAllResults();

        $data = [
            'title'       => 'Manajemen Petugas',
            'petugas'     => $petugas,
            'total_aktif' => $total_aktif
        ];

        return view('admin/kelola_petugas', $data);
    }

    // URL: localhost/admin/petugas/simpan
    // URL: localhost/admin/petugas/simpan
    // UBAH DARI 'simpan' MENJADI 'simpan_petugas'
    public function simpan_petugas()
    {
        $this->userModel->save([
            'nama'        => $this->request->getPost('nama'),
            'email'       => $this->request->getPost('email'),
            'password'    => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'no_hp'       => $this->request->getPost('no_hp'),
            'role'        => $this->request->getPost('role'),
            'status'      => $this->request->getPost('status'),
            'jadwal'      => $this->request->getPost('jadwal'),
            'eic_manager' => $this->request->getPost('eic_manager'),
            'jabatan'     => $this->request->getPost('jabatan'),
        ]);

        session()->setFlashdata('sukses', 'Data petugas berhasil ditambahkan!');
        return redirect()->to('admin/petugas');
    }

    // URL: localhost/admin/petugas/update
    // UBAH DARI 'update' MENJADI 'update_petugas'
    public function update_petugas()
    {
        $id_user = $this->request->getPost('id_user');
        $password_baru = $this->request->getPost('password');

        $dataUpdate = [
            'nama'        => $this->request->getPost('nama'),
            'email'       => $this->request->getPost('email'),
            'no_hp'       => $this->request->getPost('no_hp'),
            'role'        => $this->request->getPost('role'),
            'status'      => $this->request->getPost('status'),
            'jadwal'      => $this->request->getPost('jadwal'),
            'eic_manager' => $this->request->getPost('eic_manager'),
            'jabatan'     => $this->request->getPost('jabatan'),
        ];

        if (!empty($password_baru)) {
            $dataUpdate['password'] = password_hash($password_baru, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id_user, $dataUpdate);

        session()->setFlashdata('sukses', 'Data petugas berhasil diperbarui!');
        return redirect()->to('admin/petugas');
    }

    // URL: localhost/admin/petugas/hapus/(:num)
    // UBAH DARI 'hapus' MENJADI 'hapus_petugas'
    public function hapus_petugas($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata('sukses', 'Data petugas berhasil dihapus!');
        return redirect()->to('admin/petugas');
    }

    // URL: localhost/admin/petugas/update
    public function update()
    {
        $id_user = $this->request->getPost('id_user');
        $password_baru = $this->request->getPost('password');

        $dataUpdate = [
            'nama'        => $this->request->getPost('nama'),
            'email'       => $this->request->getPost('email'),
            'no_hp'       => $this->request->getPost('no_hp'),
            'role'        => $this->request->getPost('role'),
            'status'      => $this->request->getPost('status'),
            'jadwal'      => $this->request->getPost('jadwal'),
            'eic_manager' => $this->request->getPost('eic_manager'),
            'jabatan'     => $this->request->getPost('jabatan'),
        ];

        if (!empty($password_baru)) {
            $dataUpdate['password'] = password_hash($password_baru, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id_user, $dataUpdate);

        session()->setFlashdata('sukses', 'Data petugas berhasil diperbarui!');
        return redirect()->to('admin/petugas');
    }

    // URL: localhost/admin/petugas/hapus/(:num)
    public function hapus($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata('sukses', 'Data petugas berhasil dihapus!');
        return redirect()->to('admin/petugas');
    }

    // =====================================================================
    // LAPORAN KELUAR
    // =====================================================================

    public function laporan()
    {
        $start_date = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-7 days'));
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

        return view('admin/laporan_keluar', $data);
    }

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