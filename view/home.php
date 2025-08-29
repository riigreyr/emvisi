<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once __DIR__ . '/../controller/HomeController.php';

$controller = new HomeController();

// Ambil foto untuk slideshow
if (isset($_SESSION['user'])) {
    // user login → foto tagging sendiri
    $photos = $controller->getUserPhotosForHome();
} else {
    // belum login → foto tagging terbaru semua user
    $recentPhotos = $controller->getRecentPhotosAllUsers(5);
    $photos = [];
    foreach ($recentPhotos as $p) {
        $photos[] = $p['path_foto'];
    }
}
?>
<?php include_once __DIR__ . "/head.php"; ?>
<body>

<?php include_once __DIR__ . "/nav.php"; ?>

<!-- Konten Utama -->
<main>
  <div class="container mt-4">
    <div class="row gy-4">
      <div class="col-lg-7">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner rounded-3 shadow-sm">
    <?php if (!empty($photos)): ?>
        <?php foreach ($photos as $index => $fotoPath): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <img src="/emvisi/uploads/<?= htmlspecialchars($fotoPath) ?>" class="slideshow-img" alt="Foto Tagging <?= $index + 1 ?>" />
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="carousel-item active">
            <img src="/emvisi/uploads/foto_6899595329aa71.64687407.png" class="slideshow-img" alt="Default Slide" />
        </div>
    <?php endif; ?>
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
    <?php include_once __DIR__ . "/klasemen.php"; ?>
    
  </div>
</main>

<!-- Footer -->
<?php include_once __DIR__ . "/footer.php"; ?>

<script>
  window.addEventListener('DOMContentLoaded', () => {
    const alert = document.querySelector('.alert');
    if (alert) {
      setTimeout(() => {
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
      }, 3000); // notif hilang setelah 3 detik
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
