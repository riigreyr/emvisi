<?php
session_start();
include_once __DIR__ . "/../controller/PetaController.php";

$controller = new PetaController();
$dataBelanja = $controller->getDataBelanja();

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Peta - BelanjaYuk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <style>
    /* Buat sticky footer */
    html, body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
    }
    .container {
      flex: 1 0 auto; /* Konten utama bisa tumbuh dan dorong footer */
    }
    footer {
      flex-shrink: 0;
    }

    .bg-blue-dark {
      background-color: #0b3d91 !important;
      color: white !important;
    }
    #map {
      width: 800px;
      height: 250px;
      border-radius: 0.5rem;
    }

    /* ======= Slideshow fix supaya gak glitch turun-naik ======= */
    #carouselExample {
      width: 400px;
      height: 180px;
      overflow: hidden; /* sembunyikan bagian animasi keluar container */
      border-radius: 0.5rem;
      position: relative;
    }
    #carouselExample .carousel-inner {
      height: 180px; /* pastikan tinggi tetap */
    }
    .slideshow-img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 0.5rem;
      user-select: none;
      pointer-events: none;
    }
    /* =============================================== */

    .card-header {
      font-weight: bold;
    }

    /* Responsive: kolom jadi stack di layar kecil */
    @media (max-width: 1200px) {
      #map, #carouselExample {
        width: 100% !important;
        height: auto !important;
      }
      .slideshow-img {
        height: auto !important;
      }
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<!-- bagian navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-blue-dark px-3">
  <a class="navbar-brand" href="/emvisi/"><?= "BelanjaYuk" ?></a>
  ...
  <ul class="navbar-nav ms-auto">
    <li class="nav-item">
      <a class="nav-link" href="<?= isset($_SESSION['user']) ? '/emvisi/dashboard' : '/emvisi/' ?>">Beranda</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="/emvisi/home/peta">Peta</a>
    </li>
  </ul>
</nav>

<!-- KONTEN UTAMA -->
<div class="container mt-4">
  <div class="row gx-4 justify-content-center">
    <!-- Kolom kiri: Peta 800x250 -->
    <div class="col-auto">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="card-title mb-3">Peta Lokasi Belanja</h4>
          <div id="map"></div>
        </div>
      </div>
    </div>

    <!-- Kolom kanan: Slideshow 400x180 -->
    <div class="col-auto d-flex align-items-start">
      <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner rounded-3 shadow-sm">
          <div class="carousel-item active">
            <img src="" class="d-block slideshow-img" alt="Slide 1" />
          </div>
          <div class="carousel-item">
            <img src="https://source.unsplash.com/400x180/?mall" class="d-block slideshow-img" alt="Slide 2" />
          </div>
          <div class="carousel-item">
            <img src="https://source.unsplash.com/400x180/?store" class="d-block slideshow-img" alt="Slide 3" />
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
          <span class="visually-hidden">Sebelumnya</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
          <span class="visually-hidden">Selanjutnya</span>
        </button>
      </div>
    </div>
  </div>

  <!-- Klasemen bawah full lebar -->
  <div class="row mt-4 g-4">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-header bg-blue-dark">🏆 Top 5 User</div>
        <ul class="list-group list-group-flush">
          <?php foreach ($data['klasemen'] ?? [] as $k): ?>
            <li class="list-group-item">
              <?= htmlspecialchars($k['nama']) ?>
              <span class="badge bg-blue-dark float-end"><?= htmlspecialchars($k['skor']) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-header bg-blue-dark">📍 Lokasi Terbanyak</div>
        <ul class="list-group list-group-flush">
          <?php foreach ($data['terbanyak'] ?? [] as $t): ?>
            <li class="list-group-item">
              <?= htmlspecialchars($t['nama']) ?>
              <span class="badge bg-blue-dark float-end"><?= htmlspecialchars($t['total']) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-header bg-blue-dark">📊 Statistik</div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">User <span class="badge bg-blue-dark float-end"><?= htmlspecialchars($data['total_user'] ?? '0') ?></span></li>
          <li class="list-group-item">Tagging <span class="badge bg-blue-dark float-end"><?= htmlspecialchars($data['total_tagging'] ?? '0') ?></span></li>
          <li class="list-group-item">Belanja <span class="badge bg-blue-dark float-end"><?= htmlspecialchars($data['total_belanja'] ?? '0') ?></span></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- FOOTER -->
<footer class="mt-5 py-4 bg-blue-dark text-white text-center" style="padding: 1.5rem 0; font-size: 0.9rem;">
  <div class="container">
    <strong>BelanjaYuk</strong><br />
    <small>©<?= date('Y') ?> dikembangkan oleh Fakhri</small><br />
    <div class="mt-2">
      <strong>Kontak Kami</strong><br />
      Dinas Komunikasi, Informatika dan Persandian Aceh<br />
      Jl. Jalan. 10<br />
      Banda Aceh
    </div>
  </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  var map = L.map('map').setView([-6.2, 106.8], 11);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap'
  }).addTo(map);

  <?php foreach ($dataBelanja as $b): ?>
    L.circle([<?= $b['latitude'] ?>, <?= $b['longitude'] ?>], {
      radius: <?= $b['radius'] ?>,
      color: 'blue',
      fillOpacity: 0.5
    }).addTo(map).bindPopup("<?= htmlspecialchars($b['nama']) ?>");
  <?php endforeach; ?>
</script>

</body>
</html>
