<?php

include_once __DIR__ . "/../controller/PetaController.php";

$controller = new PetaController();
$dataBelanja = $controller->getDataBelanja();
$dataTagging = $controller->getDataTagging();
?>

<?php include_once __DIR__ . "/head.php"; ?>
<body>

<!-- Navbar -->
<?php include_once __DIR__ . "/nav.php"; ?>

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
<?php include_once __DIR__ . "/klasemen.php"; ?>
</div>


<?php include_once __DIR__ . "/footer.php"; ?>


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
