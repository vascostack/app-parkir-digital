<?= $this->extend('auth/templates/index'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <i class="fas fa-user-plus fa-2x text-dark mb-2"></i>
                                    <h1 class="h4 text-gray-900 font-weight-bold">Buat Akun Baru</h1>
                                    <p class="text-muted small">Daftar sebagai pengguna Prime Parking</p>
                                </div>

                                <?php if (session()->getFlashdata('errors')) : ?>
                                    <div class="alert alert-danger small py-2" role="alert">
                                        <ul class="mb-0 pl-3">
                                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                            <li><?= $error ?></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <form class="user" action="<?= base_url('register/attempt'); ?>" method="post">
                                    <?= csrf_field(); ?>

                                    <div class="form-group">
                                        <input type="text" name="nama" class="form-control form-control-user"
                                            placeholder="Nama Lengkap Anda" value="<?= old('nama') ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control form-control-user"
                                            placeholder="Alamat Email" value="<?= old('email') ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="no_hp" class="form-control form-control-user"
                                            placeholder="Nomor Handphone (Contoh: 0812345678)" value="<?= old('no_hp') ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            placeholder="Password (Minimal 6 Karakter)" required>
                                    </div>

                                    <button type="submit" class="btn btn-dark btn-user btn-block font-weight-bold">
                                        Daftar Akun
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small text-dark font-weight-bold" href="<?= base_url('login'); ?>">Sudah punya akun? Masuk di sini!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>