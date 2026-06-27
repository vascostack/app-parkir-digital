<?= $this->extend('layouts/v_user_layout') ?>

<?= $this->section('content') ?>
<section id="tab-profile" class="animate-fade">
  <div class="mb-4">
    <h2 class="fw-bold text-navy-dark mb-1">Pengaturan Profil Pengguna</h2>
    <p class="text-muted mb-0">Kelola informasi akun Anda untuk kredensial login dan notifikasi reservasi.</p>
  </div>
  
  <div class="row g-4">
    <div class="col-lg-4">
      <div class="premium-card p-4 text-center">
        <div class="mb-3 position-relative d-inline-block">
          <div class="bg-navy-dark text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px; font-size: 2.2rem;" id="profile-avatar-big">
            AS
          </div>
          <span class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 border border-white cursor-pointer" style="width: 32px; height: 32px; font-size: 11px; display: flex; align-items: center; justify-content: center;" onclick="alert('Fitur upload foto sedang dalam tahap pengembangan.')">
            <i class="bi bi-camera-fill"></i>
          </span>
        </div>
        
        <h5 class="fw-bold text-navy-dark mb-1 font-poppins" id="profile-card-name">Ahmad Salim</h5>
        <p class="text-muted mb-3" style="font-size: 13px;" id="profile-card-email">ahmad@salim.com</p>
        
        <div class="badge-premium-success">Pengguna Terverifikasi</div>
        <div class="border-top mt-4 pt-3 text-start">
          <small class="text-muted d-block mb-1">Bergabung Sejak</small>
          <span class="fw-semibold text-navy-dark">12 Januari 2026</span>
        </div>
      </div>
    </div>
    
    <div class="col-lg-8">
        <div class="premium-card p-4">
            <h5 class="fw-bold text-navy-dark font-poppins mb-4 border-bottom pb-2">Detail Akun</h5>
            <p class="text-muted">Formulir update profil sedang dalam pengerjaan...</p>
        </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>