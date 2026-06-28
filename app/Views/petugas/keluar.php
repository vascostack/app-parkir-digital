<?= $this->extend('layouts/v_petugas_layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-6">
        <div class="premium-card p-4">
            <h5 class="fw-bold text-navy-dark mb-4"><i class="bi bi-box-arrow-right me-2"></i>Proses Kendaraan Keluar</h5>
            
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger mb-3"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= site_url('petugas/cek_keluar') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Cari Plat Nomor</label>
                    <div class="input-group">
                        <input type="text" name="no_polisi" class="form-control" placeholder="Contoh: BE 1234 AB" required>
                        <button class="btn btn-outline-navy" type="submit">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="premium-card p-4">
            <h5 class="fw-bold text-navy-dark mb-4">Detail Transaksi</h5>
            
            <?php if(isset($parkir)): ?>
                <div class="card bg-light border-0 p-3">
                    <p class="mb-1"><strong>Plat Nomor:</strong> <?= $parkir['no_polisi'] ?></p>
                    <p class="mb-1"><strong>Waktu Masuk:</strong> <?= $parkir['waktu_masuk'] ?></p>
                    <p class="mb-4 text-muted small">Status: Menunggu Konfirmasi Keluar</p>
                    
                    <a href="<?= site_url('petugas/konfirmasi_keluar/'.$parkir['id_transaksi']) ?>" class="btn btn-success w-100">
                        <i class="bi bi-check2-circle"></i> Selesaikan Transaksi
                    </a>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    Masukkan plat nomor di samping, lalu klik cari untuk melihat detail.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>