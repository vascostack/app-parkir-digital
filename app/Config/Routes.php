<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');

$routes->group('user', function ($routes) {
    // Akses ke http://localhost:8080/user otomatis ke dashboard
    $routes->get('/', 'UserController::dashboard'); 
    
    // Rute untuk masing-masing halaman sesuai file di folder user
    $routes->get('dashboard', 'UserController::dashboard'); // /user/dashboard
    $routes->get('booking', 'UserController::booking');     // /user/booking
    $routes->get('vehicles', 'UserController::vehicles');   // /user/vehicles
    $routes->get('history', 'UserController::history');     // /user/history
    $routes->get('profile', 'UserController::profile');     // /user/profile

});

// Route untuk Authentication
$routes->get('login', 'Auth::login');
$routes->post('login/attempt', 'Auth::attemptLogin');
$routes->get('register', 'Auth::register');
$routes->post('register/attempt', 'Auth::attemptRegister');
$routes->get('logout', 'Auth::logout');

// Group khusus Admin (Hanya role 'admin' yang bisa lewat)
$routes->group('admin', ['filter' => 'roleFilter:admin'], function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    // Menu kelola data master lokasi, dsb.
});

// Group khusus Petugas (Hanya role 'petugas' yang bisa lewat)
$routes->group('petugas', ['filter' => 'roleFilter:petugas'], function($routes) {
    $routes->get('dashboard', 'Petugas\Dashboard::index');
    // Menu transaksi gate masuk / keluar
});

// Group khusus User/Pengendara (Hanya role 'user' yang bisa lewat)
$routes->group('user', ['filter' => 'roleFilter:user'], function($routes) {
    $routes->get('dashboard', 'User\Dashboard::index'); // Mengarah ke user/dashboard.php Anda
    $routes->get('booking', 'User\Booking::index');     // Mengarah ke user/booking.php Anda
    $routes->get('vehicles', 'User\Vehicles::index');   // Mengarah ke user/vehicles.php Anda
    $routes->get('history', 'User\History::index');     // Mengarah ke user/history.php Anda
    $routes->get('profile', 'User\Profile::index');     // Mengarah ke user/profile.php Anda
});

// 2. Group untuk Petugas (PISAHKAN DI SINI!)
$routes->group('petugas', function ($routes) {
    $routes->get('dashboard', 'Petugas::index');
    $routes->get('masuk', 'Petugas::masuk');
    $routes->post('proses_masuk', 'Petugas::proses_masuk'); // Harus POST
    $routes->get('keluar', 'Petugas::keluar');
    $routes->post('cek_keluar', 'Petugas::cek_keluar');     // Harus POST
    $routes->get('konfirmasi_keluar/(:num)', 'Petugas::konfirmasi_keluar/$1'); // Untuk tombol selesai
    $routes->get('transaksi', 'Petugas::transaksi');
    $routes->post('cek_booking', 'Petugas::cek_booking');
    $routes->post('proses_masuk_langsung', 'Petugas::proses_masuk_langsung');
});
