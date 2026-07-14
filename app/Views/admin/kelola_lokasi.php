<?= $this->extend('layouts/v_admin_layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy-dark mb-1">Manajemen Lokasi & Gedung</h3>
        <p class="text-muted mb-0">Kelola daftar gedung parkir dan kapasitas ruang yang tersedia.</p>
    </div>
    <!-- Tombol Tambah Gedung memanggil Modal -->
    <button class="btn btn-primary px-4 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambahLokasi">
        <i class="bi bi-plus-lg me-2"></i> Tambah Lokasi Baru
    </button>
</div>

<!-- ROW DAFTAR LOKASI -->
<div class="row g-4">
    <?php if (!empty($lokasi)): ?>
        <?php foreach ($lokasi as $l): ?>
            <div class="col-12 col-md-6 col-xl-4">
                <div class="premium-card h-100 overflow-hidden" style="border: 1px solid rgba(0,0,0,0.05); border-radius: 12px; transition: all 0.3s ease;">
                    <!-- Header Card dengan Gambar/Warna -->
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 120px; border-bottom: 1px solid rgba(0,0,0,0.05);">
                        <i class="bi bi-building text-primary opacity-50" style="font-size: 4rem;"></i>
                    </div>

                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold text-navy-dark mb-0"><?= esc($l['nama_lokasi']) ?></h5>
                            <?php if ($l['status'] == 'aktif'): ?>
                                <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill"><i class="bi bi-check-circle me-1"></i> Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 rounded-pill"><i class="bi bi-x-circle me-1"></i> Nonaktif</span>
                            <?php endif; ?>
                        </div>
                        
                        <p class="text-muted small mb-2">
                            <i class="bi bi-geo-alt me-1"></i>
                            <?= esc($l['alamat']) ?>
                        </p>

                        <div class="mb-3">
                            <small class="d-block">
                                <strong>Kode Gedung :</strong>
                                <?= esc($l['kode_gedung']) ?>
                            </small>

                            <small class="d-block">
                                <strong>Penanggung Jawab :</strong>
                                <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-2 py-0.5 rounded text-capitalize">
                                    <i class="bi bi-person-badge me-1"></i><?= esc($l['penanggung_jawab'] ?? 'Belum diatur') ?>
                                </span>
                            </small>

                            <small class="d-block mt-1">
                                <strong>Jam Operasional :</strong>
                                <?= esc($l['jam_operasional']) ?>
                            </small>
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-6">
                                <div class="p-2 bg-light rounded-3 text-center">
                                    <small class="d-block text-muted" style="font-size: 0.7rem;">Kapasitas Total</small>
                                    <strong class="text-navy-dark"><?= esc($l['kapasitas_total']) ?> Slot</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 bg-light rounded-3 text-center">
                                    <small class="d-block text-muted" style="font-size: 0.7rem;">Jenis</small>
                                    <strong class="text-navy-dark"><?= esc($l['jenis_lokasi']) ?></strong>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <a href="<?= site_url('admin/lokasi/slot/' . $l['id_lokasi']) ?>" class="btn btn-outline-primary fw-semibold">
                                <i class="bi bi-grid-3x3-gap me-1"></i> Kelola Slot (A01, C01)
                            </a>
                            <div class="d-flex gap-2 mt-1">
                                <button class="btn btn-light text-primary flex-fill" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $l['id_lokasi'] ?>"><i class="bi bi-pencil-square"></i> Edit</button>
                                <a href="<?= site_url('admin/lokasi/delete/' . $l['id_lokasi']) ?>" class="btn btn-light text-danger flex-fill" onclick="return confirm('Yakin ingin menghapus gedung ini?')"><i class="bi bi-trash"></i> Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center py-5">
            <img src="<?= base_url('assets/images/empty.png') ?>" alt="Kosong" class="mb-3" style="width: 150px; opacity: 0.5;">
            <h5 class="text-muted">Belum ada data lokasi parkir</h5>
            <p class="text-muted small">Silakan klik tombol Tambah Lokasi Baru untuk memulai.</p>
        </div>
    <?php endif; ?>
</div>

<!-- MODAL TAMBAH LOKASI -->
<div class="modal fade" id="modalTambahLokasi" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-navy-dark text-white">
                <h5 class="modal-title" id="modalTambahLabel"><i class="bi bi-building-add me-2"></i>Tambah Lokasi Parkir</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= site_url('admin/lokasi/store') ?>" method="post">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Gedung</label>
                        <input type="text" class="form-control" name="kode_gedung" placeholder="Contoh: GD-01" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Gedung / Lokasi</label>
                        <input type="text" class="form-control" name="nama_lokasi" placeholder="Contoh: Gedung Utama" required>
                    </div>

                    <!-- PENGATURAN DROPDOWN DI MODAL TAMBAH -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Penanggung Jawab Gedung</label>
                        <select class="form-select text-capitalize" name="penanggung_jawab" required>
                            <option value="">-- Pilih Petugas --</option>
                            <?php if (!empty($list_petugas)): ?>
                                <?php foreach ($list_petugas as $p): ?>
                                    <option value="<?= esc($p['nama']) ?>"><?= esc($p['nama']) ?> (<?= esc($p['role']) ?>)</option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jam Operasional</label>
                        <input type="text" class="form-control" name="jam_operasional" placeholder="07.00 - 22.00" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="2" placeholder="Detail alamat..." required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jenis Lokasi</label>
                            <select class="form-select" name="jenis_lokasi" required>
                                <option value="Parkir">Area Parkir (Gedung)</option>
                                <option value="Penitipan">Penitipan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kapasitas Total</label>
                            <input type="number" class="form-control" name="kapasitas_total" min="1" placeholder="Contoh: 100" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Lokasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT LOKASI -->
<?php if (!empty($lokasi)): ?>
    <?php foreach ($lokasi as $l): ?>
        <div class="modal fade" id="modalEdit<?= $l['id_lokasi'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-navy-dark text-white">
                        <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Lokasi Parkir</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= site_url('admin/lokasi/update') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_lokasi" value="<?= $l['id_lokasi'] ?>">

                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kode Gedung</label>
                                <input type="text" class="form-control" name="kode_gedung" value="<?= esc($l['kode_gedung']) ?>" placeholder="Contoh: GD-01" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Gedung / Lokasi</label>
                                <input type="text" class="form-control" name="nama_lokasi" value="<?= esc($l['nama_lokasi']) ?>" placeholder="Contoh: Gedung Utama" required>
                            </div>

                            <!-- PENGATURAN DROPDOWN DI MODAL EDIT -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Penanggung Jawab Gedung</label>
                                <select class="form-select text-capitalize" name="penanggung_jawab" required>
                                    <option value="">-- Pilih Petugas --</option>
                                    <?php if (!empty($list_petugas)): ?>
                                        <?php foreach ($list_petugas as $p): ?>
                                            <option value="<?= esc($p['nama']) ?>" <?= ($l['penanggung_jawab'] == $p['nama']) ? 'selected' : '' ?>>
                                                <?= esc($p['nama']) ?> (<?= esc($p['role']) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jam Operasional</label>
                                <input type="text" class="form-control" name="jam_operasional" value="<?= esc($l['jam_operasional']) ?>" placeholder="07.00 - 22.00" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Alamat</label>
                                <textarea class="form-control" name="alamat" rows="2" required><?= esc($l['alamat']) ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Jenis Lokasi</label>
                                    <select class="form-select" name="jenis_lokasi" required>
                                        <option value="Parkir" <?= $l['jenis_lokasi'] == 'Parkir' ? 'selected' : '' ?>>Area Parkir (Gedung)</option>
                                        <option value="Penitipan" <?= $l['jenis_lokasi'] == 'Penitipan' ? 'selected' : '' ?>>Penitipan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Kapasitas Total</label>
                                    <input type="number" class="form-control" name="kapasitas_total" min="1" value="<?= esc($l['kapasitas_total']) ?>" required>
                                </div>
                            </div>
                            <div class="mb-1">
                                <label class="form-label fw-semibold">Status Operasional</label>
                                <select class="form-select" name="status" required>
                                    <option value="aktif" <?= $l['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                    <option value="nonaktif" <?= $l['status'] == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>