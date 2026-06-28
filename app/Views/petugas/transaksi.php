<?= $this->extend('layouts/v_petugas_layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="premium-card p-4">
            <h5 class="fw-bold text-navy-dark mb-4"><i class="bi bi-receipt me-2"></i>Riwayat Transaksi Parkir</h5>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Plat Nomor</th>
                            <th>ID Slot</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($transaksi)): ?>
                            <?php $no = 1; foreach($transaksi as $t): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $t['no_polisi'] ?></td>
                                <td><?= $t['id_slot'] ?></td>
                                <td><?= $t['waktu_masuk'] ?></td>
                                <td><?= $t['waktu_keluar'] ?? '-' ?></td>
                                <td>
                                    <?php if($t['status_transaksi'] == 'masuk'): ?>
                                        <span class="badge bg-warning text-dark">Sedang Parkir</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data transaksi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>