<?php

namespace App\Models;

use CodeIgniter\Model;

class KendaraanModel extends Model
{
    protected $table            = 'kendaraan';
    protected $primaryKey       = 'id_kendaraan';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id_user', 'no_polisi', 'jenis', 'merek', 'warna'];

    // Opsional: Validasi dasar agar input tidak kosong atau salah tipe
    protected $validationRules = [
        'no_polisi' => 'required|min_length[3]|max_length[15]',
        'jenis'     => 'required|in_list[Motor,Mobil]',
    ];
}