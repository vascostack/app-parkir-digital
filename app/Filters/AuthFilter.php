<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Cek apakah role sesuai dengan argumen di Routes
        if ($arguments) {
            $userRole = session()->get('role');
            // Jika role user tidak ada di dalam daftar argumen yang diizinkan
            if (!in_array($userRole, $arguments)) {
                // Lempar ke halaman dashboard asli mereka masing-masing
                if ($userRole === 'admin') return redirect()->to('/admin/dashboard');
                if ($userRole === 'petugas') return redirect()->to('/petugas/dashboard');
                return redirect()->to('/user/dashboard');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak diperlukan aksi setelah request
    }
}