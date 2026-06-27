<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prime Parking - Premium Booking System</title>
  
  <!-- Google Fonts: Inter & Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
  
  <!-- Flatpickr CSS (Datetime Picker) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  
  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css" rel="stylesheet">

  <style>
    :root {
      --navy-dark: #0a1628;
      --navy-light: #1a2a3a;
      --navy-accent: #2c3e50;
      --slate-gray: #5e6e82;
      --soft-bg: #f8f9fa;
      --card-shadow: 0 4px 20px -2px rgba(10, 22, 40, 0.05), 0 2px 12px 0 rgba(0, 0, 0, 0.03);
      --card-shadow-hover: 0 10px 30px -5px rgba(10, 22, 40, 0.08), 0 4px 18px 0 rgba(0, 0, 0, 0.04);
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--soft-bg);
      color: #334155;
      overflow-x: hidden;
    }

    h1, h2, h3, h4, h5, h6, .font-poppins {
      font-family: 'Poppins', sans-serif;
    }

    /* Layout Components */
    .sidebar {
      background-color: #ffffff;
      border-right: 1px solid #e2e8f0;
      width: 280px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 100;
      transition: all 0.3s ease;
    }

    .main-content {
      margin-left: 280px;
      min-height: 100vh;
      transition: all 0.3s ease;
    }

    /* Navbar styling */
    .custom-navbar {
      background-color: #ffffff;
      border-bottom: 1px solid #e2e8f0;
      padding: 1rem 2rem;
    }

    /* Brand Header */
    .brand-logo {
      color: var(--navy-dark);
      font-weight: 700;
      font-size: 1.3rem;
      letter-spacing: 0.5px;
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 1.5rem 1.25rem;
      border-bottom: 1px solid #f1f5f9;
    }

    .brand-logo i {
      color: var(--navy-light);
      font-size: 1.6rem;
    }

    /* Sidebar Navigation Links */
    .nav-menu {
      padding: 1.5rem 1rem;
    }

    .nav-item-custom {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 0.85rem 1.2rem;
      color: var(--slate-gray);
      text-decoration: none;
      border-radius: 10px;
      font-weight: 500;
      margin-bottom: 0.5rem;
      transition: all 0.2s ease-in-out;
      cursor: pointer;
    }

    .nav-item-custom:hover {
      background-color: #f1f5f9;
      color: var(--navy-dark);
    }

    .nav-item-custom.active {
      background-color: var(--navy-dark);
      color: #ffffff;
    }

    .nav-item-custom i {
      font-size: 1.2rem;
    }

    /* Card customization */
    .premium-card {
      background-color: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      box-shadow: var(--card-shadow);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .premium-card:hover {
      transform: translateY(-2px);
      box-shadow: var(--card-shadow-hover);
    }

    /* Primary buttons */
    .btn-navy {
      background-color: var(--navy-dark);
      color: #ffffff;
      border: none;
      font-weight: 500;
      padding: 0.65rem 1.5rem;
      border-radius: 10px;
      transition: all 0.25s ease;
    }

    .btn-navy:hover {
      background-color: var(--navy-light);
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(10, 22, 40, 0.15);
    }

    .btn-outline-navy {
      background-color: transparent;
      color: var(--navy-dark);
      border: 2px solid var(--navy-dark);
      font-weight: 600;
      padding: 0.6rem 1.4rem;
      border-radius: 10px;
      transition: all 0.25s ease;
    }

    .btn-outline-navy:hover {
      background-color: var(--navy-dark);
      color: #ffffff;
    }

    /* Badges */
    .badge-premium-success {
      background-color: #e6f4ea;
      color: #137333;
      font-weight: 600;
      padding: 0.5em 1em;
      border-radius: 8px;
    }

    .badge-premium-danger {
      background-color: #fce8e6;
      color: #c5221f;
      font-weight: 600;
      padding: 0.5em 1em;
      border-radius: 8px;
    }

    /* Steps navigation for Booking */
    .booking-step-indicator {
      display: flex;
      justify-content: space-between;
      position: relative;
      margin-bottom: 2rem;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }

    .booking-step-indicator::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      height: 2px;
      background-color: #e2e8f0;
      z-index: 1;
      transform: translateY(-50%);
    }

    .indicator-line-active {
      position: absolute;
      top: 50%;
      left: 0;
      height: 2px;
      background-color: var(--navy-dark);
      z-index: 1;
      transform: translateY(-50%);
      transition: width 0.3s ease;
    }

    .step-circle {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: #ffffff;
      border: 2px solid #cbd5e1;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      color: #64748b;
      position: relative;
      z-index: 2;
      transition: all 0.3s ease;
    }

    .step-circle.active {
      border-color: var(--navy-dark);
      background-color: var(--navy-dark);
      color: #ffffff;
    }

    .step-circle.completed {
      border-color: var(--navy-dark);
      background-color: #ffffff;
      color: var(--navy-dark);
    }

    /* Interactive Slots Styling */
    .slot-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 15px;
      max-width: 500px;
      margin: 0 auto;
    }

    @media (max-width: 576px) {
      .slot-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    .slot-box {
      aspect-ratio: 1.1;
      border-radius: 12px;
      border: 2px dashed #cbd5e1;
      background-color: #ffffff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      position: relative;
      transition: all 0.2s ease;
      font-weight: 700;
    }

    .slot-box.status-available {
      border-color: #28a745;
      background-color: #f4faf6;
      color: #155724;
    }

    .slot-box.status-available:hover {
      background-color: #e8f5e9;
      transform: scale(1.05);
      box-shadow: 0 4px 12px rgba(40, 167, 69, 0.15);
    }

    .slot-box.status-reserved {
      border-color: #ffc107;
      background-color: #fffdf5;
      color: #856404;
      cursor: not-allowed;
      opacity: 0.85;
    }

    .slot-box.status-occupied {
      border-color: #dc3545;
      background-color: #fdf5f5;
      color: #721c24;
      cursor: not-allowed;
      opacity: 0.85;
    }

    .slot-box.status-selected {
      border-color: #007bff;
      background-color: #f0f7ff;
      color: #004085;
      box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.25);
      transform: scale(1.05);
    }

    .slot-icon {
      font-size: 1.3rem;
      margin-bottom: 4px;
    }

    /* Mobile sidebar adjustments */
    @media (max-width: 991.98px) {
      .sidebar {
        left: -280px;
      }
      .sidebar.show {
        left: 0;
      }
      .main-content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebarContainer">
    <div class="brand-logo">
      <i class="bi bi-shield-check"></i>
      <div class="lh-1">
        <span class="d-block text-uppercase font-poppins text-navy-dark">Prime Parking</span>
        <small class="text-muted text-uppercase" style="font-size: 9px; letter-spacing: 1px;">Corporate Booking</small>
      </div>
    </div>
    
    <nav class="nav-menu">
      <div class="nav-item-custom active" onclick="switchTab('dashboard', this)">
        <i class="bi bi-grid-1x2"></i>
        <span>Dashboard</span>
      </div>
      <div class="nav-item-custom" id="nav-booking" onclick="switchTab('booking', this)">
        <i class="bi bi-calendar3"></i>
        <span>Booking Parkir</span>
      </div>
      <div class="nav-item-custom" onclick="switchTab('vehicles', this)">
        <i class="bi bi-car-front"></i>
        <span>Kelola Kendaraan</span>
      </div>
      <div class="nav-item-custom" onclick="switchTab('history', this)">
        <i class="bi bi-clock-history"></i>
        <span>Riwayat Reservasi</span>
      </div>
      <div class="nav-item-custom" onclick="switchTab('profile', this)">
        <i class="bi bi-person-gear"></i>
        <span>Profil Saya</span>
      </div>
    </nav>
    
    <div class="position-absolute bottom-0 w-100 p-4 border-top bg-white">
      <div class="d-flex align-items-center gap-3">
        <div class="bg-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
          <i class="bi bi-person text-navy-dark fs-5"></i>
        </div>
        <div class="lh-1 overflow-hidden">
          <span class="d-block font-poppins fw-bold text-navy-dark text-truncate" id="sidebar-user-name">Ahmad Salim</span>
          <small class="text-muted text-truncate d-block" style="font-size: 11px;" id="sidebar-user-email">ahmad@salim.com</small>
        </div>
      </div>
    </div>
  </aside>

  <!-- MAIN WRAPPER -->
  <main class="main-content">
    
    <!-- NAVBAR -->
    <nav class="custom-navbar d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center gap-3">
        <button class="btn btn-light d-lg-none" type="button" onclick="toggleSidebar()">
          <i class="bi bi-list fs-4"></i>
        </button>
        <h4 class="mb-0 fw-bold font-poppins d-none d-sm-block text-navy-dark" id="page-title-heading">Dashboard Overview</h4>
      </div>
      
      <div class="d-flex align-items-center gap-3">
        <!-- Live Clock Indicator -->
        <div class="bg-light px-3 py-1.5 rounded-3 d-none d-md-flex align-items-center gap-2 border">
          <i class="bi bi-clock text-navy-dark"></i>
          <span class="font-monospace fw-semibold" id="navbar-clock" style="font-size: 13px;">2026-06-27 10:26:08</span>
        </div>
        
        <!-- Notifikasi -->
        <div class="dropdown">
          <button class="btn btn-light position-relative p-2 rounded-3 border" type="button" data-bs-toggle="dropdown">
            <i class="bi bi-bell text-navy-dark"></i>
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 mt-2" style="width: 280px;">
            <li class="p-3 border-bottom"><h6 class="mb-0 font-poppins fw-bold">Notifikasi</h6></li>
            <li><a class="dropdown-item p-3 border-bottom" href="#">
              <div class="d-flex gap-2">
                <i class="bi bi-info-circle text-primary"></i>
                <div>
                  <p class="mb-1 text-wrap" style="font-size: 12px;">Booking untuk <strong>Slot A2</strong> aktif hari ini pukul 10:00.</p>
                  <small class="text-muted text-xs">2 jam yang lalu</small>
                </div>
              </div>
            </a></li>
            <li class="p-2 text-center"><small class="text-primary cursor-pointer">Tandai sudah dibaca</small></li>
          </ul>
        </div>
        
        <div class="bg-navy-dark text-white rounded-circle p-1 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
          <strong id="navbar-initials">AS</strong>
        </div>
      </div>
    </nav>

    <!-- CONTENT BODY -->
    <div class="p-4 p-md-5">
      
      <!-- 1. TAB: DASHBOARD -->
      <section id="tab-dashboard" class="dashboard-section animate-fade">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <div>
            <h2 class="fw-bold text-navy-dark mb-1">Halo, <span id="welcome-user-name">Ahmad Salim</span>!</h2>
            <p class="text-muted mb-0">Selamat datang kembali di Portal Layanan Parkir Premium.</p>
          </div>
          <button class="btn btn-navy d-flex align-items-center gap-2" onclick="startNewBooking()">
            <i class="bi bi-calendar-plus"></i> Booking Parkir Baru
          </button>
        </div>
        
        <!-- STATS GRID -->
        <div class="row g-4 mb-5">
          <div class="col-md-4">
            <div class="premium-card p-4 d-flex align-items-center justify-content-between">
              <div>
                <span class="text-muted text-uppercase d-block mb-1" style="font-size: 11px; font-weight: 600; letter-spacing: 0.5px;">Total Kendaraan</span>
                <h2 class="fw-bold text-navy-dark mb-0 font-poppins" id="stat-total-vehicles">2</h2>
              </div>
              <div class="p-3 rounded-4 bg-light text-navy-dark">
                <i class="bi bi-car-front fs-3"></i>
              </div>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="premium-card p-4 d-flex align-items-center justify-content-between">
              <div>
                <span class="text-muted text-uppercase d-block mb-1" style="font-size: 11px; font-weight: 600; letter-spacing: 0.5px;">Booking Aktif</span>
                <h2 class="fw-bold text-navy-dark mb-0 font-poppins" id="stat-active-bookings">1</h2>
              </div>
              <div class="p-3 rounded-4 bg-primary bg-opacity-10 text-primary">
                <i class="bi bi-bookmark-check fs-3"></i>
              </div>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="premium-card p-4 d-flex align-items-center justify-content-between">
              <div>
                <span class="text-muted text-uppercase d-block mb-1" style="font-size: 11px; font-weight: 600; letter-spacing: 0.5px;">Riwayat Selesai</span>
                <h2 class="fw-bold text-navy-dark mb-0 font-poppins" id="stat-completed-bookings">2</h2>
              </div>
              <div class="p-3 rounded-4 bg-success bg-opacity-10 text-success">
                <i class="bi bi-check2-all fs-3"></i>
              </div>
            </div>
          </div>
        </div>
        
        <!-- RECENT BOOKINGS -->
        <div class="premium-card p-4">
          <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
            <h5 class="fw-bold mb-0 text-navy-dark font-poppins">5 Booking Terakhir</h5>
            <button class="btn btn-link text-navy-dark p-0 text-decoration-none fw-semibold" onclick="switchTab('history', document.getElementById('nav-booking').nextElementSibling.nextElementSibling)">
              Lihat Semua Riwayat <i class="bi bi-arrow-right"></i>
            </button>
          </div>
          
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="recentBookingsTable">
              <thead class="table-light">
                <tr>
                  <th class="border-0">Kode Booking</th>
                  <th class="border-0">Gedung</th>
                  <th class="border-0 text-center">Slot</th>
                  <th class="border-0">Kendaraan</th>
                  <th class="border-0">Waktu Kedatangan</th>
                  <th class="border-0">Status</th>
                </tr>
              </thead>
              <tbody id="recentBookingsBody">
                <!-- Will be dynamically populated via Javascript -->
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- 2. TAB: KELOLA KENDARAAN -->
      <section id="tab-vehicles" class="d-none animate-fade">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <div>
            <h2 class="fw-bold text-navy-dark mb-1">Daftar Kendaraan Saya</h2>
            <p class="text-muted mb-0">Kelola informasi kendaraan Anda untuk mempercepat proses check-out booking.</p>
          </div>
          <button class="btn btn-navy d-flex align-items-center gap-2" onclick="showAddVehicleModal()">
            <i class="bi bi-plus-lg"></i> Tambah Kendaraan
          </button>
        </div>
        
        <div class="row g-4" id="vehicle-grid">
          <!-- Populated by JS -->
        </div>
      </section>

      <!-- 3. TAB: BOOKING PARKIR (3 STEP) -->
      <section id="tab-booking" class="d-none animate-fade">
        <div class="mb-4">
          <h2 class="fw-bold text-navy-dark mb-1">Pemesanan Slot Parkir</h2>
          <p class="text-muted mb-0">Ikuti 3 langkah mudah untuk mengamankan slot parkir eksklusif Anda.</p>
        </div>
        
        <!-- STEP INDICATOR -->
        <div class="booking-step-indicator">
          <div class="indicator-line-active" id="stepIndicatorLine" style="width: 0%;"></div>
          <div class="step-circle active" id="circleStep1">1</div>
          <div class="step-circle" id="circleStep2">2</div>
          <div class="step-circle" id="circleStep3">3</div>
        </div>
        <div class="d-flex justify-content-between text-muted font-poppins px-md-5 mb-5 mx-auto" style="max-width: 650px; font-size: 13px; font-weight: 500;">
          <span class="text-center" style="width: 100px;">1. Pilih Gedung</span>
          <span class="text-center" style="width: 100px;">2. Pilih Slot</span>
          <span class="text-center" style="width: 100px;">3. Konfirmasi</span>
        </div>

        <!-- STEP 1: PILIH GEDUNG -->
        <div id="booking-step-1" class="booking-step-container">
          <div class="row g-4" id="building-cards-container">
            <!-- Populated dynamically -->
          </div>
        </div>

        <!-- STEP 2: PILIH SLOT -->
        <div id="booking-step-2" class="d-none booking-step-container">
          <!-- Breadcrumbs & Header info -->
          <div class="premium-card p-4 mb-4">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb mb-2 text-uppercase" style="font-size: 12px; font-weight: 600; letter-spacing: 0.5px;">
                <li class="breadcrumb-item"><a href="#" onclick="goBackToStep1()" class="text-decoration-none text-navy-dark">Home</a></li>
                <li class="breadcrumb-item"><a href="#" onclick="goBackToStep1()" class="text-decoration-none text-navy-dark">Booking</a></li>
                <li class="breadcrumb-item active text-muted" aria-current="page" id="breadcrumb-active-building">Gedung A</li>
              </ol>
            </nav>
            <div class="row align-items-center">
              <div class="col-md-8">
                <h3 class="fw-bold text-navy-dark font-poppins mb-1" id="step2-building-title">Gedung A - Pilih Slot Parkir</h3>
                <p class="text-muted mb-0" id="step2-building-slots-info">5 slot tersedia dari 8 slot total</p>
              </div>
              <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <!-- Vehicle Type Filter Toggles -->
                <div class="btn-group border p-1 rounded-3 bg-light" role="group">
                  <button type="button" class="btn btn-sm btn-navy rounded-2 px-3 py-1.5" id="btnFilterMobil" onclick="setVehicleFilter('Mobil')">
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
              <div class="premium-card p-4 text-center">
                <h6 class="text-uppercase text-muted mb-4 font-poppins" style="letter-spacing: 1px; font-size: 11px; font-weight: 600;">Denah Tata Letak Area Parkir</h6>
                
                <!-- Legend -->
                <div class="d-flex justify-content-center gap-3 flex-wrap mb-4" style="font-size: 12px;">
                  <span class="d-flex align-items-center gap-1.5"><span class="d-inline-block rounded-circle" style="width: 12px; height: 12px; background-color: #28a745;"></span> Tersedia</span>
                  <span class="d-flex align-items-center gap-1.5"><span class="d-inline-block rounded-circle" style="width: 12px; height: 12px; background-color: #ffc107;"></span> Dipesan</span>
                  <span class="d-flex align-items-center gap-1.5"><span class="d-inline-block rounded-circle" style="width: 12px; height: 12px; background-color: #dc3545;"></span> Terisi</span>
                  <span class="d-flex align-items-center gap-1.5"><span class="d-inline-block rounded-circle" style="width: 12px; height: 12px; background-color: #007bff;"></span> Terpilih</span>
                </div>
                
                <!-- Slot Grid Container -->
                <div class="slot-grid mb-4" id="slots-grid-container">
                  <!-- Populated by JS -->
                </div>
                
                <div class="border-top pt-3 text-muted" style="font-size: 12px;">
                  <i class="bi bi-info-circle"></i> Kotak dengan warna hijau dapat langsung dipilih dengan sekali klik.
                </div>
              </div>
            </div>
            
            <div class="col-lg-5">
              <div class="premium-card p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                  <h5 class="fw-bold text-navy-dark font-poppins mb-3 border-bottom pb-2">Ringkasan Pemilihan Slot</h5>
                  
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
                    <p class="mb-0 text-muted" style="font-size: 13px;">Biaya Parkir Estimasi</p>
                    <h3 class="fw-bold text-navy-dark mb-0 font-poppins" id="summary-parking-price">Rp 5.000 <small class="text-muted" style="font-size: 12px;">/jam</small></h3>
                  </div>
                </div>
                
                <div class="d-flex gap-3">
                  <button class="btn btn-outline-navy flex-grow-1" onclick="goBackToStep1()">KEMBALI</button>
                  <button class="btn btn-navy flex-grow-1" id="btnNextToStep3" disabled onclick="goToStep3()">LANJUTKAN</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- STEP 3: KONFIRMASI CHECKOUT -->
        <div id="booking-step-3" class="d-none booking-step-container">
          <div class="row g-4 justify-content-center">
            <div class="col-md-8 col-lg-7">
              <div class="premium-card p-4">
                <h4 class="fw-bold text-navy-dark font-poppins mb-4 border-bottom pb-3">Konfirmasi Detail Reservasi</h4>
                
                <!-- Booking details -->
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
                
                <!-- Booking Form elements -->
                <form id="bookingConfirmationForm" onsubmit="submitBooking(event)">
                  <div class="mb-3">
                    <label class="form-label font-poppins text-navy-dark fw-semibold" style="font-size: 13px;">Pilih Kendaraan Anda</label>
                    <select class="form-select border-slate" id="checkout-vehicle-select" required onchange="onVehicleSelectChanged()">
                      <!-- Populated via JS based on Category and User Vehicles -->
                    </select>
                    <div class="form-text">Sesuaikan pelat kendaraan agar check-in otomatis di palang gate berhasil.</div>
                  </div>
                  
                  <div class="mb-4">
                    <label class="form-label font-poppins text-navy-dark fw-semibold" style="font-size: 13px;">Rencana Waktu Kedatangan</label>
                    <div class="input-group">
                      <span class="input-group-text bg-white border-end-0"><i class="bi bi-calendar-event"></i></span>
                      <input type="text" class="form-control bg-white border-start-0" id="checkout-arrival-time" placeholder="Pilih Tanggal & Jam" required>
                    </div>
                  </div>
                  
                  <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-navy py-3 fs-6">
                      <i class="bi bi-shield-check me-2"></i> KONFIRMASI BOOKING PARKIR
                    </button>
                    <button type="button" class="btn btn-link text-muted" onclick="goBackToStep2()">Kembali Pilih Slot</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- 4. TAB: RIWAYAT RESERVASI -->
      <section id="tab-history" class="d-none animate-fade">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <div>
            <h2 class="fw-bold text-navy-dark mb-1">Riwayat Reservasi</h2>
            <p class="text-muted mb-0">Daftar lengkap booking parkir yang pernah Anda pesan sebelumnya.</p>
          </div>
        </div>
        
        <!-- Filter Bar -->
        <div class="premium-card p-3.5 mb-4">
          <div class="row g-3 align-items-center">
            <div class="col-md-4">
              <label class="form-label text-muted mb-1" style="font-size: 11px; font-weight: 600;">STATUS</label>
              <select class="form-select" id="history-filter-status" onchange="filterHistory()">
                <option value="Semua">Semua Status</option>
                <option value="Aktif">Aktif</option>
                <option value="Selesai">Selesai</option>
                <option value="Dibatalkan">Dibatalkan</option>
              </select>
            </div>
            <div class="col-md-5">
              <label class="form-label text-muted mb-1" style="font-size: 11px; font-weight: 600;">CARI KODE / LOKASI</label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" id="history-filter-search" placeholder="Contoh: Gedung A, PARK-..." oninput="filterHistory()">
              </div>
            </div>
            <div class="col-md-3 text-md-end pt-3">
              <button class="btn btn-outline-navy w-100" onclick="resetHistoryFilters()">Reset Filter</button>
            </div>
          </div>
        </div>
        
        <!-- Table -->
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
                <!-- Populated dynamically -->
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- 5. TAB: PROFIL USER -->
      <section id="tab-profile" class="d-none animate-fade">
        <div class="mb-4">
          <h2 class="fw-bold text-navy-dark mb-1">Pengaturan Profil Pengguna</h2>
          <p class="text-muted mb-0">Kelola informasi akun Anda untuk kredensial login dan notifikasi reservasi.</p>
        </div>
        
        <div class="row g-4">
          <div class="col-lg-4">
            <!-- Profile Card -->
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
            <!-- Forms -->
            <div class="premium-card p-4 mb-4">
              <h5 class="fw-bold text-navy-dark font-poppins mb-4 border-bottom pb-2">Informasi Pribadi</h5>
              <form id="profileDetailsForm" onsubmit="saveProfileDetails(event)">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label text-navy-dark fw-semibold" style="font-size: 13px;">Nama Lengkap</label>
                    <input type="text" class="form-control" id="profile-input-name" value="Ahmad Salim" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label text-navy-dark fw-semibold" style="font-size: 13px;">Email Address</label>
                    <input type="email" class="form-control" id="profile-input-email" value="ahmad@salim.com" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label text-navy-dark fw-semibold" style="font-size: 13px;">No. Telepon / WhatsApp</label>
                    <input type="tel" class="form-control" id="profile-input-phone" value="+62 812-3456-7890" required>
                  </div>
                  <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-navy">Simpan Perubahan</button>
                  </div>
                </div>
              </form>
            </div>
            
            <div class="premium-card p-4">
              <h5 class="fw-bold text-navy-dark font-poppins mb-4 border-bottom pb-2">Keamanan & Password</h5>
              <form id="profilePasswordForm" onsubmit="savePasswordChange(event)">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label text-navy-dark fw-semibold" style="font-size: 13px;">Password Saat Ini</label>
                    <input type="password" class="form-control" required placeholder="••••••••">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label text-navy-dark fw-semibold" style="font-size: 13px;">Password Baru</label>
                    <input type="password" class="form-control" id="new-password-input" required placeholder="Minimal 8 karakter">
                  </div>
                  <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-navy bg-opacity-25">Ganti Password</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>

    </div>
  </main>

  <!-- MODAL: ADD/EDIT VEHICLE -->
  <div class="modal fade" id="vehicleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="modal-header bg-navy-dark text-white p-4">
          <h5 class="modal-title font-poppins fw-bold" id="vehicleModalTitle">Tambah Kendaraan</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="vehicleForm" onsubmit="saveVehicle(event)">
          <div class="modal-body p-4">
            <input type="hidden" id="vehicle-id-edit">
            
            <div class="mb-3">
              <label class="form-label text-navy-dark fw-semibold" style="font-size: 13px;">Nomor Polisi (Pelat Nomor)</label>
              <input type="text" class="form-control font-monospace text-uppercase" id="vehicle-input-plate" placeholder="Contoh: B 1234 ABC" required>
            </div>
            
            <div class="row g-3 mb-3">
              <div class="col-6">
                <label class="form-label text-navy-dark fw-semibold" style="font-size: 13px;">Merek</label>
                <input type="text" class="form-control" id="vehicle-input-brand" placeholder="Contoh: Toyota" required>
              </div>
              <div class="col-6">
                <label class="form-label text-navy-dark fw-semibold" style="font-size: 13px;">Model</label>
                <input type="text" class="form-control" id="vehicle-input-model" placeholder="Contoh: Avanza" required>
              </div>
            </div>
            
            <div class="row g-3">
              <div class="col-6">
                <label class="form-label text-navy-dark fw-semibold" style="font-size: 13px;">Warna</label>
                <input type="text" class="form-control" id="vehicle-input-color" placeholder="Contoh: Silver Metalik" required>
              </div>
              <div class="col-6">
                <label class="form-label text-navy-dark fw-semibold" style="font-size: 13px;">Tipe</label>
                <select class="form-select" id="vehicle-input-type" required>
                  <option value="Mobil">Mobil</option>
                  <option value="Motor">Motor</option>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer p-3 bg-light border-top">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-navy" id="btnSaveVehicle">Simpan Kendaraan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- JS DEPENDENCIES -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    // GLOBAL APP STATE (HARDCODED)
    let state = {
      profile: {
        name: "Ahmad Salim",
        email: "ahmad@salim.com",
        phone: "+62 812-3456-7890"
      },
      vehicles: [
        { id: "v1", plate: "B 1234 ABC", brand: "Toyota", model: "Avanza", color: "Silver", type: "Mobil" },
        { id: "v2", plate: "D 5678 DEF", brand: "Honda", model: "Beat", color: "Black", type: "Motor" }
      ],
      buildings: [
        { 
          id: "b1", 
          name: "Gedung A (Grand Center)", 
          address: "Jl. Merdeka No. 12, Jakarta Pusat", 
          available: 4, 
          total: 8,
          price: 5000,
          slots: [
            { id: "A1", type: "Mobil", status: "available" },
            { id: "A2", type: "Mobil", status: "occupied" },
            { id: "A3", type: "Mobil", status: "occupied" },
            { id: "A4", type: "Mobil", status: "available" },
            { id: "A5", type: "Mobil", status: "reserved" },
            { id: "A6", type: "Mobil", status: "available" },
            { id: "A7", type: "Mobil", status: "reserved" },
            { id: "A8", type: "Mobil", status: "available" }
          ]
        },
        { 
          id: "b2", 
          name: "Gedung B (Sudirman Plaza)", 
          address: "Jl. Jend. Sudirman Kav. 21, Jakarta Selatan", 
          available: 5, 
          total: 10,
          price: 6000,
          slots: [
            { id: "B1", type: "Mobil", status: "available" },
            { id: "B2", type: "Motor", status: "available" },
            { id: "B3", type: "Mobil", status: "occupied" },
            { id: "B4", type: "Motor", status: "reserved" },
            { id: "B5", type: "Mobil", status: "occupied" },
            { id: "B6", type: "Motor", status: "available" },
            { id: "B7", type: "Mobil", status: "available" },
            { id: "B8", type: "Motor", status: "available" },
            { id: "B9", type: "Mobil", status: "reserved" },
            { id: "B10", type: "Motor", status: "occupied" }
          ]
        },
        { 
          id: "b3", 
          name: "Gedung C (Thamrin Executive)", 
          address: "Jl. MH Thamrin No. 5, Jakarta Pusat", 
          available: 0, 
          total: 6,
          price: 7500,
          slots: [
            { id: "C1", type: "Mobil", status: "occupied" },
            { id: "C2", type: "Mobil", status: "occupied" },
            { id: "C3", type: "Mobil", status: "occupied" },
            { id: "C4", type: "Mobil", status: "occupied" },
            { id: "C5", type: "Mobil", status: "occupied" },
            { id: "C6", type: "Mobil", status: "occupied" }
          ]
        }
      ],
      bookings: [
        { id: "PARK-20260620-XY982", building: "Gedung A (Grand Center)", slot: "A3", vehicle: "B 1234 ABC - Toyota Avanza (Mobil)", time: "2026-06-20 14:00", status: "Selesai", price: "Rp 15.000" },
        { id: "PARK-20260625-ZW112", building: "Gedung B (Sudirman Plaza)", slot: "B4", vehicle: "D 5678 DEF - Honda Beat (Motor)", time: "2026-06-25 09:30", status: "Selesai", price: "Rp 12.000" },
        { id: "PARK-20260627-AB771", building: "Gedung A (Grand Center)", slot: "A2", vehicle: "B 1234 ABC - Toyota Avanza (Mobil)", time: "2026-06-27 10:00", status: "Aktif", price: "Rp 5.000 /jam" }
      ],
      
      // Temp states for Booking flow
      activeBooking: {
        building: null,
        slot: null,
        vehicleType: "Mobil", // Default
        vehicleId: null,
        arrivalTime: null
      }
    };

    // BOOTSTRAP MODAL INSTANCE
    let vehicleModal = null;
    let flatpickrInstance = null;

    // INITIALIZATION
    window.addEventListener('DOMContentLoaded', () => {
      vehicleModal = new bootstrap.Modal(document.getElementById('vehicleModal'));
      
      // Initialize flatpickr
      flatpickrInstance = flatpickr("#checkout-arrival-time", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today",
        defaultDate: "2026-06-27 11:00",
        time_24hr: true
      });
      
      // Set live navbar clock
      setInterval(updateClock, 1000);
      updateClock();
      
      // Populate tables, grids, fields
      renderDashboard();
      renderVehicles();
      renderBuildingCards();
      renderHistoryTable();
      populateProfileForm();
    });

    // CLOCK
    function updateClock() {
      const now = new Date();
      const pad = (num) => String(num).padStart(2, '0');
      const year = now.getFullYear();
      const month = pad(now.getMonth() + 1);
      const date = pad(now.getDate());
      const hours = pad(now.getHours());
      const minutes = pad(now.getMinutes());
      const seconds = pad(now.getSeconds());
      
      document.getElementById('navbar-clock').textContent = `${year}-${month}-${date} ${hours}:${minutes}:${seconds}`;
    }

    // SIDEBAR TOGGLE
    function toggleSidebar() {
      document.getElementById('sidebarContainer').classList.toggle('show');
    }

    // TAB NAVIGATION SYSTEM
    function switchTab(tabId, el) {
      // Hide all tabs
      document.querySelectorAll('main > div > section').forEach(section => {
        section.classList.add('d-none');
      });
      
      // Show chosen tab
      document.getElementById('tab-' + tabId).classList.remove('d-none');
      
      // Update active state in sidebar
      document.querySelectorAll('.nav-item-custom').forEach(item => {
        item.classList.remove('active');
      });
      if (el) {
        el.classList.add('active');
      } else {
        // Fallback search
        document.querySelectorAll('.nav-item-custom').forEach(item => {
          if (item.getAttribute('onclick').includes(tabId)) {
            item.classList.add('active');
          }
        });
      }
      
      // Update heading text
      const headingTitles = {
        'dashboard': 'Dashboard Overview',
        'vehicles': 'Kelola Kendaraan Saya',
        'booking': 'Booking Parkir Premium',
        'history': 'Riwayat Reservasi',
        'profile': 'Profil Pengguna'
      };
      document.getElementById('page-title-heading').textContent = headingTitles[tabId] || 'Portal Parkir';
      
      // Close sidebar drawer on mobile
      document.getElementById('sidebarContainer').classList.remove('show');
    }

    // 1. DASHBOARD COMPONENT
    function renderDashboard() {
      // Stats count
      document.getElementById('stat-total-vehicles').textContent = state.vehicles.length;
      document.getElementById('stat-active-bookings').textContent = state.bookings.filter(b => b.status === "Aktif").length;
      document.getElementById('stat-completed-bookings').textContent = state.bookings.filter(b => b.status === "Selesai").length;
      
      // Populating the recent table (last 5)
      const tbody = document.getElementById('recentBookingsBody');
      tbody.innerHTML = '';
      
      const lastFive = state.bookings.slice().reverse().slice(0, 5);
      
      if (lastFive.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">Belum ada aktivitas booking.</td></tr>';
        return;
      }
      
      lastFive.forEach(b => {
        let badgeClass = "bg-secondary bg-opacity-10 text-secondary";
        if (b.status === "Aktif") badgeClass = "bg-primary bg-opacity-10 text-primary";
        if (b.status === "Selesai") badgeClass = "bg-success bg-opacity-10 text-success";
        if (b.status === "Dibatalkan") badgeClass = "bg-danger bg-opacity-10 text-danger";
        
        tbody.innerHTML += `
          <tr>
            <td><strong class="font-monospace text-uppercase text-navy-dark">${b.id}</strong></td>
            <td>${b.building}</td>
            <td class="text-center"><span class="badge bg-light text-navy-dark border font-poppins fw-bold">${b.slot}</span></td>
            <td class="text-truncate" style="max-width: 150px;">${b.vehicle}</td>
            <td>${b.time}</td>
            <td><span class="badge ${badgeClass} rounded-pill">${b.status}</span></td>
          </tr>
        `;
      });
    }

    // 2. KELOLA KENDARAAN COMPONENT
    function renderVehicles() {
      const grid = document.getElementById('vehicle-grid');
      grid.innerHTML = '';
      
      if (state.vehicles.length === 0) {
        grid.innerHTML = `
          <div class="col-12 text-center py-5">
            <i class="bi bi-car-front text-muted fs-1 mb-3 d-block"></i>
            <h5 class="fw-bold text-navy-dark">Belum Ada Kendaraan</h5>
            <p class="text-muted">Tambahkan kendaraan Anda sekarang untuk memudahkan proses check-out parkir.</p>
            <button class="btn btn-navy mt-2" onclick="showAddVehicleModal()">
              <i class="bi bi-plus-lg"></i> Tambah Kendaraan Pertama
            </button>
          </div>
        `;
        return;
      }
      
      state.vehicles.forEach(v => {
        grid.innerHTML += `
          <div class="col-md-4">
            <div class="premium-card p-4">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="badge bg-navy-dark text-white font-poppins px-3 py-1.5 rounded-3">${v.type}</span>
                <div class="d-flex gap-1.5">
                  <button class="btn btn-sm btn-light border" onclick="editVehicle('${v.id}')">
                    <i class="bi bi-pencil"></i>
                  </button>
                  <button class="btn btn-sm btn-light border text-danger" onclick="deleteVehicle('${v.id}')">
                    <i class="bi bi-trash"></i>
                  </button>
                </div>
              </div>
              <h3 class="fw-bold font-monospace text-uppercase mb-2 text-navy-dark" style="letter-spacing: 0.5px;">${v.plate}</h3>
              <p class="mb-0 text-muted" style="font-size: 14px;">${v.brand} ${v.model} (${v.color})</p>
            </div>
          </div>
        `;
      });
    }

    function showAddVehicleModal() {
      document.getElementById('vehicleModalTitle').textContent = "Tambah Kendaraan Baru";
      document.getElementById('vehicle-id-edit').value = "";
      document.getElementById('vehicle-input-plate').value = "";
      document.getElementById('vehicle-input-brand').value = "";
      document.getElementById('vehicle-input-model').value = "";
      document.getElementById('vehicle-input-color').value = "";
      document.getElementById('vehicle-input-type').value = "Mobil";
      vehicleModal.show();
    }

    function editVehicle(id) {
      const v = state.vehicles.find(item => item.id === id);
      if (!v) return;
      
      document.getElementById('vehicleModalTitle').textContent = "Edit Kendaraan";
      document.getElementById('vehicle-id-edit').value = v.id;
      document.getElementById('vehicle-input-plate').value = v.plate;
      document.getElementById('vehicle-input-brand').value = v.brand;
      document.getElementById('vehicle-input-model').value = v.model;
      document.getElementById('vehicle-input-color').value = v.color;
      document.getElementById('vehicle-input-type').value = v.type;
      vehicleModal.show();
    }

    function deleteVehicle(id) {
      Swal.fire({
        title: 'Hapus Kendaraan?',
        text: "Anda akan menghapus kendaraan ini dari daftar akun.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0a1628',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          state.vehicles = state.vehicles.filter(v => v.id !== id);
          renderVehicles();
          renderDashboard();
          Swal.fire({
            title: 'Berhasil!',
            text: 'Kendaraan telah dihapus.',
            icon: 'success',
            confirmButtonColor: '#0a1628'
          });
        }
      });
    }

    function saveVehicle(e) {
      e.preventDefault();
      
      const editId = document.getElementById('vehicle-id-edit').value;
      const plate = document.getElementById('vehicle-input-plate').value.toUpperCase();
      const brand = document.getElementById('vehicle-input-brand').value;
      const model = document.getElementById('vehicle-input-model').value;
      const color = document.getElementById('vehicle-input-color').value;
      const type = document.getElementById('vehicle-input-type').value;
      
      if (editId) {
        // Edit mode
        const index = state.vehicles.findIndex(v => v.id === editId);
        if (index !== -1) {
          state.vehicles[index] = { id: editId, plate, brand, model, color, type };
        }
      } else {
        // Create mode
        const newId = 'v' + Date.now();
        state.vehicles.push({ id: newId, plate, brand, model, color, type });
      }
      
      vehicleModal.hide();
      renderVehicles();
      renderDashboard();
      
      Swal.fire({
        title: 'Sukses!',
        text: 'Informasi kendaraan berhasil disimpan.',
        icon: 'success',
        confirmButtonColor: '#0a1628'
      });
    }

    // 3. BOOKING PARKIR ENGINE
    function startNewBooking() {
      // Reset state
      state.activeBooking = {
        building: null,
        slot: null,
        vehicleType: "Mobil",
        vehicleId: null,
        arrivalTime: null
      };
      
      // Reset steps
      document.getElementById('booking-step-1').classList.remove('d-none');
      document.getElementById('booking-step-2').classList.add('d-none');
      document.getElementById('booking-step-3').classList.add('d-none');
      
      // Update indicators
      document.getElementById('stepIndicatorLine').style.width = '0%';
      document.getElementById('circleStep1').className = 'step-circle active';
      document.getElementById('circleStep2').className = 'step-circle';
      document.getElementById('circleStep3').className = 'step-circle';
      
      renderBuildingCards();
      switchTab('booking', document.getElementById('nav-booking'));
    }

    function renderBuildingCards() {
      const container = document.getElementById('building-cards-container');
      container.innerHTML = '';
      
      state.buildings.forEach(b => {
        const isFull = b.available === 0;
        const btnClass = isFull ? 'btn btn-outline-secondary disabled w-100' : 'btn btn-outline-navy w-100';
        const badgeClass = isFull ? 'badge bg-danger rounded-pill px-3 py-1.5' : 'badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1.5';
        const labelText = isFull ? 'FULL' : `${b.available} Slot Tersedia`;
        
        container.innerHTML += `
          <div class="col-md-4">
            <div class="premium-card p-4 h-100 d-flex flex-column justify-content-between">
              <div>
                <div class="d-flex align-items-center justify-content-between mb-3.5">
                  <span class="${badgeClass}" style="font-weight: 600; font-size: 11px;">${labelText}</span>
                  <span class="font-poppins text-muted fw-semibold text-xs">Rp ${b.price.toLocaleString('id-ID')}/jam</span>
                </div>
                
                <h3 class="fw-bold font-poppins text-navy-dark mb-2">${b.name}</h3>
                <p class="text-muted mb-4" style="font-size: 13px;"><i class="bi bi-geo-alt-fill text-danger me-1"></i> ${b.address}</p>
              </div>
              
              <button class="${btnClass}" ${isFull ? 'disabled' : ''} onclick="selectBuilding('${b.id}')">
                ${isFull ? 'FULL' : 'PILIH GEDUNG'}
              </button>
            </div>
          </div>
        `;
      });
    }

    function selectBuilding(buildingId) {
      const b = state.buildings.find(item => item.id === buildingId);
      if (!b || b.available === 0) return;
      
      state.activeBooking.building = b;
      
      // Go to step 2
      document.getElementById('booking-step-1').classList.add('d-none');
      document.getElementById('booking-step-2').classList.remove('d-none');
      
      // Update indicators
      document.getElementById('stepIndicatorLine').style.width = '50%';
      document.getElementById('circleStep1').className = 'step-circle completed';
      document.getElementById('circleStep2').className = 'step-circle active';
      
      // Update texts in Step 2
      document.getElementById('breadcrumb-active-building').textContent = b.name;
      document.getElementById('step2-building-title').textContent = `${b.name} - Pilih Slot Parkir`;
      document.getElementById('step2-building-slots-info').textContent = `${b.available} slot tersedia dari ${b.total} slot total`;
      document.getElementById('summary-building-name').textContent = b.name;
      document.getElementById('summary-parking-price').innerHTML = `Rp ${b.price.toLocaleString('id-ID')} <small class="text-muted" style="font-size: 12px;">/jam</small>`;
      
      // Filter mobil/motor
      setVehicleFilter('Mobil');
    }

    function setVehicleFilter(type) {
      state.activeBooking.vehicleType = type;
      state.activeBooking.slot = null; // reset slot selection
      
      // Update UI active buttons
      const btnMobil = document.getElementById('btnFilterMobil');
      const btnMotor = document.getElementById('btnFilterMotor');
      
      if (type === 'Mobil') {
        btnMobil.className = 'btn btn-sm btn-navy rounded-2 px-3 py-1.5';
        btnMotor.className = 'btn btn-sm btn-light rounded-2 px-3 py-1.5';
      } else {
        btnMobil.className = 'btn btn-sm btn-light rounded-2 px-3 py-1.5';
        btnMotor.className = 'btn btn-sm btn-navy rounded-2 px-3 py-1.5';
      }
      
      // Update summary
      document.getElementById('summary-vehicle-type').textContent = type;
      document.getElementById('summary-slot-id').textContent = 'Belum Memilih';
      document.getElementById('summary-slot-id').className = 'text-primary fs-5';
      document.getElementById('btnNextToStep3').disabled = true;
      
      renderSlotsGrid();
    }

    function renderSlotsGrid() {
      const container = document.getElementById('slots-grid-container');
      container.innerHTML = '';
      
      const b = state.activeBooking.building;
      if (!b) return;
      
      // Render layout based on selected building and category
      // We will dynamically mock slot classifications based on chosen filter
      const typeLabel = state.activeBooking.vehicleType;
      
      b.slots.forEach(s => {
        let status = s.status;
        let iconClass = typeLabel === 'Mobil' ? 'bi bi-car-front-fill' : 'bi bi-bicycle';
        
        let statusClass = '';
        if (status === 'available') statusClass = 'status-available';
        if (status === 'reserved') statusClass = 'status-reserved';
        if (status === 'occupied') statusClass = 'status-occupied';
        
        // If it matches selection
        if (state.activeBooking.slot === s.id) {
          statusClass = 'status-selected';
        }
        
        let clickHandler = `onclick="clickSlot('${s.id}', '${status}')"`;
        if (status !== 'available') {
          clickHandler = '';
        }
        
        let labelIcon = `<i class="${iconClass} slot-icon"></i>`;
        if (status === 'reserved') labelIcon = '<i class="bi bi-clock-history slot-icon"></i>';
        if (status === 'occupied') labelIcon = '<i class="bi bi-x-circle slot-icon"></i>';
        
        container.innerHTML += `
          <div class="slot-box ${statusClass}" ${clickHandler}>
            ${labelIcon}
            <span style="font-size: 13px;">${s.id}</span>
          </div>
        `;
      });
    }

    function clickSlot(slotId, status) {
      if (status !== 'available') return;
      
      state.activeBooking.slot = slotId;
      document.getElementById('summary-slot-id').textContent = slotId;
      document.getElementById('summary-slot-id').className = 'text-success font-poppins fw-bold fs-4';
      document.getElementById('btnNextToStep3').disabled = false;
      
      renderSlotsGrid();
    }

    function goBackToStep1() {
      document.getElementById('booking-step-1').classList.remove('d-none');
      document.getElementById('booking-step-2').classList.add('d-none');
      
      document.getElementById('stepIndicatorLine').style.width = '0%';
      document.getElementById('circleStep1').className = 'step-circle active';
      document.getElementById('circleStep2').className = 'step-circle';
    }

    function goToStep3() {
      if (!state.activeBooking.slot) return;
      
      // Transition step
      document.getElementById('booking-step-2').classList.add('d-none');
      document.getElementById('booking-step-3').classList.remove('d-none');
      
      // Update indicators
      document.getElementById('stepIndicatorLine').style.width = '100%';
      document.getElementById('circleStep2').className = 'step-circle completed';
      document.getElementById('circleStep3').className = 'step-circle active';
      
      // Fill details in Step 3
      const b = state.activeBooking.building;
      document.getElementById('checkout-building').textContent = b.name;
      document.getElementById('checkout-slot').textContent = state.activeBooking.slot;
      document.getElementById('checkout-category').textContent = state.activeBooking.vehicleType;
      document.getElementById('checkout-price').textContent = `Rp ${b.price.toLocaleString('id-ID')} / jam`;
      
      // Fill vehicles dropdown with matching types
      const select = document.getElementById('checkout-vehicle-select');
      select.innerHTML = '';
      
      const filteredVehicles = state.vehicles.filter(v => v.type === state.activeBooking.vehicleType);
      
      if (filteredVehicles.length === 0) {
        select.innerHTML = '<option value="">-- Tidak ada kendaraan yang cocok. Tambah di menu "Kelola Kendaraan" --</option>';
        select.removeAttribute('required');
      } else {
        filteredVehicles.forEach(v => {
          select.innerHTML += `<option value="${v.id}">${v.plate} - ${v.brand} ${v.model}</option>`;
        });
        select.setAttribute('required', 'required');
      }
    }

    function goBackToStep2() {
      document.getElementById('booking-step-2').classList.remove('d-none');
      document.getElementById('booking-step-3').classList.add('d-none');
      
      document.getElementById('stepIndicatorLine').style.width = '50%';
      document.getElementById('circleStep2').className = 'step-circle active';
      document.getElementById('circleStep3').className = 'step-circle';
    }

    function submitBooking(e) {
      e.preventDefault();
      
      const select = document.getElementById('checkout-vehicle-select');
      if (select.required && !select.value) {
        Swal.fire({
          title: 'Perhatian!',
          text: 'Silakan daftarkan kendaraan dengan jenis yang sesuai terlebih dahulu.',
          icon: 'warning',
          confirmButtonColor: '#0a1628'
        });
        return;
      }
      
      const vId = select.value;
      const vehicleObj = state.vehicles.find(item => item.id === vId);
      const vehicleLabel = vehicleObj ? `${vehicleObj.plate} - ${vehicleObj.brand} ${vehicleObj.model} (${vehicleObj.type})` : "Kendaraan Pribadi";
      
      const arrTime = document.getElementById('checkout-arrival-time').value;
      const bCode = 'PARK-2026' + String(Math.floor(100000 + Math.random() * 900000)) + '-ABC';
      
      const bObj = state.activeBooking.building;
      
      // Create new booking object
      const newBooking = {
        id: bCode,
        building: bObj.name,
        slot: state.activeBooking.slot,
        vehicle: vehicleLabel,
        time: arrTime,
        status: "Aktif",
        price: `Rp ${bObj.price.toLocaleString('id-ID')} /jam`
      };
      
      // Save
      state.bookings.push(newBooking);
      
      // Decrement available counter on this building
      const bIndex = state.buildings.findIndex(item => item.id === bObj.id);
      if (bIndex !== -1 && state.buildings[bIndex].available > 0) {
        state.buildings[bIndex].available -= 1;
        
        // Also flag the chosen slot as occupied in local simulation
        const sIndex = state.buildings[bIndex].slots.findIndex(s => s.id === state.activeBooking.slot);
        if (sIndex !== -1) {
          state.buildings[bIndex].slots[sIndex].status = "occupied";
        }
      }
      
      // Re-render
      renderDashboard();
      renderHistoryTable();
      
      // GORGEOUS SUCCESS POPUP WITH SWEETALERT2
      Swal.fire({
        title: '<h4 class="font-poppins fw-bold text-success mb-0">Booking Berhasil!</h4>',
        html: `
          <div class="p-3 text-start">
            <div class="text-center mb-4">
              <i class="bi bi-check-circle-fill text-success" style="font-size: 3.5rem;"></i>
              <p class="text-muted mt-2">Slot <strong>${state.activeBooking.slot}</strong> berhasil dipesan untuk <strong>${state.profile.name}</strong></p>
            </div>
            
            <div class="p-3 bg-light rounded-3 mb-3 border">
              <div class="row text-navy-dark" style="font-size: 13px;">
                <div class="col-5 text-muted">Gedung:</div>
                <div class="col-7 fw-semibold text-end">${bObj.name}</div>
                <div class="col-5 text-muted mt-1">Slot:</div>
                <div class="col-7 fw-semibold text-end text-primary">${state.activeBooking.slot}</div>
                <div class="col-5 text-muted mt-1">Waktu Kedatangan:</div>
                <div class="col-7 fw-semibold text-end">${arrTime}</div>
                <div class="col-5 text-muted mt-1">Kode Unik:</div>
                <div class="col-7 font-monospace fw-bold text-end text-success">${bCode}</div>
              </div>
            </div>

            <div class="text-center">
              <span class="text-muted d-block mb-2" style="font-size: 11px; text-transform:uppercase; font-weight:600;">Barcode Check-In Gate</span>
              <!-- Premium styled QR Code Placeholder -->
              <div class="p-3 border rounded-3 d-inline-block bg-white shadow-sm">
                <i class="bi bi-qr-code text-navy-dark" style="font-size: 6rem; line-height: 1;"></i>
              </div>
              <small class="text-muted d-block mt-2 font-monospace" style="font-size: 11px;">${bCode}</small>
            </div>
          </div>
        `,
        confirmButtonText: 'Tutup & Lihat Dasbor',
        confirmButtonColor: '#0a1628',
        customClass: {
          popup: 'rounded-4'
        }
      }).then(() => {
        // Redirect to dashboard
        switchTab('dashboard', document.querySelector('.nav-menu div:first-child'));
      });
    }

    // 4. RIWAYAT RESERVASI TABLE
    function renderHistoryTable() {
      const tbody = document.getElementById('historyTableBody');
      tbody.innerHTML = '';
      
      const statusFilter = document.getElementById('history-filter-status').value;
      const searchFilter = document.getElementById('history-filter-search').value.toLowerCase();
      
      const filtered = state.bookings.filter(b => {
        const matchesStatus = statusFilter === "Semua" || b.status === statusFilter;
        const matchesSearch = b.building.toLowerCase().includes(searchFilter) || b.id.toLowerCase().includes(searchFilter) || b.slot.toLowerCase().includes(searchFilter);
        return matchesStatus && matchesSearch;
      });
      
      if (filtered.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-5 text-muted">Tidak ada data riwayat yang cocok dengan filter.</td></tr>';
        return;
      }
      
      // Populate
      filtered.slice().reverse().forEach(b => {
        let badgeClass = "bg-secondary bg-opacity-10 text-secondary";
        if (b.status === "Aktif") badgeClass = "bg-primary bg-opacity-10 text-primary";
        if (b.status === "Selesai") badgeClass = "bg-success bg-opacity-10 text-success";
        if (b.status === "Dibatalkan") badgeClass = "bg-danger bg-opacity-10 text-danger";
        
        tbody.innerHTML += `
          <tr>
            <td><strong class="font-monospace text-uppercase text-navy-dark">${b.id}</strong></td>
            <td>${b.building}</td>
            <td class="text-center"><span class="badge bg-light text-navy-dark border font-poppins fw-bold">${b.slot}</span></td>
            <td class="text-truncate" style="max-width: 160px;">${b.vehicle}</td>
            <td>${b.time}</td>
            <td><span class="badge ${badgeClass} rounded-pill">${b.status}</span></td>
            <td class="text-center">
              <button class="btn btn-sm btn-outline-navy py-1 px-2.5" onclick="viewBookingDetails('${b.id}')">
                <i class="bi bi-eye"></i> Detail
              </button>
            </td>
          </tr>
        `;
      });
    }

    function filterHistory() {
      renderHistoryTable();
    }

    function resetHistoryFilters() {
      document.getElementById('history-filter-status').value = "Semua";
      document.getElementById('history-filter-search').value = "";
      renderHistoryTable();
    }

    function viewBookingDetails(bCode) {
      const b = state.bookings.find(item => item.id === bCode);
      if (!b) return;
      
      Swal.fire({
        title: '<h5 class="font-poppins fw-bold text-navy-dark mb-0">Rincian Reservasi</h5>',
        html: `
          <div class="text-start p-2">
            <div class="p-3 bg-light border rounded-3 mb-3" style="font-size: 13.5px;">
              <div class="row g-2">
                <div class="col-5 text-muted">Gedung:</div>
                <div class="col-7 text-end fw-semibold">${b.building}</div>
                <div class="col-5 text-muted">Slot Parkir:</div>
                <div class="col-7 text-end fw-bold text-primary">${b.slot}</div>
                <div class="col-5 text-muted">Kendaraan:</div>
                <div class="col-7 text-end text-truncate fw-semibold" style="max-width: 170px;">${b.vehicle}</div>
                <div class="col-5 text-muted">Waktu Kedatangan:</div>
                <div class="col-7 text-end fw-semibold">${b.time}</div>
                <div class="col-5 text-muted">Biaya Estimasi:</div>
                <div class="col-7 text-end fw-semibold">${b.price}</div>
                <div class="col-5 text-muted">Kode Unik:</div>
                <div class="col-7 text-end font-monospace fw-bold text-success">${b.id}</div>
              </div>
            </div>
            <div class="text-center py-2 bg-white rounded border">
              <span class="text-muted d-block mb-1.5" style="font-size: 11px; text-transform:uppercase;">QR Code Pembuka Gate</span>
              <i class="bi bi-qr-code text-navy-dark" style="font-size: 5rem;"></i>
              <div class="text-center"><small class="text-muted font-monospace" style="font-size: 10px;">${b.id}</small></div>
            </div>
          </div>
        `,
        confirmButtonText: 'Tutup',
        confirmButtonColor: '#0a1628',
        customClass: {
          popup: 'rounded-4'
        }
      });
    }

    // 5. PROFIL USER COMPONENT
    function populateProfileForm() {
      // Inputs
      document.getElementById('profile-input-name').value = state.profile.name;
      document.getElementById('profile-input-email').value = state.profile.email;
      document.getElementById('profile-input-phone').value = state.profile.phone;
      
      // Cards & Sidebar
      document.getElementById('profile-card-name').textContent = state.profile.name;
      document.getElementById('profile-card-email').textContent = state.profile.email;
      document.getElementById('sidebar-user-name').textContent = state.profile.name;
      document.getElementById('sidebar-user-email').textContent = state.profile.email;
      document.getElementById('welcome-user-name').textContent = state.profile.name;
      
      // Initials
      const parts = state.profile.name.split(' ');
      const initials = parts.map(p => p[0]).join('').substring(0, 2).toUpperCase();
      document.getElementById('navbar-initials').textContent = initials;
      document.getElementById('profile-avatar-big').textContent = initials;
    }

    function saveProfileDetails(e) {
      e.preventDefault();
      
      const newName = document.getElementById('profile-input-name').value;
      const newEmail = document.getElementById('profile-input-email').value;
      const newPhone = document.getElementById('profile-input-phone').value;
      
      state.profile = {
        name: newName,
        email: newEmail,
        phone: newPhone
      };
      
      populateProfileForm();
      
      Swal.fire({
        title: 'Sukses!',
        text: 'Detail profil Anda berhasil diperbarui.',
        icon: 'success',
        confirmButtonColor: '#0a1628'
      });
    }

    function savePasswordChange(e) {
      e.preventDefault();
      document.getElementById('new-password-input').value = "";
      
      Swal.fire({
        title: 'Berhasil!',
        text: 'Password Anda telah berhasil diganti.',
        icon: 'success',
        confirmButtonColor: '#0a1628'
      });
    }
  </script>
</body>
</html>
