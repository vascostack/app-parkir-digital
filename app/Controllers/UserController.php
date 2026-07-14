<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    public function dashboard()
    {
        $data = ['title' => 'Dashboard Utama'];
        return view('user/dashboard', $data);
    }

    public function booking()
    {
        $data = ['title' => 'Booking Parkir'];
        return view('user/booking', $data);
    }

    public function vehicles()
    {
        $data = ['title' => 'Kelola Kendaraan'];
        return view('user/vehicles', $data);
    }

    public function history()
    {
        $data = ['title' => 'Riwayat Reservasi'];
        return view('user/history', $data);
    }

    public function profile()
    {
        $data = ['title' => 'Profil Saya'];
        return view('user/profile', $data);
    }
}