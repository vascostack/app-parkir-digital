<?= $this->extend('layouts/v_petugas_layout') ?>

<?= $this->section('content') ?>
<!-- Tambahkan CDN Select2 untuk Searchable Dropdown -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* Styling Umum Tema Navy */
    .bg-navy {
        background-color: var(--navy-dark, #0f172a);
    }

    .text-navy {
        color: var(--navy-dark, #0f172a);
    }

    .card-premium {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    /* Tombol Aksi */
    .btn-coral {
        background-color: #ef4444;
        color: white;
        border-radius: 8px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-coral:hover {
        background-color: #dc2626;
        color: white;
    }

    .btn-navy-outline {
        border: 2px solid var(--navy-dark, #0f172a);
        color: var(--navy-dark, #0f172a);
        background: transparent;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-navy-outline:hover {
        background: var(--navy-dark, #0f172a);
        color: white;
    }

    /* Box Estimasi */
    .estimasi-box {
        background-color: #fef9c3;
        border: 1px solid #fde047;
        border-radius: 8px;
        padding: 15px;
        display: none;
    }

    /* Styling Struk */
    .receipt-container {
        max-width: 450px;
        margin: 0 auto;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border-top: 8px solid #22c55e;
    }

    .receipt-header {
        text-align: center;
        border-bottom: 2px dashed #cbd5e1;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }

    .receipt-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .receipt-total {
        border-top: 2px dashed #cbd5e1;
        padding-top: 15px;
        margin-top: 15px;
        font-weight: bold;
        font-size: 1.1rem;
    }

    /* Styling Kustom Select2 agar cocok dengan form-select-lg Bootstrap */
    .select2-container .select2-selection--single {
        height: 48px;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        display: flex;
        align-items: center;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px;
    }

    /* Sembunyikan elemen lain saat nge-print */
    @media print {
        body * {
            visibility: hidden;
        }

        .receipt-container,
        .receipt-container * {
            visibility: visible;
        }

        .receipt-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            box-shadow: none;
            border: none;
            padding: 0;
            margin: 0;
        }

        .no-print {
            display: none !important;
        }

        .main-sidebar,
        .main-header {
            display: none !important;
        }
    }
</style>

<div class="mb-4 d-flex justify-content-between align-items-center no-print">
    <div>
        <h3 class="fw-bold text-navy mb-1">Parkir Keluar</h3>
        <p class="text-muted">Proses checkout kendaraan dari area parkir</p>
    </div>
</div>

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 no-print" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('pesan') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 no-print" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('struk')): ?>
    <?php $struk = session()->getFlashdata('struk'); ?>
    <div class="receipt-container mt-4">
        <div class="receipt-header">
            <h5 class="fw-bold mb-1">PRIME PARKING</h5>
            <small class="text-muted">Sistem Parkir Digital</small><br>
            <small class="text-muted">Jl. Contoh No. 123, Kota Anda</small>
        </div>

        <div class="receipt-body">
            <div class="receipt-row">
                <span class="text-muted">ID Transaksi</span>
                <span class="fw-semibold">#<?= $struk['id_transaksi'] ?></span>
            </div>
            <div class="receipt-row">
                <span class="text-muted">Plat Nomor</span>
                <span class="fw-bold text-dark"><?= strtoupper($struk['no_polisi']) ?></span>
            </div>
            <div class="receipt-row">
                <span class="text-muted">Jenis Kendaraan</span>
                <span><?= ucfirst($struk['jenis']) ?></span>
            </div>
            <div class="receipt-row">
                <span class="text-muted">Waktu Masuk</span>
                <span><?= $struk['waktu_masuk'] ?></span>
            </div>
            <div class="receipt-row">
                <span class="text-muted">Waktu Keluar</span>
                <span><?= $struk['waktu_keluar'] ?></span>
            </div>
            <div class="receipt-row">
                <span class="text-muted">Durasi Parkir</span>
                <span><?= $struk['durasi_menit'] ?> menit</span>
            </div>

            <div class="receipt-row mt-3">
                <span class="text-muted">Tarif per Jam</span>
                <span>Rp <?= number_format($struk['tarif_jam'], 0, ',', '.') ?></span>
            </div>
            <div class="receipt-row">
                <span class="text-muted">Lama Parkir</span>
                <span><?= $struk['durasi_jam'] ?> jam</span>
            </div>

            <div class="receipt-row receipt-total text-danger">
                <span>TOTAL BAYAR</span>
                <span>Rp <?= number_format($struk['total_bayar'], 0, ',', '.') ?></span>
            </div>
        </div>

        <div class="text-center mt-4 mb-3">
            <small class="text-muted">Terima kasih atas kunjungan Anda</small><br>
            <small class="text-muted" style="font-size: 0.7rem;">Struk ini sah sebagai bukti pembayaran</small>
        </div>

        <div class="d-flex gap-2 mt-4 justify-content-center no-print">
            <button onclick="window.print()" class="btn btn-primary flex-grow-1"><i class="bi bi-printer me-1"></i> Cetak Struk</button>
            <a href="<?= site_url('petugas/keluar') ?>" class="btn btn-secondary flex-grow-1"><i class="bi bi-arrow-repeat me-1"></i> Transaksi Baru</a>
        </div>
    </div>

<?php else: ?>
    <div class="row g-4 no-print">
        <div class="col-lg-8">
            <!-- Form Aksi Cepat -->
            <div class="card card-premium p-4 mb-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-danger text-white rounded p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-box-arrow-right fs-5"></i>
                    </div>
                    <h5 class="fw-bold mb-0">Pilih Kendaraan Keluar</h5>
                </div>

                <form id="formCheckout" action="<?= site_url('petugas/konfirmasi_keluar') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted small">Cari Plat Nomor Kendaraan <span class="text-danger">*</span></label>
                        <select name="id_transaksi" id="selectKendaraan" class="form-select form-select-lg select2-init" style="width: 100%;" required>
                            <option value="" selected disabled>-- Ketik Plat Nomor --</option>
                            <?php foreach ($kendaraan_parkir as $k) : ?>
                                <option value="<?= $k['id_transaksi'] ?>"
                                    data-plat="<?= strtoupper($k['no_polisi']) ?>"
                                    data-jenis="<?= $k['jenis'] ?>"
                                    data-waktumasuk="<?= str_replace(' ', 'T', $k['waktu_masuk']) ?>">
                                    <?= strtoupper($k['no_polisi']) ?> - (<?= ucfirst($k['jenis']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted mt-2 d-block"><i class="bi bi-search me-1"></i> Ketik nomor plat untuk pencarian cepat.</small>
                    </div>

                    <div id="estimasiBox" class="estimasi-box mb-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-calculator me-1"></i> Estimasi Pembayaran</h6>
                        <div class="row">
                            <div class="col-6">
                                <small class="text-muted d-block">Durasi Parkir</small>
                                <span class="fw-bold fs-5" id="estDurasi">-</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Estimasi Biaya</small>
                                <span class="fw-bold fs-5 text-danger" id="estBiaya">Rp 0</span>
                            </div>
                        </div>
                        <small class="text-muted d-block mt-2" style="font-size: 0.75rem;">* Perhitungan berdasarkan durasi parkir dan tarif per jam (pembulatan ke atas).</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" id="btnProsesKeluar" class="btn btn-coral btn-lg flex-grow-1" disabled>
                            <i class="bi bi-box-arrow-right me-2"></i> Proses Parkir Keluar
                        </button>
                        <button type="reset" id="btnBatal" class="btn btn-light border btn-lg px-4">
                            <i class="bi bi-x"></i> Batal
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel dengan Fitur Tab -->
            <div class="card card-premium p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-car-front me-2"></i> Daftar Kendaran Sedang Parkir</h6>
                    <span class="badge bg-warning text-dark rounded-pill"><?= count($kendaraan_parkir) ?> Total</span>
                </div>

                <!-- Nav Tabs -->
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-semibold" id="pills-semua-tab" data-bs-toggle="pill" data-bs-target="#pills-semua" type="button" role="tab" aria-controls="pills-semua" aria-selected="true">Semua</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold text-success" id="pills-motor-tab" data-bs-toggle="pill" data-bs-target="#pills-motor" type="button" role="tab" aria-controls="pills-motor" aria-selected="false"><i class="bi bi-scooter"></i> Motor</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold text-primary" id="pills-mobil-tab" data-bs-toggle="pill" data-bs-target="#pills-mobil" type="button" role="tab" aria-controls="pills-mobil" aria-selected="false"><i class="bi bi-car-front"></i> Mobil</button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="pills-tabContent">

                    <!-- TAB SEMUA -->
                    <div class="tab-pane fade show active" id="pills-semua" role="tabpanel" aria-labelledby="pills-semua-tab">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Plat Nomor</th>
                                        <th>Jenis</th>
                                        <th>Durasi Parkir</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($kendaraan_parkir) > 0): ?>
                                        <?php foreach ($kendaraan_parkir as $kp) : ?>
                                            <tr class="row-parkir" data-waktumasuk="<?= str_replace(' ', 'T', $kp['waktu_masuk']) ?>" data-jenis="<?= $kp['jenis'] ?>">
                                                <td class="fw-bold"><?= strtoupper($kp['no_polisi']) ?></td>
                                                <td>
                                                    <?php if ($kp['jenis'] == 'motor'): ?>
                                                        <span class="text-success"><i class="bi bi-scooter"></i> Motor</span>
                                                    <?php else: ?>
                                                        <span class="text-primary"><i class="bi bi-car-front"></i> Mobil</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="fw-bold text-navy p-0 m-0 class-durasi">-</div>
                                                    <small class="text-muted text-xs">Masuk: <?= date('H:i', strtotime($kp['waktu_masuk'])) ?></small>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-pilih-cepat" data-id="<?= $kp['id_transaksi'] ?>">Checkout</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Kosong.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB MOTOR -->
                    <div class="tab-pane fade" id="pills-motor" role="tabpanel" aria-labelledby="pills-motor-tab">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Plat Nomor</th>
                                        <th>Durasi Parkir</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $countMotor = 0;
                                    foreach ($kendaraan_parkir as $kp) :
                                        if ($kp['jenis'] == 'motor'): $countMotor++;
                                    ?>
                                            <tr class="row-parkir" data-waktumasuk="<?= str_replace(' ', 'T', $kp['waktu_masuk']) ?>" data-jenis="<?= $kp['jenis'] ?>">
                                                <td class="fw-bold"><?= strtoupper($kp['no_polisi']) ?></td>
                                                <td>
                                                    <div class="fw-bold text-navy p-0 m-0 class-durasi">-</div>
                                                    <small class="text-muted text-xs">Masuk: <?= date('H:i', strtotime($kp['waktu_masuk'])) ?></small>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-pilih-cepat" data-id="<?= $kp['id_transaksi'] ?>">Checkout</button>
                                                </td>
                                            </tr>
                                    <?php endif;
                                    endforeach; ?>
                                    <?php if ($countMotor == 0): ?>
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">Tidak ada motor.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB MOBIL -->
                    <div class="tab-pane fade" id="pills-mobil" role="tabpanel" aria-labelledby="pills-mobil-tab">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Plat Nomor</th>
                                        <th>Durasi Parkir</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $countMobil = 0;
                                    foreach ($kendaraan_parkir as $kp) :
                                        if ($kp['jenis'] == 'mobil'): $countMobil++;
                                    ?>
                                            <tr class="row-parkir" data-waktumasuk="<?= str_replace(' ', 'T', $kp['waktu_masuk']) ?>" data-jenis="<?= $kp['jenis'] ?>">
                                                <td class="fw-bold"><?= strtoupper($kp['no_polisi']) ?></td>
                                                <td>
                                                    <div class="fw-bold text-navy p-0 m-0 class-durasi">-</div>
                                                    <small class="text-muted text-xs">Masuk: <?= date('H:i', strtotime($kp['waktu_masuk'])) ?></small>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-pilih-cepat" data-id="<?= $kp['id_transaksi'] ?>">Checkout</button>
                                                </td>
                                            </tr>
                                    <?php endif;
                                    endforeach; ?>
                                    <?php if ($countMobil == 0): ?>
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">Tidak ada mobil.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Sidebar Informasi Parkir -->
            <div class="card card-premium p-4 mb-4" style="background-color: #fdfbf7;">
                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle text-danger me-2"></i> Informasi Parkir Keluar</h6>
                <ul class="list-unstyled mb-0 text-muted small" style="line-height: 2;">
                    <li><i class="bi bi-check2 text-success me-2 fw-bold"></i> Cari plat atau pilih dari tabel</li>
                    <li><i class="bi bi-check2 text-success me-2 fw-bold"></i> Sistem hitung durasi otomatis</li>
                    <li><i class="bi bi-check2 text-success me-2 fw-bold"></i> Biaya dihitung per jam (pembulatan ke atas)</li>
                    <li><i class="bi bi-check2 text-success me-2 fw-bold"></i> Struk dapat dicetak atau disalin</li>
                </ul>
                <hr>
                <h6 class="fw-bold text-dark mb-3">Tarif Parkir per Jam</h6>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-success fw-semibold"><i class="bi bi-scooter me-1"></i> Motor</span>
                    <span class="fw-bold text-success">Rp 2.000/jam</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-primary fw-semibold"><i class="bi bi-car-front me-1"></i> Mobil</span>
                    <span class="fw-bold text-primary">Rp 5.000/jam</span>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 rounded-4 shadow-lg text-center p-4">
            <div class="modal-body">
                <div class="mb-3">
                    <div class="rounded-circle border border-2 border-secondary text-secondary d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                        <i class="bi bi-question fs-1"></i>
                    </div>
                </div>
                <h5 class="fw-bold mb-3">Konfirmasi Parkir Keluar</h5>

                <div class="bg-light rounded p-2 mb-4 text-start small">
                    <div class="mb-1"><strong>Plat:</strong> <span id="modalPlat">-</span></div>
                    <div class="mb-1"><strong>Durasi:</strong> <span id="modalDurasi">-</span></div>
                    <div><strong>Estimasi:</strong> <span class="text-danger fw-bold" id="modalBiaya">-</span></div>
                </div>

                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-coral px-4" id="btnSubmitFinal">Ya, Proses Keluar</button>
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan script jQuery dan Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const estimasiBox = document.getElementById('estimasiBox');
        const estDurasi = document.getElementById('estDurasi');
        const estBiaya = document.getElementById('estBiaya');
        const btnProses = document.getElementById('btnProsesKeluar');
        const formCheckout = document.getElementById('formCheckout');

        
        let waktuServer = new Date(); 

        if ($('.select2-init').length > 0) {
            $('.select2-init').select2({
                placeholder: "-- Ketik Plat Nomor --",
                allowClear: true
            });
        }

        let modalKonfirmasi;
        const modalEl = document.getElementById('modalKonfirmasi');
        if (modalEl) {
            modalKonfirmasi = new bootstrap.Modal(modalEl);
        }


        setInterval(function() {
            waktuServer.setSeconds(waktuServer.getSeconds() + 1);
        }, 1000);

        function hitungEstimasi(selectedOption) {
            if (!selectedOption) return;

            const waktuMasukStr = selectedOption.getAttribute('data-waktumasuk');
            const jenis = selectedOption.getAttribute('data-jenis');
            const plat = selectedOption.getAttribute('data-plat');

            if (!waktuMasukStr) return;

            const parts = waktuMasukStr.split(/[- :T]/);
            const waktuMasuk = new Date(parts[0], parts[1] - 1, parts[2], parts[3], parts[4], parts[5]);

           
            let selisihMs = waktuServer - waktuMasuk;
            
            if (selisihMs > 24000000 && (waktuServer.getHours() - waktuMasuk.getHours() >= 7)) {
                selisihMs -= 7 * 60 * 60 * 1000; 
            }
            if (selisihMs < 0) selisihMs = 0;

            const menitTotal = Math.floor(selisihMs / 60000);
            const jam = Math.floor(menitTotal / 60);
            const sisaMenit = menitTotal % 60;

            let textDurasi = '';
            if (jam > 0) textDurasi += jam + ' jam ';
            textDurasi += sisaMenit + ' menit';

            const tarifPerJam = (jenis === 'mobil') ? 5000 : 2000;
            let totalBiaya = 0;

            if (menitTotal > 0) {
                let jamDihitung = Math.ceil(menitTotal / 60);
                totalBiaya = jamDihitung * tarifPerJam;
            }

            const formatRupiah = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(totalBiaya);

            estDurasi.textContent = textDurasi;
            estBiaya.textContent = formatRupiah;
            document.getElementById('modalPlat').textContent = plat + ' (' + jenis + ')';
            document.getElementById('modalDurasi').textContent = textDurasi;
            document.getElementById('modalBiaya').textContent = formatRupiah;

            btnProses.disabled = false;
            estimasiBox.style.display = 'block';
        }

        $('#selectKendaraan').on('select2:select', function(e) {
            hitungEstimasi(e.params.data.element);
        });

        $('#selectKendaraan').on('select2:unselect', function() {
            estimasiBox.style.display = 'none';
            btnProses.disabled = true;
        });

        $('.btn-pilih-cepat').on('click', function() {
            const idTransaksi = $(this).data('id');
            $('#selectKendaraan').val(idTransaksi).trigger('change.select2');
            const selectedOption = $('#selectKendaraan option[value="' + idTransaksi + '"]')[0];
            hitungEstimasi(selectedOption);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        document.getElementById('btnBatal').addEventListener('click', function() {
            $('#selectKendaraan').val(null).trigger('change.select2');
            estimasiBox.style.display = 'none';
            btnProses.disabled = true;
        });

        btnProses.addEventListener('click', function() {
            if (modalKonfirmasi) modalKonfirmasi.show();
        });

        document.getElementById('btnSubmitFinal').addEventListener('click', function() {
            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
            this.disabled = true;
            formCheckout.submit();
        });

        function updateSemuaDurasiTabel() {
            const semuaBaris = document.querySelectorAll('.row-parkir');

            semuaBaris.forEach(row => {
                const waktuMasukStr = row.getAttribute('data-waktumasuk');
                const targetTeks = row.querySelector('.class-durasi');

                if (!waktuMasukStr || !targetTeks) return;

                const parts = waktuMasukStr.split(/[- :T]/);
                const waktuMasuk = new Date(parts[0], parts[1] - 1, parts[2], parts[3], parts[4], parts[5]);
                
                let selisihMs = waktuServer - waktuMasuk;
                
                if (selisihMs > 24000000 && (waktuServer.getHours() - waktuMasuk.getHours() >= 7)) {
                    selisihMs -= 7 * 60 * 60 * 1000;
                }
                if (selisihMs < 0) selisihMs = 0;

                const detikTotal = Math.floor(selisihMs / 1000);
                const menitTotal = Math.floor(detikTotal / 60);
                const jam = Math.floor(menitTotal / 60);
                const sisaMenit = menitTotal % 60;
                const sisaDetik = detikTotal % 60;

                let textDurasi = '';
                if (jam > 0) textDurasi += jam + 'j ';
                if (menitTotal > 0 || jam > 0) textDurasi += sisaMenit + 'm ';
                textDurasi += sisaDetik + 'd';

                targetTeks.textContent = textDurasi;
            });
        }

        updateSemuaDurasiTabel();
        setInterval(updateSemuaDurasiTabel, 1000);
    });
</script>

<?= $this->endSection() ?>