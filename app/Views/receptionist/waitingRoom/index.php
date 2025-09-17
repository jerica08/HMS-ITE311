<!DOCTYPE html>
<html lang ="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width", initial-scale="1.0">
        <title>Waiting Room</title>
        <link rel="stylesheet" href="<?= base_url('assets/css/dashboard-common.css') ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body class="receptionist-theme">
        <header class="header">
            <div class="header-content">
                <div class="logo">
                    <h1><i class="fas fa-user-secret"></i>Receptionists</h1>
                </div>
                <div class="user-info">
                    <div href="" class="fas fa-avatar" href=""></div>
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
            <!-- Sidebar -->
            <nav class="sidebar">
                <ul class="nav-menu">
                    <li class="nav-item">
                    <a href="<?= base_url('receptionist/dashboard') ?>" class="nav-link">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('receptionist/patient-registration') ?>" class="nav-link">
                            <i class="fas fa-user-plus nav-icon"></i>
                            Patient Registration
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('receptionist/appointments') ?>" class="nav-link">
                            <i class="fas fa-calendar-alt nav-icon"></i>
                            Appointment Booking
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('receptionist/check-in') ?>" class="nav-link">

                            <i class="fas fa-clipboard-check nav-icon"></i>
                            Patient Check-in
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('receptionist/waiting-room') ?>" class="nav-link active">
                            <i class="fas fa-chair nav-icon"></i>
                            Waiting Room
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('receptionist/insurance') ?>" class="nav-link">
                            <i class="fas fa-shield-alt nav-icon"></i>
                            Insurance Verification
                        </a>
                    </li>
                </ul>
            </nav>
            
            <main class="content">
                <div class="content-header">
                    <h1 class="page-title"><i class="fas fa-chair"></i> Waiting Room</h1>
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
                        <div class="form-actions">
                            <button class="btn btn-primary" type="button" id="callNext"><i class="fas fa-bullhorn"></i> Call Next</button>
                            <button class="btn" type="button" id="markNoShow"><i class="fas fa-user-slash"></i> Mark No-show</button>
                        </div>
                    </div>
                </section>
            </main>
        </div>
        <style>
        /* Page-specific styles that complement the common CSS */
        .content-header { 
            margin-bottom: 1.5rem; 
        }
        .page-subtitle { 
            margin: 0.5rem 0 0 0; 
            opacity: 0.8;
            font-size: 0.95rem;
        }
        .filters { 
            display: flex; 
            align-items: center; 
            gap: 8px; 
            flex-wrap: wrap;
        }
        .filter-input { 
            padding: 8px 12px; 
            border: 1px solid #e2e8f0; 
            border-radius: 8px; 
            background: white;
            font-size: 0.9rem;
        }
        .table-wrapper { 
            width: 100%; 
            overflow-x: auto; 
        }
        .status-badge { 
            display: inline-block; 
            padding: 4px 8px; 
            border-radius: 999px; 
            font-size: 0.85rem; 
            font-weight: 600; 
        }
        .status-waiting { 
            background: #FEF3C7; 
            color: #92400E; 
        }
        .status-called { 
            background: #DBEAFE; 
            color: #1E40AF; 
        }
        .status-no_show { 
            background: #FEE2E2; 
            color: #991B1B; 
        }
        .form-actions { 
            display: flex; 
            gap: 10px; 
            justify-content: flex-end; 
            margin-top: 1rem;
        }
        @media (max-width: 768px) { 
            .filters {
                flex-direction: column;
                align-items: stretch;
            }
            .filter-input {
                width: 100%;
            }
        }
        </style>

        <script src="<?= base_url('js/logout.js') ?>"></script>
    </body>
    </html>