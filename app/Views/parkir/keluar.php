<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Parkir Keluar | Smart Parking</title>

    <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <style>
        .bg-blue-gradient {
            background: linear-gradient(180deg, #4e73df 100%, #224abe 100%);
            color: white;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('dashboard') ?>">
                <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-parking"></i></div>
                <div class="sidebar-brand-text mx-3"><?= session('username') ?? 'Petugas'; ?></div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('dashboard') ?>"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard Petugas</span></a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Menu Parkir</div>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('parkir/masuk') ?>"><i class="fas fa-fw fa-sign-in-alt"></i><span>Parkir Masuk</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?= site_url('parkir/keluar') ?>"><i class="fas fa-fw fa-sign-out-alt"></i><span>Parkir Keluar</span></a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"></nav>

                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="<?= site_url('dashboard') ?>" class="text-primary font-weight-bold text-decoration-none"><i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard</a>
                        <div class="text-muted small"><i class="fas fa-clock mr-1"></i> <?= date('d F Y, H:i') ?></div>
                    </div>

                    <div class="mb-4">
                        <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Parkir Keluar</h1>
                        <p class="text-muted mb-0">Proses checkout kendaraan dari area parkir</p>
                    </div>

                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show text-dark" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-lg-8 mb-4">
                            
                            <div class="card shadow border-0 mb-4">
                                <div class="card-header bg-blue-gradient py-3">
                                    <h6 class="m-0 font-weight-bold"><i class="fas fa-car mr-2"></i> Pilih Kendaraan Keluar</h6>
                                    <small class="text-white-50">Pilih kendaraan yang akan keluar dari area parkir</small>
                                </div>
                                <div class="card-body">
                                    <form action="<?= site_url('parkir/proses_keluar') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <div class="form-group mb-4">
                                            <label for="id_transaksi" class="font-weight-bold text-dark"><i class="fas fa-id-card mr-1 text-primary"></i> Plat Nomor Kendaraan *</label>
                                            <select name="id_transaksi" id="id_transaksi" class="form-control form-control-lg font-weight-bold text-primary shadow-sm" required>
                                                <option value="">-- Pilih Kendaraan --</option>
                                                <?php foreach ($kendaraan_aktif as $k) : ?>
                                                    <option value="<?= $k['id_transaksi'] ?>">
                                                        <?= $k['no_polisi'] ?> (<?= $k['jenis'] ?>) - Masuk Jam <?= date('H:i', strtotime($k['waktu_masuk'])) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <small class="form-text text-muted"><i class="fas fa-info-circle text-primary"></i> Hanya menampilkan kendaraan yang saat ini ada di dalam lokasi</small>
                                        </div>
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-primary btn-lg px-4 font-weight-bold mr-2 shadow-sm"><i class="fas fa-sign-out-alt mr-2"></i> Proses Parkir Keluar</button>
                                            <a href="<?= site_url('dashboard') ?>" class="btn btn-lg btn-light border px-4">Batal</a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card shadow border-0">
                                <div class="card-header bg-light border-bottom py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-parking text-primary mr-2"></i> Kendaraan Sedang Parkir</h6>
                                    <span class="badge badge-primary px-3 py-2 font-weight-bold"><?= count($kendaraan_aktif) ?> Kendaraan</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped mb-0 text-dark align-middle">
                                            <thead class="bg-light font-weight-bold">
                                                <tr>
                                                    <th class="border-0 pl-4">Plat Nomor</th>
                                                    <th class="border-0">Jenis</th>
                                                    <th class="border-0">Waktu Masuk</th>
                                                    <th class="border-0 pr-4">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($kendaraan_aktif)) : ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center py-4 text-muted">Tidak ada kendaraan di dalam area parkir.</td>
                                                    </tr>
                                                <?php else : ?>
                                                    <?php foreach ($kendaraan_aktif as $k) : ?>
                                                        <tr>
                                                            <td class="font-weight-bold text-uppercase pl-4" style="letter-spacing: 1px;"><i class="fas fa-id-card-alt text-muted mr-2"></i><?= $k['no_polisi'] ?></td>
                                                            <td>
                                                                <?php if ($k['jenis'] == 'Motor') : ?>
                                                                    <span class="badge badge-success px-2 py-1"><i class="fas fa-motorcycle mr-1"></i> Motor</span>
                                                                <?php else : ?>
                                                                    <span class="badge badge-primary px-2 py-1"><i class="fas fa-car mr-1"></i> Mobil</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><i class="far fa-clock text-muted mr-1"></i> <?= date('H:i | d M Y', strtotime($k['waktu_masuk'])) ?></td>
                                                            <td class="pr-4">
                                                                <form action="<?= site_url('parkir/proses_keluar') ?>" method="post" class="d-inline">
                                                                    <?= csrf_field() ?>
                                                                    <input type="hidden" name="id_transaksi" value="<?= $k['id_transaksi'] ?>">
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger font-weight-bold"><i class="fas fa-calculator mr-1"></i> Keluar</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4">
                            <div class="card bg-white border-left-primary shadow mb-4">
                                <div class="card-body">
                                    <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-info-circle mr-2"></i> Informasi Tarif Parkir</h6>
                                    <div class="d-flex justify-content-between align-items-center mb-2 font-weight-bold text-dark">
                                        <span><i class="fas fa-motorcycle text-success mr-2"></i> Motor</span>
                                        <span class="text-success">Rp 2.000 / Jam</span>
                                    </div>
                                    <p class="small text-muted mb-3 pl-4">Rp 2.000 pada jam pertama, ditambah Rp 1.000 untuk setiap jam berikutnya (Pembulatan ke atas).</p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-2 font-weight-bold text-dark">
                                        <span><i class="fas fa-car text-primary mr-2"></i> Mobil</span>
                                        <span class="text-primary">Rp 5.000 / Jam</span>
                                    </div>
                                    <p class="small text-muted mb-0 pl-4">Rp 5.000 pada jam pertama, ditambah Rp 2.000 untuk setiap jam berikutnya (Pembulatan ke atas).</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto"><span>Copyright &copy; parkir-digital 2026</span></div>
                </div>
            </footer>
        </div>
    </div>

    <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
    <script src="<?= base_url('js/sb-admin-2.min.js') ?>"></script>
</body>
</html>