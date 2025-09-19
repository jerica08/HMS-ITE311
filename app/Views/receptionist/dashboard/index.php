<!DOCTYPE html>
<html lang ="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width", initial-scale="1.0">
        <title>Receptionist Dashboard</title>
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
                    <a class="btn btn-secondary" href="<?= base_url('profile') ?>" style="margin-left:.5rem;">
                        <i class="fas fa-user"></i> Profile
                    </a>
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
                        <a href="<?= base_url('receptionist/dashboard') ?>" class="nav-link active">
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
                        <a href="<?= base_url('receptionist/insurance') ?>" class="nav-link">
                            <i class="fas fa-shield-alt nav-icon"></i>
                            Insurance Verification
                        </a>
                    </li>
                </ul>
            </nav>
            <main class="content">
                <h1 class="page-title">Dashboard</h1>
    
                <!-- Dashboard Overview Cards -->
                <div class="dashboard-overview">
                    <!--Today's Appointmenet Card-->
                    <div class="overview-card">
                        <div class="card-header-modern">
                            <div class="card-icon-modern blue">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div>
                                <h3 class="card-title-modern">Today's Appointments</h3>
                                <p class="card-subtitle">Schedule visit for today</p>
                            </div>
                        </div>
                        <div class="card-metrics">
                            <div class="metrics">
                                <div class="metric-value purple">0</div>
                                <div class="metric-label">Total</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value purple">0</div>
                                <div class="metric-label">Checked</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value red">0</div>
                                <div class="metric-label">Pending</div>
                            </div>
                        </div>
                        <div class="card-actions">
                            <a href="#" class="action-btn primary">View Schedule</a>
                            <a href="#" class="action-btn secondary">New Appointment</a>
                        </div>
                    </div>
                    <!--Patient Registration Card-->
                    <div class="overview-card">
                        <div class="card-header-modern">
                            <div class="card-icon-modern blue">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div>
                                <h3 class="card-title-modern">Patient Registration</h3>
                                <p class="card-subtitle">New patient registrations</p>
                            </div>
                        </div>
                        <div class="card-metrics">
                            <div class="metrics">
                                <div class="metric-value purple">0</div>
                                <div class="metric-label">Today</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value purple">0</div>
                                <div class="metric-label"> New This Week</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value red">0</div>
                                <div class="metric-label">Pending</div>
                            </div>
                        </div>
                        <div class="card-actions">
                            <a href="#" class="action-btn primary">Register Patient</a>
                            <a href="#" class="action-btn danger">View Pending</a>
                        </div>
                    </div>
                    <!--Insurance Verification-->
                    <div class="overview-card">
                        <div class="card-header-modern">
                            <div class="card-icon-modern blue">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="card-info">
                                <h3 class="card-title">Insurance Verification</h3>
                                <p class="card-content">Insurance status checks</p>
                            </div>
                        </div>
                    <div class="card-metrics">
                            <div class="metric">
                                <div class="metric-value green">0</div>
                                <div class="metric-label">Pending</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value green">0</div>
                                <div class="metric-label">Verified</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value green">0</div>
                                <div class="metric-label">Issues</div>
                            </div>
                        </div>
                        <div class="card-actions">
                            <a href="#" class="action-btn primary">Verify Insurance</a>
                            <a href="#" class="action-btn danger">Resolve Issues</a>
                        </div>
                    </div>
                </div>
                <div class="table-container">
                    <h3 style="margin-bottom: 1.5rem;">Today's Appointment Schedule</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Patient Name</th>
                                <th>Doctor</th>
                                <th>Type</th>
                                <th>Insurance</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>09:00 AM</strong></td>
                                <td>PATIENT1</td>
                                <td>Dr. Johnson</td>
                                <td>Follow-up</td>
                                <td>Blue Cross</td>
                                <td><span class="badge badge-success">Checked In</span></td>
                                <td><a href="#" class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">View</a></td>
                            </tr>
                            <tr>
                                <td><strong>09:30 AM</strong></td>
                                <td>PATIENT2</td>
                                <td>Dr. Wilson</td>
                                <td>Consultation</td>
                                <td>Aetna</td>
                                <td><span class="badge badge-warning">Waiting</span></td>
                                <td><a href="#" class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">Check In</a></td>
                            </tr>
                            <tr>
                                <td><strong>10:00 AM</strong></td>
                                <td>PATIENT3</td>
                                <td>Dr. Brown</td>
                                <td>Check-up</td>
                                <td>Medicare</td>
                                <td><span class="badge badge-info">Scheduled</span></td>
                                <td><a href="#" class="btn btn-success" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">Check In</a></td>
                            </tr>
                            <tr>
                                <td><strong>10:30 AM</strong></td>
                                <td>PATIENT4</td>
                                <td>Dr. Martinez</td>
                                <td>Follow-up</td>
                                <td>Cigna</td>
                                <td><span class="badge badge-info">Scheduled</span></td>
                                <td><a href="#" class="btn btn-success" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">Check In</a></td>
                            </tr>
                            <tr>
                                <td><strong>11:00 AM</strong></td>
                                <td>PATIENT5</td>
                                <td>Dr. Lee</td>
                                <td>New Patient</td>
                                <td>Self-Pay</td>
                                <td><span class="badge badge-danger">No Show</span></td>
                                <td><a href="#" class="btn btn-warning" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">Contact</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
        <script>
        // Simple navigation functionality - removed preventDefault to allow page navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                // Allow navigation to proceed - don't prevent default
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Logout functionality
        function handleLogout() {
            if(confirm('Are you sure you want to logout?')) {
                window.location.href = '<?= base_url('auth/logout') ?>';
            }
        }
    </script>
    <script src="<?= base_url('js/logout.js') ?>"></script>
    </body>
    </html>