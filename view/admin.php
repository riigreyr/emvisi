<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: /emvisi/");
    exit;
}
?>

<?php include_once __DIR__ . "/head.php"; ?>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">Admin Dashboard</a>
    </div>
</nav>

<div class="container mt-4">

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">
                <i class="bi bi-person-circle"></i> Profile
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="klasemen-tab" data-bs-toggle="tab" data-bs-target="#klasemen" type="button" role="tab">
                <i class="bi bi-trophy"></i> Klasemen
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="halte-tab" data-bs-toggle="tab" data-bs-target="#halte" type="button" role="tab">
                <i class="bi bi-geo-alt"></i> Halte
            </button>
        </li>
    </ul>

    <div class="tab-content mt-3" id="myTabContent">
        <!-- Profile Tab -->
        <div class="tab-pane fade show active" id="profile" role="tabpanel">
            <div class="card p-4">
                <h5 class="mb-3">Update Profile</h5>
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" placeholder="Enter full name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" placeholder="Enter email">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                            <input type="text" class="form-control" placeholder="Enter username">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save Changes</button>
                </form>
            </div>
        </div>

        <!-- Klasemen Tab -->
        <div class="tab-pane fade" id="klasemen" role="tabpanel">
            <div class="card p-4">
                <div class="d-flex justify-content-between mb-3">
                    <h5>Klasemen Data</h5>
                    <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#klasemenModal"><i class="bi bi-plus-circle"></i> Add</button>
                </div>
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Wisata</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Foto</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>john_doe</td>
                            <td>Pantai Indah</td>
                            <td>-6.2000</td>
                            <td>106.8167</td>
                            <td><img src="https://via.placeholder.com/50" class="rounded"></td>
                            <td>
                                <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Halte Tab -->
        <div class="tab-pane fade" id="halte" role="tabpanel">
            <div class="card p-4">
                <div class="d-flex justify-content-between mb-3">
                    <h5>Halte Data</h5>
                    <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#halteModal"><i class="bi bi-plus-circle"></i> Add</button>
                </div>
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Wisata</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Radius</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Pantai Indah</td>
                            <td>-6.2000</td>
                            <td>106.8167</td>
                            <td>50m</td>
                            <td>
                                <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Klasemen Modal -->
<div class="modal fade" id="klasemenModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title">Add Klasemen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Wisata</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label>Latitude</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col mb-3">
                            <label>Longitude</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Upload Foto</label>
                        <input type="file" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Halte Modal -->
<div class="modal fade" id="halteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title">Add Halte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Wisata</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label>Latitude</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col mb-3">
                            <label>Longitude</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Radius</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
