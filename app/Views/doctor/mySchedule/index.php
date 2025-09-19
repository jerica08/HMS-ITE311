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
        /* Calendar & list */
        .calendar-card { background:#fff; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.1); padding:1rem; }
        .calendar-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; }
        .calendar-grid { display:grid; grid-template-columns: repeat(7, 1fr); gap:.5rem; }
        .calendar-day { background:#f8fafc; border-radius:8px; padding:.75rem; min-height:140px; display:flex; flex-direction:column; gap:.5rem; }
        .day-title { font-weight:600; color:#334155; display:flex; align-items:center; justify-content:space-between; }
        .shift-chip { background:#e0f2fe; color:#075985; border:1px solid #bae6fd; border-radius:6px; padding:.35rem .5rem; font-size:.85rem; display:flex; align-items:center; gap:.35rem; cursor:pointer; }
        .shift-chip.afternoon { background:#dcfce7; color:#166534; border-color:#bbf7d0; }
        .shift-chip.night { background:#ede9fe; color:#5b21b6; border-color:#ddd6fe; }
        .upcoming-card { background:#fff; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.1); padding:1rem; }
        .upcoming-item { display:flex; justify-content:space-between; align-items:center; padding:.75rem 0; border-bottom:1px solid #f1f5f9; }
        .upcoming-item:last-child { border-bottom:0; }
        .badge { padding:.2rem .5rem; border-radius:9999px; font-size:.75rem; }
        .badge.morning { background:#e0f2fe; color:#075985; }
        .badge.afternoon { background:#dcfce7; color:#166534; }
        .badge.night { background:#ede9fe; color:#5b21b6; }
        /* Modals */
        .modal { display:none; position:fixed; inset:0; z-index:1000; background:rgba(15,23,42,.45); }
        .modal.show { display:flex; align-items:center; justify-content:center; }
        .modal-content { background:#fff; border-radius:10px; width:94%; max-width:720px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,.15); }
        .modal-header { display:flex; align-items:center; justify-content:space-between; padding:1rem 1.25rem; border-bottom:1px solid #e5e7eb; background:#f8f9ff; }
        .modal-body { padding:1rem 1.25rem; }
        .modal-footer { display:flex; justify-content:flex-end; gap:.5rem; padding:1rem 1.25rem; border-top:1px solid #e5e7eb; background:#fff; }
        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; }
        .form-grid .full { grid-column:1 / -1; }
        .form-label { font-size:.9rem; color:#374151; margin-bottom:.25rem; display:block; font-weight:600; }
        .form-input, .form-select, .form-textarea { width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:.6rem .75rem; font-size:.95rem; }
        .form-textarea { min-height:90px; }
        .mini { padding:.35rem .6rem; font-size:.85rem; }
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
        <div class="page-actions" style="display:flex; gap:.5rem; flex-wrap:wrap;">
            <button class="btn btn-success" id="addAvailabilityBtn"><i class="fas fa-plus"></i> Add Availability</button>
            <button class="btn btn-primary" id="requestSwapBtn"><i class="fas fa-exchange-alt"></i> Request Shift Swap</button>
            <button class="btn btn-secondary" id="refreshBtn"><i class="fas fa-sync"></i> Refresh</button>
        </div>

        <br>
        <div class="dashboard-overview">
            <div class="overview-card">
                <div class="card-header-modern">
                    <div class="card-icon-modern blue"><i class="fas fa-calendar-day"></i></div>
                    <div class="card-info">
                        <h3 class="card-title-modern">Next Shift</h3>
                        <p class="card-subtitle">When and where</p>
                    </div>
                </div>
                <div class="card-metrics">
                    <div class="metric">
                        <div id="nextShiftWhen" class="metric-value blue">—</div>
                        <div id="nextShiftWhere" class="metric-label">—</div>
                    </div>
                </div>
            </div>
            <div class="overview-card">
                <div class="card-header-modern">
                    <div class="card-icon-modern purple"><i class="fas fa-clock"></i></div>
                    <div class="card-info">
                        <h3 class="card-title-modern">Weekly Hours</h3>
                        <p class="card-subtitle">This week</p>
                    </div>
                </div>
                <div class="card-metrics">
                    <div class="metric">
                        <div id="weeklyHours" class="metric-value purple">0</div>
                        <div class="metric-label">Hours</div>
                    </div>
                </div>
            </div>
            <div class="overview-card">
                <div class="card-header-modern">
                    <div class="card-icon-modern green"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="card-info">
                        <h3 class="card-title-modern">Conflicts</h3>
                        <p class="card-subtitle">Overlaps & leaves</p>
                    </div>
                </div>
                <div class="card-metrics">
                    <div class="metric">
                        <div id="conflictCount" class="metric-value green">0</div>
                        <div class="metric-label">Items</div>
                    </div>
                </div>
            </div>
        </div>
        
    </main>
</div>

<script src="<?= base_url('js/logout.js') ?>"></script>
</body>
</html>
