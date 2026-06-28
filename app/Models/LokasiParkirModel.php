<?php

namespace App\Models;

use CodeIgniter\Model;

class LokasiParkirModel extends Model
{
    protected $table            = 'lokasi_parkir';
    protected $primaryKey       = 'id_lokasi';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['nama_lokasi', 'alamat', 'kapasitas_mobil', 'kapasitas_motor'];
}