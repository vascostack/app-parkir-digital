<?= $this->extend('layouts/v_user_layout') ?>

<?= $this->section('content') ?>
<section id="tab-history" class="animate-fade">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h2 class="fw-bold text-navy-dark mb-1">Riwayat Reservasi</h2>
      <p class="text-muted mb-0">Daftar lengkap booking parkir yang pernah Anda pesan sebelumnya.</p>
    </div>
  </div>

  <div class="premium-card p-3.5 mb-4">
    <div class="row g-3 align-items-center">
      <div class="col-md-4">
        <label class="form-label text-muted mb-1" style="font-size: 11px; font-weight: 600;">STATUS</label>
        <select class="form-select" id="history-filter-status" onchange="filterHistory()">
          <option value="Semua">Semua Status</option>
          <option value="pending">Belum Bayar (Pending)</option>
          <option value="dibooking">Aktif (Dibooking)</option>
          <option value="check-in">Selesai (Check-In)</option>
        </select>
      </div>
      <div class="col-md-5">
        <label class="form-label text-muted mb-1" style="font-size: 11px; font-weight: 600;">CARI KODE / LOKASI</label>
        <div class="input-group">
          <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
          <input type="text" class="form-control" id="history-filter-search" placeholder="Contoh: Gedung Utama, A01..." oninput="filterHistory()">
        </div>
      </div>
      <div class="col-md-3 text-md-end pt-3">
        <button class="btn btn-outline-navy w-100" onclick="resetHistoryFilters()">Reset Filter</button>
      </div>
    </div>
  </div>

  <div class="premium-card p-4">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Kode Booking</th>
            <th>Lokasi</th>
            <th class="text-center">Slot</th>
            <th>Kendaraan</th>
            <th>Waktu Kedatangan</th>
            <th>Status</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody id="historyTableBody">
          <?php if (!empty($history)): ?>
            <?php foreach ($history as $row): ?>
              <tr class="history-row" data-status="<?= $row['status_reservasi'] ?>" data-search="<?= strtolower($row['nama_lokasi'] . ' ' . $row['kode_slot'] . ' #RES-' . $row['id_reservasi']) ?>">

                <td class="font-monospace fw-bold text-secondary">#RES-<?= $row['id_reservasi'] ?></td>

                <td>
                  <div class="fw-bold text-dark"><?= esc($row['nama_lokasi']) ?></div>
                  <small class="text-muted text-truncate d-inline-block" style="max-width: 180px;"><?= esc($row['alamat']) ?></small>
                </td>

                <td class="text-center">
                  <span class="badge bg-dark px-2.5 py-1.5 font-monospace fs-7"><?= esc($row['kode_slot']) ?></span>
                </td>

                <td>
                  <div class="fw-semibold text-dark font-monospace text-uppercase"><?= esc($row['no_polisi'] ?? '-') ?></div>
                  <small class="text-muted text-capitalize"><?= esc($row['jenis'] ?? '-') ?></small>
                </td>

                <td>
                  <div class="small fw-medium text-dark"><?= date('d M Y', strtotime($row['waktu_kedatangan'])) ?></div>
                  <small class="text-danger font-monospace fw-bold"><?= date('H:i', strtotime($row['waktu_kedatangan'])) ?> - <?= date('H:i', strtotime($row['waktu_expired'])) ?> WIB</small>
                </td>

                <td>
                  <?php if ($row['status_reservasi'] === 'pending'): ?>
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill small fw-bold">
                      <i class="bi bi-clock-history me-1"></i> Belum Bayar
                    </span>
                  <?php elseif ($row['status_reservasi'] === 'dibooking'): ?>
                    <span class="badge bg-success text-white px-3 py-2 rounded-pill small fw-bold">
                      <i class="bi bi-check-circle-fill me-1"></i> Terbooking
                    </span>
                  <?php elseif ($row['status_reservasi'] === 'check-in'): ?>
                    <span class="badge bg-primary text-white px-3 py-2 rounded-pill small fw-bold">
                      <i class="bi bi-geo-alt-fill me-1"></i> Sudah Parkir
                    </span>
                  <?php else: ?>
                    <span class="badge bg-secondary text-white px-3 py-2 rounded-pill small fw-bold">
                      <?= esc($row['status_reservasi']) ?>
                    </span>
                  <?php endif; ?>
                </td>

                <td class="text-center">
                  <?php if ($row['status_reservasi'] === 'pending'): ?>
                    <a href="<?= site_url('user/booking/payment/' . $row['id_reservasi']) ?>" class="btn btn-sm btn-navy fw-bold px-3 shadow-sm">
                      <i class="bi bi-wallet2 me-1"></i> Bayar
                    </a>
                  <?php else: ?>
                    <button class="btn btn-sm btn-light border text-muted px-3" disabled>
                      <i class="bi bi-lock-fill"></i> Detail
                    </button>
                  <?php endif; ?>
                </td>

              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center py-5 text-muted">
                <i class="bi bi-folder-x fs-1 d-block mb-2 opacity-50"></i>
                Belum ada riwayat reservasi slot parkir.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<script>
  function filterHistory() {
    let statusFilter = document.getElementById('history-filter-status').value;
    let searchFilter = document.getElementById('history-filter-search').value.toLowerCase();
    let rows = document.querySelectorAll('.history-row');

    rows.forEach(row => {
      let rowStatus = row.getAttribute('data-status');
      let rowSearch = row.getAttribute('data-search');

      let matchStatus = (statusFilter === 'Semua' || rowStatus === statusFilter);
      let matchSearch = rowSearch.includes(searchFilter);

      if (matchStatus && matchSearch) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  }

  function resetHistoryFilters() {
    document.getElementById('history-filter-status').value = 'Semua';
    document.getElementById('history-filter-search').value = '';
    filterHistory();
  }
</script>
<?= $this->endSection() ?>