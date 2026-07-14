<?php

namespace App\Models;

use CodeIgniter\Model;

class SlotParkirModel extends Model
{
    protected $table            = 'slot_parkir';
    protected $primaryKey       = 'id_slot';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;
    
    protected $allowedFields    = [
        'id_lokasi', 
        'kode_slot', 
        'jenis_slot', 
        'status_slot'
    ];
}