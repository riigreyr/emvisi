<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
  header("Location: /emvisi/");
  exit;
}
$user = $_SESSION['user'];
?>
<!-- Header -->
<?php include_once __DIR__ . "/head.php"; ?>
<body>
<!-- Navbar -->
<?php include_once __DIR__ . "/nav.php"; ?>

<main class="container mt-4">
  <!-- Logout -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="tagToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        Berhasil Tagging!
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

  <div class="d-flex justify-content-between align-items-start mb-3">
    <h2>Selamat Datang di Dashboard</h2>
  </div>

<!-- Form-->
<div class="card shadow-sm">
  <div class="card-header bg-blue-dark text-white d-flex justify-content-between align-items-center">
    Profil Anda
    <a href="/emvisi/index.php?logout=true" class="btn btn-sm btn-light">
      <i class="bi bi-box-arrow-right"></i> Logout
    </a>
  </div>
  <div class="card-body">

    <ul class="nav nav-tabs mb-3" id="profileTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="edit-profile-tab" data-bs-toggle="tab" data-bs-target="#edit-profile" type="button" role="tab">Edit Profile</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="tagging-tab" data-bs-toggle="tab" data-bs-target="#tagging" type="button" role="tab">Tagging</button>
      </li>
    </ul>

    <div class="tab-content" id="profileTabContent">
<!-- Edit Profile -->
      <div class="tab-pane fade show active" id="edit-profile" role="tabpanel">
        <form method="post" action="/emvisi/dashboard" class="row g-3 align-items-center">
          <div class="col-md-4">
            <label>Email</label>
            <input type="email" class="form-control" value="<?= htmlspecialchars($user['user_email']) ?>" readonly>
          </div>
          <div class="col-md-4">
            <label>Nama Lengkap</label>
            <input type="text" class="form-control" name="fullname" value="<?= htmlspecialchars($user['full_name']) ?>">
          </div>
          <div class="col-md-4">
            <label>Deskripsi</label>
            <input type="text" class="form-control" name="description" value="<?= htmlspecialchars($user['user_description']) ?>">
          </div>
          <div class="col-12 text-end mt-2">
            <button class="btn btn-blue-dark">Update</button>
          </div>
        </form>
      </div>

    <div class="tab-pane fade" id="tagging" role="tabpanel">
  <form method="post" action="/emvisi/dashboard" enctype="multipart/form-data" id="tagForm" class="row g-3 align-items-center">
    <div class="col-md-2">
      <label>Latitude</label>
      <input type="text" name="latitude" id="latitude" class="form-control" readonly required>
    </div>
    <div class="col-md-2">
      <label>Longitude</label>
      <input type="text" name="longitude" id="longitude" class="form-control" readonly required>
    </div>
    <div class="col-md-2">
      <label>Nama Lokasi</label>
      <input type="text" name="nama_lokasi" id="nama_lokasi" class="form-control" readonly>
    </div>
    <div class="col-md-2">
      <label>Jarak (meter)</label>
      <input type="text" name="radius" id="radius" class="form-control" readonly>
    </div>
    <div class="col-md-2">
      <label>Foto Upload *</label>
      <input type="file" name="foto" id="fotoUpload" class="form-control" disabled required>
    </div>
  <!-- Tagging -->
    <div class="col-12 text-end mt-2 d-flex justify-content-end gap-2">
      <button type="button" onclick="checkLocation()" class="btn btn-secondary">Check Lokasi & Marker</button>
      <button type="submit" class="btn btn-success" id="btnTagging" disabled>Tagging</button>
    </div>
  </form>
</div>

    </div>
  </div>
</div>


<!-- Klasemen -->
<?php include_once __DIR__ . "/klasemen.php"; ?>
</main>
<!-- Footer -->
<?php include_once __DIR__ . "/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function checkLocation() {
  navigator.geolocation.getCurrentPosition(async function(pos) {
    const lat = pos.coords.latitude;
    const lng = pos.coords.longitude;
    document.getElementById("latitude").value = lat;
    document.getElementById("longitude").value = lng;

    const res = await fetch('/emvisi/check-radius', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ latitude: lat, longitude: lng })
    });

    const data = await res.json();
    if(data.success){
      document.getElementById("nama_lokasi").value = data.nama;
      document.getElementById("radius").value = data.jarak;
      document.getElementById("fotoUpload").disabled = false;
      alert("Lokasi valid: " + data.nama + " (" + data.jarak + " m)");
    } else {
      alert("Anda berada di luar radius lokasi.");
      document.getElementById("nama_lokasi").value = "";
      document.getElementById("radius").value = "";
      document.getElementById("fotoUpload").disabled = true;
      document.getElementById("btnTagging").disabled = true;
    }
  }, () => { alert("Gagal mendapatkan lokasi."); });
}

function checkEnableTagging() {
  const lat = document.getElementById("latitude").value.trim();
  const lng = document.getElementById("longitude").value.trim();
  const nama = document.getElementById("nama_lokasi").value.trim();
  const radius = document.getElementById("radius").value.trim();
  const foto = document.querySelector("input[name='foto']").files.length > 0;
  document.getElementById("btnTagging").disabled = !(lat && lng && nama && radius && foto);
}

document.addEventListener("DOMContentLoaded", function () {
  document.querySelector("input[name='foto']").addEventListener("change", checkEnableTagging);
  document.getElementById("tagForm").addEventListener("submit", function(e){
    // Disable tombol supaya double submit nggak terjadi
    document.getElementById("btnTagging").disabled = true;

    // Tampilkan alert sukses
    alert("Berhasil Tagging!");

    // Form tetap submit
});
});
</script>
