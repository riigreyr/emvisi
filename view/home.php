<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once __DIR__ . '/../controller/HomeController.php';
$controller = new HomeController();
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Homepage - BelanjaYuk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    html, body { height: 100%; }
    body { display: flex; flex-direction: column; }
    main { flex: 1; }
    .slideshow-img {
      width: 100%; height: 400px; object-fit: cover; border-radius: 8px;
    }
    .carousel-caption-custom {
      position: absolute; bottom: 10px; left: 15px;
      background-color: rgba(0, 0, 0, 0.5); color: white;
      padding: 5px 10px; border-radius: 5px; font-size: 0.9rem;
    }
    .card-header { font-weight: bold; }
    footer {
      background: #e9ecef; text-align: center;
      padding: 1.5rem 0; font-size: 0.9rem; color: #333;
    }
    .card-equal-height { height: 100%; }
    .bg-blue-dark { background-color: #0b3d91 !important; color: white !important; }
    .btn-blue-dark {
      background-color: #0b3d91; border-color: #0b3d91; color: white;
    }
    .btn-blue-dark:hover {
      background-color: #092f6d; border-color: #092f6d; color: white;
    }
    .custom-klasemen-row { margin-top: 3rem; }
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
        <a class="nav-link active" aria-current="page" href="/emvisi/">Beranda</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/emvisi/home/peta">Peta</a>
      </li>
    </ul>
  </div>
</nav>

<!-- Konten Utama -->
<main>
  <div class="container mt-4">
    <div class="row gy-4">
      <div class="col-lg-7">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner rounded-3 shadow-sm">
            <div class="carousel-item active position-relative">
              <img src="../assets/img/slide1.jpg" class="slideshow-img" alt="Slide 1" />
              <div class="carousel-caption-custom"></div>
            </div>
            <div class="carousel-item">
              <img src="../assets/img/slide2.jpg" class="slideshow-img" alt="Slide 2" />
            </div>
            <div class="carousel-item">
              <img src="../assets/img/slide3.jpg" class="slideshow-img" alt="Slide 3" />
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      </div>

      <div class="col-lg-5">
        <ul class="nav nav-tabs mb-3" id="authTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-selected="true">
              Register
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-selected="false">
              Login
            </button>
          </li>
        </ul>

        <div class="tab-content" id="authTabContent">
          <!-- Register -->
          <div class="tab-pane fade show active" id="register" role="tabpanel">
            <form method="post">
              <input type="hidden" name="register" value="1">
              <div class="row g-3 align-items-center">
                <div class="col-md-6">
                  <label for="registerEmail" class="form-label">Email</label>
                  <input type="email" class="form-control" id="registerEmail" name="email" required />
                </div>
                <div class="col-md-6">
                  <label for="registerPassword" class="form-label">Password</label>
                  <input type="password" class="form-control" id="registerPassword" name="password" required />
                </div>
                <div class="col-md-6">
                  <label for="registerName" class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control" id="registerName" name="fullname" required />
                </div>
                <div class="col-md-6">
                  <label for="registerDescription" class="form-label">Deskripsi</label>
                  <input type="text" class="form-control" id="registerDescription" name="description" />
                </div>
              </div>
              <button type="submit" class="btn btn-blue-dark w-100 mt-3">
                <i class="bi bi-person-plus-fill"></i> Register
              </button>
             <?php
if (!empty($_SESSION['notif_register'])) {
    echo $_SESSION['notif_register'];
    unset($_SESSION['notif_register']);
}
?>



            </form>
          </div>

          <!-- Login -->
          <div class="tab-pane fade" id="login" role="tabpanel">
            <form method="post">
              <input type="hidden" name="login" value="1">
              <div class="mb-3">
                <label for="loginEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="loginEmail" name="email" required />
              </div>
              <div class="mb-3">
                <label for="loginPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="loginPassword" name="password" required />
              </div>
              <button type="submit" class="btn btn-blue-dark w-100">Login</button>
              <?php if (isset($_SESSION['notif_login'])): ?>
                <div class="alert alert-danger mt-2"><?= $_SESSION['notif_login']; unset($_SESSION['notif_login']); ?></div>
              <?php endif; ?>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Klasemen -->
    <div class="row custom-klasemen-row g-4">
      <div class="col-md-4">
        <div class="card shadow-sm card-equal-height">
          <div class="card-header bg-blue-dark">Top 5 Klasemen</div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><span class="badge bg-blue-dark float-end"></span></li>
            <li class="list-group-item"><span class="badge bg-blue-dark float-end"></span></li>
            <li class="list-group-item"><span class="badge bg-blue-dark float-end"></span></li>
            <li class="list-group-item"><span class="badge bg-blue-dark float-end"></span></li>
            <li class="list-group-item"><span class="badge bg-blue-dark float-end"></span></li>
          </ul>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm card-equal-height h-100">
          <div class="card-header bg-blue-dark">Top 5 Lokasi</div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><span class="badge bg-blue-dark float-end"></span></li>
            <li class="list-group-item"><span class="badge bg-blue-dark float-end"></span></li>
            <li class="list-group-item"><span class="badge bg-blue-dark float-end"></span></li>
            <li class="list-group-item"><span class="badge bg-blue-dark float-end"></span></li>
            <li class="list-group-item"><span class="badge bg-blue-dark float-end"></span></li>
          </ul>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm card-equal-height">
          <div class="card-header bg-blue-dark">Data</div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Total User <span class="badge bg-blue-dark float-end"></span></li>
            <li class="list-group-item">Total Lokasi <span class="badge bg-blue-dark float-end"></span></li>
            <li class="list-group-item">Total Tagging <span class="badge bg-blue-dark float-end"></span></li>
            <li class="list-group-item">Latest User Tagging <span class="badge bg-blue-dark float-end"></span></li>
            <li class="list-group-item">Latest Lokasi Tagging <span class="badge bg-blue-dark float-end"></span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Footer -->
<footer class="mt-5 py-4 bg-blue-dark text-white">
  <div class="container">
    <strong>BelanjaYuk</strong><br>
    <small>©2025 dikembangkan oleh Fakhri</small>
    <div class="mt-2">
      <strong>Kontak Kami</strong><br>
      Dinas Komunikasi, Informatika dan Persandian Aceh<br>
      Jl. Jalan. 10<br>
      Banda Aceh
    </div>
  </div>
</footer>

<script>
  window.addEventListener('DOMContentLoaded', () => {
    const alert = document.querySelector('.alert');
    if (alert) {
      setTimeout(() => {
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
      }, 1000); // notif hilang setelah 3 detik
    }
  });
</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if (isset($_SESSION['switch_to_login'])): ?>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const loginTab = new bootstrap.Tab(document.querySelector('#login-tab'));
      loginTab.show();
    });
  </script>
  <?php unset($_SESSION['switch_to_login']); ?>
<?php endif; ?>

</body>
</html>
