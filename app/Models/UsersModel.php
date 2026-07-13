<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Tambahkan jadwal, eic_manager, dan jabatan di sini agar bisa disimpan ke database
    protected $allowedFields    = ['nama', 'email', 'password', 'no_hp', 'role', 'status', 'jadwal', 'eic_manager', 'jabatan'];
}