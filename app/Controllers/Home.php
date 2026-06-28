<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Kalau user sudah login, langsung alihkan ke dashboard mereka
        if (session()->get('logged_in')) {
            $role = session()->get('role');
            if ($role === 'admin') return redirect()->to('/admin/dashboard');
            if ($role === 'petugas') return redirect()->to('/petugas/dashboard');
            return redirect()->to('/user/dashboard');
        }

        // Kalau belum login, tampilkan landing page
        return view('landing_page');
    }
}