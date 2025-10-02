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
            width: 100px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        .permission-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
        }
        .permission-icon {
            font-size: 2rem;
           text-align: center;
            color: #3b82f6;
            margin-bottom: 0.5rem;
        }
        .permission-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-align: center;
        }
        .permission-count {
            font-size: 1.5rem;
            text-align: center;
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
        <!--header-->
        <?= view('admin/components/header', ['currentUser' => $currentUser ?? null]) ?>

        <!--Main Content-->
        <div class="main-container">

            <main class="content">
            <h1 class="page-title"> Security Access</h1>
            <!--sidebar-->
            <?= view('admin/components/sidebar') ?>
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
                     <div class="stat-number" style="font-size: 2rem; font-weight: bold; color: #22c55e; text-align: center; padding: 1rem;">0%</div>
                    
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
                    <div class="stat-number" style="font-size: 2rem; font-weight: bold; color: #2266c5; text-align: center; padding: 1rem;">0</div>
                     
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
                    <div class="stat-number" style="font-size: 2rem; font-weight: bold; color: #c52222; text-align: center; padding: 1rem;">0</div>
                    
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
                    <div class="stat-number" style="font-size: 2rem; font-weight: bold; color: #cf7214; text-align: center; padding: 1rem;">0</div>
                </div>
            </div>

        </main>
        </div>
    <script src="/js/logout.js"></script>
</body>
</html>
