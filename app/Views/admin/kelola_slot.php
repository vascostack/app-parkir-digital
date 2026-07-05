<?= $this->extend('layouts/v_admin_layout') ?>

<?= $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="<?= site_url('admin/lokasi') ?>" class="btn btn-sm btn-outline-secondary mb-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Lokasi
        </a>
        <h3 class="fw-bold text-navy-dark mb-1">Kelola Slot: <?= esc($lokasi['nama_lokasi']) ?></h3>
        <p class="text-muted mb-0"><i class="bi bi-geo-alt me-1"></i> <?= esc($lokasi['alamat']) ?> | Kapasitas: <?= esc($lokasi['kapasitas_total']) ?></p>
    </div>
    <!-- Tombol Tambah Slot -->
    <button class="btn btn-primary px-4 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambahSlot">
        <i class="bi bi-plus-square me-2"></i> Tambah Slot
    </button>
</div>

<!-- DAFTAR SLOT PARKIR -->
<div class="row g-3">
    <?php if(!empty($slot)): ?>
        <?php foreach($slot as $s): ?>
        
        <!-- Menentukan Warna Berdasarkan Status Slot -->
        <?php 
            $bg_color = 'bg-success'; // Default Tersedia
            if($s['status_slot'] == 'terisi') $bg_color = 'bg-danger';
            elseif($s['status_slot'] == 'dipesan') $bg_color = 'bg-warning text-dark';
            elseif($s['status_slot'] == 'maintenance') $bg_color = 'bg-secondary';
        ?>

        <div class="col-6 col-md-3 col-xl-2">
            <div class="card h-100 border-0 shadow-sm text-center">
                <!-- Header Slot (Warna Status) -->
                <div class="card-header <?= $bg_color ?> text-white py-2 border-0">
                    <h5 class="mb-0 fw-bold"><?= esc($s['kode_slot']) ?></h5>
                </div>
                
                <div class="card-body p-2 bg-light d-flex flex-column justify-content-center">
                    <small class="d-block mb-1 text-muted fw-semibold">
                        <i class="bi <?= $s['jenis_slot'] == 'mobil' ? 'bi-car-front-fill' : 'bi-bicycle' ?>"></i> 
                        <?= ucfirst(esc($s['jenis_slot'])) ?>
                    </small>
                    <span class="badge <?= $bg_color ?> bg-opacity-25 text-dark w-100" style="font-size: 0.7rem;">
                        <?= strtoupper(esc($s['status_slot'])) ?>
                    </span>
                </div>
                
                <!-- Action Buttons Edit & Hapus (Kecil di bawah) -->
                <div class="card-footer bg-white border-0 p-1 d-flex justify-content-between">
                    <button class="btn btn-sm btn-link text-primary p-0 text-decoration-none" style="font-size: 0.8rem;" data-bs-toggle="modal" data-bs-target="#modalEditSlot<?= $s['id_slot'] ?>">Edit</button>
                    <a href="<?= site_url('admin/lokasi/delete_slot/' . $s['id_slot'] . '/' . $lokasi['id_lokasi']) ?>" class="btn btn-sm btn-link text-danger p-0 text-decoration-none" style="font-size: 0.8rem;" onclick="return confirm('Hapus slot ini?')">Hapus</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center py-5 bg-white rounded shadow-sm">
            <h5 class="text-muted">Belum ada slot parkir di gedung ini</h5>
            <p class="text-muted small">Klik tombol "Tambah Slot" untuk membuat kode parkir baru (misal: A01, A02).</p>
        </div>
    <?php endif; ?>
</div>

<!-- MODAL TAMBAH SLOT -->
<div class="modal fade" id="modalTambahSlot" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title"><i class="bi bi-plus-square me-2"></i>Tambah Slot Baru</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('admin/lokasi/store_slot') ?>" method="post">
                <div class="modal-body p-3">
                    <!-- Hidden input untuk membawa ID Lokasi -->
                    <input type="hidden" name="id_lokasi" value="<?= $lokasi['id_lokasi'] ?>">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Kode Slot (Contoh: A01)</label>
                        <input type="text" class="form-control form-control-sm" name="kode_slot" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Jenis Kendaraan</label>
                        <select class="form-select form-select-sm" name="jenis_slot" required>
                            <option value="mobil">Mobil</option>
                            <option value="motor">Motor</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light p-2">
                    <button type="submit" class="btn btn-sm btn-primary w-100">Simpan Slot</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL EDIT SLOT (DITAMBAHKAN BIAR FUNGSI EDIT JALAN) -->
<!-- ========================================== -->
<?php if(!empty($slot)): ?>
    <?php foreach($slot as $s): ?>
    <div class="modal fade" id="modalEditSlot<?= $s['id_slot'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Slot Parkir</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?= site_url('admin/lokasi/update_slot') ?>" method="post">
                    <?= csrf_field() ?>
                    <!-- Hidden inputs untuk rute update & redirect -->
                    <input type="hidden" name="id_slot" value="<?= $s['id_slot'] ?>">
                    <input type="hidden" name="id_lokasi" value="<?= $lokasi['id_lokasi'] ?>">
                    
                    <div class="modal-body p-3">
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Kode Slot</label>
                            <input type="text" class="form-control form-control-sm" name="kode_slot" value="<?= esc($s['kode_slot']) ?>" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Jenis Kendaraan</label>
                            <select class="form-select form-select-sm" name="jenis_slot" required>
                                <option value="mobil" <?= $s['jenis_slot'] == 'mobil' ? 'selected' : '' ?>>Mobil</option>
                                <option value="motor" <?= $s['jenis_slot'] == 'motor' ? 'selected' : '' ?>>Motor</option>
                            </select>
                        </div>
                        <div class="mb-1">
                            <label class="form-label small fw-semibold">Status Ketersediaan</label>
                            <select class="form-select form-select-sm" name="status_slot" required>
                                <option value="tersedia" <?= $s['status_slot'] == 'tersedia' ? 'selected' : '' ?>>Tersedia (Hijau)</option>
                                <option value="dipesan" <?= $s['status_slot'] == 'dipesan' ? 'selected' : '' ?>>Dipesan (Kuning)</option>
                                <option value="terisi" <?= $s['status_slot'] == 'terisi' ? 'selected' : '' ?>>Terisi (Merah)</option>
                                <option value="maintenance" <?= $s['status_slot'] == 'maintenance' ? 'selected' : '' ?>>Maintenance (Abu-abu)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-light p-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>