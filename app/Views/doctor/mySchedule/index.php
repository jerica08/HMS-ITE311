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
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 1.5rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid #e2e8f0;
            }
            .section-icon {
                width: 40px;
                height: 40px;
                border-radius: 8px;
                background: #3b82f6;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.2rem;
            }
            .status-admitted { background: #fef3c7; color: #92400e; }
            .status-discharged { background: #dcfce7; color: #166534; }
            .status-critical { background: #fecaca; color: #991b1b; }
            .status-stable { background: #dbeafe; color: #1e40af; }
            .status-emergency { background: #fed7cc; color: #c2410c; }
            .search-filters {
                background: white;
                border-radius: 8px;
                padding: 1.5rem;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                margin-bottom: 2rem;
            }
            .filter-row {
                display: flex;
                gap: 1rem;
                align-items: end;
                flex-wrap: wrap;
            }
            .filter-group {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
                min-width: 150px;
            }
            .filter-input {
                padding: 0.5rem;
                border: 1px solid #e2e8f0;
                border-radius: 5px;
                font-size: 0.9rem;
            }
            .patient-table {
                background: white;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .table-header {
                background: #f8fafc;
                padding: 1rem;
                border-bottom: 1px solid #e2e8f0;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .action-buttons {
                display: flex;
                gap: 0.5rem;
                margin-top: 1rem;
                flex-wrap: wrap;
            }
            .btn-small {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }
            .critical-alert {
                background: #fef2f2;
                border: 1px solid #fecaca;
                border-left: 4px solid #ef4444;
                border-radius: 8px;
                padding: 1rem;
                margin-bottom: 1rem;
            }
            .alert-header {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-weight: 600;
                color: #991b1b;
                margin-bottom: 0.5rem;
            }
            .alert-content {
                color: #7f1d1d;
                font-size: 0.9rem;
            }
            .quick-actions {
                background: white;
                border-radius: 8px;
                padding: 1.5rem;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                margin-bottom: 2rem;
            }
            .actions-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
                margin-top: 1rem;
            }
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
        <!--Main Content-->
        <div class="main-container">
                  <!--sidebar-->
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
                        <a href="<?= base_url('doctor/mySchedule') ?>" class="nav-link active">
                            <i class="fas fa-clock nav-icon"></i>
                            My Schedule
                        </a>
                    </li>
                </ul>      
            </nav>
        
            <!--Main Content-->
            <main class="content">
                <h1 class="page-title">My Schedule</h1>
                <div class="page-actions">
                    <button class="btn btn-success" id="blockTimeBtn">
                        <i class="fas fa-plus"></i> Block Time                  
                    </button>
                    <button class="btn btn-primary" id="scheduleSettingsBtn">
                        <i class="fas fa-cog"></i> Schedule Setting                     
                    </button>
                </div><br>

                <!--Dashboard overview cards-->
                <div class="dashboard-overview">

                    <!-- Today's Schedule Card -->
                    <div class="overview-card">
                        <div class="card-header-modern">
                            <div class="card-icon-modern blue">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-info">
                                <h3 class="card-title-modern">Today's Schedule</h3>
                                <p class="card-subtitle">September 09, 2025</p>
                            </div>
                        </div>
                        <div class="card-metrics">
                            <div class="metric">
                                <div class="metric-value blue">0</div>
                                <div class="metric-label">Appointments</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value green">0</div>
                                <div class="metric-label">Hours Booked</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value orange">0</div>
                                <div class="metric-label">Hours Free</div>
                            </div>
                        </div>
                    </div>
                    <!-- This Week Card -->
                    <div class="overview-card">
                        <div class="card-header-modern">
                            <div class="card-icon-modern blue">
                                <i class="fas fa-calendar-week"></i>
                            </div>
                            <div class="card-info">
                                <h3 class="card-title-modern">This Week</h3>
                                <p class="card-subtitle">Sept.09 - Sept.12, 2025</p>
                            </div>
                        </div>
                        <div class="card-metrics">
                            <div class="metric">
                                <div class="metric-value blue">0</div>
                                <div class="metric-label">Sceduled</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value green">0</div>
                                <div class="metric-label">Cancelled</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value orange">0</div>
                                <div class="metric-label">No-shows</div>
                            </div>
                        </div>
                    </div>                                   
                </div>
                
                <!--Calendar View-->    
                <div class="search-filter">
                    <h3 style="margin-bottom: 1rem;">Schedule View</h3>
                    <div class="filter-row">
                        <div class="btn-group">
                            <button class="btn btn-primary active" id="todayView">Today</button>
                            <button class="btn btn-secondary" id="weekView">Week</button>
                            <button class="btn btn-secondary" id="monthView">Month</button>
                        </div>
                         <div>
                            <input type="date" class="filter-input" id="dateSelector" value="2025-08-20">
                        </div>                                                                
                        <div>
                            <select class="filter-input" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="scheduled">Scheduled</option>
                                <option value="in-progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="no-show">No Show</option>
                            </select>
                        </div>  
                        <div>
                            <button class="btn btn-secondary">
                                <i class="fas fa-print"></i> Print
                            </button>
                            <button class="btn btn-primary">
                                <i class="fas fa-sync"></i> Refresh
                            </button>
                        </div>    
                    </div>                          
                </div>

                <!-- Daily Schedule View -->
                <div class="card" style="margin-top: 2rem;" id="dailySchedule">
                    <div class="card-header">
                        <h3 class="card-title">Tuesday, August 20, 2025</h3>
                    </div>
                    <div class="card-content">
                        <div style="display: grid; grid-template-columns: 100px 1fr; gap: 0; border: 1px solid #e2e8f0; border-radius: 8px;">
                            <!-- Time slots -->
                            <div style="background: #f7fafc; padding: 1rem 0.5rem; border-right: 1px solid #e2e8f0; text-align: center; font-weight: 600;">8:00 AM</div>
                            <div style="padding: 1rem; border-bottom: 1px solid #e2e8f0;">
                                <div style="background: #e6fffa; padding: 0.8rem; border-radius: 5px; border-left: 4px solid #38b2ac;">
                                    <strong>Available</strong> - Open slot for appointments
                                </div>
                            </div>

                            <div style="background: #f7fafc; padding: 1rem 0.5rem; border-right: 1px solid #e2e8f0; text-align: center; font-weight: 600;">9:00 AM</div>
                            <div style="padding: 1rem; border-bottom: 1px solid #e2e8f0;">
                                <div style="background: #bee3f8; padding: 0.8rem; border-radius: 5px; border-left: 4px solid #4299e1; cursor: pointer;" class="appointment-details-btn" data-appointment-id="apt1">
                                    <strong>John Smith</strong> - Follow-up (Hypertension)<br>
                                    <small>Duration: 30 min | Room: 201</small>
                                </div>
                            </div>

                            <div style="background: #f7fafc; padding: 1rem 0.5rem; border-right: 1px solid #e2e8f0; text-align: center; font-weight: 600;">9:30 AM</div>
                            <div style="padding: 1rem; border-bottom: 1px solid #e2e8f0;">
                                <div style="background: #c6f6d5; padding: 0.8rem; border-radius: 5px; border-left: 4px solid #48bb78;">
                                    <strong>Maria Garcia</strong> - Consultation (Chest Pain)<br>
                                    <small>Duration: 45 min | Room: 201</small>
                                </div>
                            </div>

                            <div style="background: #f7fafc; padding: 1rem 0.5rem; border-right: 1px solid #e2e8f0; text-align: center; font-weight: 600;">10:15 AM</div>
                            <div style="padding: 1rem; border-bottom: 1px solid #e2e8f0;">
                                <div style="background: #fbb6ce; padding: 0.8rem; border-radius: 5px; border-left: 4px solid #ed64a6;">
                                    <strong>Robert Johnson</strong> - Check-up (Annual Physical)<br>
                                    <small>Duration: 30 min | Room: 201 | <strong>IN PROGRESS</strong></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            <!-- Modals -->
            <div class="modal" id="blockTimeModal">

                <!-- Block Time Modal -->
                <div class="modal-content" style="max-width: 720px;">
                    <div class="modal-header">
                        <h3>Block Time</h3>
                        <button class="modal-close" id="closeBlockTime">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="blockTimeForm">
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Block Type</label>
                                <select class="form-select" required>
                                    <option value="">Select</option>
                                    <option>Personal Time</option>
                                    <option>Administrative Work</option>
                                    <option>Research</option>
                                    <option>Meeting</option>
                                    <option>Training</option>
                                </select>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Date</label>
                                    <input type="date" class="form-input" required>
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Duration</label>
                                    <select class="form-select" required>
                                        <option>30 minutes</option>
                                        <option>1 hour</option>
                                        <option>2 hours</option>
                                        <option>Half day</option>
                                        <option>Full day</option>
                                    </select>
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Start Time</label>
                                    <input type="time" class="form-input" required>
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">End Time</label>
                                    <input type="time" class="form-input" required>
                                </div>
                            </div>
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Notes</label>
                                <textarea class="form-input" rows="3" placeholder="Optional notes..."></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancelBlockTime">Cancel</button>
                        <button type="submit" form="blockTimeForm" class="btn btn-success">Save Block</button>
                    </div>
                </div>
            </div>

            <!-- Schedule Settings Modal -->
            <div class="modal" id="scheduleSettingsModal">
                <div class="modal-content" style="max-width: 720px;">
                    <div class="modal-header">
                        <h3>Schedule Settings</h3>
                        <button class="modal-close" id="closeScheduleSettings">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="scheduleSettingsForm">
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Default Appointment Duration</label>
                                <select class="form-select">
                                    <option>15 minutes</option>
                                    <option selected>30 minutes</option>
                                    <option>45 minutes</option>
                                    <option>60 minutes</option>
                                </select>
                            </div>
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Buffer Time Between Appointments</label>
                                <select class="form-select">
                                    <option>No buffer</option>
                                    <option selected>5 minutes</option>
                                    <option>10 minutes</option>
                                    <option>15 minutes</option>
                                </select>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Workday Start</label>
                                    <input type="time" class="form-input" value="08:00">
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Workday End</label>
                                    <input type="time" class="form-input" value="17:00">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancelScheduleSettings">Cancel</button>
                        <button type="submit" form="scheduleSettingsForm" class="btn btn-primary">Save Settings</button>
                    </div>
                </div>
            </div>

            <!-- Appointment Details Modal -->
            <div class="modal" id="appointmentDetailsModal">
                <div class="modal-content" style="max-width: 760px;">
                    <div class="modal-header">
                        <h3>Appointment Details</h3>
                        <button class="modal-close" id="closeAppointmentDetails">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                            <div>
                                <h4 style="margin-bottom: 1rem; color: #2d3748;">Patient</h4>
                                <div style="background: #f0fff4; padding: 1rem; border-radius: 8px;">
                                    <div style="margin-bottom: 0.5rem;"><strong>Name:</strong> <span id="aptPatientName">John Smith</span></div>
                                    <div style="margin-bottom: 0.5rem;"><strong>Reason:</strong> <span id="aptReason">Follow-up (Hypertension)</span></div>
                                    <div style="margin-bottom: 0.5rem;"><strong>Room:</strong> <span id="aptRoom">201</span></div>
                                </div>
                            </div>
                            <div>
                                <h4 style="margin-bottom: 1rem; color: #2d3748;">Schedule</h4>
                                <div style="background: #f7fafc; padding: 1rem; border-radius: 8px;">
                                    <div style="margin-bottom: 0.5rem;"><strong>Date:</strong> <span id="aptDate">Aug 20, 2025</span></div>
                                    <div style="margin-bottom: 0.5rem;"><strong>Time:</strong> <span id="aptTime">9:00 AM - 9:30 AM</span></div>
                                    <div style="margin-bottom: 0.5rem;"><strong>Status:</strong> <span id="aptStatus" class="badge badge-info">Scheduled</span></div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Notes</label>
                            <textarea class="form-input" rows="3" placeholder="Add notes..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancelAppointmentDetails">Close</button>
                        <button type="button" class="btn btn-primary" id="printAppointment">Print</button>
                    </div>
                </div>
            </div>

            <style>
            .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); }
            .modal.show { display: flex; align-items: center; justify-content: center; }
            .modal-content { background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15); }
            .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; border-bottom: 1px solid #e2e8f0; background-color: #f7fafc; }
            .modal-header h3 { margin: 0; color: #2d3748; }
            .modal-close { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #718096; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; }
            .modal-close:hover { color: #2d3748; }
            .modal-body { padding: 1.5rem; }
            .modal-footer { display: flex; justify-content: flex-end; gap: 1rem; padding: 1.5rem; border-top: 1px solid #e2e8f0; background-color: #f7fafc; }
            .form-input, .form-select { width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.9rem; }
            .form-input:focus, .form-select:focus { outline: none; border-color: #4299e1; box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1); }
            </style>

            <script>
            (function() {
                const blockModal = document.getElementById('blockTimeModal');
                const settingsModal = document.getElementById('scheduleSettingsModal');
                const aptModal = document.getElementById('appointmentDetailsModal');

                function open(m) { m.classList.add('show'); }
                function close(m) { m.classList.remove('show'); }

                // Block Time
                document.getElementById('blockTimeBtn').addEventListener('click', function(){ open(blockModal); });
                document.getElementById('closeBlockTime').addEventListener('click', function(){ close(blockModal); });
                document.getElementById('cancelBlockTime').addEventListener('click', function(){ close(blockModal); });
                document.getElementById('blockTimeForm').addEventListener('submit', function(e){ e.preventDefault(); alert('Block time saved.'); close(blockModal); this.reset(); });

                // Schedule Settings
                document.getElementById('scheduleSettingsBtn').addEventListener('click', function(){ open(settingsModal); });
                document.getElementById('closeScheduleSettings').addEventListener('click', function(){ close(settingsModal); });
                document.getElementById('cancelScheduleSettings').addEventListener('click', function(){ close(settingsModal); });
                document.getElementById('scheduleSettingsForm').addEventListener('submit', function(e){ e.preventDefault(); alert('Settings saved.'); close(settingsModal); });

                // Appointment Details
                document.querySelectorAll('.appointment-details-btn').forEach(function(el){ el.addEventListener('click', function(){ open(aptModal); }); });
                document.getElementById('closeAppointmentDetails').addEventListener('click', function(){ close(aptModal); });
                document.getElementById('cancelAppointmentDetails').addEventListener('click', function(){ close(aptModal); });
                document.getElementById('printAppointment').addEventListener('click', function(){ window.print(); });

                // Outside click close
                window.addEventListener('click', function(e){
                    [blockModal, settingsModal, aptModal].forEach(function(m){ if (e.target === m) close(m); });
                });
            })();
            </script>

            </main>
        </div>
        <script src="/js/logout.js"></script>
    </body>
</html>