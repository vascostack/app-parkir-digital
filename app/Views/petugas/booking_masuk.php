<?= $this->extend('layouts/v_petugas_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid p-0">

    <!-- Notifikasi Sukses / Berhasil Check-In Tepat Waktu -->
    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('pesan') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Notifikasi Warning / Terlambat Datang & Harus Bayar Denda -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card premium-card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-navy-dark mb-1"><i class="bi bi-person-lines-fill me-2"></i> Monitoring Booking User</h5>
                <p class="text-muted small mb-0">Daftar pelanggan aplikasi yang memesan tempat parkir secara remote.</p>
            </div>
            <span class="badge bg-dark font-monospace"><?= count($daftar_booking) ?> Data</span>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="min-width: 900px;">
                    <thead class="table-light text-secondary font-poppins small">
                        <tr>
                            <th class="ps-4">ID / User</th>
                            <th>Kendaraan</th>
                            <th>Alokasi Slot</th>
                            <th>Rencana Datang</th>
                            <th>Batas Expired</th>
                            <th>Pembayaran</th>
                            <th>Status Tiket</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        <?php if (empty($daftar_booking)) : ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i> Belum ada data booking dari aplikasi user.
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($daftar_booking as $b) : ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-navy-dark">#<?= $b['id_reservasi'] ?></span>
                                    <small class="d-block text-muted"><?= esc($b['nama_user'] ?? 'Guest') ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary font-monospace"><?= esc($b['no_polisi'] ?? '-') ?></span>
                                    <small class="d-block text-capitalize text-muted"><?= esc($b['jenis'] ?? '-') ?></small>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark"><i class="bi bi-p-circle-fill text-success me-1"></i> Slot <?= esc($b['kode_slot'] ?? $b['id_slot']) ?></span>
                                </td>
                                <td><?= date('d M Y, H:i', strtotime($b['waktu_kedatangan'])) ?></td>
                                <td>
                                    <?php if (time() > strtotime($b['waktu_expired']) && $b['status_reservasi'] !== 'check-in') : ?>
                                        <span class="text-danger fw-bold font-monospace"><i class="bi bi-clock-history"></i> Lewat Batas</span>
                                    <?php else : ?>
                                        <span class="text-muted font-monospace"><?= date('H:i', strtotime($b['waktu_expired'])) ?> WIB</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge <?= $b['status_pembayaran'] === 'lunas' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' ?> border">
                                        <?= strtoupper($b['status_pembayaran']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge text-capitalize <?= $b['status_reservasi'] === 'check-in' ? 'bg-info text-white' : ($b['status_reservasi'] === 'dibooking' ? 'bg-primary' : 'bg-secondary') ?>">
                                        <?= $b['status_reservasi'] ?>
                                    </span>
                                </td>
                                <td class="text-center pe-4">
                                    <?php if ($b['status_reservasi'] !== 'check-in') : ?>
                                        <a href="<?= site_url('petugas/bookingpetugas/checkin/' . $b['id_reservasi']) ?>" 
                                           class="btn btn-sm btn-dark font-poppins rounded-2 fw-semibold shadow-sm px-3"
                                           onclick="return confirm('Konfirmasi kedatangan user #<?= $b['id_reservasi'] ?>?')">
                                            <i class="bi bi-check2-circle me-1"></i> Check-In
                                        </a>
                                    <?php else : ?>
                                        <button class="btn btn-sm btn-light border disabled rounded-2 text-muted px-3">
                                            <i class="bi bi-dash-circle me-1"></i> Selesai
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>