<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard' ?> - HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard-common.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?= $this->renderSection('styles') ?>
</head>
<body class="admin">
    <?= $this->include('admin/components/header') ?>
    
    <div class="main-container">
        <?= $this->include('admin/components/sidebar') ?>
        
        <main class="content">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <script src="<?= base_url('js/session-manager.js') ?>"></script>
    <script src="<?= base_url('js/utils.js') ?>"></script>
    <script src="<?= base_url('js/admin-dashboard.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
