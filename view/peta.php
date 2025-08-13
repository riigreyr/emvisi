<?php
session_start();
include_once __DIR__ . "/../controller/PetaController.php";

$controller = new PetaController();
$dataBelanja = $controller->getDataBelanja();
$dataTagging = $controller->getDataTagging();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Peta - BelanjaYuk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <style>
    html, body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
    }
    .container {
      flex: 1 0 auto;
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

    /* Container foto & info di kanan */
    #infoPanel {
      width: 400px;
      padding-left: 15px;
    }
    #infoPanel img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 0.5rem;
      user-select: none;
      pointer-events: none;
      box-shadow: 0 0 5px rgba(0,0,0,0.2);
    }
    #infoText {
      margin-top: 10px;
      font-weight: 600;
      color: #0b3d91;
      min-height: 50px;
    }

    /* Responsive */
    @media (max-width: 1200px) {
      #map, #infoPanel {
        width: 100% !important;
        height: auto !important;
      }
      #infoPanel img {
        height: auto !important;
      }
    }
  </style>
</head>
<body>

<!-- Navbar dan Konten seperti sebelumnya -->
<nav class="navbar navbar-expand-lg navbar-dark bg-blue-dark px-3">
  <a class="navbar-brand" href="/emvisi/">BelanjaYuk</a>
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

<div class="container mt-4">
  <div class="row gx-4 justify-content-center">
    <!-- Peta -->
    <div class="col-auto">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="card-title mb-3">Peta Lokasi Belanja</h4>
          <div id="map"></div>
        </div>
      </div>
    </div>

    <!-- Panel Foto dan Info User & Lokasi -->
    <div class="col-auto d-flex align-items-start">
      <div id="infoPanel">
        <img id="fotoMarker" src="" alt="Foto Lokasi" />
        <div id="infoText">Klik marker di peta untuk melihat info lokasi dan user</div>
      </div>
    </div>
  </div>

  <!-- (Klasemen dan footer tetap sama, tidak diubah) -->
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
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  // Circle untuk data belanja (radius wilayah)
  <?php foreach ($dataBelanja as $b): ?>
    L.circle([<?= $b['latitude'] ?>, <?= $b['longitude'] ?>], {
      radius: <?= $b['radius'] ?>,
      color: 'blue',
      fillOpacity: 0.3
    }).addTo(map).bindPopup("<?= htmlspecialchars($b['nama']) ?>");
  <?php endforeach; ?>

  var dataTagging = <?= json_encode($dataTagging) ?>;

  var fotoMarker = document.getElementById('fotoMarker');
  var infoText = document.getElementById('infoText');

  dataTagging.forEach(function(tag) {
  if (tag.latitude && tag.longitude) {
    var marker = L.marker([parseFloat(tag.latitude), parseFloat(tag.longitude)])
      .addTo(map)
      .bindPopup("<strong>" + tag.nama_belanja + "</strong><br>Oleh: " + tag.nama_user);

    marker.on('click', function() {
      fotoMarker.src = "/emvisi/uploads/" + tag.path_foto;
      infoText.innerHTML = 
        "<strong>Lokasi:</strong> " + tag.nama_belanja + "<br>" +
        "<strong>User:</strong> " + tag.nama_user;
    });
  }
});


  // Set default view dan tampilkan foto/info pertama jika ada data
  if(dataTagging.length > 0) {
    map.setView([parseFloat(dataTagging[0].latitude), parseFloat(dataTagging[0].longitude)], 14);
    fotoMarker.src = "/emvisi/uploads/" + dataTagging[0].path_foto;
    infoText.innerHTML = 
      "<strong>Lokasi:</strong> " + dataTagging[0].nama_belanja + "<br>" +
      "<strong>User:</strong> " + dataTagging[0].nama_user;
  }
</script>

</body>
</html>
