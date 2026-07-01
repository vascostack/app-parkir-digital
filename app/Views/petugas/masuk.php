<?= $this->extend('layouts/v_petugas_layout') ?>

<?= $this->section('content') ?>
<style>
    /* Kustomisasi Tab Navigasi - Tema Premium Navy */
    .custom-tabs .nav-link {
        color: var(--slate-gray);
        font-weight: 600;
        border: none;
        border-bottom: 3px solid transparent;
        padding: 12px 24px;
        transition: all 0.3s ease;
    }
    .custom-tabs .nav-link:hover {
        color: var(--navy-light);
    }
    .custom-tabs .nav-link.active {
        color: var(--navy-dark);
        border-bottom: 3px solid var(--navy-dark);
        background: transparent;
    }

    /* Kustomisasi Radio Button menjadi Card (Desain Lama) */
    .radio-card input[type="radio"] {
        display: none;
    }
    .radio-card label {
        display: block;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        background-color: #fff;
    }
    .radio-card label:hover {
        border-color: #cbd5e1;
        background-color: #f8fafc;
    }
    .radio-card input[type="radio"]:checked + label {
        border-color: var(--navy-dark);
        background-color: #f1f5f9; /* Abu-abu sangat muda */
        color: var(--navy-dark);
        box-shadow: 0 4px 12px rgba(10, 22, 40, 0.08);
    }
    
    .icon-vehicle { color: var(--slate-gray); font-size: 2.5rem; transition: color 0.2s; }
    .radio-card input[type="radio"]:checked + label .icon-vehicle { color: var(--navy-dark); }

    /* Header Form Navy */
    .form-header-navy {
        background-color: var(--navy-dark);
        color: white;
        border-radius: 12px 12px 0 0;
        padding: 15px 20px;
    }

    /* Tombol Kustom Navy */
    .btn-navy-custom {
        background-color: var(--navy-dark);
        color: white;
        border: none;
    }
    .btn-navy-custom:hover {
        background-color: var(--navy-light);
        color: white;
    }
</style>

<div class="mb-4">
    <h3 class="fw-bold text-navy-dark mb-1">Parkir Masuk</h3>
    <p class="text-muted">Input data kendaraan yang masuk area parkir</p>
</div>

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('pesan') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<div class="row g-4">
    <div class="col-lg-8">
        
        <ul class="nav nav-tabs custom-tabs mb-4" id="parkirTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#langsung" type="button">
                    <i class="bi bi-car-front me-2"></i>Parkir Langsung
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#booking" type="button">
                    <i class="bi bi-qr-code-scan me-2"></i>Scan Booking
                </button>
            </li>
        </ul>

        <div class="tab-content" id="parkirTabContent">
            
            <div class="tab-pane fade show active" id="langsung">
                <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid #e2e8f0 !important;">
                    <div class="form-header-navy d-flex align-items-center">
                        <i class="bi bi-car-front-fill me-2 fs-5"></i>
                        <h6 class="mb-0 fw-semibold">Form Input Kendaraan</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?= site_url('petugas/proses_masuk_langsung') ?>" method="post">
                            <?= csrf_field() ?>
                            
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-navy-dark">
                                    <i class="bi bi-123 me-1"></i> Plat Nomor Kendaraan <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="no_polisi" class="form-control form-control-lg" placeholder="Contoh: BE 8380 XX" required style="text-transform: uppercase;">
                                <small class="text-muted"><i class="bi bi-info-circle me-1"></i> Masukkan plat nomor kendaraan tanpa spasi.</small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-navy-dark">
                                    </i> Jenis Kendaraan <span class="text-danger">*</span>
                                </label>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="radio-card">
                                            <input type="radio" name="jenis" id="motor" value="motor" required>
                                            <label for="motor">
                                                <i class="bi bi-scooter icon-vehicle mb-2"></i>
                                                <h6 class="fw-bold mb-1">Motor</h6>
                                                <small class="text-muted">Sepeda motor</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="radio-card">
                                            <input type="radio" name="jenis" id="mobil" value="mobil" required>
                                            <label for="mobil">
                                                <i class="bi bi-car-front icon-vehicle mb-2"></i>
                                                <h6 class="fw-bold mb-1">Mobil</h6>
                                                <small class="text-muted">Mobil penumpang, SUV, MPV</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-navy-dark">
                                        <i class="bi bi-tag me-1"></i> Merek Kendaraan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="merek" class="form-control form-control-lg" placeholder="Contoh: Honda / Toyota" required>
                                </div>
                                <div class="col-md-6 mt-3 mt-md-0">
                                    <label class="form-label fw-semibold text-navy-dark">
                                        <i class="bi bi-palette me-1"></i> Warna Kendaraan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="warna" class="form-control form-control-lg" placeholder="Contoh: Hitam / Putih" required>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-navy-dark"><i class="bi bi-geo-alt me-1"></i> Lokasi Parkir</label>
                                    <select class="form-select form-select-lg" name="id_lokasi">
                                        <option value="" disabled selected>-- Pilih Lokasi --</option>
                                        <?php if(isset($lokasi)): ?>
                                            <?php foreach($lokasi as $l) : ?>
                                                <option value="<?= $l['id_lokasi'] ?>"><?= esc($l['nama_lokasi']) ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3 mt-md-0">
                                    <label class="form-label fw-semibold text-navy-dark"><i class="bi bi-grid-3x3 me-1"></i> Kode Slot <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg" name="id_slot" id="id_slot" required>
                                        <option value="" disabled selected>-- Pilih Slot Parkir --</option>
                                        <?php if(isset($slot)): ?>
                                            <?php foreach($slot as $s) : ?>
                                                <option value="<?= $s['id_slot'] ?>" data-jenis="<?= esc($s['jenis_slot']) ?>">
                                                    <?= esc($s['kode_slot']) ?> (<?= esc($s['jenis_slot']) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-navy-custom btn-lg flex-grow-1">
                                    <i class="bi bi-save me-2"></i> Simpan Data Masuk
                                </button>
                                <button type="reset" class="btn btn-light btn-lg border px-4">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="booking">
                <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid #e2e8f0 !important;">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background-color: #f1f5f9;">
                                <i class="bi bi-qr-code text-navy-dark" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold text-navy-dark mb-3">Verifikasi Kode Booking</h5>
                        <p class="text-muted mb-4">Masukkan kode reservasi yang telah diberikan kepada customer saat mereka melakukan pemesanan via aplikasi.</p>
                        
                        <form action="<?= site_url('petugas/cek_booking') ?>" method="post" class="mx-auto" style="max-width: 400px;">
                            <?= csrf_field() ?>
                            <div class="input-group input-group-lg mb-4 shadow-sm rounded-3">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                                <input type="text" name="kode_booking" class="form-control border-start-0 ps-0" placeholder="Contoh: BKG-2026-XYZ" required style="font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">
                            </div>
                            <button type="submit" class="btn btn-navy-custom btn-lg w-100 rounded-3 shadow-sm">
                                Verifikasi Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-lg-4">
        
        <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-left: 4px solid var(--navy-dark) !important; background-color: #f8fafc;">
            <div class="card-body p-4">
                <h6 class="fw-bold text-navy-dark mb-3"><i class="bi bi-info-circle-fill me-2"></i> Informasi Parkir Masuk</h6>
                <ul class="list-unstyled mb-0 text-muted small" style="line-height: 2;">
                    <li><i class="bi bi-check2 text-navy-dark me-2 fw-bold"></i> Pastikan plat nomor terbaca jelas</li>
                    <li><i class="bi bi-check2 text-navy-dark me-2 fw-bold"></i> Pilih jenis kendaraan sesuai kategori</li>
                    <li><i class="bi bi-check2 text-navy-dark me-2 fw-bold"></i> Merek dan warna wajib diisi sesuai kondisi fisik</li>
                    <li><i class="bi bi-check2 text-navy-dark me-2 fw-bold"></i> Waktu masuk tercatat otomatis</li>
                    <li class="text-danger mt-2"><i class="bi bi-exclamation-triangle-fill me-2"></i> Kendaraan yang belum keluar tidak bisa masuk lagi.</li>
                </ul>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold text-navy-dark mb-3">Statistik Hari Ini</h6>
                <div class="row g-3 text-center">
                    <div class="col-6">
                        <div class="p-3 border rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Total Masuk</small>
                            <h4 class="fw-bold text-navy-dark mb-0">7</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 border rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Mobil</small>
                            <h4 class="fw-bold text-navy-dark mb-0">3</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 border rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Motor</small>
                            <h4 class="fw-bold text-navy-dark mb-0">4</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 border rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Waktu</small>
                            <h5 class="fw-bold text-dark mb-0 font-monospace"><?= date('H:i') ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const radioJenis = document.querySelectorAll('input[name="jenis"]');
    const selectSlot = document.getElementById('id_slot');
    const optionsSlot = selectSlot.querySelectorAll('option:not([disabled])'); 

    // Fungsi untuk menyaring opsi slot
    function filterSlots(jenisTerpilih) {
        // Reset pilihan dropdown jadi kosong tiap kali ganti kendaraan
        selectSlot.value = "";
        
        optionsSlot.forEach(option => {
            // Cek apakah data-jenis dari slot sama dengan radio yang dipilih
            if (option.getAttribute('data-jenis').toLowerCase() === jenisTerpilih.toLowerCase()) {
                option.hidden = false;
                option.disabled = false;
            } else {
                option.hidden = true;
                option.disabled = true;
            }
        });
    }

    // Sembunyikan semua slot dulu sebelum diklik apa-apa
    optionsSlot.forEach(option => {
        option.hidden = true;
        option.disabled = true;
    });

    // Tambahkan event listener saat gambar motor/mobil diklik
    radioJenis.forEach(radio => {
        radio.addEventListener('change', function() {
            filterSlots(this.value);
        });
    });
});
</script>

<?= $this->endSection() ?>