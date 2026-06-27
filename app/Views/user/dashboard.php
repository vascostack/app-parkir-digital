<?= $this->extend('layouts/v_user_layout') ?>

<?= $this->section('content') ?>
<section id="tab-dashboard" class="dashboard-section animate-fade">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h2 class="fw-bold text-navy-dark mb-1">Halo, <span id="welcome-user-name">Ahmad Salim</span>!</h2>
      <p class="text-muted mb-0">Selamat datang kembali di Portal Layanan Parkir Premium.</p>
    </div>
    <a href="<?= site_url('user/booking') ?>" class="btn btn-navy d-flex align-items-center gap-2">
      <i class="bi bi-calendar-plus"></i> Booking Parkir Baru
    </a>
  </div>
  
  <div class="row g-4 mb-5">
    <div class="col-md-4">
      <div class="premium-card p-4 d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted text-uppercase d-block mb-1" style="font-size: 11px; font-weight: 600; letter-spacing: 0.5px;">Total Kendaraan</span>
          <h2 class="fw-bold text-navy-dark mb-0 font-poppins" id="stat-total-vehicles">2</h2>
        </div>
        <div class="p-3 rounded-4 bg-light text-navy-dark">
          <i class="bi bi-car-front fs-3"></i>
        </div>
      </div>
    </div>
    
    <div class="col-md-4">
      <div class="premium-card p-4 d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted text-uppercase d-block mb-1" style="font-size: 11px; font-weight: 600; letter-spacing: 0.5px;">Booking Aktif</span>
          <h2 class="fw-bold text-navy-dark mb-0 font-poppins" id="stat-active-bookings">1</h2>
        </div>
        <div class="p-3 rounded-4 bg-primary bg-opacity-10 text-primary">
          <i class="bi bi-bookmark-check fs-3"></i>
        </div>
      </div>
    </div>
    
    <div class="col-md-4">
      <div class="premium-card p-4 d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted text-uppercase d-block mb-1" style="font-size: 11px; font-weight: 600; letter-spacing: 0.5px;">Riwayat Selesai</span>
          <h2 class="fw-bold text-navy-dark mb-0 font-poppins" id="stat-completed-bookings">2</h2>
        </div>
        <div class="p-3 rounded-4 bg-success bg-opacity-10 text-success">
          <i class="bi bi-check2-all fs-3"></i>
        </div>
      </div>
    </div>
  </div>
  
  <div class="premium-card p-4">
    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
      <h5 class="fw-bold mb-0 text-navy-dark font-poppins">5 Booking Terakhir</h5>
      <a href="<?= site_url('user/history') ?>" class="btn btn-link text-navy-dark p-0 text-decoration-none fw-semibold">
        Lihat Semua Riwayat <i class="bi bi-arrow-right"></i>
      </a>
    </div>
    
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" id="recentBookingsTable">
        <thead class="table-light">
          <tr>
            <th class="border-0">Kode Booking</th>
            <th class="border-0">Gedung</th>
            <th class="border-0 text-center">Slot</th>
            <th class="border-0">Kendaraan</th>
            <th class="border-0">Waktu Kedatangan</th>
            <th class="border-0">Status</th>
          </tr>
        </thead>
        <tbody id="recentBookingsBody">
          </tbody>
      </table>
    </div>
  </div>
</section>
<?= $this->endSection() ?>