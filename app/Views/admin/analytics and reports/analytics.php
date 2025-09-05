<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics & Reports Management - HMS Admin</title>
    <link rel="stylesheet" href="/assets/css/dashboard-common.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .chart-container.full-width {
            grid-column: 1 / -1;
            margin-bottom: 1.5rem;
        }
        .charts-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .chart-container {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .chart-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2937;
        }
        .chart-period {
            font-size: 0.8rem;
            color: #6b7280;
            background: #f3f4f6;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
        }
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .kpi-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
            border-left: 4px solid #3b82f6;
        }
        .kpi-value {
            font-size: 2rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        .kpi-label {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }
        .kpi-change {
            font-size: 0.8rem;
            font-weight: 500;
        }
        .kpi-positive { color: #22c55e; }
        .kpi-negative { color: #ef4444; }
        .report-filters {
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
        .report-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }
        .data-table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .table-header {
            background: #f8fafc;
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .metric-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
        }
        .metric-card.revenue {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .metric-card.patients {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .metric-card.efficiency {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
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
                        <a href="<?= base_url('') ?>" class="nav-link">
                            <i class="fas fa-user-tie nav-icon"></i>
                            Staff Management
                        </a>
                     <li class="nav-item">
                        <a href="<?= base_url('admin/resource_management') ?>" class="nav-link">
                            <i class="fas fa-hospital nav-icon"></i>
                             Resource Management
                        </a>
                    </li>
                     <li class="nav-item">
                        <a href="<?= base_url('admin/financial_management') ?>" class="nav-link">
                            <i class="fas fa-dollar-sign nav-icon"></i>
                            Financial Management
                        </a>
                        <li class="nav-item">
                        <a href="<?= base_url('admin/patient_management') ?>" class="nav-link">
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
                        <a href="<?= base_url('admin/analytics') ?>" class="nav-link active">
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
                        <a href="<?= base_url('admin/security_access') ?>" class="nav-link">
                            <i class="fas fa-shield-alt nav-icon"></i>
                            Security & Access
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/audit_logs') ?>" class="nav-link">
                            <i class="fas fa-clipboard-list nav-icon"></i>
                            Audit Logs
                        </a>
                    </li>
                   

                </ul>
            
            </nav>
       
        <!--Main Content-->
        <main class="content">
            <h1 class="page-title"> Analytics & Reports</h1>
        
            <!--Overview Cards-->
            <div class="dashboard-overview">
                <!-- Total User Cards -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern blue">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Total Patients</h3>                         
                        </div>
                    </div>  
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value blue">1452</div>
                        </div>
                    </div>
                </div>

                <!-- Today's Appointment Card -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Today's Appointments</h3>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value purple">350</div>
                        </div>
                    </div>   
                </div>

                <!-- Monthly Revenue Card -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Monthly Revenue</h3>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value purple">$45,678</div>
                        </div>
                    </div>
                </div>

                <!--Active Staff Card-->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Active Staff</h3>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value purple">156</div>
                        </div>
                    </div>
                </div>

                <!--Bed Occupation Card-->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Bed Occupation</h3>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value purple">87%</div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Report Filters-->    
           <div class="report-filters">
                <h3 style="margin-bottom: 1rem;">Report Filters</h3>
                <div class="filter-row">
                    <div class="filter-group">
                        <label>Date Range</label>
                        <select clsas="filter-input" id="dateRange">
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month" selected>This Month</option>
                            <option value="quarter">This Quarter</option>
                            <option value="year">This Year</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Department</label>
                        <select class="filter-input" id="department">
                            <option value="">All Department</option>
                            <option value="emergency">Emergency</option>
                            <option value="cardiology">Cardiology</option>
                            <option value="laboratory">Laboratory</option>
                            <option value="pharmacy">Pharmacy</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Report Type</label>
                        <select class="filter-input" id="reportType">
                            <option value="overview">Overview</option>
                            <option value="financial">Financial</option>
                            <option value="operational">Operational</option>
                            <option value="clinical">Clinical</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>&nbsp;</label>
                        <button class="btn btn-primary" onclick="applyFilters()">
                            <i class="fas fa-filter"></i> Apply Filters
                        </button>
                    </div>
                </div>  
                <div class="report-actions">
                    <button class="btn btn-success" onclick="exportReport('pdf')">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                    <button class="btn btn-secondary" onclick="exportReport('excel')">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                    <button class="btn btn-warning" onclick="scheduleReport()">
                        <i class="fas fa-clock"></i> Schedule Report
                    </button>
                    <button class="btn btn-info" onclick="shareReport()">
                        <i class="fas fa-share"></i> Share Report
                    </button>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="analytics-grid">
                <!-- Patient Flow Chart -->
                <div class="chart-container full-width">
                    <div class="chart-header">
                        <div class="chart-title">Patient Flow Trends</div>
                        <div class="chart-period">Last 30 Days</div>
                    </div>
                    
                </div>

                <!-- Revenue Chart -->
                <div class="chart-container">
                    <div class="chart-header">
                        <div class="chart-title">Monthly Revenue</div>
                        <div class="chart-period">This Year</div>
                    </div>
                   
                </div>

                <!-- Department Performance -->
                <div class="chart-container">
                    <div class="chart-header">
                        <div class="chart-title">Department Performance</div>
                        <div class="chart-period">This Month</div>
                    </div>
                    <canvas id="departmentChart" width="400" height="300"></canvas>
                </div>

                <!-- Bed Occupancy -->
                <div class="chart-container">
                    <div class="chart-header">
                        <div class="chart-title">Bed Occupancy Rate</div>
                        <div class="chart-period">Real-time</div>
                    </div>
                    <canvas id="occupancyChart" width="400" height="300"></canvas>
                </div>

                <!-- Staff Utilization -->
                <div class="chart-container">
                    <div class="chart-header">
                        <div class="chart-title">Staff Utilization</div>
                        <div class="chart-period">This Week</div>
                    </div>
                    <canvas id="staffChart" width="400" height="300"></canvas>
                </div>
            </div>

            <!--Detailed Report Table-->
            <div class="data-table-contianer">
                <div class="table-contianer">
                    <h3>Performance Reports</h3>
                    <button class="btn btn-secondary" onclick="refreshReports()">
                        <i class="fas fa-refresh"></i> Refresh
                    </button>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Metrics</th>
                            <th>Current Value</th>
                            <th>Previous period</th>
                            <th>Change</th>
                            <th>Target</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Average Wait Time</td>
                            <td>23 minutes</td>
                            <td>28 minutes</td>
                            <td class="kpi-positive">-18%</td>
                            <td>20 minutes</td>
                            <td><span class="badge badge-warning">Near Target</span></td>
                        </tr>
                        <tr>
                            <td>Patient Satisfaction</td>
                            <td>94.5%</td>
                            <td>96.2%</td>
                            <td class="kpi-negative">-1.7%</td>
                            <td>95%</td>
                            <td><span class="badge badge-success">On Target</span></td>
                        </tr>
                        <tr>
                            <td>Readmission Rate</td>
                            <td>8.2%</td>
                            <td>9.1%</td>
                            <td class="kpi-positive">-9.9%</td>
                            <td>8%</td>
                            <td><span class="badge badge-warning">Near Target</span></td>
                        </tr>
                        <tr>
                            <td>Staff Overtime</td>
                            <td>12.5%</td>
                            <td>15.3%</td>
                            <td class="kpi-positive">-18%</td>
                            <td>10%</td>
                            <td><span class="badge badge-warning">Above Target</span></td>
                        </tr>
                        <tr>
                            <td>Equipment Utilization</td>
                            <td>78%</td>
                            <td>72%</td>
                            <td class="kpi-positive">+8.3%</td>
                            <td>75%</td>
                            <td><span class="badge badge-success">Above Target</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script src="/js/analytics.js"></script>
    <script src="/js/logout.js"></script>
</body>
</html>