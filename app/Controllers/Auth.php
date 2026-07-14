<?php

namespace App\Controllers;

use App\Models\UsersModel; 
use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        // Hubungkan ke tabel users
        $this->userModel = new \App\Models\UsersModel();
    }

    public function login()
    {
        // Jika sudah login, tendang ke dashboard masing masing
        if (session()->get('logged_in')) {
            return $this->redirectByRole(session()->get('role'));
        }
        return view('auth/login'); 
    }

    public function attemptLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if ($user) {
            // Cek apakah akun aktif
            if ($user['status'] === 'nonaktif') {
                return redirect()->back()->withInput()->with('error', 'Akun Anda dinonaktifkan. Hubungi admin.');
            }

            // Verifikasi Password bcrypt
            if (password_verify($password, $user['password'])) {
                // Set data session
                $sessionData = [
                    'id_user'   => $user['id_user'],
                    'nama'      => $user['nama'],
                    'email'     => $user['email'],
                    'role'      => $user['role'],
                    'logged_in' => true
                ];
                session()->set($sessionData);

                // redirect sesuai role
                return $this->redirectByRole($user['role']);
            }
        }

        return redirect()->back()->withInput()->with('error', 'Email atau Password salah.');
    }

    public function register()
    {
        if (session()->get('logged_in')) {
            return $this->redirectByRole(session()->get('role'));
        }
        return view('auth/register');
    }

    public function attemptRegister()
    {
        // Validasi input
        $rules = [
            'nama'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'no_hp'    => 'required|numeric|min_length[10]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan data 
        $this->userModel->save([
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'no_hp'    => $this->request->getPost('no_hp'),
            'role'     => 'user',
            'status'   => 'aktif'
        ]);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    // Helper untuk mengarahkan halaman berdasarkan role
    private function redirectByRole($role)
    {
        if ($role === 'admin') {
            return redirect()->to('/admin/dashboard');
        } elseif ($role === 'petugas') {
            return redirect()->to('/petugas/dashboard');
        } else {
            return redirect()->to('/user/dashboard');
        }
    }
}