<?= $this->extend('layouts/v_user_layout') ?>

<?= $this->section('content') ?>
<section id="tab-history" class="animate-fade">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h2 class="fw-bold text-navy-dark mb-1">Riwayat Reservasi</h2>
      <p class="text-muted mb-0">Daftar lengkap booking parkir yang pernah Anda pesan sebelumnya.</p>
    </div>
  </div>
  
  <div class="premium-card p-3.5 mb-4">
    <div class="row g-3 align-items-center">
      <div class="col-md-4">
        <label class="form-label text-muted mb-1" style="font-size: 11px; font-weight: 600;">STATUS</label>
        <select class="form-select" id="history-filter-status" onchange="filterHistory()">
          <option value="Semua">Semua Status</option>
          <option value="Aktif">Aktif</option>
          <option value="Selesai">Selesai</option>
          <option value="Dibatalkan">Dibatalkan</option>
        </select>
      </div>
      <div class="col-md-5">
        <label class="form-label text-muted mb-1" style="font-size: 11px; font-weight: 600;">CARI KODE / LOKASI</label>
        <div class="input-group">
          <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
          <input type="text" class="form-control" id="history-filter-search" placeholder="Contoh: Gedung A, PARK-..." oninput="filterHistory()">
        </div>
      </div>
      <div class="col-md-3 text-md-end pt-3">
        <button class="btn btn-outline-navy w-100" onclick="resetHistoryFilters()">Reset Filter</button>
      </div>
    </div>
  </div>
  
  <div class="premium-card p-4">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Kode Booking</th>
            <th>Lokasi</th>
            <th class="text-center">Slot</th>
            <th>Kendaraan</th>
            <th>Waktu Kedatangan</th>
            <th>Status</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody id="historyTableBody">
          </tbody>
      </table>
    </div>
  </div>
</section>
<?= $this->endSection() ?>