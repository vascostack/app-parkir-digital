<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Petugas extends BaseController
{
    public function dashboard()
    {
        return view('petugas/dashboard');
    }
}
