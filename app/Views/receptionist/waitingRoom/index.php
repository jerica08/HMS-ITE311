<!DOCTYPE html>
<html lang ="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width", initial-scale="1.0">
        <title>Waiting Room</title>
        <link rel="stylesheet" href="assets/css/dashboard-common.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body class="receptionist-theme">
        <header class="header">
            <div class="header-content">
                <div class="logo">
                    <h1><i class="fas fa-user-secret"></i>Receptionists</h1>
                </div>
                <div class="user-info">
                    <div class="user-avatar">
                        <?= strtoupper(substr(\App\Helpers\UserHelper::getDisplayName($currentUser ?? null), 0, 2)) ?>
                    </div>
                    <div>
                        <div style="font-weight: 600;">
                            <?= \App\Helpers\UserHelper::getDisplayName($currentUser ?? null) ?>
                        </div>
                        <div style="font-size: 0.9rem;opacity:0.8;">
                            <?= \App\Helpers\UserHelper::getDisplayRole($currentUser ?? null) ?>
                        </div>
                    </div>
                    <button class="logout-btn" onclick="handleLogout()">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </div>
            </div>
        </header>

        <div class="main-container">
            <!-- Sidebar -->
            <nav class="sidebar">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="#dashboard" class="nav-link">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#patient-registration" class="nav-link">
                            <i class="fas fa-user-plus nav-icon"></i>
                            Patient Registration
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#appointments" class="nav-link">
                            <i class="fas fa-calendar-alt nav-icon"></i>
                            Appointment Booking
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#check-in" class="nav-link">
                            <i class="fas fa-clipboard-check nav-icon"></i>
                            Patient Check-in
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#waiting-room" class="nav-link active">
                            <i class="fas fa-chair nav-icon"></i>
                            Waiting Room
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#insurance" class="nav-link">
                            <i class="fas fa-shield-alt nav-icon"></i>
                            Insurance Verification
                        </a>
                    </li>
                </ul>
            </nav>
            <main class="content">
                <div class="content-header">
                    <h2 class="page-title"><i class="fas fa-chair"></i> Waiting Room</h2>
                    <p class="page-subtitle">Monitor the waiting queue, manage status, and call the next patient.</p>
                </div>

                <section class="card">
                    <div class="card-header">
                        <h3 class="card-title">Queue</h3>
                        <div class="card-actions">
                            <div class="filters">
                                <select id="filterDepartment" class="filter-input">
                                    <option value="">All Departments</option>
                                </select>
                                <select id="filterDoctor" class="filter-input">
                                    <option value="">All Doctors</option>
                                </select>
                                <select id="filterStatus" class="filter-input">
                                    <option value="">All Status</option>
                                    <option value="waiting">Waiting</option>
                                    <option value="called">Called</option>
                                    <option value="no_show">No-show</option>
                                </select>
                            </div>
                            <button class="btn btn-secondary" type="button" id="refreshQueue"><i class="fas fa-rotate"></i> Refresh</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Queue #</th>
                                        <th>Patient</th>
                                        <th>Department</th>
                                        <th>Doctor</th>
                                        <th>Status</th>
                                        <th>Arrival</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="queueBody">
                                    <!-- Rows will be populated by backend/JS -->
                                </tbody>
                            </table>
                        </div>
                        <div class="form-actions" style="margin-top: 12px;">
                            <button class="btn btn-primary" type="button" id="callNext"><i class="fas fa-bullhorn"></i> Call Next</button>
                            <button class="btn" type="button" id="markNoShow"><i class="fas fa-user-slash"></i> Mark No-show</button>
                        </div>
                    </div>
                </section>
            </main>
        </div>
        <style>
        .content { 
            padding: 24px;
            width: 100%; 
            overflow: auto; 
        }
        .content-header { 
            margin-bottom: 16px; 
        }
        .page-title { 
            margin: 0 0 6px 0; 
            font-weight: 700; 
        }
        .page-subtitle { 
            margin: 0; 
            opacity: 0.8; 
        }
        .card { 
            background: var(--card-bg, #fff); 
            border-radius: 12px; 
            box-shadow: var(--shadow-md, 0 2px 12px rgba(0,0,0,0.06)); 
            overflow: hidden; 
        }
        .card-header { 
            padding: 16px 20px; 
            border-bottom: 1px solid rgba(0,0,0,0.06); 
            display: flex; align-items: center; 
            justify-content: space-between; 
            gap: 12px;
            flex-wrap: wrap;
        }
        .card-title { margin: 0; font-size: 1.05rem; font-weight: 600; }
        .card-actions { display: flex; align-items: center; gap: 10px; }
        .filters { display: flex; align-items: center; gap: 8px; }
        .filter-input { padding: 8px 10px; border: 1px solid rgba(0,0,0,0.15); border-radius: 8px; background: var(--input-bg, #fff); }
        .card-body { padding: 20px; }
        .table-wrapper { width: 100%; overflow: auto; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 10px 12px; text-align: left; border-bottom: 1px solid rgba(0,0,0,0.06); }
        .table thead th { background: rgba(0,0,0,0.03); font-weight: 700; }
        .status-badge { display: inline-block; padding: 4px 8px; border-radius: 999px; font-size: 0.85rem; font-weight: 600; }
        .status-waiting { background: #FEF3C7; color: #92400E; }
        .status-called { background: #DBEAFE; color: #1E40AF; }
        .status-no_show { background: #FEE2E2; color: #991B1B; }
        .form-actions { display: flex; gap: 10px; justify-content: flex-end; padding-top: 8px; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 14px; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; background: var(--muted, #e5e7eb); color: #111827; }
        .btn-primary { background: var(--primary, #2563eb); color: #fff; }
        .btn-secondary { background: var(--muted, #e5e7eb); color: #111827; }
        .btn:hover { filter: brightness(0.98); }
        @media (max-width: 900px) { .card-header { align-items: flex-start; } }
        .main-container { display: flex; }
        .sidebar { flex: 0 0 280px; }
        .content { flex: 1 1 auto; }
        </style>

        <script src="/public/js/logout.js"></script>
   
    </body>
    </html>