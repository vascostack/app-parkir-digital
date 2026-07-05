<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Prime Parking - Admin Control Panel' ?></title>

  <!-- Google Fonts: Inter & Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Flatpickr & SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    .font-poppins {
      font-family: 'Poppins', sans-serif;
    }

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

    .custom-navbar {
      background-color: #ffffff;
      border-bottom: 1px solid #e2e8f0;
      padding: 1rem 2rem;
    }

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
      color: #ef4444;
      font-size: 1.6rem;
    }

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

  <!-- SIDEBAR ADMIN -->
  <aside class="sidebar" id="sidebarContainer">
    <div class="brand-logo">
      <i class="bi bi-shield-lock-fill"></i>
      <div class="lh-1">
        <span class="d-block text-uppercase font-poppins text-navy-dark">Prime Parking</span>
        <small class="text-danger text-uppercase fw-bold" style="font-size: 9px; letter-spacing: 1px;">System Admin</small>
      </div>
    </div>

    <nav class="nav-menu">
      <a href="<?= site_url('admin/dashboard') ?>" class="nav-item-custom <?= url_is('admin/dashboard') || url_is('admin') ? 'active' : '' ?>">
        <i class="bi bi-grid-1x2"></i> <span>Dashboard</span>
      </a>
      
      <!-- MENU KELOLA LOKASI DITAMBAHKAN DI SINI -->
      <a href="<?= site_url('admin/lokasi') ?>" class="nav-item-custom <?= url_is('admin/lokasi*') ? 'active' : '' ?>">
        <i class="bi bi-building"></i> <span>Kelola Lokasi</span>
      </a>

      <a href="<?= site_url('admin/petugas') ?>" class="nav-item-custom <?= url_is('admin/petugas') ? 'active' : '' ?>">
        <i class="bi bi-people"></i> <span>Kelola Petugas</span>
      </a>
      <a href="<?= site_url('admin/laporan') ?>" class="nav-item-custom <?= url_is('admin/laporan') ? 'active' : '' ?>">
        <i class="bi bi-file-earmark-bar-graph"></i> <span>Laporan Keluar</span>
      </a>
      <a href="<?= site_url('logout'); ?>" class="nav-item-custom text-danger mt-4 border-top pt-3 rounded-0">
        <i class="bi bi-box-arrow-right"></i> <span>Keluar</span>
      </a>
    </nav>

    <div class="position-absolute bottom-0 w-100 p-4 border-top bg-white">
      <div class="d-flex align-items-center gap-3">
        <div class="bg-danger bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
          <i class="bi bi-person-workspace text-danger fs-5"></i>
        </div>
        <div class="lh-1 overflow-hidden">
          <span class="d-block font-poppins fw-bold text-navy-dark text-truncate">Vasco (Admin)</span>
          <small class="text-muted text-truncate d-block" style="font-size: 11px;">admin@primeparking.com</small>
        </div>
      </div>
    </div>
  </aside>

  <!-- MAIN WRAPPER -->
  <main class="main-content">

    <!-- NAVBAR -->
    <nav class="custom-navbar d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center gap-3">
        <button class="btn btn-light d-lg-none" type="button" onclick="document.getElementById('sidebarContainer').classList.toggle('show')">
          <i class="bi bi-list fs-4"></i>
        </button>
        <h4 class="mb-0 fw-bold font-poppins d-none d-sm-block text-navy-dark"><?= $title ?? 'Dashboard Overview' ?></h4>
      </div>

      <div class="d-flex align-items-center gap-3">
        <div class="bg-light px-3 py-1.5 rounded-3 d-none d-md-flex align-items-center gap-2 border">
          <i class="bi bi-clock text-navy-dark"></i>
          <span class="font-monospace fw-semibold" id="waktu-header" style="font-size: 13px;"><?= date('Y-m-d H:i:s') ?></span>
        </div>
        <div class="bg-danger text-white rounded-circle p-1 d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px;">
          ADM
        </div>
      </div>
    </nav>

    <!-- CONTENT BODY DYNAMIC -->
    <div class="p-4 p-md-5">
      <?= $this->renderSection('content') ?>
    </div>

  </main>

  <!-- Script Libraries -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Script jam real-time di Navbar atas
    setInterval(function() {
      const target = document.getElementById('waktu-header');
      if (target) {
        const sekarang = new Date();
        const format = sekarang.getFullYear() + '-' +
          String(sekarang.getMonth() + 1).padStart(2, '0') + '-' +
          String(sekarang.getDate()).padStart(2, '0') + ' ' +
          String(sekarang.getHours()).padStart(2, '0') + ':' +
          String(sekarang.getMinutes()).padStart(2, '0') + ':' +
          String(sekarang.getSeconds()).padStart(2, '0');
        target.textContent = format;
      }
    }, 1000);
  </script>

  <!-- RENDER SECTION SCRIPTS ANAK (DI SINI CHART AKAN MUNCUL) -->
  <?= $this->renderSection('scripts') ?>
</body>

</html>