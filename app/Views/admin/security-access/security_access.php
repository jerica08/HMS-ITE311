<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Access - HMS Admin</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard-common.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <style>
        .security-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .security-section {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
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
            background: #dc2626;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2937;
        }
        .security-metric {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .security-metric:last-child {
            border-bottom: none;
        }
        .metric-label {
            font-weight: 500;
            color: #1f2937;
        }
        .metric-value {
            font-weight: bold;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.9rem;
        }
        .metric-good { background: #dcfce7; color: #166534; }
        .metric-warning { background: #fef3c7; color: #92400e; }
        .metric-danger { background: #fecaca; color: #991b1b; }
        .access-table {
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
        .permission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        .permission-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
        }
        .permission-icon {
            font-size: 2rem;
            color: #3b82f6;
            margin-bottom: 0.5rem;
        }
        .permission-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .permission-count {
            font-size: 1.5rem;
            font-weight: bold;
            color: #1f2937;
        }
        .security-alert {
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
        .login-attempt {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
            font-size: 0.9rem;
        }
        .login-attempt:last-child {
            border-bottom: none;
        }
        .attempt-status {
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .status-success { background: #dcfce7; color: #166534; }
        .status-failed { background: #fecaca; color: #991b1b; }
        .status-blocked { background: #fed7cc; color: #c2410c; }
        .ip-address {
            font-family: monospace;
            background: #f3f4f6;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body class="admin">

    <header class="header">
        <div class="header-content">
            <div class="logo">
                <h1><i class="fas fa-hospital"></i> Administrator</h1>                    
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
                      <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">
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
                  </li>
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
                  </li>
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
                  </li>
                  <li class="nav-item">
                      <a href="<?= base_url('admin/analytics') ?>" class="nav-link">
                          <i class="fas fa-chart-bar nav-icon"></i>
                          Analytics & Reports
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="<?= base_url('admin/systemSettings') ?>" class="nav-link">
                          <i class="fas fa-cogs nav-icon"></i>
                          System Settings
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="<?= base_url('admin/securityAccess') ?>" class="nav-link active">
                          <i class="fas fa-shield-alt nav-icon"></i>
                          Security & Access
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="<?= base_url('admin/auditLogs') ?>" class="nav-link">
                          <i class="fas fa-clipboard-list nav-icon"></i>
                          Audit Logs
                      </a>
                  </li>
              </ul>          
          </nav>

            <main class="content">
            <h1 class="page-title"> Security Access</h1>

            <!--Dashboard overview cards-->
            <div class="dashboard-overview">
                <!-- Security Score Cards -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern blue">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Security Score</h3>
                            <p class="card-subtitle">Overall system security</p>
                        </div>
                    </div>
                     <div class="stat-number" style="font-size: 2rem; font-weight: bold; color: #22c55e; text-align: center; padding: 1rem;">98.5%</div>
                    
                </div>

                <!-- Active Session Card -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Active Sessions</h3>
                            <p class="card-subtitle">Currently user sessions</p>
                        </div>
                    </div>
                    <div class="stat-number" style="font-size: 2rem; font-weight: bold; color: #2266c5; text-align: center; padding: 1rem;">156</div>
                     
                </div>

                <!-- Blocked IPs Card -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-user-times"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Blocked IPs</h3>
                            <p class="card-subtitle">Suspicious IPs</p>
                        </div>
                    </div>
                    <div class="stat-number" style="font-size: 2rem; font-weight: bold; color: #c52222; text-align: center; padding: 1rem;">7</div>
                    
                </div>
                <!--2FA-->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">2FA Enabled</h3>
                            <p class="card-subtitle">Users with 2FA</p>
                        </div>
                    </div>
                    <div class="stat-number" style="font-size: 2rem; font-weight: bold; color: #cf7214; text-align: center; padding: 1rem;">89</div>
                </div>
            </div>

            <div class="security-grid">
                <!--Security Metrics-->
                <div class="security-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <div class="section-title">Security Metrics</div>
                        </div>
                    </div>

                    <div class="security-metric">
                        <div class="metric-label">Password Strength</div>
                        <div class="metric-value metric-good">Strong</div>
                    </div>
                     <div class="security-metric">
                        <div class="metric-label">Failed Login Attempts</div>
                        <div class="metric-value metric-good">10</div>
                    </div>
                    <div class="security-metric">
                        <div class="metric-label">Firewall Status</div>
                        <div class="metric-value metric-good">Active</div>
                    </div>
                    <div class="security-metric">
                        <div class="metric-label">Vulnerability Scan</div>
                        <div class="metric-value metric-good">Clean</div>
                    </div>

                    <div class="action-buttons">
                        <button class="btn btn-primary btn-small" onclick="runSecurityScan()">
                            <i class="fs fa-file-alt"></i>Security Scan
                        </button>
                        <button class="btn btn-primary btn-small" onclick="generateSecurityReport()">
                            <i class="fs fa-file-alt"></i>Generate Report
                        </button>
                    </div>
                </div>

                <!--Access Permissions-->
                <div class="security-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-user-lock"></i>
                        </div>
                        <div>
                            <div class="section-title">Access Permissions</div>
                        </div>
                    </div>

                    <div class="permisiion-grid">
                        <div class="permission-card">
                            <div class="permission-icon">
                                <i class="fas fa-user-shiled"></i>
                            </div>
                            <div class="permisiion-title">Admin Access</div>
                            <div class="permission-count">5</div>
                        </div>
                        <div class="permission card">
                            <div class="permission-icon">
                                <i class="fas fa-user-md"></i>
                            </div>
                            <div class="permisiion-title">Medical Staff</div>
                            <div class="permisiion-count">89</div>
                        </div>
                        <div class="permission card">
                            <div class="permission-icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="permisiion-title">Support Staff</div>
                            <div class="permisiion-count">34</div>
                        </div>
                        <div class="permission card">
                            <div class="permission-icon">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <div class="permisiion-title">Temporary Access</div>
                            <div class="permisiion-count">34</div>
                        </div>
                    </div>
        
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-small" onclick="">
                            <i class="fs fa-file-alt"></i>Manage Permission
                        </button>
                        <button class="btn btn-primary btn-small" onclick="">
                            <i class="fs fa-file-alt"></i>Review Access
                        </button>
                    </div>
                </div>

                <!--Login Security-->
                <div class="security-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div>
                            <div class="section-title">Login Security</div>
                        </div>
                    </div>

                    <div class="security-metric">
                        <div class="metric-label">Password Strength</div>
                        <div class="metric-value metric-good">Strong</div>
                    </div>
                     <div class="security-metric">
                        <div class="metric-label">Failed Login Attempts</div>
                        <div class="metric-value metric-good">10</div>
                    </div>
                    <div class="security-metric">
                        <div class="metric-label">Firewall Status</div>
                        <div class="metric-value metric-good">Active</div>
                    </div>
                    <div class="security-metric">
                        <div class="metric-label">Vulnerability Scan</div>
                        <div class="metric-value metric-good">Clean</div>
                    </div>

                    <div class="action-buttons">
                        <button class="btn btn-primary btn-small" onclick="runSecurityScan()">
                            <i class="fs fa-file-alt"></i>Security Scan
                        </button>
                        <button class="btn btn-primary btn-small" onclick="generateSecurityReport()">
                            <i class="fs fa-file-alt"></i>Generate Report
                        </button>
                    </div>
                </div>

                <!--Network Security-->
                <div class="security-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-network-wired"></i>
                        </div>
                        <div>
                            <div class="section-title">Network Security</div>
                        </div>
                    </div>

                    <div class="security-metric">
                        <div class="metric-label">Password Strength</div>
                        <div class="metric-value metric-good">Strong</div>
                    </div>
                     <div class="security-metric">
                        <div class="metric-label">Failed Login Attempts</div>
                        <div class="metric-value metric-good">10</div>
                    </div>
                    <div class="security-metric">
                        <div class="metric-label">Firewall Status</div>
                        <div class="metric-value metric-good">Active</div>
                    </div>
                    <div class="security-metric">
                        <div class="metric-label">Vulnerability Scan</div>
                        <div class="metric-value metric-good">Clean</div>
                    </div>

                    <div class="action-buttons">
                        <button class="btn btn-primary btn-small" onclick="runSecurityScan()">
                            <i class="fs fa-file-alt"></i>Security Scan
                        </button>
                        <button class="btn btn-primary btn-small" onclick="generateSecurityReport()">
                            <i class="fs fa-file-alt"></i>Generate Report
                        </button>
                    </div>
                </div>
            </div>

            <!--Display here the Recent Login Attemps-->
            <div class="access-table">
                <div class="table-header">
                    <h3> Recent Login Attemps</h3>
                    <div style="display:flex;gap:0.5rem;">
                        <button class="btn btn-secondary btn-small" onlcick="refreshLoginAttempts()">
                            <i class="fas fa-refresh"></i> Refresh
                        </button>
                         <button class="btn btn-warning btn-small" onclick="blockSuspiciousIPs()">
                            <i class="fas fa-ban"></i> Block Suspicious
                        </button>
                    </div>
                </div>   
                
                 <div style="max-height: 400px; overflow-y: auto;">
                    <div class="login-attempt">
                        <div>
                            <strong>Dr. John Smith</strong><br>
                            <small>this is an example</small>
                        </div>
                        <div class="ip-address">192.168.1.45</div>
                        <div>2 minutes ago</div>
                        <div class="attempt-status status-success">Success</div>
                    </div>                  
                </div>
            </div>

        </main>
        </div>
    <script src="/js/logout.js"></script>
</body>
</html>
