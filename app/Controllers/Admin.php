<?php

namespace App\Controllers; // Kembali ke namespace utama karena filenya di luar

use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function dashboard()
    {
        $data = [
            'title'                => 'Dashboard Admin',
            'pendapatan_hari_ini'  => 350000,
            'total_masuk_hari_ini' => 84,
            'sedang_parkir'        => 15,
            'slot_tersisa'         => 35,
            'terakhir_keluar'      => [
                ['no_polisi' => 'B 7636 XX', 'jenis' => 'mobil', 'biaya' => 15000, 'waktu' => '19:45'],
                ['no_polisi' => 'B 5636 YY', 'jenis' => 'motor', 'biaya' => 4000, 'waktu' => '19:30'],
            ]
        ];

        return view('admin/dashboard', $data);
    }
}