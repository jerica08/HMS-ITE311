<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Management - HMS Admin</title>
    <link rel="stylesheet" href="/assets/css/dashboard-common.css">
    <link rel="stylesheet" href="/assets/css/users.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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
                        <a href="<?= base_url('') ?>" class="nav-link">
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
                        <a href="<?= base_url('') ?>" class="nav-link active">
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
       
        <!--Main Content-->
        <main class="content">
            <h1 class="page-title"> Patient Management</h1>

            <!--Dashboard overview cards-->
            <div class="dashboard-overview">
                <!-- Total User Cards -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern blue">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Total Patient</h3>
                            <p class="card-subtitle">All Registered Users</p>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value blue">10,986</div>
                        </div>
                    </div>
                </div>

                <!-- Active User Card -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-bed"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Admitted Patient</h3>
                            <p class="card-subtitle">Currently active</p>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value purple">634</div>
                        </div>
                    </div>   
                </div>

                <!-- Inactive User Card -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Critical Patient</h3>
                            <p class="card-subtitle">Requiring urgent care</p>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value purple">531</div>
                        </div>
                    </div>
                </div>
                <!--Admin Users Card-->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">New Admissions</h3>
                            <p class="card-subtitle">Today</p>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value purple">562</div>
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
            <!--Filter and Actions-->    
            <div class="search-filter">
                <h3 style="margin-bottom: 1rem;">Patient Search & Filters</h3>
                <div class="filter-row">
                    <div class="filter-group">
                        <label> Search Patient</label>
                        <input type="text" class="filter-input" placeholder="Search by name, email, or ID..." 
                            id="searchInput" value="">
                    </div>
                    <div class="filter-group">
                        <label>Status Filter</label>
                        <select class="filter-input" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="admitted">Admitted</option>
                            <option value="discharged">Dishcarge</option>
                            <option value="critical">Critical</option>
                            <option value="emergency">Emergency</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label> Role Filter</label>
                        <select class="filter-input" id="roleFilter">
                            <option value="">All Roles</option>
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
                    <div class="filter-group">
                        <label>Department</label>
                        <select class="filter-input" id="departmentFilter">
                            <option value="">All Departments</option>
                            <option value="emergency">Emergency</option>
                            <option value="icu">ICU</option>
                            <option value="cardiology">Cardiology</option>
                            <option value="general">General Ward</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Date Range</label>
                        <select class="filter-input" id="dateFilter">
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>&nbsp;</label>
                        <button class="btn btn-primary" onclick="applyFilters()">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>     
                </div>          
            </div>


        </main>
        </div>
</body>
</html>