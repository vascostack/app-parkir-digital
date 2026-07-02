<?= $this->extend('layouts/v_user_layout') ?>

<?= $this->section('content') ?>
<div class="container py-5 font-sans" style="min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-5">
            
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden text-center">
                
                <div class="card-header border-0 text-white px-4 py-5" style="background: linear-gradient(135deg, #0f172a, #1e1b4b);">
                    <h4 class="fw-bold mb-1 tracking-wide">Gerbang Pembayaran</h4>
                    <p class="small text-muted mb-0 text-light opacity-75">Pindai kode QRIS di bawah untuk menyelesaikan reservasi</p>
                </div>
                
                <div class="card-body p-4 d-flex flex-column align-items-center">
                    
                    <div class="mb-4 bg-light rounded-3 p-3 w-100 border">
                        <span class="text-uppercase text-muted fw-bold d-block small mb-1" style="font-size: 11px; letter-spacing: 0.05em;">Total yang Harus Dibayar</span>
                        <h3 class="fw-black text-dark mb-0">
                            <span class="text-success fw-bold me-1">Rp</span><?php echo number_format((float)(isset($reservasi['biaya_booking']) ? $reservasi['biaya_booking'] : 0), 0, ',', '.'); ?>
                        </h3>
                    </div>

                    <div class="bg-white rounded-3 p-3 text-start small mb-4 border w-100 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Gedung / Lokasi</span>
                            <span class="fw-semibold text-dark bg-light px-2.5 py-1 rounded">
                                <?php echo isset($reservasi['nama_lokasi']) ? esc($reservasi['nama_lokasi']) : '-'; ?>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Kode Slot Parkir</span>
                            <span class="fw-bold text-primary bg-light px-3 py-1 rounded text-uppercase border tracking-wider">
                                <?php echo isset($reservasi['kode_slot']) ? esc($reservasi['kode_slot']) : '-'; ?>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <span class="text-muted">Nomor Invoice</span>
                            <span class="text-secondary font-monospace fw-semibold">
                                #RES-<?php echo isset($reservasi['id_reservasi']) ? esc($reservasi['id_reservasi']) : '0'; ?>
                            </span>
                        </div>
                    </div>

                    <div class="position-relative bg-white p-4 border rounded-4 shadow-sm mb-4 d-flex flex-column align-items-center justify-content-center" style="max-width: 260px;">
                        
                        <div class="position-absolute bg-success text-white fw-bold px-3 py-1 rounded-pill uppercase text-nowrap shadow-sm" style="top: -12px; font-size: 9px; letter-spacing: 0.1em; left: 50%; transform: translateX(-50%);">
                            QRIS Standar
                        </div>
                        
                        <div class="bg-light p-2 rounded-3 border border-dashed text-center d-flex align-items-center justify-content-center" style="width: 190px; height: 190px;">
                            <img src="<?php echo isset($qrCodeImage) ? $qrCodeImage : ''; ?>" alt="QRIS Parkir Digital" class="img-fluid d-block mx-auto" style="max-height: 170px; object-fit: contain;">
                        </div>
                        
                        <div class="mt-3 bg-warning bg-opacity-10 border border-warning rounded-3 p-2 text-warning fw-bold w-100 d-flex align-items-center justify-content-center gap-2" style="font-size: 10px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 text-warning" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                            </svg>
                            <span class="text-nowrap text-dark">Lingkungan Simulasi Sandbox</span>
                        </div>
                    </div>

                    <form action="<?php echo site_url('user/booking/pay-process'); ?>" method="POST" class="w-100 mt-2">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id_reservasi" value="<?php echo isset($reservasi['id_reservasi']) ? esc($reservasi['id_reservasi']) : ''; ?>">
                        <input type="hidden" name="jumlah" value="<?php echo isset($reservasi['biaya_booking']) ? esc($reservasi['biaya_booking']) : '0'; ?>">

                        <button type="submit" class="btn btn-dark w-100 fw-bold py-3 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2 tracking-wide" style="background-color: #0f172a;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                            KONFIRMASI SIMULASI PEMBAYARAN
                        </button>
                    </form>

                    <div class="mt-4 pt-3 border-top w-100 text-center">
                        <a href="<?php echo site_url('user/history'); ?>" class="text-decoration-none text-muted small fw-medium">
                            Bayar Nanti, Lihat Riwayat Booking &rarr;
                        </a>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</div>
<?= $this->endSection() ?>