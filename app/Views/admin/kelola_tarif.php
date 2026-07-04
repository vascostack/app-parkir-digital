<?= $this->extend('layouts/v_admin_layout') ?>

<?= $this->section('content') ?>
<div class="row g-4">
    <div class="col-lg-8 mx-auto">
        <!-- Tambahan shadow-sm dan border-0 agar card lebih premium -->
        <div class="card border-0 shadow-sm p-4" style="border-radius: 1rem;">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                    <i class="bi bi-tags fs-4"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-navy-dark mb-1">Kelola Tarif Parkir</h4>
                    <span class="text-muted small">Atur biaya parkir per jam untuk setiap jenis kendaraan.</span>
                </div>
            </div>

            <!-- Pesan Sukses (Dari Flashdata) -->
            <?php if(session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success fw-semibold">
                    <i class="bi bi-check-circle me-2"></i> <?= session()->getFlashdata('pesan') ?>
                </div>
            <?php endif; ?>

            <!-- Tambahkan ID formTarif disini -->
            <form id="formTarif" action="<?= site_url('admin/tarif/update') ?>" method="POST">
                <div class="row g-4">
                    <!-- Tarif Mobil -->
                    <div class="col-md-6">
                        <label class="fw-semibold text-navy-dark mb-2">Tarif Mobil (Per Jam)</label>
                        <div class="input-group input-group-lg shadow-sm rounded-3">
                            <span class="input-group-text bg-light border-end-0 fw-bold text-secondary">Rp</span>
                            <!-- Value diubah ke 10000 -->
                            <input type="number" name="tarif_mobil" class="form-control border-start-0 ps-0 fw-semibold" 
                                   value="<?= $tarif_mobil ?? 10000 ?>" required>
                        </div>
                    </div>
                    
                    <!-- Tarif Motor -->
                    <div class="col-md-6">
                        <label class="fw-semibold text-navy-dark mb-2">Tarif Motor (Per Jam)</label>
                        <div class="input-group input-group-lg shadow-sm rounded-3">
                            <span class="input-group-text bg-light border-end-0 fw-bold text-secondary">Rp</span>
                            <!-- Value diubah ke 5000 -->
                            <input type="number" name="tarif_motor" class="form-control border-start-0 ps-0 fw-semibold" 
                                   value="<?= $tarif_motor ?? 5000 ?>" required>
                        </div>
                    </div>
                </div>

                <hr class="my-4 text-muted opacity-25">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold rounded-3 shadow-sm">
                        <i class="bi bi-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambahkan Library SweetAlert2 via CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script untuk memunculkan Pop-up Konfirmasi -->
<script>
    document.getElementById('formTarif').addEventListener('submit', function(e) {
        e.preventDefault(); // Mencegah form langsung tersubmit

        Swal.fire({
            title: 'Konfirmasi Perubahan',
            text: "Apakah Anda yakin ingin memperbarui tarif parkir ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#dc3545',
            confirmButtonText: '<i class="bi bi-check-lg"></i> Ya, Simpan!',
            cancelButtonText: 'Batal',
            reverseButtons: true // Membalik posisi tombol agar 'Simpan' di kanan
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user klik 'Ya', lanjutkan submit form ke Controller
                this.submit(); 
            }
        })
    });
</script>
<?= $this->endSection() ?>