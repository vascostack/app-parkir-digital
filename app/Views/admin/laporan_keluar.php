<?= $this->extend('layouts/v_admin_layout') ?>

<?= $this->section('content') ?>
<!-- Card Filter (Sesuai referensi gambar POS) -->
<div class="premium-card p-4 mb-4">
    <form action="<?= site_url('admin/laporan') ?>" method="GET" class="row align-items-end g-3">
        <div class="col-md-3">
            <label class="form-label text-muted fw-semibold small mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" class="form-control" value="<?= $start_date ?? date('Y-m-d') ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label text-muted fw-semibold small mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" class="form-control" value="<?= $end_date ?? date('Y-m-d') ?>">
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <button type="submit" class="btn btn-success px-4 me-2">
                <i class="bi bi-funnel me-1"></i> Filter Laporan
            </button>
            <!-- Tombol Print membuka tab baru untuk tampilan khusus cetak -->
            <a href="<?= site_url('admin/laporan/cetak?start_date=' . ($start_date ?? date('Y-m-d')) . '&end_date=' . ($end_date ?? date('Y-m-d'))) ?>" target="_blank" class="btn btn-outline-secondary px-4 bg-white">
                <i class="bi bi-printer me-1"></i> Cetak Laporan
            </a>

            <!-- Tombol Export Excel Berdasarkan Filter Tanggal GET -->
            <a href="<?= site_url('admin/laporan/export?start_date=' . $start_date . '&end_date=' . $end_date) ?>" class="btn btn-success fw-semibold">
                <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
            </a>
        </div>
    </form>
</div>

<!-- Card Data Laporan -->
<div class="premium-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-navy-dark mb-0">Daftar Transaksi Lunas</h5>

        <!-- Badge Total Pendapatan -->
        <div class="bg-success bg-opacity-10 text-success px-4 py-2 rounded-3 border border-success border-opacity-25">
            <span class="small fw-semibold d-block" style="line-height: 1;">Total Pendapatan</span>
            <span class="fs-5 fw-bold">Rp <?= number_format($total_pendapatan ?? 0, 0, ',', '.') ?></span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-secondary text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                <tr>
                    <th>ID Transaksi</th>
                    <th>Waktu Keluar</th>
                    <th>Plat Nomor</th>
                    <th>Tipe Kendaraan</th>
                    <th>Petugas (Kasir)</th>
                    <th class="text-end">Total Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data_laporan)): ?>
                    <?php foreach ($data_laporan as $row): ?>
                        <tr>
                            <td class="fw-semibold text-navy-dark">#<?= $row['id_transaksi'] ?></td>
                            <td class="text-muted"><?= date('d/m/Y H:i', strtotime($row['waktu_keluar'])) ?></td>
                            <td class="fw-bold"><?= strtoupper($row['no_polisi']) ?></td>
                            <td><?= ucfirst($row['jenis']) ?></td>
                            <td><?= $row['nama_petugas'] ?></td>
                            <td class="text-end text-danger fw-semibold">IDR <?= number_format($row['biaya'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                            Tidak ada transaksi pada rentang tanggal ini.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>