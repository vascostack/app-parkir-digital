<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkir Digital</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<!-- navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">Parkir Digital</a>

        <div class="ms-auto">
            <a href="/login" class="btn btn-light btn-sm me-2">Login</a>
            <a href="/register" class="btn btn-warning btn-sm">Register</a>
        </div>
    </div>
</nav>

<!-- hero -->
<section class="bg-light text-center py-5">
    <div class="container">
        <h1 class="fw-bold">Sistem Informasi Parkir Digital</h1>
        <p class="text-muted mt-2">
            Aplikasi manajemen parkir berbasis web untuk mempermudah pengelolaan kendaraan masuk dan keluar secara real-time.
        </p>

        <div class="mt-4">
            <a href="/login" class="btn btn-primary btn-lg me-2">Mulai Login</a>
            <a href="/register" class="btn btn-outline-primary btn-lg">Buat Akun</a>
        </div>
    </div>
</section>

<!-- fitur -->
<section class="py-5">
    <div class="container">
        <div class="row text-center">

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm p-3">
                    <h5>Manajemen Kendaraan</h5>
                    <p class="text-muted">Catat kendaraan masuk dan keluar secara cepat.</p>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm p-3">
                    <h5>Multi Role User</h5>
                    <p class="text-muted">Admin & Petugas memiliki akses berbeda.</p>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm p-3">
                    <h5>Laporan Otomatis</h5>
                    <p class="text-muted">Cetak laporan parkir dengan mudah.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>