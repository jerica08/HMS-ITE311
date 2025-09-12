<!DOCTYPE html>
<html lang ="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width", initial-scale="1.0">
        <title>Patients CheckIn</title>
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
                        <a href="#check-in" class="nav-link active">
                            <i class="fas fa-clipboard-check nav-icon"></i>
                            Patient Check-in
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#waiting-room" class="nav-link">
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
                    <h2 class="page-title"><i class="fas fa-clipboard-check"></i> Patient Check-in</h2>
                    <p class="page-subtitle">Confirm arrival, assign queue number, and capture any arrival notes.</p>
                </div>

                <section class="card">
                    <div class="card-header">
                        <h3 class="card-title">Check-in Details</h3>
                    </div>
                    <div class="card-body">
                        <form id="patientCheckInForm" action="/receptionist/checkin/confirm" method="post" novalidate>
                            <?= csrf_field() ?>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="patient">Patient</label>
                                    <input type="text" id="patient" name="patient_search" placeholder="Search by name or ID" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="appointment">Appointment</label>
                                    <select id="appointment" name="appointment_id" required>
                                        <option value="">Select today's appointment</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="queue">Queue Number</label>
                                    <input type="text" id="queue" name="queue_number" placeholder="Auto or manual">
                                </div>
                                <div class="form-group">
                                    <label for="arrivalTime">Arrival Time</label>
                                    <input type="time" id="arrivalTime" name="arrival_time">
                                </div>
                                <div class="form-group form-group-full">
                                    <label for="notes">Arrival Notes</label>
                                    <textarea id="notes" name="notes" rows="3" placeholder="Optional notes (e.g., accompanied by, special assistance)"></textarea>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Confirm Check-in</button>
                                <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> Reset</button>
                            </div>
                        </form>
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
        }
        .card-title { margin: 0; font-size: 1.05rem; font-weight: 600; }
        .card-body { padding: 20px; }
        .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group-full { grid-column: 1 / -1; }
        .form-group label { font-weight: 600; margin-bottom: 6px; }
        .form-group input, .form-group select, .form-group textarea { padding: 10px 12px; border: 1px solid rgba(0,0,0,0.15); border-radius: 8px; background: var(--input-bg, #fff); }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: var(--primary, #2563eb); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15); }
        .form-actions { display: flex; gap: 10px; justify-content: flex-end; padding-top: 8px; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 14px; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; }
        .btn-primary { background: var(--primary, #2563eb); color: #fff; }
        .btn-secondary { background: var(--muted, #e5e7eb); color: #111827; }
        .btn:hover { filter: brightness(0.98); }
        @media (max-width: 900px) { .form-grid { grid-template-columns: 1fr; } }
        .main-container { display: flex; }
        .sidebar { flex: 0 0 280px; }
        .content { flex: 1 1 auto; }
        </style>

        <script src="/public/js/logout.js"></script>
   
    </body>
    </html>