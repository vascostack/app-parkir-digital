<?= $this->extend('layouts/v_admin_layout') ?>

<?= $this->section('content') ?>

<!-- Menampilkan Notifikasi Sukses dari Controller -->
<?php if(session()->getFlashdata('sukses')): ?>
    <div class="alert alert-success border-0 shadow-sm bg-success bg-opacity-10 text-success fw-semibold mb-4 rounded-3">
        <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('sukses') ?>
    </div>
<?php endif; ?>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 bg-primary text-white p-3">
            <div class="d-flex align-items-center">
                <div class="bg-white bg-opacity-25 rounded-3 p-3 me-3">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
                <div>
                    <span class="d-block small text-white-50 fw-semibold text-uppercase">Petugas Aktif</span>
                    <h3 class="fw-bold mb-0"><?= $total_aktif ?? 0 ?> <span class="fs-6 fw-normal">Orang</span></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Card -->
<div class="card border-0 shadow-sm p-4 rounded-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-navy-dark mb-1">Manajemen Petugas</h4>
            <span class="text-muted small">Kelola data, role, jadwal shift, and status akun petugas parkir.</span>
        </div>
        <button type="button" class="btn btn-primary px-4 py-2 fw-semibold rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-person-plus me-2"></i> Tambah Petugas
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-secondary text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama & Jabatan</th>
                    <th>Kontak</th>
                    <th>Operasional (Jadwal & EIC)</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-center" width="12%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; if(!empty($petugas)): ?>
                    <?php foreach($petugas as $p): ?>
                    <tr>
                        <td class="text-muted"><?= $no++ ?></td>
                        <td>
                            <div class="fw-bold text-navy-dark"><?= $p['nama'] ?? '-' ?></div>
                            <div class="small text-primary fw-medium">
                                <i class="bi bi-briefcase me-1"></i> 
                                <?= (!empty($p['jabatan']) ? $p['jabatan'] : 'Belum diatur') ?>
                            </div>
                        </td>
                        <td>
                            <div class="small text-muted mb-1"><i class="bi bi-envelope me-1"></i> <?= $p['email'] ?? '-' ?></div>
                            <div class="small text-muted"><i class="bi bi-telephone me-1"></i> <?= !empty($p['no_hp']) ? $p['no_hp'] : '-' ?></div>
                        </td>
                        <td>
                            <div class="mb-1">
                                <?php if(!empty($p['jadwal'])): ?>
                                    <span class="badge bg-warning text-dark px-2 py-1 rounded-2 fw-semibold" style="font-size: 0.75rem;">
                                        <i class="bi bi-clock-fill me-1"></i> Shift: <?= $p['jadwal'] ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-light text-muted px-2 py-1 rounded-2 border" style="font-size: 0.75rem;">
                                        <i class="bi bi-clock me-1"></i> Shift: Belum diatur
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="text-secondary ps-1" style="font-size: 0.8rem;">
                                <i class="bi bi-person-badge me-1"></i> EIC: <span class="fw-bold text-dark"><?= !empty($p['eic_manager']) ? $p['eic_manager'] : '-' ?></span>
                            </div>
                        </td>
                        <td>
                            <?php if(($p['role'] ?? '') == 'admin'): ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Admin</span>
                            <?php else: ?>
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">Petugas</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(($p['status'] ?? '') == 'aktif'): ?>
                                <span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle me-1"></i> Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-secondary px-3 py-2 rounded-pill"><i class="bi bi-dash-circle me-1"></i> Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-light text-primary me-1 rounded-3" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $p['id_user'] ?>">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <!-- Menggunakan rute hapus_petugas -->
                            <a href="<?= site_url('admin/petugas/hapus/'.$p['id_user']) ?>" class="btn btn-sm btn-light text-danger rounded-3 btn-hapus" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- MODAL EDIT PETUGAS -->
                    <div class="modal fade" id="modalEdit<?= $p['id_user'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow rounded-4">
                                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                                    <h5 class="modal-title fw-bold text-navy-dark">Edit Data Petugas</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="<?= site_url('admin/petugas/update') ?>" method="POST" class="form-konfirmasi">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id_user" value="<?= $p['id_user'] ?>">
                                    <div class="modal-body px-4">
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Nama Lengkap</label>
                                                <input type="text" name="nama" class="form-control" value="<?= $p['nama'] ?? '' ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Jabatan</label>
                                                <input type="text" name="jabatan" class="form-control" value="<?= $p['jabatan'] ?? '' ?>" placeholder="Contoh: Supervisor, Kasir, Staff Lapangan">
                                            </div>
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Email</label>
                                                <input type="email" name="email" class="form-control" value="<?= $p['email'] ?? '' ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">No. HP</label>
                                                <input type="text" name="no_hp" class="form-control" value="<?= $p['no_hp'] ?? '' ?>">
                                            </div>
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Jadwal / Shift Kerja</label>
                                                <select name="jadwal" class="form-select">
                                                    <option value="" <?= empty($p['jadwal'] ?? '') ? 'selected' : '' ?>>-- Pilih Shift --</option>
                                                    <option value="Pagi (06:00 - 14:00)" <?= ($p['jadwal'] ?? '') == 'Pagi (06:00 - 14:00)' ? 'selected' : '' ?>>Pagi (06:00 - 14:00)</option>
                                                    <option value="Siang (14:00 - 22:00)" <?= ($p['jadwal'] ?? '') == 'Siang (14:00 - 22:00)' ? 'selected' : '' ?>>Siang (14:00 - 22:00)</option>
                                                    <option value="Malam (22:00 - 06:00)" <?= ($p['jadwal'] ?? '') == 'Malam (22:00 - 06:00)' ? 'selected' : '' ?>>Malam (22:00 - 06:00)</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">EIC Manager (Penanggung Jawab)</label>
                                                <input type="text" name="eic_manager" class="form-control" value="<?= $p['eic_manager'] ?? '' ?>" placeholder="Nama Manager On Duty">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-muted fw-semibold small">Password Baru <span class="text-danger fw-normal" style="font-size: 0.75rem;">(Kosongkan jika tidak ingin mengubah)</span></label>
                                            <input type="password" name="password" class="form-control" placeholder="******">
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Role</label>
                                                <select name="role" class="form-select" required>
                                                    <option value="petugas" <?= ($p['role'] ?? '') == 'petugas' ? 'selected' : '' ?>>Petugas Lapangan</option>
                                                    <option value="admin" <?= ($p['role'] ?? '') == 'admin' ? 'selected' : '' ?>>System Admin</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted fw-semibold small">Status Akun</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="aktif" <?= ($p['status'] ?? '') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                                    <option value="nonaktif" <?= ($p['status'] ?? '') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                                        <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary px-4 rounded-3">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data petugas.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH PETUGAS -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-navy-dark">Tambah Akun Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('admin/petugas/simpan') ?>" method="POST" class="form-konfirmasi">
                <?= csrf_field() ?>
                <div class="modal-body px-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Supervisor, Kasir, Staff Lapangan">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small">No. HP</label>
                            <input type="text" name="no_hp" class="form-control">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small">Jadwal / Shift Kerja</label>
                            <select name="jadwal" class="form-select">
                                <option value="" selected>-- Pilih Shift --</option>
                                <option value="Pagi (06:00 - 14:00)">Pagi (06:00 - 14:00)</option>
                                <option value="Siang (14:00 - 22:00)">Siang (14:00 - 22:00)</option>
                                <option value="Malam (22:00 - 06:00)">Malam (22:00 - 06:00)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small">EIC Manager (Penanggung Jawab)</label>
                            <input type="text" name="eic_manager" class="form-control" placeholder="Nama Manager On Duty">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold small">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="petugas">Petugas Lapangan</option>
                                <option value="admin">System Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small">Status Akun</label>
                            <select name="status" class="form-select" required>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Library SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Konfirmasi untuk Form (Tambah & Edit)
    const forms = document.querySelectorAll('.form-konfirmasi');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); 
            Swal.fire({
                title: 'Konfirmasi Data',
                text: "Apakah data yang dimasukkan sudah benar?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Proses!',
                cancelButtonText: 'Cek Kembali',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });
    });

    // Konfirmasi untuk Hapus
    const btnHapus = document.querySelectorAll('.btn-hapus');
    btnHapus.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const linkHapus = this.getAttribute('href');
            
            Swal.fire({
                title: 'Hapus Petugas?',
                text: "Data ini tidak dapat dikembalikan setelah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-trash"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = linkHapus;
                }
            })
        });
    });
</script>

<?= $this->endSection() ?>