<?php

namespace App\Models;

use CodeIgniter\Model;

class KendaraanModel extends Model
{
    protected $table            = 'kendaraan';
    protected $primaryKey       = 'id_kendaraan';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id_user', 'no_polisi', 'jenis', 'merek', 'warna'];
}