<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Management - HMS Admin</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard-common.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .financial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .financial-section {
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
            background: #22c55e;
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
        .financial-metric {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .financial-metric:last-child {
            border-bottom: none;
        }
        .metric-info {
            flex: 1;
        }
        .metric-label {
            font-weight: 500;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }
        .metric-details {
            font-size: 0.8rem;
            color: #6b7280;
        }
        .metric-value {
            font-weight: bold;
            font-size: 1.1rem;
        }
        .value-positive { color: #22c55e; }
        .value-negative { color: #ef4444; }
        .value-neutral { color: #3b82f6; }
        .revenue-chart {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .chart-container {
            position: relative;
            height: 300px;
            margin-top: 1rem;
        }
        .billing-table {
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
        .payment-status {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .status-paid { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-overdue { background: #fecaca; color: #991b1b; }
        .status-partial { background: #dbeafe; color: #1e40af; }
        .budget-progress {
            margin: 1rem 0;
        }
        .progress-bar {
            background: #e2e8f0;
            height: 12px;
            border-radius: 6px;
            overflow: hidden;
            margin: 0.5rem 0;
        }
        .progress-fill {
            height: 100%;
            transition: width 0.3s ease;
        }
        .progress-under { background: #22c55e; }
        .progress-near { background: #f59e0b; }
        .progress-over { background: #ef4444; }
        .financial-alert {
            background: #fef3c7;
            border: 1px solid #fbbf24;
            border-left: 4px solid #f59e0b;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .alert-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: #92400e;
            margin-bottom: 0.5rem;
        }
        .alert-content {
            color: #78350f;
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
        .insurance-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
            font-size: 0.9rem;
        }
        .insurance-item:last-child {
            border-bottom: none;
        }
        .insurance-logo {
            width: 30px;
            height: 30px;
            border-radius: 4px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }
        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-number {
            font-size: 1.8rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }
        .stat-change {
            font-size: 0.8rem;
            font-weight: 500;
        }
        .change-positive { color: #22c55e; }
        .change-negative { color: #ef4444; }
    </style>
</head>
<body class="admin-theme">
    <header class="header">
        <div class="header-content">
            <div class="logo">
                <h1><i class="fas fa-hospital"></i> HMS - Financial Management</h1>
            </div>
            <div class="user-info">
                <div class="user-avatar">AD</div>
                <div>
                    <div style="font-weight: 600;">
                        <?= \App\Helpers\UserHelper::getDisplayName($currentUser ?? null) ?>
                    </div>
                    <div style="font-size: 0.9rem; opacity: 0.8;">
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
                      <a href="<?= base_url('admin/financial') ?>" class="nav-link active">
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
                      <a href="<?= base_url('admin/securityAccess') ?>" class="nav-link">
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
            <h1 class="page-title">Financial Management</h1>

            <!--Financial Stats -->
            <div class="quick-stats">
                <div class="stat-card revenue">
                    <div class="stat-number" style="color: #28aa61;">₱0</div>
                    <div class="stat-label">Monthly Revenue</div>
                    <div class="stat-change change-positive">
                        <i class="fas fa-arrow-up"></i> +12% from last month
                    </div>
                </div>
                <div class="stat-card expenses">
                    <div class="stat-number" style="color: #ddd314;">₱0</div>
                    <div class="stat-label">Monthly Expenses</div>
                    <div class="stat-change change-positive">
                        <i class="fas fa-arrow-down"></i> -5% from last month
                    </div>
                </div>
                <div class="stat-card profit">
                    <div class="stat-number" style="color: #2c28aa;">₱0</div>
                    <div class="stat-label">Net Profit</div>
                    <div class="stat-change change-positive">
                        <i class="fas fa-arrow-up"></i> +25% from last month
                    </div>
                </div>
                <div class="stat-card outstanding">
                    <div class="stat-number" style="color: #f37126;">₱0</div>
                    <div class="stat-label">Outstanding Bills</div>
                    <div class="stat-change change-negative">
                        <i class="fas fa-arrow-up"></i> +8% from last month
                    </div>
                </div>
            </div>
            <div class="financial-grid">
                
                <!-- Billing Overview -->
                <div class="financial-section">
                    <div class="section-header">
                        <div class="section-icon" style="background: #3b82f6;">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <div>
                            <div class="section-title">Billing Overview</div>
                        </div>
                    </div>

                    <div class="financial-metric">
                        <div class="metric-info">
                            <div class="metric-label">Total Invoices</div>
                            <div class="metric-details">This month</div>
                        </div>
                        <div class="metric-value value-neutral">1,247</div>
                    </div>

                    <div class="financial-metric">
                        <div class="metric-info">
                            <div class="metric-label">Paid Invoices</div>
                            <div class="metric-details">₱1,890,000</div>
                        </div>
                        <div class="metric-value value-positive">892</div>
                    </div>

                    <div class="financial-metric">
                        <div class="metric-info">
                            <div class="metric-label">Pending Payments</div>
                            <div class="metric-details">₱340,000</div>
                        </div>
                        <div class="metric-value value-negative">245</div>
                    </div>

                    <div class="financial-metric">
                        <div class="metric-info">
                            <div class="metric-label">Overdue Payments</div>
                            <div class="metric-details">₱85,000</div>
                        </div>
                        <div class="metric-value value-negative">110</div>
                    </div>

                    <div class="action-buttons">
                        <button class="btn btn-primary btn-small" onclick="manageBilling()">
                            <i class="fas fa-file-invoice"></i> Manage Billing
                        </button>
                        <button class="btn btn-warning btn-small" onclick="sendReminders()">
                            <i class="fas fa-bell"></i> Send Reminders
                        </button>
                    </div>
                </div>

                <!-- Insurance Management -->
                <div class="financial-section">
                    <div class="section-header">
                        <div class="section-icon" style="background: #8b5cf6;">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <div class="section-title">Insurance Providers</div>
                        </div>
                    </div>

                    <div class="insurance-item">
                        <div style="display: flex; align-items: center;">
                            <div class="insurance-logo">
                                <i class="fas fa-building"></i>
                            </div>
                            <div>
                                <div class="metric-label">Blue Cross Blue Shield</div>
                                <div class="metric-details">1,245 active patients</div>
                            </div>
                        </div>
                        <div class="payment-status status-paid">Active</div>
                    </div>

                    <div class="insurance-item">
                        <div style="display: flex; align-items: center;">
                            <div class="insurance-logo">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div>
                                <div class="metric-label">Aetna</div>
                                <div class="metric-details">892 active patients</div>
                            </div>
                        </div>
                        <div class="payment-status status-paid">Active</div>
                    </div>

                    <div class="insurance-item">
                        <div style="display: flex; align-items: center;">
                            <div class="insurance-logo">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div>
                                <div class="metric-label">Medicare</div>
                                <div class="metric-details">567 active patients</div>
                            </div>
                        </div>
                        <div class="payment-status status-pending">Pending</div>
                    </div>

                    <div class="action-buttons">
                        <button class="btn btn-primary btn-small" onclick="manageInsurance()">
                            <i class="fas fa-cog"></i> Manage Providers
                        </button>
                        <button class="btn btn-secondary btn-small" onclick="claimReports()">
                            <i class="fas fa-file-medical"></i> Claim Reports
                        </button>
                    </div>
                </div>

                <!-- Revenue Analysis -->
                <div class="financial-section">
                    <div class="section-header">
                        <div class="section-icon" style="background: #f59e0b;">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div>
                            <div class="section-title">Revenue Sources</div>
                        </div>
                    </div>

                    <div class="financial-metric">
                        <div class="metric-info">
                            <div class="metric-label">Patient Services</div>
                            <div class="metric-details">Consultations, procedures</div>
                        </div>
                        <div class="metric-value value-positive">₱1.2M (50%)</div>
                    </div>

                    <div class="financial-metric">
                        <div class="metric-info">
                            <div class="metric-label">Emergency Services</div>
                            <div class="metric-details">Emergency department</div>
                        </div>
                        <div class="metric-value value-positive">₱720K (30%)</div>
                    </div>

                    <div class="financial-metric">
                        <div class="metric-info">
                            <div class="metric-label">Laboratory Services</div>
                            <div class="metric-details">Tests and diagnostics</div>
                        </div>
                        <div class="metric-value value-positive">₱288K (12%)</div>
                    </div>

                    <div class="financial-metric">
                        <div class="metric-info">
                            <div class="metric-label">Pharmacy</div>
                            <div class="metric-details">Medication sales</div>
                        </div>
                        <div class="metric-value value-positive">₱192K (8%)</div>
                    </div>

                    <div class="action-buttons">
                        <button class="btn btn-primary btn-small" onclick="revenueAnalysis()">
                            <i class="fas fa-chart-line"></i> Detailed Analysis
                        </button>
                        <button class="btn btn-secondary btn-small" onclick="exportFinancialReport()">
                            <i class="fas fa-download"></i> Export Report
                        </button>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="billing-table">
                <div class="table-header">
                    <h3>Recent Financial Transactions</h3>
                    <div style="display: flex; gap: 0.5rem;">
                        <button class="btn btn-secondary btn-small" onclick="refreshTransactions()">
                            <i class="fas fa-refresh"></i> Refresh
                        </button>
                        <button class="btn btn-primary btn-small" onclick="addTransaction()">
                            <i class="fas fa-plus"></i> Add Transaction
                        </button>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Patient/Vendor</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Dec 23, 2024</td>
                            <td>Floro Gagni</td>
                            <td>Emergency Room Visit</td>
                            <td>₱2,450.00</td>
                            <td><span class="payment-status status-paid">Paid</span></td>
                            <td><button class="btn btn-secondary btn-small">View</button></td>
                        </tr>                     
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        // Initialize revenue chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Revenue',
                        data: [2100000, 2250000, 2180000, 2350000, 2280000, 2420000, 2380000, 2450000, 2320000, 2480000, 2350000, 2400000],
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Expenses',
                        data: [1800000, 1850000, 1780000, 1920000, 1850000, 1900000, 1880000, 1820000, 1790000, 1850000, 1800000, 1800000],
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            ticks: {
                                callback: function(value) {
                                    return '$' + (value / 1000000).toFixed(1) + 'M';
                                }
                            }
                        }
                    }
                }
            });
        });

        function manageBudgets() {
            alert('Opening budget management interface...');
        }

        function budgetReports() {
            alert('Generating budget reports...');
        }

        function manageBilling() {
            alert('Opening billing management system...');
        }

        function sendReminders() {
            alert('Sending payment reminders...');
        }

        function manageInsurance() {
            alert('Opening insurance provider management...');
        }

        function claimReports() {
            alert('Generating insurance claim reports...');
        }

        function revenueAnalysis() {
            alert('Opening detailed revenue analysis...');
        }

        function exportFinancialReport() {
            alert('Exporting financial report...');
        }

        function refreshTransactions() {
            alert('Refreshing transaction list...');
        }

        function addTransaction() {
            alert('Opening new transaction form...');
        }

        // Auto-refresh financial data every 5 minutes
        setInterval(() => {
            console.log('Auto-refreshing financial data...');
        }, 300000);

    </script>
    <script src="/js/logout.js"></script>
</body>
</html>
