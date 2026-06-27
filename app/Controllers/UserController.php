<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    // Menampilkan halaman dashboard.php
    public function dashboard()
    {
        $data = ['title' => 'Dashboard Utama'];
        return view('user/dashboard', $data);
    }

    // Menampilkan halaman booking.php
    public function booking()
    {
        $data = ['title' => 'Booking Parkir'];
        return view('user/booking', $data);
    }

    // Menampilkan halaman vehicles.php
    public function vehicles()
    {
        $data = ['title' => 'Kelola Kendaraan'];
        return view('user/vehicles', $data);
    }

    // Menampilkan halaman history.php
    public function history()
    {
        $data = ['title' => 'Riwayat Reservasi'];
        return view('user/history', $data);
    }

    // Menampilkan halaman profile.php
    public function profile()
    {
        $data = ['title' => 'Profil Saya'];
        return view('user/profile', $data);
    }
}