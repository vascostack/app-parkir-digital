<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Parkir Masuk | Smart Parking</title>

    <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <style>
        /* Custom styling diubah menjadi Biru senada SB Admin 2 */
        .bg-blue-gradient {
            background: linear-gradient(180deg, #4e73df 100%, #224abe 100%);
            color: white;
        }
        .vehicle-select-card {
            cursor: pointer;
            border: 2px solid #eaecf4;
            transition: all 0.2s ease-in-out;
        }
        .vehicle-select-card:hover {
            border-color: #4e73df;
        }
        .vehicle-radio:checked + .vehicle-select-card {
            border-color: #4e73df;
            background-color: #f0f4fd;
        }
    </style>

</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('dashboard') ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-parking"></i>
                </div>
                <div class="sidebar-brand-text mx-3"><?= session('username'); ?></div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('dashboard') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard Petugas</span></a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">Menu Parkir</div>

            <li class="nav-item active">
                <a class="nav-link" href="<?= site_url('parkir/masuk') ?>">
                    <i class="fas fa-fw fa-sign-in-alt"></i>
                    <span>Parkir Masuk</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('parkir/keluar') ?>">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Parkir Keluar</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= session('username'); ?></span>
                                <img class="img-profile rounded-circle" src="<?= base_url('img/undraw_profile.svg') ?>">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="<?= site_url('dashboard') ?>" class="text-primary font-weight-bold text-decoration-none">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
                        </a>
                        <div class="text-muted small">
                            <i class="fas fa-clock mr-1"></i> <?= date('d F Y, H:i') ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Parkir Masuk</h1>
                        <p class="text-muted mb-0">Input data kendaraan yang masuk area parkir</p>
                    </div>

                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-lg-7 mb-4">
                            <form action="<?= site_url('parkir/proses_masuk') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="card shadow border-0">
                                    <div class="card-header bg-blue-gradient py-3">
                                        <h6 class="m-0 font-weight-bold"><i class="fas fa-car mr-2"></i> Form Input Kendaraan</h6>
                                        <small class="text-white-50">Isi data kendaraan dengan lengkap</small>
                                    </div>
                                    <div class="card-body">
                                        
                                        <div class="form-group mb-4">
                                            <label for="no_polisi" class="font-weight-bold text-dark">
                                                <i class="fas fa-id-card mr-1 text-primary"></i> Plat Nomor Kendaraan <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="no_polisi" id="no_polisi" class="form-control form-control-lg text-uppercase font-weight-bold" placeholder="Contoh: B 1234 XYZ" style="letter-spacing: 2px;" required autofocus>
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle mr-1 text-primary"></i> Masukkan plat nomor kendaraan tanpa tanda baca
                                            </small>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label class="font-weight-bold text-dark">
                                                <i class="fas fa-motorcycle mr-1 text-primary"></i> Jenis Kendaraan <span class="text-danger">*</span>
                                            </label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="w-100 m-0">
                                                        <input type="radio" name="jenis" value="Motor" class="vehicle-radio d-none" checked required>
                                                        <div class="card p-3 text-center vehicle-select-card rounded">
                                                            <div class="text-success mb-2">
                                                                <i class="fas fa-motorcycle fa-2x"></i>
                                                            </div>
                                                            <h6 class="font-weight-bold text-dark mb-1">Motor</h6>
                                                            <small class="text-muted d-block">Sepeda motor, skuter, dll</small>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="w-100 m-0">
                                                        <input type="radio" name="jenis" value="Mobil" class="vehicle-radio d-none">
                                                        <div class="card p-3 text-center vehicle-select-card rounded">
                                                            <div class="text-primary mb-2">
                                                                <i class="fas fa-car fa-2x"></i>
                                                            </div>
                                                            <h6 class="font-weight-bold text-dark mb-1">Mobil</h6>
                                                            <small class="text-muted d-block">Mobil penumpang, SUV, MPV</small>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="id_lokasi" class="font-weight-bold text-dark">
                                                    <i class="fas fa-map-marker-alt mr-1 text-primary"></i> Lokasi Parkir <span class="text-danger">*</span>
                                                </label>
                                                <select name="id_lokasi" id="id_lokasi" class="form-control" required>
                                                    <option value="1">Gedung Parkir Utama</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label for="id_slot" class="font-weight-bold text-dark">
                                                    <i class="fas fa-th-large mr-1 text-primary"></i> Kode Slot <span class="text-danger">*</span>
                                                </label>
                                                <select name="id_slot" id="id_slot" class="form-control" required>
                                                    <option value="1">A01 (Lantai 1)</option>
                                                    <option value="2">A02 (Lantai 1)</option>
                                                    <option value="3">B01 (Lantai 2)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between pt-3 border-top">
                                            <button type="submit" class="btn btn-lg btn-primary px-4 font-weight-bold shadow-sm">
                                                <i class="fas fa-save mr-2"></i> Simpan Data Masuk
                                            </button>
                                            <button type="reset" class="btn btn-lg btn-outline-secondary px-4">
                                                <i class="fas fa-undo mr-2"></i> Reset Form
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-5">
                            
                            <div class="card bg-light border-left-primary shadow mb-4">
                                <div class="card-body py-3">
                                    <h6 class="font-weight-bold text-primary mb-3">
                                        <i class="fas fa-exclamation-circle mr-2"></i> Informasi Parkir Masuk
                                    </h6>
                                    <ul class="list-unstyled mb-0 small text-dark" style="line-height: 1.8;">
                                        <li><i class="fas fa-check text-success mr-2"></i> Pastikan plat nomor terbaca dengan jelas</li>
                                        <li><i class="fas fa-check text-success mr-2"></i> Pilih jenis kendaraan sesuai kategori</li>
                                        <li><i class="fas fa-check text-success mr-2"></i> Waktu masuk akan tercatat otomatis</li>
                                        <li class="mt-2 text-danger">
                                            <i class="fas fa-exclamation-triangle mr-2"></i> Kendaraan yang belum keluar tidak bisa masuk lagi.
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <h6 class="font-weight-bold text-dark mb-3">Statistik Hari Ini</h6>
                                    <div class="row text-center">
                                        <div class="col-6 mb-3">
                                            <div class="border rounded p-2 bg-light">
                                                <small class="text-muted d-block font-weight-bold">Total Masuk</small>
                                                <span class="h4 font-weight-bold text-primary">7</span>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="border rounded p-2 bg-light">
                                                <small class="text-muted d-block font-weight-bold">Mobil</small>
                                                <span class="h4 font-weight-bold text-info">3</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="border rounded p-2 bg-light">
                                                <small class="text-muted d-block font-weight-bold">Motor</small>
                                                <span class="h4 font-weight-bold text-success">4</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="border rounded p-2 bg-light">
                                                <small class="text-muted d-block font-weight-bold">Waktu</small>
                                                <span class="h5 font-weight-bold text-dark d-block mt-1"><?= date('H:i') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow mb-4">
                                <div class="card-body p-3">
                                    <h6 class="font-weight-bold text-dark mb-2"><i class="fas fa-bolt text-primary mr-1"></i> Aksi Cepat</h6>
                                    <a href="<?= site_url('dashboard') ?>" class="btn btn-block btn-light text-left border">
                                        <i class="fas fa-tachometer-alt mr-2 text-primary"></i> Dashboard <i class="fas fa-chevron-right float-right mt-1 small text-muted"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; parkir-digital 2026</span>
                    </div>
                </div>
            </footer>
            </div>
        </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-true">
        <div class="modal-content-wrapper">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Pilih "Logout" di bawah jika Anda ingin mengakhiri sesi kerja hari ini.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <a class="btn btn-primary" href="<?= site_url('logout') ?>">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <script src="<?= base_url('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <script src="<?= base_url('js/sb-admin-2.min.js') ?>"></script>

</body>

</html>