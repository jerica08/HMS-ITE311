<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width", initial-scale="1.0">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href=<?= base_url('assets/css/dashboard-common.css') ?>>
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
                        <a href="<?= base_url('admin/dashboard') ?>" class="nav-link active">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/users') ?>" class="nav-link">
                            <i class="fas fa-users nav-icon"></i>
                            User Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/staff') ?>" class="nav-link">
                            <i class="fas fa-user-tie nav-icon"></i>
                            Staff Management
                        </a>
                     <li class="nav-item">
                        <a href="<?= base_url('admin/resource') ?>" class="nav-link">
                            <i class="fas fa-hospital nav-icon"></i>
                             Resource Management
                        </a>
                    </li>
                     <li class="nav-item">
                        <a href="<?= base_url('admin/financial') ?>" class="nav-link">
                            <i class="fas fa-dollar-sign nav-icon"></i>
                            Financial Management
                        </a>
                        <li class="nav-item">
                        <a href="<?= base_url('admin/patient') ?>" class="nav-link">
                            <i class="fas fa-user-injured nav-icon"></i>
                            Patient Management
                        </a>
                        
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/communication') ?>" class="nav-link">
                            <i class="fas fa-comments nav-icon"></i>
                             Communication
                        </a>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/analytics') ?>" class="nav-link">
                            <i class="fas fa-chart-bar nav-icon"></i>
                            Analytics & Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/system-settings') ?>" class="nav-link">
                            <i class="fas fa-cogs nav-icon"></i>
                            System Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/security') ?>" class="nav-link">
                            <i class="fas fa-shield-alt nav-icon"></i>
                            Security & Access
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/communication') ?>" class="nav-link">
                            <i class="fas fa-comments nav-icon"></i>
                            Communication
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/audit-logs') ?>" class="nav-link">
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

                        <div class="metric-value blue" id="totalUsers">0</div>
                            <div class="metric-label">Total Users</div>
                        </div>
                        <div class="metric">
                        <div class="metric-value blue" id="activeRoles">0</div>
                            <div class="metric-label">Active Roles</div>
                        </div>
                        <div class="metric">
                            <div class="metric-value blue">12</div>

                            <div class="metric-label">Pending</div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <button class="action-btn primary" onclick="openAddUserModal()">Add User</button>
                        <button class="action-btn secondary" onclick="window.location.href='<?= base_url('admin/roles') ?>'">Manage Roles</button>
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
                            <div class="metric-value purple" id="totalPatients">0</div>
                            <div class="metric-label">Patients</div>
                        </div>
                        <div class="metric">
                            <div class="metric-value purple" id="todaysVisits">0</div>
                            <div class="metric-label">Today's Visits</div>
                        </div>
                        <div class="metric">
                            <div class="metric-value purple">₱47K</div>

                            <div class="metric-label">Revenue</div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <button class="action-btn primary" onclick="window.location.href='<?= base_url('admin/analytics') ?>'">View Reports</button>
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
                            <div class="metric-value purple" id="activeSessions">0</div>
                            <div class="metric-label">Active Sessions</div>
                        </div>
                        <div class="metric">
                            <div class="metric-value purple" id="failedLogins">0</div>
                            <div class="metric-label">Failed Logins</div>
                        </div>
                        <div class="metric">
                            <div class="metric-value purple">99.9%</div>
                            <div class="metric-label">Security Score</div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <button class="action-btn danger" onclick="window.location.href='<?= base_url('admin/security') ?>'">Security Audit</button>
                        <button class="action-btn warning" onclick="window.location.href='<?= base_url('admin/audit-logs') ?>'">Access Logs</button>
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

            <!-- Add User Modal -->
            <div id="userModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 id="modalTitle">Add New User</h2>
                        <button class="close-btn" onclick="closeUserModal()">&times;</button>
                    </div>
                    <form id="userForm">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>First Name*</label>
                                <input type="text" class="form-input" id="first_name" name="first_name" required>
                            </div>  
                            <div class="form-group">
                                <label>Last Name*</label>
                                <input type="text" class="form-input" id="last_name" name="last_name" required>
                            </div> 
                            <div class="form-group">
                                <label>Email*</label>
                                <input type="email" class="form-input" id="email" name="email" required>
                            </div> 
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-input" id="phone" name="phone">
                            </div> 
                            <div class="form-group">
                                <label>Password*</label>
                                <input type="password" class="form-input" id="password" name="password" required placeholder="Enter password (min 6 characters)">
                            </div>
                            <div class="form-group">
                                <label>Role*</label>
                                <select class="form-input" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin">Administrator</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="nurse">Nurse</option>
                                    <option value="receptionist">Receptionist</option>
                                    <option value="laboratorist">Laboratory Staff</option>
                                    <option value="pharmacist">Pharmacist</option>
                                    <option value="accountant">Accountant</option>
                                    <option value="it_staff">IT Staff</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Department</label>
                                <select class="form-input" id="department" name="department">
                                    <option value="">Select Department</option>
                                    <option value="Cardiology">Cardiology</option>
                                    <option value="Emergency">Emergency</option>
                                    <option value="Laboratory">Laboratory</option>
                                    <option value="Pharmacy">Pharmacy</option>
                                    <option value="Administration">Administration</option>
                                    <option value="IT Department">IT Department</option>
                                    <option value="Accounting">Accounting</option>
                                </select>
                            </div>
                        </div>
                        <div style="display:flex;gap:1rem;justify-content:flex-end;margin-top:2rem;">
                            <button type="button" class="btn btn-secondary" onclick="closeUserModal()">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save User</button>
                        </div>
                    </form>
                </div>
            </div>

            <style>
                .modal {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0,0,0,0.5);
                    z-index: 1000;
                }
                .modal-content {
                    background: white;
                    margin: 5% auto;
                    padding: 2rem;
                    border-radius: 8px;
                    width: 90%;
                    max-width: 600px;
                    max-height: 80vh;
                    overflow-y: auto;
                }
                .modal-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 1.5rem;
                    padding-bottom: 1rem;
                    border-bottom: 1px solid #e2e8f0;
                }
                .close-btn {
                    background: none;
                    border: none;
                    font-size: 1.5rem;
                    cursor: pointer;
                    color: #6b7280;
                }
                .form-grid {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 1rem;
                    margin-bottom: 1rem;
                }
                .form-group {
                    display: flex;
                    flex-direction: column;
                    gap: 0.5rem;
                }
                .form-input {
                    padding: 0.75rem;
                    border: 1px solid #e2e8f0;
                    border-radius: 5px;
                    font-size: 0.9rem;
                }
                .btn {
                    padding: 0.75rem 1.5rem;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 0.9rem;
                    font-weight: 500;
                }
                .btn-primary {
                    background: #3b82f6;
                    color: white;
                }
                .btn-secondary {
                    background: #6b7280;
                    color: white;
                }
            </style>

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
    <script src="/js/utils.js"></script>
    <script src="/js/admin-dashboard.js"></script>
    <script src="/js/index.js"></script>
    <script src="/js/logout.js"></script>
    </body>
</html>