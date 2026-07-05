<?php

namespace App\Models;

use CodeIgniter\Model;

class LokasiParkirModel extends Model
{
    protected $table            = 'lokasi_parkir';
    protected $primaryKey       = 'id_lokasi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;
    
    // Disesuaikan persis dengan kolom di database (tanpa id_lokasi karena auto increment)
    protected $allowedFields    = [
        'nama_lokasi', 
        'alamat', 
        'jenis_lokasi', 
        'kapasitas_total', 
        'status'
    ];
}