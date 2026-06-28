<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
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
