<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// 1. PINTU UTAMA / LANDING PAGE
$routes->get('/', 'Home::index');

// 2. ROUTE AUTHENTICATION (LOGIN, REGISTER, LOGOUT)
$routes->get('login', 'Auth::login');
$routes->post('login/attempt', 'Auth::attemptLogin');
$routes->get('register', 'Auth::register');
$routes->post('register/attempt', 'Auth::attemptRegister');
$routes->get('logout', 'Auth::logout');

$routes->group('admin', ['filter' => 'roleFilter:admin'], function ($routes) {
    // Ubah bagian kanan ini dari 'Admin\Dashboard::index' menjadi 'Admin::dashboard'
    $routes->get('dashboard', 'Admin::dashboard');
});

// 4. GROUP KHUSUS PETUGAS (Diproteksi Filter Petugas & Mengarah ke Controller Tunggal Petugas)
$routes->group('petugas', ['filter' => 'roleFilter:petugas'], function ($routes) {
    $routes->get('dashboard', 'Petugas::index');
    $routes->get('masuk', 'Petugas::masuk');
    $routes->post('proses_masuk_langsung', 'Petugas::proses_masuk_langsung');
    $routes->post('cek_booking', 'Petugas::cek_booking');

    $routes->get('bookingpetugas', 'BookingPetugas::index');
    $routes->post('bookingpetugas/proses', 'BookingPetugas::proses_checkin');
    $routes->get('bookingpetugas/checkin/(:num)', 'BookingPetugas::proses_checkin_manual/$1');

    $routes->get('keluar', 'Petugas::keluar');
    $routes->post('cek_keluar', 'Petugas::cek_keluar');
    $routes->get('konfirmasi_keluar/(:num)', 'Petugas::konfirmasi_keluar/$1');

    $routes->post('konfirmasi_keluar', 'Petugas::konfirmasi_keluar');
    $routes->get('transaksi', 'Petugas::transaksi');
});

// 5. GROUP KHUSUS USER / PENGENDARA (Sudah Digabung & Rapi)
$routes->group('user', ['filter' => 'roleFilter:user'], function ($routes) {
    // Akses ke http://localhost:8080/user otomatis dilempar ke dashboard
    $routes->get('/', 'User\Dashboard::index');
    $routes->get('dashboard', 'User\Dashboard::index');

    // Fitur Booking Slot (DIUPDATE DAN DITAMBAHKAN DI SINI)
    $routes->get('booking', 'User\Booking::index');
    $routes->post('booking/process', 'User\Booking::process'); // Menggantikan booking/store
    $routes->get('booking/payment/(:num)', 'User\Booking::payment/$1');
    $routes->post('booking/pay-process', 'User\Booking::payProcess');

    // Fitur Kelola Kendaraan
    $routes->get('vehicles', 'User\Vehicles::index');
    $routes->post('vehicles/store', 'User\Vehicles::store');

    $routes->get('history', 'User\History::index');
    $routes->get('profile', 'User\Profile::index');
});
