<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UsersModel();
    }

    public function index()
    {
        // Ambil ID user dari session login 
        $userId = session()->get('id_user') ?? session()->get('id');

        // Jika user ternyata belum login, lempar ke halaman login 
        if (!$userId) {
            return redirect()->to('/login'); 
        }

        // Ambil data user dari database
        $user = $this->userModel->find($userId);

        // Jika data user tidak ketemu di DB, kasih fallback array data kosong 
        if (!$user) {
            $user = [
                'nama'  => 'Pengguna',
                'email' => 'user@mail.com',
                'created_at' => date('Y-m-d H:i:s')
            ];
        }

        $data = [
            'title' => 'Profil Pengguna',
            'user'  => $user
        ];

        return view('user/profile', $data);
    }
}