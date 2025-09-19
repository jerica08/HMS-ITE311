<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Schedule - HMS Doctor</title>
    <link rel="stylesheet" href="/assets/css/dashboard-common.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .section-header { 
            display:flex; 
            align-items:center;
            gap:1rem; 
            margin-bottom:1.5rem; 
            padding-bottom:1rem; 
            border-bottom:1px solid #e2e8f0; 
        }
        .section-icon { 
            width:40px; 
            height:40px; 
            border-radius:8px; 
            background:#3b82f6; 
            display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.2rem; }
        .placeholder { background:#fff; border-radius:8px; padding:1.25rem; box-shadow:0 2px 4px rgba(0,0,0,0.08); }
        .info { color:#64748b; }
    </style>
</head>
<body class="doctor">

<header class="header">
    <div class="header-content">
        <div class="logo">
            <h1><i class="fas fa-user-md"></i> Doctor</h1>
        </div>
        <div class="user-info">
            <div class="user-avatar">
                <?= strtoupper(substr(\App\Helpers\UserHelper::getDisplayName($currentUser ?? null), 0, 2)) ?>
            </div>
            <div>
                <div style="font-weight: 600;">
                    <?= \App\Helpers\UserHelper::getDisplayName($currentUser ?? null) ?>
                </div>
                <div style="font-size: 0.9rem;opacity:0.8">
                    <?= \App\Helpers\UserHelper::getDisplayRole($currentUser ?? null) ?>
                </div>
            </div>
            <a class="btn btn-secondary" href="<?= base_url('profile') ?>" style="margin-left:.5rem;">
                <i class="fas fa-user"></i> Profile
            </a>
            <button class="logout-btn" onclick="handleLogout()">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </div>
    </div>
</header>

<div class="main-container">
    <nav class="sidebar">
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="<?= base_url('doctor/dashboard') ?>" class="nav-link">
                    <i class="fas fa-tachometer-alt nav-icon"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('doctor/patients') ?>" class="nav-link">
                    <i class="fas fa-users nav-icon"></i>
                    My Patients
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('doctor/appointments') ?>" class="nav-link">
                    <i class="fas fa-calendar-alt nav-icon"></i>
                    Appointments
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('doctor/prescriptions') ?>" class="nav-link">
                    <i class="fas fa-prescription-bottle nav-icon"></i>
                    Prescriptions
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('doctor/lab-results') ?>" class="nav-link">
                    <i class="fas fa-flask nav-icon"></i>
                    Lab Results
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('doctor/ehr') ?>" class="nav-link">
                    <i class="fas fa-file-medical nav-icon"></i>
                    Electronic Health Record
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('doctor/my-schedule') ?>" class="nav-link active">
                    <i class="fas fa-clock nav-icon"></i>
                    My Schedule
                </a>
            </li>
        </ul>      
    </nav>

    <main class="content">
        <h1 class="page-title">My Schedule</h1>
    </main>
</div>

<script src="<?= base_url('js/logout.js') ?>"></script>
</body>
</html>
