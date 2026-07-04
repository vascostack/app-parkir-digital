<?= $this->extend('layouts/v_user_layout') ?>

<?= $this->section('content') ?>
<section id="tab-booking" class="animate-fade">
  <div class="mb-4">
    <h2 class="fw-bold text-navy-dark mb-1">Sistem Pemesanan Slot Parkir</h2>
    <p class="text-muted mb-0">Ikuti 3 langkah mudah untuk mengamankan slot parkir eksklusif Anda.</p>
  </div>
  
  <div class="mx-auto mb-2 position-relative" style="max-width: 600px; height: 40px;">
    <div class="position-absolute start-0 end-0 bg-light-subtle border-top" style="top: 50%; transform: translateY(-50%); z-index: 1; height: 4px; background-color: #e9ecef;"></div>
    <div class="position-absolute start-0" id="stepIndicatorLine" style="top: 50%; transform: translateY(-50%); z-index: 1; height: 4px; width: 0%; background-color: #0d233a; transition: width 0.3s ease;"></div>
    
    <div class="d-flex justify-content-between position-absolute w-100 h-100 align-items-center" style="z-index: 2;">
      <div class="step-circle active" id="circleStep1">1</div>
      <div class="step-circle" id="circleStep2">2</div>
      <div class="step-circle" id="circleStep3">3</div>
    </div>
  </div>
  
  <div class="d-flex justify-content-between text-muted px-md-5 mb-5 mx-auto" style="max-width: 650px; font-size: 13px; font-weight: 500;">
    <span class="text-center" style="width: 100px;">1. Pilih Gedung</span>
    <span class="text-center" style="width: 100px;">2. Pilih Slot Parkir</span>
    <span class="text-center" style="width: 100px;">3. Konfirmasi Booking</span>
  </div>

  <div id="booking-step-1" class="booking-step-container">
    <h5 class="fw-semibold text-navy-dark mb-3">Daftar Gedung Parkir Premium</h5>
    <p class="text-muted mb-4" style="font-size: 14px;">Pilih lokasi gedung yang ingin Anda gunakan.</p>
    <div class="row g-4" id="building-cards-container">
        </div>
  </div>

  <div id="booking-step-2" class="d-none booking-step-container">
    <div class="p-4 mb-4 bg-white shadow-sm rounded-3 border">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-2 text-uppercase" style="font-size: 12px; font-weight: 600; letter-spacing: 0.5px;">
          <li class="breadcrumb-item"><a href="#" onclick="goBackToStep1()" class="text-decoration-none text-navy-dark">Home</a></li>
          <li class="breadcrumb-item"><a href="#" onclick="goBackToStep1()" class="text-decoration-none text-navy-dark">Booking</a></li>
          <li class="breadcrumb-item active text-muted" aria-current="page" id="breadcrumb-active-building">Gedung A</li>
        </ol>
      </nav>
      <div class="row align-items-center">
        <div class="col-md-8">
          <h3 class="fw-bold text-navy-dark mb-1" id="step2-building-title">Gedung A</h3>
          <p class="text-muted mb-0" id="step2-building-slots-info">0 slot tersedia</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
          <div class="btn-group border p-1 rounded-3 bg-light" role="group">
            <button type="button" class="btn btn-sm btn-navy rounded-2 px-3 py-1.5 active" id="btnFilterMobil" onclick="setVehicleFilter('Mobil')">
              <i class="bi bi-car-front-fill me-1"></i> Mobil
            </button>
            <button type="button" class="btn btn-sm btn-light rounded-2 px-3 py-1.5" id="btnFilterMotor" onclick="setVehicleFilter('Motor')">
              <i class="bi bi-bicycle me-1"></i> Motor
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-lg-7">
        <div class="p-4 text-center bg-white shadow-sm rounded-3 border">
          <h6 class="text-uppercase text-muted mb-4" style="letter-spacing: 1px; font-size: 11px; font-weight: 600;" id="denah-title">Denah Area Parkir (Mobil)</h6>
          
          <div class="d-flex justify-content-center gap-3 flex-wrap mb-4" style="font-size: 12px;">
            <span class="d-flex align-items-center gap-2"><span class="d-inline-block rounded-circle" style="width: 12px; height: 12px; background-color: #28a745;"></span> Tersedia</span>
            <span class="d-flex align-items-center gap-2"><span class="d-inline-block rounded-circle" style="width: 12px; height: 12px; background-color: #ffc107;"></span> Dipesan</span>
            <span class="d-flex align-items-center gap-2"><span class="d-inline-block rounded-circle" style="width: 12px; height: 12px; background-color: #dc3545;"></span> Terisi</span>
            <span class="d-flex align-items-center gap-2"><span class="d-inline-block rounded-circle" style="width: 12px; height: 12px; background-color: #007bff;"></span> Pilihan</span>
          </div>
          
          <div class="d-flex flex-wrap justify-content-center gap-3 mb-4" id="slots-grid-container">
              </div>
          
          <div class="border-top pt-3 text-muted" style="font-size: 12px;">
            <i class="bi bi-info-circle"></i> Klik pada slot berwarna hijau (tersedia) untuk memilih.
          </div>
        </div>
      </div>
      
      <div class="col-lg-5">
        <div class="p-4 h-100 d-flex flex-column justify-content-between bg-white shadow-sm rounded-3 border">
          <div>
            <h5 class="fw-bold text-navy-dark mb-3 border-bottom pb-2">Ringkasan Pilihan Slot</h5>
            
            <div class="d-flex justify-content-between mb-3">
              <span class="text-muted">Gedung Dipilih</span>
              <strong class="text-navy-dark" id="summary-building-name">-</strong>
            </div>
            <div class="d-flex justify-content-between mb-3">
              <span class="text-muted">Tipe Kendaraan</span>
              <strong class="text-navy-dark" id="summary-vehicle-type">Mobil</strong>
            </div>
            <div class="d-flex justify-content-between mb-4">
              <span class="text-muted">Slot Terpilih</span>
              <strong class="text-primary fs-5" id="summary-slot-id">Belum Memilih</strong>
            </div>
            
            <div class="bg-light p-3 rounded-3 mb-4 text-center">
              <p class="mb-0 text-muted" style="font-size: 13px;">Estimasi Tarif Parkir</p>
              <h3 class="fw-bold text-navy-dark mb-0" id="summary-parking-price">Rp 0 <small class="text-muted" style="font-size: 12px;">/jam</small></h3>
            </div>
          </div>
          
          <div class="d-flex gap-3">
            <button class="btn btn-outline-secondary flex-grow-1" onclick="goBackToStep1()">KEMBALI</button>
            <button class="btn btn-navy flex-grow-1" id="btnNextToStep3" disabled onclick="goToStep3()">LANJUTKAN</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="booking-step-3" class="d-none booking-step-container">
    <div class="row g-4 justify-content-center">
      <div class="col-md-8 col-lg-7">
        <div class="p-4 bg-white shadow-sm rounded-3 border">
          <h4 class="fw-bold text-navy-dark mb-4 border-bottom pb-3">Konfirmasi Detail Reservasi</h4>
          
          <div class="p-3 bg-light rounded-4 mb-4 border">
            <div class="row">
              <div class="col-6 mb-3">
                <span class="text-muted d-block" style="font-size: 11px; font-weight:600; text-transform:uppercase;">Lokasi Gedung</span>
                <strong class="text-navy-dark" id="checkout-building">-</strong>
              </div>
              <div class="col-6 mb-3">
                <span class="text-muted d-block" style="font-size: 11px; font-weight:600; text-transform:uppercase;">Slot Pilihan</span>
                <strong class="text-primary" id="checkout-slot">-</strong>
              </div>
              <div class="col-6">
                <span class="text-muted d-block" style="font-size: 11px; font-weight:600; text-transform:uppercase;">Kategori</span>
                <strong class="text-navy-dark" id="checkout-category">-</strong>
              </div>
              <div class="col-6">
                <span class="text-muted d-block" style="font-size: 11px; font-weight:600; text-transform:uppercase;">Biaya Dasar</span>
                <strong class="text-navy-dark" id="checkout-price">-</strong>
              </div>
            </div>
          </div>
          
          <form action="<?= site_url('user/booking/process') ?>" method="POST" id="bookingConfirmationForm">
            <?= csrf_field() ?>
            <input type="hidden" name="id_lokasi" id="input-hidden-lokasi">
            <input type="hidden" name="id_slot" id="input-hidden-slot">
            <input type="hidden" name="jenis_kendaraan" id="input-hidden-jenis">

            <div class="mb-3">
              <label class="form-label text-navy-dark fw-semibold" style="font-size: 13px;">Pilih Kendaraan Anda</label>
              <select class="form-select border" id="checkout-vehicle-select" name="id_kendaraan" required>
                  <option value="" disabled selected>-- Pilih Kendaraan Anda --</option>
                  <?php if (!empty($kendaraan)): ?>
                    <?php foreach ($kendaraan as $k): ?>
                      <option value="<?= $k['id_kendaraan'] ?>" data-jenis="<?= strtolower($k['jenis']) ?>">
                        <?= esc($k['no_polisi']) ?> - <?= esc($k['merek']) ?> (<?= ucfirst($k['jenis']) ?>)
                      </option>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <option value="" disabled>Anda belum mendaftarkan kendaraan</option>
                  <?php endif; ?>
              </select>
              <div class="form-text text-danger" id="vehicle-warning" style="display:none; font-size: 12px;">
                ⚠️ Jenis kendaraan yang Anda pilih tidak sesuai dengan kategori tipe slot parkir!
              </div>
            </div>
            
            <div class="mb-4">
              <label class="form-label text-navy-dark fw-semibold" style="font-size: 13px;">Rencana Waktu Kedatangan</label>
              <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-calendar-event"></i></span>
                <input type="datetime-local" class="form-control bg-white border-start-0" id="checkout-arrival-time" name="waktu_masuk" required>
              </div>
            </div>
            
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-navy py-3 fs-6" id="btnSubmitBooking">
                <i class="bi bi-shield-check me-2"></i> KONFIRMASI BOOKING PARKIR
              </button>
              <button type="button" class="btn btn-link text-muted text-decoration-none" onclick="goBackToStep2()">Kembali Pilih Slot</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  .btn-navy { background-color: #0d233a; color: white; }
  .btn-navy:hover { background-color: #163352; color: white; }
  .text-navy-dark { color: #0d233a; }
  
  .step-circle {
    width: 36px; height: 36px; border-radius: 50%; background-color: #e9ecef;
    display: flex; align-items: center; justify-content: center; font-weight: bold; color: #6c757d;
    transition: all 0.3s ease; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  .step-circle.active { background-color: #0d233a; color: white; border-color: #0d233a; }
  .step-circle.completed { background-color: #28a745; color: white; border-color: #28a745; }
  
  .slot-box {
    width: 75px; height: 75px; border-radius: 12px; display: flex; flex-direction: column;
    align-items: center; justify-content: center; font-weight: bold; font-size: 14px;
    cursor: pointer; transition: all 0.2s ease; color: white;
  }
  .slot-available { background-color: #28a745; }
  .slot-available:hover { transform: scale(1.05); }
  .slot-booked { background-color: #ffc107; cursor: not-allowed; opacity: 0.8; }
  .slot-occupied { background-color: #dc3545; cursor: not-allowed; opacity: 0.8; }
  .slot-selected { background-color: #007bff; transform: scale(1.05); box-shadow: 0 4px 10px rgba(0,123,255,0.4); }
  .slot-box small { font-size: 10px; font-weight: normal; margin-top: 2px; }
</style>

<script>
// 1. Ambil data lokasi dari PHP ke Object JS
const buildingsData = [
  <?php foreach ($lokasi as $l): ?>
  { 
    id: <?= $l['id_lokasi'] ?>, 
    name: '<?= esc($l['nama_lokasi']) ?>', 
    address: '<?= esc($l['alamat'] ?? 'Alamat Gedung') ?>', 
    price: <?= $l['tarif_per_jam'] ?? 5000 ?>
  },
  <?php endforeach; ?>
];

// 2. Ambil data slot dari PHP ke Array JS
const globalSlotsData = [
  <?php foreach ($slot as $s): ?>
  {
    id: <?= $s['id_slot'] ?>,
    id_lokasi: <?= $s['id_lokasi'] ?>,
    code: '<?= esc($s['kode_slot']) ?>',
    jenis: '<?= strtolower($s['jenis_slot']) ?>', // mobil / motor
    status: '<?= esc($s['status_slot']) ?>' // tersedia / dipesan / terisi
  },
  <?php endforeach; ?>
];

let bookingState = {
  selectedBuilding: null,
  selectedVehicleType: 'Mobil', // Default Tab Filter
  selectedSlot: null
};

document.addEventListener("DOMContentLoaded", function() {
  renderBuildingCards();
  
  // Set default min date-time untuk kedatangan hari ini
  const now = new Date();
  now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
  document.getElementById('checkout-arrival-time').min = now.toISOString().slice(0,16);

  // Validasi kecocokan jenis kendaraan terpilih saat checkout
  document.getElementById('checkout-vehicle-select').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const vehicleJenis = selectedOption.getAttribute('data-jenis');
    const requiredJenis = bookingState.selectedVehicleType.toLowerCase();
    
    const warning = document.getElementById('vehicle-warning');
    const submitBtn = document.getElementById('btnSubmitBooking');
    
    if (vehicleJenis !== requiredJenis) {
      warning.style.display = 'block';
      submitBtn.disabled = true;
    } else {
      warning.style.display = 'none';
      submitBtn.disabled = false;
    }
  });
});

function renderBuildingCards() {
  const container = document.getElementById('building-cards-container');
  container.innerHTML = '';

  buildingsData.forEach(b => {
    // Hitung total slot dan slot tersedia secara dinamis milik gedung ini
    const buildingSlots = globalSlotsData.filter(s => s.id_lokasi === b.id);
    const slotsAvailable = buildingSlots.filter(s => s.status === 'tersedia').length;
    const slotsTotal = buildingSlots.length;

    const isFull = slotsAvailable === 0;
    const badgeColor = isFull ? 'bg-danger text-white' : 'bg-success text-white';
    const badgeText = isFull ? 'FULL' : `${slotsAvailable} Tersedia`;
    const btnAttr = isFull ? 'disabled' : `onclick="selectBuilding(${b.id}, '${b.name}', ${b.price}, ${slotsAvailable}, ${slotsTotal})"`;
    const btnClass = isFull ? 'btn-light text-muted' : 'btn-navy';

    container.innerHTML += `
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border rounded-4 p-3 bg-white">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="badge ${badgeColor} px-2 py-1.5 rounded-2" style="font-size:11px;">${badgeText}</span>
            <span class="fw-bold text-navy-dark" style="font-size:14px;">Rp ${b.price.toLocaleString('id-ID')}<small class="text-muted" style="font-size:11px;">/jam</small></span>
          </div>
          <h5 class="fw-bold text-navy-dark mb-1" style="font-size:16px;"><i class="bi bi-building me-2"></i>${b.name}</h5>
          <p class="text-muted mb-4" style="font-size:12px;"><i class="bi bi-geo-alt me-1"></i>${b.address}</p>
          <button class="btn w-100 py-2 rounded-3 fw-semibold btn-sm ${btnClass}" ${btnAttr}>
            ${isFull ? 'KAPASITAS PENUH' : 'PILIH GEDUNG'}
          </button>
        </div>
      </div>
    `;
  });
}

function selectBuilding(id, name, price, available, total) {
  bookingState.selectedBuilding = { id, name, price };
  bookingState.selectedSlot = null;

  document.getElementById('breadcrumb-active-building').innerText = name;
  document.getElementById('step2-building-title').innerText = `${name}`;
  
  // Update info slot dinamis sesuai filter kendaraan yang aktif saat ini
  updateSlotHeaderInfo();

  document.getElementById('summary-building-name').innerText = name;
  document.getElementById('summary-parking-price').innerHTML = `Rp ${price.toLocaleString('id-ID')} <small class="text-muted">/jam</small>`;
  document.getElementById('summary-slot-id').innerText = 'Belum Memilih';
  document.getElementById('summary-slot-id').className = 'text-muted fs-6';
  document.getElementById('btnNextToStep3').disabled = true;

  renderSlotsGrid();

  document.getElementById('stepIndicatorLine').style.width = '50%';
  document.getElementById('circleStep1').className = 'step-circle completed';
  document.getElementById('circleStep2').className = 'step-circle active';

  document.getElementById('booking-step-1').classList.add('d-none');
  document.getElementById('booking-step-2').classList.remove('d-none');
  window.scrollTo(0, 0);
}

function updateSlotHeaderInfo() {
  if (!bookingState.selectedBuilding) return;
  
  const bId = bookingState.selectedBuilding.id;
  const currentJenis = bookingState.selectedVehicleType.toLowerCase();
  
  const activeSlots = globalSlotsData.filter(s => s.id_lokasi === bId && s.jenis === currentJenis);
  const available = activeSlots.filter(s => s.status === 'tersedia').length;
  const total = activeSlots.length;
  
  document.getElementById('step2-building-slots-info').innerText = `${available} slot ${bookingState.selectedVehicleType} tersedia dari ${total} total slot`;
}

function renderSlotsGrid() {
  const container = document.getElementById('slots-grid-container');
  const title = document.getElementById('denah-title');
  const currentType = bookingState.selectedVehicleType;
  
  title.innerText = `Denah Area Parkir (${currentType})`;
  container.innerHTML = '';

  // Filter slot berdasarkan id_lokasi gedung terpilih DAN jenis kendaraan (mobil/motor)
  const listData = globalSlotsData.filter(s => 
    s.id_lokasi === bookingState.selectedBuilding.id && 
    s.jenis === currentType.toLowerCase()
  );

  if(listData.length === 0) {
    container.innerHTML = `<p class="text-muted py-4">Tidak ada ketersediaan denah parkir untuk kategori ini.</p>`;
    return;
  }

  listData.forEach(slot => {
    let statusClass = 'slot-available';
    let icon = '<i class="bi bi-check-circle"></i>';
    let isDisabledAttr = '';

    // Penyelarasan string status database (tersedia, terisi, dipesan)
    if (slot.status === 'terisi' || slot.status === 'occupied') {
      statusClass = 'slot-occupied';
      icon = '<i class="bi bi-lock-fill"></i>';
      isDisabledAttr = 'data-disabled="true"';
    } else if (slot.status === 'dipesan' || slot.status === 'booked') {
      statusClass = 'slot-booked';
      icon = '<i class="bi bi-clock"></i>';
      isDisabledAttr = 'data-disabled="true"';
    }

    if (bookingState.selectedSlot && bookingState.selectedSlot.id === slot.id) {
      statusClass = 'slot-selected';
      icon = '<i class="bi bi-pin-map-fill"></i>';
    }

    container.innerHTML += `
      <div class="slot-box ${statusClass}" ${isDisabledAttr} onclick="selectSlot(this, ${slot.id}, '${slot.code}')">
        <span>${slot.code}</span>
        <small>${icon}</small>
      </div>
    `;
  });
}

function setVehicleFilter(type) {
  bookingState.selectedVehicleType = type;
  bookingState.selectedSlot = null;
  
  document.getElementById('summary-vehicle-type').innerText = type;
  document.getElementById('summary-slot-id').innerText = 'Belum Memilih';
  document.getElementById('summary-slot-id').className = 'text-muted fs-6';
  document.getElementById('btnNextToStep3').disabled = true;

  if (type === 'Mobil') {
    document.getElementById('btnFilterMobil').className = 'btn btn-sm btn-navy rounded-2 px-3 py-1.5 active';
    document.getElementById('btnFilterMotor').className = 'btn btn-sm btn-light rounded-2 px-3 py-1.5';
  } else {
    document.getElementById('btnFilterMobil').className = 'btn btn-sm btn-light rounded-2 px-3 py-1.5';
    document.getElementById('btnFilterMotor').className = 'btn btn-sm btn-navy rounded-2 px-3 py-1.5 active';
  }

  updateSlotHeaderInfo();
  renderSlotsGrid();
}

function selectSlot(element, slotId, slotCode) {
  if (element.hasAttribute('data-disabled')) return;

  bookingState.selectedSlot = { id: slotId, code: slotCode };
  renderSlotsGrid();

  const summarySlot = document.getElementById('summary-slot-id');
  summarySlot.innerText = slotCode;
  summarySlot.className = 'text-primary fs-4 fw-bold';

  document.getElementById('btnNextToStep3').disabled = false;
}

function goToStep3() {
  document.getElementById('checkout-building').innerText = bookingState.selectedBuilding.name;
  document.getElementById('checkout-slot').innerText = bookingState.selectedSlot.code;
  document.getElementById('checkout-category').innerText = bookingState.selectedVehicleType;
  document.getElementById('checkout-price').innerText = `Rp ${bookingState.selectedBuilding.price.toLocaleString('id-ID')} /jam`;

  // Masukkan data ke input hidden form agar dikirim ke Controller
  document.getElementById('input-hidden-lokasi').value = bookingState.selectedBuilding.id;
  document.getElementById('input-hidden-slot').value = bookingState.selectedSlot.id;
  document.getElementById('input-hidden-jenis').value = bookingState.selectedVehicleType.toLowerCase();

  // Reset validasi select kendaraan saat masuk step 3
  document.getElementById('checkout-vehicle-select').selectedIndex = 0;
  document.getElementById('vehicle-warning').style.display = 'none';
  document.getElementById('btnSubmitBooking').disabled = false;

  document.getElementById('stepIndicatorLine').style.width = '100%';
  document.getElementById('circleStep2').className = 'step-circle completed';
  document.getElementById('circleStep3').className = 'step-circle active';

  document.getElementById('booking-step-2').classList.add('d-none');
  document.getElementById('booking-step-3').classList.remove('d-none');
  window.scrollTo(0, 0);
}

function goBackToStep1() {
  document.getElementById('stepIndicatorLine').style.width = '0%';
  document.getElementById('circleStep1').className = 'step-circle active';
  document.getElementById('circleStep2').className = 'step-circle';

  document.getElementById('booking-step-2').classList.add('d-none');
  document.getElementById('booking-step-1').classList.remove('d-none');
}

function goBackToStep2() {
  document.getElementById('stepIndicatorLine').style.width = '50%';
  document.getElementById('circleStep2').className = 'step-circle active';
  document.getElementById('circleStep3').className = 'step-circle';

  document.getElementById('booking-step-3').classList.add('d-none');
  document.getElementById('booking-step-2').classList.remove('d-none');
}
</script>
<?= $this->endSection() ?>