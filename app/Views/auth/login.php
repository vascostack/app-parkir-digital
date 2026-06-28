<?= $this->extend('auth/templates/index'); ?> 

<?= $this->section('content'); ?>
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <i class="fas fa-parking fa-3x text-dark mb-2"></i>
                                    <h1 class="h4 text-gray-900 font-weight-bold">PRIME PARKING</h1>
                                    <p class="text-muted small">Silakan masuk ke akun Anda</p>
                                </div>

                                <?php if (session()->getFlashdata('error')) : ?>
                                    <div class="alert alert-danger small py-2 text-center" role="alert">
                                        <?= session()->getFlashdata('error'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (session()->getFlashdata('success')) : ?>
                                    <div class="alert alert-success small py-2 text-center" role="alert">
                                        <?= session()->getFlashdata('success'); ?>
                                    </div>
                                <?php endif; ?>

                                <form class="user" action="<?= base_url('login/attempt'); ?>" method="post">
                                    <?= csrf_field(); ?>
                                    
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control form-control-user"
                                            placeholder="Alamat Email" value="<?= old('email') ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            placeholder="Password" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Ingat Saya</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-dark btn-user btn-block font-weight-bold">
                                        Masuk
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small text-dark font-weight-bold" href="<?= base_url('register'); ?>">Belum punya akun? Daftar Sekarang!</a>
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