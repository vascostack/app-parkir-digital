<?= $this->extend('layouts/v_user_layout') ?>

<?= $this->section('content') ?>
<section id="tab-vehicles" class="animate-fade">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h2 class="fw-bold text-navy-dark mb-1">Daftar Kendaraan Saya</h2>
      <p class="text-muted mb-0">Kelola informasi kendaraan Anda untuk mempercepat proses check-out booking.</p>
    </div>
    <button class="btn btn-navy d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addVehicleModal">
      <i class="bi bi-plus-lg"></i> Tambah Kendaraan
    </button>
  </div>
  
  <div class="row g-4" id="vehicle-grid">
    <?php if (empty($kendaraan)) : ?>
      <div class="col-12 text-center py-5">
        <p class="text-muted mb-0">Kamu belum mendaftarkan kendaraan apa pun.</p>
      </div>
    <?php else : ?>
      <?php foreach ($kendaraan as $k) : ?>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm border rounded-4 p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="badge bg-light text-navy-dark border px-2 py-1.5 rounded-2 text-uppercase font-monospace">
                <?= $k['jenis'] == 'mobil' ? '🚗 Mobil' : '🏍️ Motor' ?>
              </span>
              <span class="text-muted small"><?= esc($k['warna']) ?></span>
            </div>
            <h4 class="fw-bold text-primary font-monospace my-2 tracking-wide"><?= esc($k['no_polisi']) ?></h4>
            <p class="text-muted mb-0 small"><i class="bi bi-tag me-1"></i> Merek: <?= esc($k['merek']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>

<div class="modal fade" id="addVehicleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-b pb-2">
        <h5 class="modal-title fw-bold text-navy-dark">Tambah Kendaraan</h5>
        <button type="button" class="btn-close" data-bs-shadow="none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('user/vehicles/store') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="modal-body space-y-3">
          <div class="mb-3">
            <label class="form-label small fw-semibold">Nomor Polisi (Plat No)</label>
            <input type="text" name="no_polisi" class="form-control text-uppercase font-monospace" placeholder="B 1234 XYZ" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Jenis Kendaraan</label>
            <select name="jenis" class="form-select" required>
              <option value="mobil">Mobil</option>
              <option value="motor">Motor</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Merek</label>
            <input type="text" name="merek" class="form-control" placeholder="Toyota / Honda">
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Warna</label>
            <input type="text" name="warna" class="form-control" placeholder="Hitam / Putih">
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-navy">Simpan Kendaraan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>