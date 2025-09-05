<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Management - HMS Admin</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard-common.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <style>
        .resource-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .resource-section {
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
            background: #3b82f6;
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
        .resource-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .resource-item:last-child {
            border-bottom: none;
        }
        .resource-info {
            flex: 1;
        }
        .resource-label {
            font-weight: 500;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }
        .resource-details {
            font-size: 0.8rem;
            color: #6b7280;
        }
        .resource-status {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .status-available { background: #dcfce7; color: #166534; }
        .status-occupied { background: #fef3c7; color: #92400e; }
        .status-maintenance { background: #fecaca; color: #991b1b; }
        .status-low { background: #fed7cc; color: #c2410c; }
        .status-critical { background: #fecaca; color: #991b1b; }
        .status-good { background: #dcfce7; color: #166534; }
        .progress-bar {
            background: #e2e8f0;
            height: 8px;
            border-radius: 4px;
            margin: 0.5rem 0;
        }
        .progress-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
        }
        .progress-high { background: #22c55e; }
        .progress-medium { background: #f59e0b; }
        .progress-low { background: #ef4444; }
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
        .bed-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
            gap: 0.5rem;
            margin-top: 1rem;
        }
        .bed-item {
            aspect-ratio: 1;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .bed-available {
            background: #dcfce7;
            color: #166534;
            border: 2px solid #22c55e;
        }
        .bed-occupied {
            background: #fef3c7;
            color: #92400e;
            border: 2px solid #f59e0b;
        }
        .bed-maintenance {
            background: #fecaca;
            color: #991b1b;
            border: 2px solid #ef4444;
        }
        .bed-item:hover {
            transform: scale(1.05);
        }
        .equipment-list {
            max-height: 300px;
            overflow-y: auto;
        }
        .equipment-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
            font-size: 0.9rem;
        }
        .equipment-item:last-child {
            border-bottom: none;
        }
        .equipment-icon {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
        }
        .inventory-alert {
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
                        <a href="<?= base_url('') ?>" class="nav-link active">
                            <i class="fas fa-hospital nav-icon"></i>
                             Resource Management
                        </a>
                    </li>
                     <li class="nav-item">
                        <a href="<?= base_url('') ?>" class="nav-link">
                            <i class="fas fa-dollar-sign nav-icon"></i>
                            Financial Management
                        </a>
                        <li class="nav-item">
                        <a href="<?= base_url('') ?>" class="nav-link">
                            <i class="fas fa-user-injured nav-icon"></i>
                            Patient Management
                        </a>
                        
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('') ?>" class="nav-link">
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
                        <a href="<?= base_url('admin/audit-logs') ?>" class="nav-link">
                            <i class="fas fa-clipboard-list nav-icon"></i>
                            Audit Logs
                        </a>
                    </li>
                </ul>         
            </nav> 
            
            <main class="content">
                <h1 class="page-title"> Hospital Resource Management</h1>
                
              <!--Dashboard overview cards-->
            <div class="dashboard-overview">
                <!-- Bed Occupation Cards -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern blue">
                            <i class="fas fa-bed"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Bed Occopuation </h3>
                            <p class="card-subtitle">Current  bed utilization</p>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value blue">87%</div>
                        </div>
                    </div>
                </div>

                <!-- Active User Card -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Equipment Status</h3>
                            <p class="card-subtitle">Operational equipment</p>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value purple">94%</div>
                        </div>
                    </div>   
                </div>

                <!--Inventroy Card -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-user-times"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Inventroy Alerts</h3>
                            <p class="card-subtitle">Low stock Items</p>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value purple">12</div>
                        </div>
                    </div>
                </div>
                <!--Departments Card-->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Departments</h3>
                            <p class="card-subtitle">Active administrators</p>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value purple"></div>
                        </div>
                    </div>
                </div>
            </div>
                
                <!--Quick Actions-->
                <div class="quick-actions">
                    <h3 style="margin-bottom: 1rem;">Quick Actions</h3>
                    <div class="action grid">
                        <button class="btn btn-primary" onclick="addNewBed()">
                            <i class="fas fa-plus"></i> Add Bed
                        </button>
                        <button class="btn btn-success" onclick="addEquipment()">
                            <i class="fas fa-plus"></i>  Add Equipment
                        </button>
                        <button class="btn btn-warning" onclick="scheduleMaintenance()">
                            <i class="fas fa-plus"></i>  Schedule Maintenance 
                        </button>
                        <button class="btn btn-secondary" onclick="generateInventory()">
                            <i class="fas fa-plus"></i> Inventroy Report 
                        </button>
                        <button class="btn btn-info" onclick="requestSupplies()">
                            <i class="fas fa-plus"></i> Request Supplies  
                        </button>
                        <button class="btn btn-primary" onclick="manageDepartments()">
                            <i class="fas fa-plus"></i> Manage Departments  
                        </button>
                    </div>
                    </div>

                    <div class="resource-grid">
                        <!--Bed Management-->
                        <div class="resource-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-bed"></i>
                            </div>
                            <div>
                                <div class="section-title">Bed Management</div>
                            </div>
                        </div>

                        <div class="resource-item">
                            <div class="resource-info">
                                <div class="resource-label">ICU Beds</div>
                                <div class="resource-details">Critical care unit - 20 total beds</div>
                            </div>
                            <div class="resource-status status-occupied">0/20 Occupied</div>
                        </div>

                        <div class="resource-item">
                            <div class="resource-info">
                                <div class="resource-label">General Ward</div>
                                <div class="resource-details">General patient care - 50 total beds</div>
                            </div>
                            <div class="resource-status status-available">0/50 Occupied</div>
                        </div>

                        <div class="resource-item">
                            <div class="resource-info">
                                <div class="resource-label">Emergency Beds</div>
                                <div class="resource-details">Emergency department - 15 total beds</div>
                            </div>
                            <div class="resource-status status-occupied">0/15 Occupied</div>
                        </div>

                        <div class="action-buttons">
                            <button class="btn btn-primary btn-small" onclick="manageBeds()">
                                <i class="fas fa-cog"></i> Manage Beds
                            </button>
                            <button class="btn btn-secondary btn-small" onclick="bedAssignments()">
                                <i class="fas fa-user-plus"></i> Assignments
                            </button>
                        </div>
                        </div>

                        <!--Equipment Management-->
                        <div class="resource-section">
                        <div class="section-header">
                            <div class="section-icon" style="background: #22c55e;">
                                <i class="fas fa-stethoscope"></i>
                            </div>
                            <div>
                                <div class="section-title">Medical Equipment</div>
                            </div>
                        </div>

                        <div class="equipment-list">
                            <div class="equipment-item">
                                <div class="equipment-icon">
                                    <i class="fas fa-heartbeat"></i>
                                </div>
                                <div class="resource-info">
                                    <div class="resource-label">Ventilators</div>
                                    <div class="resource-details">15 units - 12 operational</div>
                                </div>
                                <div class="resource-status status-good">Operational</div>
                            </div>
                            <div class="equipment-item">
                                <div class="equipment-icon">
                                    <i class="fas fa-x-ray"></i>
                                </div>
                                <div class="resource-info">
                                    <div class="resource-label">X-Ray Machines</div>
                                    <div class="resource-details">3 units - 2 operational</div>
                                </div>
                                <div class="resource-status status-maintenance">1 Maintenance</div>
                            </div>
                            <div class="equipment-item">
                                <div class="equipment-icon">
                                    <i class="fas fa-microscope"></i>
                                </div>
                                <div class="resource-info">
                                    <div class="resource-label">Lab Equipment</div>
                                    <div class="resource-details">25 units - 23 operational</div>
                                </div>
                                <div class="resource-status status-good">Operational</div>
                            </div>
                            <div class="equipment-item">
                                <div class="equipment-icon">
                                    <i class="fas fa-ambulance"></i>
                                </div>
                                <div class="resource-info">
                                    <div class="resource-label">Ambulances</div>
                                    <div class="resource-details">8 units - 6 available</div>
                                </div>
                                <div class="resource-status status-available">Available</div>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <button class="btn btn-primary btn-small" onclick="manageEquipment()">
                                <i class="fas fa-tools"></i> Manage Equipment
                            </button>
                            <button class="btn btn-warning btn-small" onclick="scheduleMaintenace()">
                                <i class="fas fa-wrench"></i> Maintenance
                            </button>
                        </div>
                        </div>

                        <!--Inventory Management-->
                        <div class="resource-section">
                        <div class="section-header">
                            <div class="section-icon" style="background: #f59e0b;">
                                <i class="fas fa-boxes"></i>
                            </div>
                            <div>
                                <div class="section-title">Inventory Status</div>
                            </div>
                        </div>

                        <div class="resource-item">
                            <div class="resource-info">
                                <div class="resource-label">Surgical Supplies</div>
                                <div class="resource-details">Masks, gloves, gowns</div>
                                <div class="progress-bar">
                                    <div class="progress-fill progress-low" style="width: 15%;"></div>
                                </div>
                            </div>
                            <div class="resource-status status-critical">Critical</div>
                        </div>

                        <div class="resource-item">
                            <div class="resource-info">
                                <div class="resource-label">Medications</div>
                                <div class="resource-details">General pharmaceuticals</div>
                                <div class="progress-bar">
                                    <div class="progress-fill progress-medium" style="width: 65%;"></div>
                                </div>
                            </div>
                            <div class="resource-status status-good">Good</div>
                        </div>

                        <div class="resource-item">
                            <div class="resource-info">
                                <div class="resource-label">Blood Bank</div>
                                <div class="resource-details">All blood types</div>
                                <div class="progress-bar">
                                    <div class="progress-fill progress-medium" style="width: 45%;"></div>
                                </div>
                            </div>
                            <div class="resource-status status-low">Low Stock</div>
                        </div>

                        <div class="resource-item">
                            <div class="resource-info">
                                <div class="resource-label">Oxygen Supply</div>
                                <div class="resource-details">Oxygen tanks and concentrators</div>
                                <div class="progress-bar">
                                    <div class="progress-fill progress-high" style="width: 85%;"></div>
                                </div>
                            </div>
                            <div class="resource-status status-good">Good</div>
                        </div>

                        <div class="action-buttons">
                            <button class="btn btn-primary btn-small" onclick="manageInventory()">
                                <i class="fas fa-warehouse"></i> Manage Inventory
                            </button>
                            <button class="btn btn-success btn-small" onclick="orderSupplies()">
                                <i class="fas fa-shopping-cart"></i> Order Supplies
                            </button>
                        </div>
                        </div>

                        <!--Inventory Management-->
                        <div class="resource-section">
                        <div class="section-header">
                            <div class="section-icon" style="background: #8b5cf6;">
                                <i class="fas fa-building"></i>
                            </div>
                            <div>
                                <div class="section-title">Department Overview</div>
                            </div>
                        </div>

                        <div class="resource-item">
                            <div class="resource-info">
                                <div class="resource-label">Emergency Department</div>
                                <div class="resource-details">24/7 emergency care - 25 staff</div>
                            </div>
                            <div class="resource-status status-good">Active</div>
                        </div>

                        <div class="resource-item">
                            <div class="resource-info">
                                <div class="resource-label">Cardiology</div>
                                <div class="resource-details">Heart care specialists - 12 staff</div>
                            </div>
                            <div class="resource-status status-good">Active</div>
                        </div>

                        <div class="resource-item">
                            <div class="resource-info">
                                <div class="resource-label">Laboratory</div>
                                <div class="resource-details">Diagnostic testing - 18 staff</div>
                            </div>
                            <div class="resource-status status-good">Active</div>
                        </div>

                        <div class="resource-item">
                            <div class="resource-info">
                                <div class="resource-label">Pharmacy</div>
                                <div class="resource-details">Medication dispensing - 8 staff</div>
                            </div>
                            <div class="resource-status status-good">Active</div>
                        </div>

                        <div class="action-buttons">
                            <button class="btn btn-primary btn-small" onclick="manageDepartments()">
                                <i class="fas fa-cog"></i> Manage Departments
                            </button>
                            <button class="btn btn-secondary btn-small" onclick="departmentReports()">
                                <i class="fas fa-chart-bar"></i> Reports
                            </button>
                        </div>
                        </div>
                    </div>
            </main>
        </div>

        <script>
        function addNewBed() {
            alert('Opening bed registration form...');
        }

        function addEquipment() {
            alert('Opening equipment registration form...');
        }

        function scheduleMaintenace() {
            alert('Opening maintenance scheduler...');
        }

        function generateInventoryReport() {
            alert('Generating inventory report...');
        }

        function requestSupplies() {
            alert('Opening supply request form...');
        }

        function manageDepartments() {
            alert('Opening department management...');
        }

        function manageBeds() {
            alert('Opening bed management interface...');
        }

        function bedAssignments() {
            alert('Opening bed assignment interface...');
        }

        function manageEquipment() {
            alert('Opening equipment management...');
        }

        function manageInventory() {
            alert('Opening inventory management...');
        }

        function orderSupplies() {
            alert('Opening supply ordering system...');
        }

        function departmentReports() {
            alert('Opening department reports...');
        }

        // Auto-refresh resource data every 2 minutes
        setInterval(() => {
            console.log('Auto-refreshing resource data...');
        }, 120000);

        // Logout functionality
        document.querySelector('.logout-btn').addEventListener('click', function() {
            if(confirm('Are you sure you want to logout?')) {
                window.location.href = 'auth/login.php';
            }
        });
        </script>
    </body>
</html>
