<?php
include_once __DIR__ . '/../controller/KlasemenController.php';
$controller = new KlasemenController();
$data = $controller->getData();
?>

<div class="row custom-klasemen-row g-4">
  <!-- Top 5 Klasemen -->
  <div class="col-md-4">
    <div class="card shadow-sm card-equal-height">
      <div class="card-header bg-blue-dark">Top 5 Klasemen</div>
      <ul class="list-group list-group-flush">
        <?php foreach ($data['top_users'] as $user): ?>
          <li class="list-group-item">
            <?= htmlspecialchars($user['full_name']) ?>
            <span class="badge bg-blue-dark float-end"><?= $user['total'] ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <!-- Top 5 Lokasi -->
  <div class="col-md-4">
    <div class="card shadow-sm card-equal-height h-100">
      <div class="card-header bg-blue-dark">Top 5 Lokasi</div>
      <ul class="list-group list-group-flush">
        <?php foreach ($data['top_lokasi'] as $lokasi): ?>
          <li class="list-group-item">
            <?= htmlspecialchars($lokasi['nama']) ?>
            <span class="badge bg-blue-dark float-end"><?= $lokasi['total'] ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <!-- Data Summary -->
  <div class="col-md-4">
    <div class="card shadow-sm card-equal-height">
      <div class="card-header bg-blue-dark">Data</div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">Total User <span class="badge bg-blue-dark float-end"><?= $data['summary']['total_user'] ?></span></li>
        <li class="list-group-item">Total Lokasi <span class="badge bg-blue-dark float-end"><?= $data['summary']['total_lokasi'] ?></span></li>
        <li class="list-group-item">Total Tagging <span class="badge bg-blue-dark float-end"><?= $data['summary']['total_tagging'] ?></span></li>
        <li class="list-group-item">Latest User Tagging <span class="badge bg-blue-dark float-end"><?= $data['summary']['latest_user'] ?></span></li>
        <li class="list-group-item">Latest Lokasi Tagging <span class="badge bg-blue-dark float-end"><?= $data['summary']['latest_lokasi'] ?></span></li>
      </ul>
    </div>
  </div>
</div>
