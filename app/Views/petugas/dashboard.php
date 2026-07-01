<?= $this->extend('layouts/v_petugas_layout') ?>

<?= $this->section('content') ?>
<section id="tab-dashboard" class="dashboard-section animate-fade">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h2 class="fw-bold text-navy-dark mb-1">
        Halo, <span class="text-capitalize"><?= session()->get('nama') ?? session()->get('username') ?? 'Petugas' ?></span>!
      </h2>
      <p class="text-muted mb-0">Selamat bertugas di Portal Layanan Parkir Premium.</p>
    </div>
    <div class="d-flex gap-2">
      <a href="<?= site_url('petugas/masuk') ?>" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
        <i class="bi bi-box-arrow-in-right"></i> Kendaraan Masuk
      </a>
      <a href="<?= site_url('petugas/keluar') ?>" class="btn btn-danger d-flex align-items-center gap-2 shadow-sm">
        <i class="bi bi-box-arrow-right"></i> Kendaraan Keluar
      </a>
    </div>
  </div>
  
  <div class="row g-4 mb-5">
    <div class="col-md-4">
      <div class="premium-card p-4 d-flex align-items-center justify-content-between h-100">
        <div>
          <span class="text-muted text-uppercase d-block mb-1" style="font-size: 11px; font-weight: 600; letter-spacing: 0.5px;">Kendaraan di Lokasi</span>
          <h2 class="fw-bold text-navy-dark mb-0 font-poppins"><?= $parked_count ?? 0 ?></h2>
        </div>
        <div class="p-3 rounded-4 bg-primary bg-opacity-10 text-primary">
          <i class="bi bi-p-circle fs-3"></i>
        </div>
      </div>
    </div>
    
    <div class="col-md-4">
      <div class="premium-card p-4 d-flex align-items-center justify-content-between h-100">
        <div>
          <span class="text-muted text-uppercase d-block mb-1" style="font-size: 11px; font-weight: 600; letter-spacing: 0.5px;">Transaksi Hari Ini</span>
          <h2 class="fw-bold text-navy-dark mb-0 font-poppins"><?= $today_transactions ?? 0 ?></h2>
        </div>
        <div class="p-3 rounded-4 bg-success bg-opacity-10 text-success">
          <i class="bi bi-check2-square fs-3"></i>
        </div>
      </div>
    </div>
    
    <div class="col-md-4">
      <div class="premium-card p-4 d-flex align-items-center justify-content-between h-100">
        <div>
          <span class="text-muted text-uppercase d-block mb-1" style="font-size: 11px; font-weight: 600; letter-spacing: 0.5px;">Pendapatan Hari Ini</span>
          <h2 class="fw-bold text-navy-dark mb-0 font-poppins">Rp <?= number_format($today_income ?? 0, 0, ',', '.') ?></h2>
        </div>
        <div class="p-3 rounded-4 bg-warning bg-opacity-10 text-warning">
          <i class="bi bi-cash-coin fs-3"></i>
        </div>
      </div>
    </div>
  </div>
  
  <div class="premium-card p-4">
    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
      <h5 class="fw-bold mb-0 text-navy-dark font-poppins">5 Transaksi Terakhir</h5>
      <a href="<?= site_url('petugas/transaksi') ?>" class="btn btn-link text-navy-dark p-0 text-decoration-none fw-semibold">
        Lihat Semua Transaksi <i class="bi bi-arrow-right"></i>
      </a>
    </div>
    
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="border-0">ID Transaksi</th>
            <th class="border-0">Plat Nomor</th>
            <th class="border-0">Waktu Masuk</th>
            <th class="border-0">Waktu Keluar</th>
            <th class="border-0">Tarif</th>
            <th class="border-0">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($recent_transactions)) : ?>
            <?php foreach ($recent_transactions as $row) : ?>
              <tr>
                <td>#TRX-<?= $row['id_transaksi'] ?></td>
                <td class="fw-bold"><?= $row['no_polisi'] ?? '-' ?></td>
                <td><?= date('H:i', strtotime($row['waktu_masuk'])) ?> WIB</td>
                <td><?= $row['waktu_keluar'] ? date('H:i', strtotime($row['waktu_keluar'])) . ' WIB' : '-' ?></td>
                <td><?= $row['total_biaya'] > 0 ? 'Rp ' . number_format($row['total_biaya'], 0, ',', '.') : '-' ?></td>
                <td>
                  <?php if ($row['status_transaksi'] == 'selesai') : ?>
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1">Selesai</span>
                  <?php else : ?>
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1">Di Lokasi</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="6" class="text-center text-muted">Belum ada transaksi hari ini.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<?= $this->endSection() ?>