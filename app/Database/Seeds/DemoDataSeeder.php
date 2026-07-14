<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run()
    {

        $user = $this->db->table('users')->orderBy('id_user', 'ASC')->get()->getRowArray();
        $idPetugasDefault = (!empty($user)) ? $user['id_user'] : 1;

        $this->db->query('SET FOREIGN_KEY_CHECKS = 0;');
        $this->db->table('lokasi_parkir')->truncate();
        $this->db->table('slot_parkir')->truncate();
        $this->db->table('kendaraan')->truncate();
        $this->db->table('transaksi')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1;');

        $this->db->table('lokasi_parkir')->insertBatch([
            [
                'id_lokasi'       => 1,
                'nama_lokasi'     => 'Gedung A - Utama',
                'alamat'          => 'Jl. Sudirman No. 1',
                'jenis_lokasi'    => 'Parkir',
                'kapasitas_total' => 20,
                'status'          => 'aktif',
            ],
            [
                'id_lokasi'       => 2,
                'nama_lokasi'     => 'Gedung B - Annex',
                'alamat'          => 'Jl. Thamrin No. 5',
                'jenis_lokasi'    => 'Parkir',
                'kapasitas_total' => 15,
                'status'          => 'aktif',
            ],
        ]);

        $this->db->table('slot_parkir')->insertBatch([
            ['id_slot' => 1, 'id_lokasi' => 1, 'kode_slot' => 'A-01', 'jenis_slot' => 'mobil', 'status_slot' => 'tersedia'],
            ['id_slot' => 2, 'id_lokasi' => 1, 'kode_slot' => 'A-02', 'jenis_slot' => 'mobil', 'status_slot' => 'tersedia'],
            ['id_slot' => 3, 'id_lokasi' => 1, 'kode_slot' => 'A-03', 'jenis_slot' => 'motor', 'status_slot' => 'tersedia'],
            ['id_slot' => 4, 'id_lokasi' => 2, 'kode_slot' => 'B-01', 'jenis_slot' => 'mobil', 'status_slot' => 'tersedia'],
            ['id_slot' => 5, 'id_lokasi' => 2, 'kode_slot' => 'B-02', 'jenis_slot' => 'motor', 'status_slot' => 'tersedia'],
        ]);

        $this->db->table('kendaraan')->insertBatch([
            ['id_kendaraan' => 1, 'id_user' => null, 'no_polisi' => 'B1234ABC', 'jenis' => 'mobil', 'merek' => 'Toyota Avanza', 'warna' => 'Hitam'],
            ['id_kendaraan' => 2, 'id_user' => null, 'no_polisi' => 'B5678DEF', 'jenis' => 'motor', 'merek' => 'Honda Beat', 'warna' => 'Merah'],
            ['id_kendaraan' => 3, 'id_user' => null, 'no_polisi' => 'B9999XYZ', 'jenis' => 'mobil', 'merek' => 'Honda Brio', 'warna' => 'Putih'],
        ]);

        $sekarang = date('Y-m-d H:i:s');
        $kemarin  = date('Y-m-d H:i:s', strtotime('-1 day'));
        $duaHari  = date('Y-m-d H:i:s', strtotime('-2 day'));

        $this->db->table('transaksi')->insertBatch([
            [
                'id_reservasi'     => null,
                'id_kendaraan'     => 1,
                'id_slot'          => 1,
                'id_petugas'       => $idPetugasDefault, // Menggunakan ID dinamis hasil query ke tabel users
                'waktu_masuk'      => $duaHari,
                'waktu_keluar'     => $duaHari,
                'durasi'           => 120,
                'total_biaya'      => 10000,
                'status_transaksi' => 'selesai',
            ],
            [
                'id_reservasi'     => null,
                'id_kendaraan'     => 2,
                'id_slot'          => 3,
                'id_petugas'       => $idPetugasDefault, // Menggunakan ID dinamis hasil query ke tabel users
                'waktu_masuk'      => $kemarin,
                'waktu_keluar'     => $kemarin,
                'durasi'           => 60,
                'total_biaya'      => 5000,
                'status_transaksi' => 'selesai',
            ],
            [
                'id_reservasi'     => null,
                'id_kendaraan'     => 3,
                'id_slot'          => 4,
                'id_petugas'       => $idPetugasDefault, // Menggunakan ID dinamis hasil query ke tabel users
                'waktu_masuk'      => $sekarang,
                'waktu_keluar'     => $sekarang,
                'durasi'           => 90,
                'total_biaya'      => 15000,
                'status_transaksi' => 'selesai',
            ],
        ]);

        echo "Demo data (Gedung, Slot, Kendaraan, Transaksi) berhasil dimasukkan.\n";
    }
}
