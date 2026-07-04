<?= $this->extend('layouts/v_admin_layout') ?>

<?= $this->section('content') ?>

<!-- ROW CARD METRIK UTAMA -->
<div class="row g-4 mb-4">
  <!-- Card Pendapatan -->
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="premium-card p-4 h-100" style="border-top: 4px solid #22c55e;">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <small class="text-muted fw-semibold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Pendapatan Hari Ini</small>
          <h3 class="fw-bold text-navy-dark mt-2 mb-0">Rp <?= number_format($pendapatan_hari_ini ?? 0, 0, ',', '.') ?></h3>
        </div>
        <div class="bg-success bg-opacity-10 text-success rounded-3 p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
          <i class="bi bi-wallet2 fs-3"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Card Total Kendaraan Masuk -->
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="premium-card p-4 h-100" style="border-top: 4px solid #3b82f6;">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <small class="text-muted fw-semibold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Kendaraan Masuk</small>
          <h3 class="fw-bold text-navy-dark mt-2 mb-0"><?= $total_masuk_hari_ini ?? 0 ?> <span class="fs-6 fw-normal text-muted">Unit</span></h3>
        </div>
        <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
          <i class="bi bi-box-arrow-in-right fs-3"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Card Sedang Parkir -->
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="premium-card p-4 h-100" style="border-top: 4px solid #eab308;">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <small class="text-muted fw-semibold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Sedang Parkir</small>
          <h3 class="fw-bold text-navy-dark mt-2 mb-0"><?= $sedang_parkir ?? 0 ?> <span class="fs-6 fw-normal text-muted">Aktif</span></h3>
        </div>
        <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
          <i class="bi bi-p-circle fs-3"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Card Slot Kosong -->
  <div class="col-12 col-sm-6 col-xl-3">
    <div class="premium-card p-4 h-100" style="border-top: 4px solid #ef4444;">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <small class="text-muted fw-semibold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Slot Kosong</small>
          <h3 class="fw-bold text-navy-dark mt-2 mb-0"><?= $slot_tersisa ?? 0 ?> <span class="fs-6 fw-normal text-muted">Slot</span></h3>
        </div>
        <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
          <i class="bi bi-grid-3x3-gap fs-3"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ROW DIAGRAM STATISTIK -->
<div class="row g-4 mb-5">
  <!-- Chart Tren Pendapatan -->
  <div class="col-lg-8">
    <div class="premium-card p-4">
      <h5 class="fw-bold text-navy-dark mb-3"><i class="bi bi-graph-up me-2 text-success"></i> Tren Pendapatan Parkir</h5>
      <div style="position: relative; height: 300px;">
        <canvas id="revenueChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Chart Rasio Kendaraan -->
  <div class="col-lg-4">
    <div class="premium-card p-4">
      <h5 class="fw-bold text-navy-dark mb-3"><i class="bi bi-pie-chart me-2 text-primary"></i> Rasio Kendaraan</h5>
      <div style="position: relative; height: 300px;" class="d-flex align-items-center justify-content-center">
        <canvas id="vehicleChart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- ROW DATA TABEL & MENU CEPAT -->
<div class="row g-4">
  <!-- Tabel Riwayat Terakhir -->
  <div class="col-lg-8">
    <div class="premium-card p-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-navy-dark mb-0"><i class="bi bi-clock-history me-2 text-muted"></i> Transaksi Keluar Terakhir</h5>
        <a href="<?= site_url('admin/laporan') ?>" class="btn btn-sm btn-outline-navy">Lihat Semua</a>
      </div>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light text-secondary">
            <tr>
              <th>Plat Nomor</th>
              <th>Jenis</th>
              <th>Total Bayar</th>
              <th>Waktu Keluar</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($terakhir_keluar)): ?>
              <?php foreach ($terakhir_keluar as $tk): ?>
                <tr>
                  <td class="fw-bold text-navy-dark"><?= $tk['no_polisi'] ?></td>
                  <td>
                    <?php if (strtolower($tk['jenis']) == 'mobil'): ?>
                      <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1.5"><i class="bi bi-car-front me-1"></i> Mobil</span>
                    <?php else: ?>
                      <span class="badge bg-success bg-opacity-10 text-success px-2.5 py-1.5"><i class="bi bi-scooter me-1"></i> Motor</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-danger fw-semibold">Rp <?= number_format($tk['biaya'], 0, ',', '.') ?></td>
                  <td class="text-muted small"><?= $tk['waktu'] ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="text-center text-muted py-4">Belum ada aktivitas keluar hari ini.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Menu Navigasi Cepat Admin -->
  <div class="col-lg-4">
    <div class="premium-card p-4 bg-white">
      <h5 class="fw-bold text-navy-dark mb-4"><i class="bi bi-lightning-charge me-2 text-warning"></i> Menu Pintas Admin</h5>
      <div class="d-grid gap-3">
        <a href="<?= site_url('admin/tarif') ?>" class="btn btn-light text-start p-3 rounded-3 d-flex align-items-center justify-content-between border">
          <div>
            <strong class="d-block text-navy-dark">Kelola Tarif Parkir</strong>
            <small class="text-muted">Ubah biaya per jam mobil/motor</small>
          </div>
          <i class="bi bi-chevron-right text-muted"></i>
        </a>
        <a href="<?= site_url('admin/petugas') ?>" class="btn btn-light text-start p-3 rounded-3 d-flex align-items-center justify-content-between border">
          <div>
            <strong class="d-block text-navy-dark">Manajemen Petugas</strong>
            <small class="text-muted">Tambah, edit, atau hapus akun petugas</small>
          </div>
          <i class="bi bi-chevron-right text-muted"></i>
        </a>
        <a href="<?= site_url('admin/laporan') ?>" class="btn btn-light text-start p-3 rounded-3 d-flex align-items-center justify-content-between border">
          <div>
            <strong class="d-block text-navy-dark">Laporan Pendapatan</strong>
            <small class="text-muted">Cetak rekap & filter data parkir</small>
          </div>
          <i class="bi bi-chevron-right text-muted"></i>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- SCRIPT UNTUK LOAD LIBRARY & HANDLING CHART -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  
  // 1. Ambil data dengan proteksi fallback jika dari Controller kosong
  const labelsRevenue = <?= !empty($chart_revenue_labels) ? $chart_revenue_labels : '["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"]' ?>;
  const dataRevenue   = <?= !empty($chart_revenue_data) ? $chart_revenue_data : '[0, 0, 0, 0, 0, 0, 0]' ?>;
  const dataMobil     = <?= $chart_veh_mobil ?? 0 ?>;
  const dataMotor     = <?= $chart_veh_motor ?? 0 ?>;

  // 2. Render Chart Pendapatan
  const canvasRevenue = document.getElementById('revenueChart');
  if (canvasRevenue) {
    new Chart(canvasRevenue.getContext('2d'), {
      type: 'line',
      data: {
        labels: labelsRevenue,
        datasets: [{
          label: 'Pendapatan (Rp)',
          data: dataRevenue,
          borderColor: '#22c55e',
          backgroundColor: 'rgba(34, 197, 94, 0.1)',
          borderWidth: 3,
          fill: true,
          tension: 0.3,
          pointBackgroundColor: '#22c55e'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return 'Rp ' + value.toLocaleString('id-ID');
              }
            }
          }
        }
      }
    });
  }

  // 3. Render Chart Rasio Kendaraan
  const canvasVehicle = document.getElementById('vehicleChart');
  if (canvasVehicle) {
    new Chart(canvasVehicle.getContext('2d'), {
      type: 'doughnut',
      data: {
        labels: ['Mobil', 'Motor'],
        datasets: [{
          data: [dataMobil, dataMotor],
          backgroundColor: ['#3b82f6', '#10b981'],
          borderWidth: 2,
          hoverOffset: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              boxWidth: 12,
              font: { size: 12 }
            }
          }
        }
      }
    });
  }
});
</script>

<?= $this->endSection() ?>