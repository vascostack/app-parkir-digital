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
    
    protected $allowedFields    = [
        'kode_gedung',
        'nama_lokasi',
        'alamat',
        'jenis_lokasi',
        'kapasitas_total',
        'penanggung_jawab',
        'jam_operasional',
        'status'
    ];
}