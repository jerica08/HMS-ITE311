<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - HMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Laboratory Management</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="/laboratories">
                                <i class="fas fa-flask"></i> All Laboratories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/laboratories/create">
                                <i class="fas fa-plus"></i> Add Laboratory
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?= $title ?></h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="/laboratories/create" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Laboratory
                        </a>
                    </div>
                </div>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Laboratories List</h5>
                            </div>
                            <div class="card-body">
                                <?php if (empty($laboratories_list)): ?>
                                    <div class="text-center py-5">
                                        <i class="fas fa-flask fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No laboratories found</h5>
                                        <p class="text-muted">Start by adding your first laboratory.</p>
                                        <a href="/laboratories/create" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Add Laboratory
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Location</th>
                                                    <th>Capacity</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($laboratories_list as $lab): ?>
                                                    <tr>
                                                        <td><?= $lab['id'] ?></td>
                                                        <td><?= esc($lab['name']) ?></td>
                                                        <td><?= esc($lab['location']) ?></td>
                                                        <td><?= $lab['capacity'] ?></td>
                                                        <td>
                                                            <span class="badge bg-<?= $lab['status'] === 'active' ? 'success' : ($lab['status'] === 'inactive' ? 'danger' : 'warning') ?>">
                                                                <?= ucfirst($lab['status']) ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="/laboratories/edit/<?= $lab['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                            <a href="/laboratories/delete/<?= $lab['id'] ?>" class="btn btn-sm btn-outline-danger" 
                                                               onclick="return confirm('Are you sure you want to delete this laboratory?')">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
