<?= $this->extend('layouts/v_user_layout') ?>

<?= $this->section('content') ?>
<section id="tab-vehicles" class="animate-fade">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h2 class="fw-bold text-navy-dark mb-1">Daftar Kendaraan Saya</h2>
      <p class="text-muted mb-0">Kelola informasi kendaraan Anda untuk mempercepat proses check-out booking.</p>
    </div>
    <button class="btn btn-navy d-flex align-items-center gap-2" onclick="showAddVehicleModal()">
      <i class="bi bi-plus-lg"></i> Tambah Kendaraan
    </button>
  </div>
  
  <div class="row g-4" id="vehicle-grid">
    </div>
</section>
<?= $this->endSection() ?>