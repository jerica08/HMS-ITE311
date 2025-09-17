<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Appointment Management - HMS Doctor</title>
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
    <body class="patient">

        <header class="header">
            <div class="header-content">
                <div class="logo">
                    <h1><i class="fas fa-hospital"></i>Doctor</h1>                    
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
                        <a href="" class="nav-link">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-users nav-icon"></i>
                           My Patients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link active">
                            <i class="fas fa-calendar-alt nav-icon"></i>
                            Appointments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-prescription-bottle nav-icon"></i>
                           Prescription
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-flask nav-icon"></i>
                            Lab Results
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-file-medical nav-icon"></i>
                           Electronic Health Records
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-clock nav-icon"></i>
                            My Schedule
                        </a>
                    </li>               
                </ul>          
            </nav>
        
            <!--Main Content-->
            <main class="content">
                <h1 class="page-title">Appointments</h1>
                <div class="page-actions">
                    <button class="btn btn-success" id="addPatientBtn">
                        <i class="fas fa-plus"></i> Schedule Appointments
                    </button>
                </div><br>

                <!--Dashboard overview cards-->
                <div class="dashboard-overview">

                    <!-- Today's Appointment Card -->
                    <div class="overview-card">
                        <div class="card-header-modern">
                            <div class="card-icon-modern blue">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-info">
                                <h3 class="card-title-modern">Todays Appointments</h3>
                                <p class="card-subtitle">Scedule for today</p>
                            </div>
                        </div>
                        <div class="card-metrics">
                            <div class="metric">
                                <div class="metric-value blue">0</div>
                                <div class="metric-label">Total</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value green">0</div>
                                <div class="metric-label">Completedk</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value orange">0</div>
                                <div class="metric-label">Remaining</div>
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
                                <h3 class="card-title-modern">Todays This Week</h3>
                                <p class="card-subtitle">Weekly overview</p>
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
                    <!-- Time Management Card -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-icon-modern blue">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h3 class="card-title">Time Management</h3>
                                <p class="card-content">Average consultation time</p>
                            </div>
                        </div>
                        <div class="card-content">
                            <div style="margin-bottom: 1rem;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span>Average Duration</span>
                                    <span>25 min</span>
                                </div>
                                <div style="background: #e2e8f0; height: 8px; border-radius: 4px;">
                                    <div style="background: #4299e1; height: 100%; width: 75%; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 1rem;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span>On-time Rate</span>
                                    <span>92%</span>
                                </div>
                                <div style="background: #e2e8f0; height: 8px; border-radius: 4px;">
                                    <div style="background: #48bb78; height: 100%; width: 53%; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>

                <!-- Alerts Card -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <h3 class="card-title">Appointment Alerts</h3>
                            <p class="card-content">Require attention</p>
                        </div>
                    </div>
                    <div class="card-content">
                        <div style="padding: 0.8rem; background: #fed7d7; border-radius: 5px; margin-bottom: 1rem; border-left: 4px solid #f56565;">
                            <strong>Overdue:</strong> Example alert notif.
                        </div>
                        <div style="padding: 0.8rem; background: #feebc8; border-radius: 5px; margin-bottom: 1rem; border-left: 4px solid #ed8936;">
                            <strong>Reminder:</strong> Example alert notif.
                        </div>
                        <div style="padding: 0.8rem; background: #bee3f8; border-radius: 5px; border-left: 4px solid #4299e1;">
                            <strong>Info:</strong> Example alert notif.
                        </div>
                    </div>
                </div>
      
                <!--Calendar View-->    
                <div class="search-filter">
                    <h3 style="margin-bottom: 1rem;">View Options</h3>
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
                    </div>          
                </div><br>

                

            <!-- Schedule Table -->
                <div class="patient-table">
                    <div class="table-header">
                        <h3>Today's Schedule - August 20, 2025</h3>
                        <div style="display: flex; gap: 0.5rem;">
                            <button class="btn btn-primary btn-small" id="printBtn">
                                <i class="fas fa-print"></i> Print Schedule
                            </button>
                            <button class="btn btn-secondary btn-small" id="exportBtn">
                                <i class="fas fa-sync"></i> Refresh
                            </button>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Patient</th>
                                <th>Type</th>
                                <th>Condition/Reason</th>
                                <th>Duration</th>              
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                           <tr>
                            <td>10:00 AM</td>
                            <td>
                                <div>
                                    <strong>Sarah Wilson</strong><br>
                                    <small>P0012347 | Age: 45</small>
                                </div>
                            </td>
                            <td>Follow-up</td>
                            <td>Hypertension Management</td>
                            <td>30 min</td>
                            <td><span class="badge badge-success">Completed</span></td>
                            <td>
                                <button class="btn btn-primary " style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">View Notes</button>
                                <button class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;"s>Reschedule</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>



            </main>
        </div>
        <script src="/js/logout.js"></script>
    </body>
</html>