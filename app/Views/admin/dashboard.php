<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width", initial-scale="1.0">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="/assets/css/dashboard-common.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body class="admin">
        <!--Header-->
        <header class="header">
            <div class="header-content">
                <div class="logo">
                    <h1><i class="fas fa-hospital"></i> Administrator</h1>                    
                </div>
                <div class="user-info">
                    <div href="" class="fas fa-avatar" href=""></div>
                    <div>
                        <div style="font-weight: 600;">Dr.Jerica Marquez</div>
                        <div style="font-size: 0.9rem;opacity:0.8">Hospital Administrator</div>
                    </div>
                    <button class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </div>
            </div>
        </header>
        <div class="main-container">
            <!--sidebar-->
            <nav class="sidebar">
              
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="admin-dashboard.html" class="nav-link active">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="user-management.html" class="nav-link">
                            <i class="fas fa-users nav-icon"></i>
                            User Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin-analytics.html" class="nav-link">
                            <i class="fas fa-chart-bar nav-icon"></i>
                            Analytics & Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin-system-settings.html" class="nav-link">
                            <i class="fas fa-cogs nav-icon"></i>
                            System Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin-security.html" class="nav-link">
                            <i class="fas fa-shield-alt nav-icon"></i>
                            Security & Access
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin-audit-logs.html" class="nav-link">
                            <i class="fas fa-clipboard-list nav-icon"></i>
                            Audit Logs
                        </a>
                    </li>
                </ul>
            
            </nav>
        <!--main content-->
        <main class="content">
            <h1 class="page-title"> Administrator Dashboard</h1>

            <!--Dashboard overview cards-->
            <div class="dashboard-overview">
                <!-- User Management Card -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern blue">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">User Management</h3>
                            <p class="card-subtitle">Manage all system users and roles</p>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value blue">247</div>
                            <div class="metric-label">Total Users</div>
                        </div>
                        <div class="metric">
                            <div class="metric-value blue">8</div>
                            <div class="metric-label">Active Roles</div>
                        </div>
                        <div class="metric">
                            <div class="metric-value blue">12</div>
                            <div class="metric-label">Pending</div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <button class="action-btn primary">Add User</button>
                        <button class="action-btn secondary">Manage Roles</button>
                    </div>
                </div>

                <!-- System Analytics Card -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">System Analytics</h3>
                            <p class="card-subtitle">Comprehensive system reports</p>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value purple">1,847</div>
                            <div class="metric-label">Patients</div>
                        </div>
                        <div class="metric">
                            <div class="metric-value purple">342</div>
                            <div class="metric-label">Today's Visits</div>
                        </div>
                        <div class="metric">
                            <div class="metric-value green">$47K</div>
                            <div class="metric-label">Revenue</div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <button class="action-btn primary">View Reports</button>
                        <button class="action-btn secondary">Export Data</button>
                    </div>
                </div>

                <!-- Security & Access Card -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Security & Access</h3>
                            <p class="card-subtitle">Monitor system security</p>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value purple">156</div>
                            <div class="metric-label">Active Sessions</div>
                        </div>
                        <div class="metric">
                            <div class="metric-value purple">3</div>
                            <div class="metric-label">Failed Logins</div>
                        </div>
                        <div class="metric">
                            <div class="metric-value purple">99.9%</div>
                            <div class="metric-label">Security Score</div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <button class="action-btn danger">Security Audit</button>
                        <button class="action-btn warning">Access Logs</button>
                    </div>
                </div>
            </div>

            <!--Recent activity table-->
            <div class="table-container">
                <h3 style="margin-bottom: 1.5rem;"> Recent System Activities</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Module</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>08:45 AM</td>
                            <td>Dr. GAGNI</td>
                            <td>Patient Record Updated</td>
                            <td>EHR System</td>
                            <td><span class="badge badge-success">Success</span></td>
                            <td><a href="#" class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">View</a></td>
                        </tr>
                        <tr>
                            <td>08:42 AM</td>
                            <td>Nurse Xyril</td>
                            <td>Medication Administered</td>
                            <td>Patient Care</td>
                            <td><span class="badge badge-success">Success</span></td>
                            <td><a href="#" class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">View</a></td>
                        </tr>
                        <tr>
                            <td>08:38 AM</td>
                            <td>Lab Tech</td>
                            <td>Test Results Uploaded</td>
                            <td>Laboratory</td>
                            <td><span class="badge badge-success">Success</span></td>
                            <td><a href="#" class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">View</a></td>
                        </tr>
                        <tr>
                            <td>08:35 AM</td>
                            <td>System</td>
                            <td>Branch Sync Failed</td>
                            <td>Integration</td>
                            <td><span class="badge badge-danger">Failed</span></td>
                            <td><a href="#" class="btn btn-warning" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">Retry</a></td>
                        </tr>
                        <tr>
                            <td>08:30 AM</td>
                            <td>Pharmacist</td>
                            <td>Inventory Updated</td>
                            <td>Pharmacy</td>
                            <td><span class="badge badge-success">Success</span></td>
                            <td><a href="#" class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">View</a></td>
                        </tr>             
                    </tbody>
                </table>
            </div>

            <div class="dashboard-overview"style="margin-top:2rem;">
                
                <div class="card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-exclamation-triangle"></i>                          
                        </div>
                         <div>
                            <h3 class="card-title">System Alerts</h3>
                            <p class="card-content">Important notifications</p>
                        </div>
                    </div>
                    <div class="card-content">
                        <div style="padding: 0.8rem; background: #fed7d7; border-radius: 5px; margin-bottom: 1rem; border-left: 4px solid #f56565;">
                            <strong>High Priority:</strong> Branch 3 connection unstable
                        </div>
                        <div style="padding: 0.8rem; background: #feebc8; border-radius: 5px; margin-bottom: 1rem; border-left: 4px solid #ed8936;">
                            <strong>Medium:</strong> Backup scheduled for tonight
                        </div>
                        <div style="padding: 0.8rem; background: #bee3f8; border-radius: 5px; border-left: 4px solid #4299e1;">
                            <strong>Info:</strong> System update available
                        </div>
                    </div>
                </div>
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
        document.querySelector('.logout-btn').addEventListener('click', function() {
            if(confirm('Are you sure you want to logout?')) {
                window.location.href = '/auth/logout';
            }
        });
    </script>
    
        
    </body>
</html>