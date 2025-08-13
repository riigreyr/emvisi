<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Pastikan user sudah login
if (!isset($_SESSION['user'])) {
  header("Location: /emvisi/");
  exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard - BelanjaYuk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    html, body { height: 100%; }
    body { display: flex; flex-direction: column; }
    main { flex: 1; }
    footer { background: #e9ecef; text-align: center; padding: 1.5rem 0; font-size: 0.9rem; color: #333; }
    .bg-blue-dark { background-color: #0b3d91 !important; color: white !important; }
    .btn-blue-dark { background-color: #0b3d91; border-color: #0b3d91; color: white; }
    .btn-blue-dark:hover { background-color: #092f6d; border-color: #092f6d; color: white; }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-blue-dark px-3">
  <a class="navbar-brand" href="#">BelanjaYuk</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">
      <li class="nav-item">
        <a class="nav-link active" href="/emvisi/dashboard">Beranda</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/emvisi/home/peta">Peta</a>
      </li>
    </ul>
  </div>
</nav>

<!-- Tombol Logout -->
<div class="container mt-3 d-flex justify-content-end">
  <a class="btn btn-sm btn-light" href="/emvisi/index.php?logout=true">
    <i class="bi bi-box-arrow-right"></i> Logout
  </a>
</div>

<!-- Main Content -->
<main class="container mt-4">
  <ul class="nav nav-tabs mb-3" id="dashboardTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Edit Profile</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="tagging-tab" data-bs-toggle="tab" data-bs-target="#tagging" type="button" role="tab">Tagging</button>
    </li>
  </ul>

  <div class="tab-content" id="dashboardTabContent">
    <!-- Profile -->
    <div class="tab-pane fade show active" id="profile" role="tabpanel">
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-blue-dark">Profil Anda</div>
        <div class="card-body">
          <?php if (isset($_SESSION['update_success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['update_success']; unset($_SESSION['update_success']); ?></div>
          <?php elseif (isset($_SESSION['update_error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['update_error']; unset($_SESSION['update_error']); ?></div>
          <?php endif; ?>
          <form method="post" action="/emvisi/dashboard"> 
            <div class="mb-3">
              <label>Email</label>
              <input type="email" class="form-control" value="<?= htmlspecialchars($user['user_email']) ?>" readonly />
            </div>
            <div class="mb-3">
              <label>Nama Lengkap</label>
              <input type="text" class="form-control" name="fullname" value="<?= htmlspecialchars($user['full_name']) ?>" />
            </div>
            <div class="mb-3">
              <label>Deskripsi</label>
              <input type="text" class="form-control" name="description" value="<?= htmlspecialchars($user['user_description']) ?>" />
            </div>
            <button class="btn btn-blue-dark">Update</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Tagging -->
    <div class="tab-pane fade" id="tagging" role="tabpanel">
      <div class="card shadow-sm">
        <?php if (isset($_SESSION['tagging_success'])): ?>
          <div class="alert alert-success"><?= $_SESSION['tagging_success']; unset($_SESSION['tagging_success']); ?></div>
        <?php elseif (isset($_SESSION['tagging_error'])): ?>
          <div class="alert alert-danger"><?= $_SESSION['tagging_error']; unset($_SESSION['tagging_error']); ?></div>
        <?php endif; ?>

        <div class="card-header bg-blue-dark">Form Tagging</div>
        <div class="card-body">
          <form method="post" action="/emvisi/dashboard" enctype="multipart/form-data" id="tagForm">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label>Latitude</label>
                  <input type="text" name="latitude" id="latitude" class="form-control" readonly required>
                </div>
                <div class="mb-3">
                  <label>Longitude</label>
                  <input type="text" name="longitude" id="longitude" class="form-control" readonly required>
                </div>
                <div class="mb-3">
  <label>Foto Upload *</label>
  <input type="file" name="foto" class="form-control" id="fotoUpload" disabled required>
</div>

              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label>Nama Lokasi</label>
                  <input type="text" name="nama_lokasi" id="nama_lokasi" class="form-control" readonly>
                </div>
                <div class="mb-3">
                  <label>Jarak (meter)</label>
                  <input type="text" name="radius" id="radius" class="form-control" readonly>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-center gap-3 mt-4">
              <button type="button" onclick="checkLocation()" class="btn btn-secondary">Check Lokasi & Marker</button>
              <button type="submit" class="btn btn-success" id="btnTagging" disabled>Tagging</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Footer -->
<!-- Footer -->
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
    if (data.success) {
      document.getElementById("nama_lokasi").value = data.nama;
      document.getElementById("radius").value = data.jarak;
      alert("Berhasil! Lokasi ditemukan: " + data.nama + " (Jarak: " + data.jarak + " m)");

      // Aktifkan input foto setelah lokasi valid
      document.getElementById("fotoUpload").disabled = false;
    } else {
      alert("Anda berada di luar radius lokasi.");
      document.getElementById("nama_lokasi").value = "";
      document.getElementById("radius").value = "";
      document.getElementById("fotoUpload").disabled = true;
      document.getElementById("btnTagging").disabled = true;
    }
  }, () => {
    alert("Gagal mendapatkan lokasi.");
  });
}

function checkEnableTagging() {
  const lat = document.getElementById("latitude").value.trim();
  const lng = document.getElementById("longitude").value.trim();
  const nama = document.getElementById("nama_lokasi").value.trim();
  const radius = document.getElementById("radius").value.trim();
  const foto = document.querySelector("input[name='foto']").files.length > 0;

  const canTag = lat && lng && nama && radius && foto;
  document.getElementById("btnTagging").disabled = !canTag;
}

document.addEventListener("DOMContentLoaded", function () {
  document.querySelector("input[name='foto']").addEventListener("change", checkEnableTagging);
});

document.getElementById("tagForm").addEventListener("submit", function(e){
  document.getElementById("btnTagging").disabled = true;
});

</script>

</body>
</html>
