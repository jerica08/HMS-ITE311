<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management - HMS Admin</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard-common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/users.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .staff-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .staff-section {
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
        .staff-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .staff-item:last-child {
            border-bottom: none;
        }
        .staff-info {
            flex: 1;
        }
        .staff-name {
            font-weight: 500;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }
        .staff-details {
            font-size: 0.8rem;
            color: #6b7280;
        }
        .staff-status {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .status-on-duty { background: #dcfce7; color: #166534; }
        .status-off-duty { background: #f3f4f6; color: #6b7280; }
        .status-break { background: #fef3c7; color: #92400e; }
        .status-leave { background: #fecaca; color: #991b1b; }
        .status-overtime { background: #dbeafe; color: #1e40af; }
        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
            margin-top: 1rem;
        }
        .schedule-day {
            text-align: center;
            padding: 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .day-header {
            background: #f3f4f6;
            color: #6b7280;
            font-weight: 600;
        }
        .day-scheduled {
            background: #dcfce7;
            color: #166534;
        }
        .day-off {
            background: #f3f4f6;
            color: #9ca3af;
        }
        .day-overtime {
            background: #dbeafe;
            color: #1e40af;
        }
        .performance-metric {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .performance-metric:last-child {
            border-bottom: none;
        }
        .metric-label {
            font-weight: 500;
            color: #1f2937;
        }
        .metric-value {
            font-weight: bold;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 2rem;
        }
        .metric-excellent { background: #dcfce7; color: #166534; }
        .metric-good { background: #dbeafe; color: #1e40af; }
        .metric-average { background: #fef3c7; color: #92400e; }
        .metric-poor { background: #fecaca; color: #991b1b; }
        .certification-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            background: #f8fafc;
            border-radius: 6px;
            margin: 0.5rem 0;
            font-size: 0.9rem;
        }
        .cert-status {
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .cert-valid { background: #dcfce7; color: #166534; }
        .cert-expiring { background: #fef3c7; color: #92400e; }
        .cert-expired { background: #fecaca; color: #991b1b; }
        .payroll-summary {
            background: #f8fafc;
            border-radius: 6px;
            padding: 1rem;
            margin: 1rem 0;
        }
        .payroll-item {
            display: flex;
            justify-content: space-between;
            margin: 0.5rem 0;
            font-size: 0.9rem;
        }
        .payroll-total {
            font-weight: bold;
            border-top: 1px solid #e2e8f0;
            padding-top: 0.5rem;
            margin-top: 0.5rem;
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
        .staff-alert {
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
        /* Search filter styles  */
        .search-filter {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
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
            min-width: 180px;
        }
        .filter-input {
            padding: 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            font-size: 0.9rem;
        }
        /* Table styles */
        .staff-table {
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
                <div class="fas fa-user-circle"></div>
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
                      <a href="<?= base_url('admin/staff') ?>" class="nav-link active">
                          <i class="fas fa-user-tie nav-icon"></i>
                          Staff Management
                      </a>
                  </li>
                   <li class="nav-item">
                      <a href="<?= base_url('admin/patient') ?>" class="nav-link">
                          <i class="fas fa-user-injured nav-icon"></i>
                          Patient Management
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
                <h1 class="page-title"> Staff Management</h1>
                <div class="page-actions">
                    <button class="btn btn-success" type="button" id="addStaffBtnTop">
                        <i class="fas fa-plus"></i> Add New Staff
                    </button>
                    <button class="btn btn-primary" type="button" id="assignShiftBtnTop" style="margin-left: .5rem;">
                        <i class="fas fa-calendar-plus"></i> Assign Shift
                    </button>
                    <button class="btn btn-warning" type="button" id="approveLeaveBtnTop" style="margin-left: .5rem;">
                        <i class="fas fa-clipboard-check"></i> Approve Leave
                    </button>
                </div><br>


                <!--Dashboard overview cards-->
                <div class="dashboard-overview">
                    <!-- Total User Cards -->
                    <div class="overview-card">
                        <div class="card-header-modern">
                            <div class="card-icon-modern blue">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-info">
                                <h3 class="card-title-modern">Total Staff</h3>
                                <p class="card-subtitle">Active Employees</p>
                            </div>
                        </div>
                        <div class="card-metrics">
                            <div class="metric">
                                <div class="metric-value blue">0</div>
                            </div>
                        </div>
                    </div>

                    <!-- Active User Card -->
                    <div class="overview-card">
                        <div class="card-header-modern">
                            <div class="card-icon-modern purple">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="card-info">
                                <h3 class="card-title-modern">On Duty</h3>
                                <p class="card-subtitle">Currently working</p>
                            </div>
                        </div>
                        <div class="card-metrics">
                            <div class="metric">
                                <div class="metric-value purple">0</div>
                            </div>
                        </div>   
                    </div>

                    <!-- Inactive User Card -->
                    <div class="overview-card">
                        <div class="card-header-modern">
                            <div class="card-icon-modern purple">
                                <i class="fas fa-user-times"></i>
                            </div>
                            <div class="card-info">
                                <h3 class="card-title-modern">Overtime Hours</h3>
                                <p class="card-subtitle">This week</p>
                            </div>
                        </div>
                        <div class="card-metrics">
                            <div class="metric">
                                <div class="metric-value purple">0</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Staff Filters -->
                <div class="search-filter">
                    <h3 style="margin-bottom: 1rem;">Search Staff</h3>
                    <div class="filter-row">
                        <div class="filter-group">
                            <label>Search</label>
                            <input type="text" class="filter-input" id="searchStaffInput" placeholder="Search by name or contact...">
                        </div>
                        <div class="filter-group">
                            <label>Role</label>
                            <select class="filter-input" id="roleFilter">
                                <option value="">All Roles</option>
                                <option value="Doctor">Doctor</option>
                                <option value="Nurse">Nurse</option>
                                <option value="Pharmacist">Pharmacist</option>
                                <option value="Lab Technician">Lab Technician</option>
                                <option value="Receptionist">Receptionist</option>
                                <option value="Accountant">Accountant</option>
                                <option value="IT Staff">IT Staff</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Department</label>
                            <select class="filter-input" id="departmentFilter">
                                <option value="">All Departments</option>
                                <option value="Cardiology">Cardiology</option>
                                <option value="ICU">ICU</option>
                                <option value="ER">ER</option>
                                <option value="Pharmacy">Pharmacy</option>
                                <option value="Laboratory">Laboratory</option>
                                <option value="Billing">Billing</option>
                                <option value="IT">IT</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>&nbsp;</label>
                            <button class="btn btn-primary" id="applyStaffFilters">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Staff Table -->
                <div class="staff-table" style="margin-top: 1rem;">
                    <div class="table-header">
                        <h3>Staff List</h3>
                        <div style="display: flex; gap: 0.5rem;">
                            <button class="btn btn-secondary btn-small" id="exportStaffBtn">
                                <i class="fas fa-download"></i> Export
                            </button>
                            <button class="btn btn-primary btn-small" id="filterStaffBtn">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <button class="btn btn-primary btn-small" id="printStaffBtn">
                                <i class="fas fa-print"></i> Print List
                            </button>
                        </div>

                <!-- Approve Leave Modal -->
                <div class="modal" id="approveLeaveModal">
                    <div class="modal-content" style="max-width: 680px;">
                        <div class="modal-header">
                            <h3>Approve Leave</h3>
                            <button class="modal-close" data-close>&times;</button>
                        </div>
                        <div class="modal-body">
                            <form id="approveLeaveForm">
                                <div style="margin-bottom: 1rem;">
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Pending Leave Requests</label>
                                    <input type="text" id="leaveSearch" class="form-input" placeholder="Search by staff name or ID..." style="margin-bottom: .5rem;">
                                    <div style="max-height: 180px; overflow:auto; border:1px solid #e2e8f0; border-radius:6px;">
                                        <table style="width:100%; border-collapse: collapse; font-size:.9rem;">
                                            <thead>
                                                <tr style="background:#f8fafc;">
                                                    <th style="text-align:left; padding:.5rem; border-bottom:1px solid #e2e8f0;">Staff</th>
                                                    <th style="text-align:left; padding:.5rem; border-bottom:1px solid #e2e8f0;">Type</th>
                                                    <th style="text-align:left; padding:.5rem; border-bottom:1px solid #e2e8f0;">Dates</th>
                                                    <th style="text-align:left; padding:.5rem; border-bottom:1px solid #e2e8f0;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="pendingLeaveBody"></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Staff ID *</label>
                                        <input type="text" name="staff_id" class="form-input" placeholder="e.g., S000312" required>
                                    </div>
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Leave Type *</label>
                                        <select name="leave_type" class="form-select" required>
                                            <option value="">Select</option>
                                            <option value="sick">Sick Leave</option>
                                            <option value="vacation">Vacation Leave</option>
                                            <option value="emergency">Emergency Leave</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Start Date *</label>
                                        <input type="date" name="start_date" class="form-input" required>
                                    </div>
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">End Date *</label>
                                        <input type="date" name="end_date" class="form-input" required>
                                    </div>
                                </div>
                                <div style="margin-bottom: 1rem;">
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Reason</label>
                                    <textarea name="reason" class="form-input" rows="3" placeholder="Reason for leave (optional)"></textarea>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Decision *</label>
                                        <select name="decision" class="form-select" required>
                                            <option value="approved">Approve</option>
                                            <option value="rejected">Reject</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Approver Note</label>
                                        <input type="text" name="approver_note" class="form-input" placeholder="Optional note">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-close>Cancel</button>
                            <button type="submit" form="approveLeaveForm" class="btn btn-warning">Submit Decision</button>
                        </div>
                    </div>
                </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Staff ID</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Department</th>
                                <th>Shift</th>
                                <th>Status</th>
                                <th>Contact</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>S000145</td>
                                <td>Dr. Alex Rivera</td>
                                <td>Doctor</td>
                                <td>Cardiology</td>
                                <td>08:00 - 16:00</td>
                                <td><span class="badge badge-success">On Duty</span></td>
                                <td>(555) 101-2233</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-primary btn-small" title="View Profile"><i class="fas fa-eye"></i> View</button>
                                        <button class="btn btn-secondary btn-small" title="Edit Details"><i class="fas fa-edit"></i> Edit</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>S000312</td>
                                <td>Nurse Jamie Cruz</td>
                                <td>Nurse</td>
                                <td>ICU</td>
                                <td>16:00 - 00:00</td>
                                <td><span class="badge badge-warning">On Break</span></td>
                                <td>(555) 987-6543</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-primary btn-small"><i class="fas fa-eye"></i> View</button>
                                        <button class="btn btn-secondary btn-small"><i class="fas fa-edit"></i> Edit</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Assign Shift Modal -->
                <div class="modal" id="assignShiftModal">
                    <div class="modal-content" style="max-width: 680px;">
                        <div class="modal-header">
                            <h3>Assign Shift</h3>
                            <button class="modal-close" data-close>&times;</button>
                        </div>
                        <div class="modal-body">
                            <form id="assignShiftForm">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Staff ID *</label>
                                        <input type="text" name="staff_id" class="form-input" placeholder="e.g., S000145" required>
                                    </div>
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Department</label>
                                        <select name="department" class="form-select">
                                            <option value="">Select Department</option>
                                            <option value="Cardiology">Cardiology</option>
                                            <option value="ICU">ICU</option>
                                            <option value="ER">ER</option>
                                            <option value="Pharmacy">Pharmacy</option>
                                            <option value="Laboratory">Laboratory</option>
                                            <option value="Billing">Billing</option>
                                            <option value="IT">IT</option>
                                        </select>
                                    </div>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Date *</label>
                                        <input type="date" name="date" class="form-input" required>
                                    </div>
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Shift Type</label>
                                        <select name="shift_type" class="form-select">
                                            <option value="">Select</option>
                                            <option value="morning">Morning</option>
                                            <option value="afternoon">Afternoon</option>
                                            <option value="night">Night</option>
                                            <option value="custom">Custom</option>
                                        </select>
                                    </div>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Start Time *</label>
                                        <input type="time" name="start_time" class="form-input" required>
                                    </div>
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">End Time *</label>
                                        <input type="time" name="end_time" class="form-input" required>
                                    </div>
                                </div>
                                <div style="margin-bottom: 1rem;">
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Notes</label>
                                    <textarea name="notes" class="form-input" rows="3" placeholder="Optional details"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-close>Cancel</button>
                            <button type="submit" form="assignShiftForm" class="btn btn-primary">Assign</button>
                        </div>
                    </div>
                </div>

                <!-- Add Staff Modal (matching Patient modal pattern) -->
                <div class="modal" id="addStaffModal">
                    <div class="modal-content" style="max-width: 720px;">
                        <div class="modal-header">
                            <h3>Add Staff</h3>
                            <button class="modal-close" data-close>&times;</button>
                        </div>
                        <div class="modal-body">
                            <form id="addStaffForm">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">First Name *</label>
                                        <input type="text" name="first_name" class="form-input" required>
                                    </div>
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Last Name *</label>
                                        <input type="text" name="last_name" class="form-input" required>
                                    </div>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email</label>
                                        <input type="email" name="email" class="form-input" placeholder="name@example.com">
                                    </div>
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Phone</label>
                                        <input type="text" name="phone" class="form-input" placeholder="(555) 123-4567">
                                    </div>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Employee ID *</label>
                                        <input type="text" name="employee_id" class="form-input" required placeholder="e.g., S000999">
                                    </div>
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Status *</label>
                                        <select name="status" class="form-select" required>
                                            <option value="active" selected>Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Role *</label>
                                        <select name="role" class="form-select" required>
                                            <option value="">Select Role</option>
                                            <option value="Doctor">Doctor</option>
                                            <option value="Nurse">Nurse</option>
                                            <option value="Pharmacist">Pharmacist</option>
                                            <option value="Lab Technician">Lab Technician</option>
                                            <option value="Receptionist">Receptionist</option>
                                            <option value="Accountant">Accountant</option>
                                            <option value="IT Staff">IT Staff</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Department</label>
                                        <select name="department" class="form-select">
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
                                <div style="margin-bottom: 1rem;">
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Notes</label>
                                    <textarea name="notes" class="form-input" rows="3" placeholder="Additional information (optional)"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-close>Cancel</button>
                            <button type="submit" form="addStaffForm" class="btn btn-success">Save Staff</button>
                        </div>
                    </div>
                </div>

                <!-- Modal styles (copied to match patient modal) -->
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


                <script src="<?= base_url('js/logout.js') ?>"></script>

                <script>
                    (function(){
                        const table = document.querySelector('.staff-table table');
                        const rows = table ? Array.from(table.querySelectorAll('tbody tr')) : [];
                        const searchInput = document.getElementById('searchStaffInput');
                        const roleFilter = document.getElementById('roleFilter');
                        const deptFilter = document.getElementById('departmentFilter');
                        const applyBtn = document.getElementById('applyStaffFilters');

                        function text(el){ return (el?.textContent || '').trim().toLowerCase(); }

                        function applyFilters(){
                            if (!rows.length) return;
                            const q = (searchInput?.value || '').trim().toLowerCase();
                            const role = roleFilter?.value || '';
                            const dept = deptFilter?.value || '';

                            rows.forEach(tr => {
                                const cells = tr.querySelectorAll('td');
                                const name = text(cells[1]);
                                const roleText = text(cells[2]);
                                const deptText = text(cells[3]);
                                const contact = text(cells[6]);

                                let ok = true;
                                if (q) {
                                    ok = name.includes(q) || contact.includes(q);
                                }
                                if (ok && role) {
                                    ok = roleText === role.toLowerCase();
                                }
                                if (ok && dept) {
                                    ok = deptText === dept.toLowerCase();
                                }
                                tr.style.display = ok ? '' : 'none';
                            });
                        }

                        applyBtn?.addEventListener('click', applyFilters);
                        [searchInput, roleFilter, deptFilter].forEach(el => el?.addEventListener('change', applyFilters));

                        // Modal helpers (same pattern as patient page)
                        function openModal(el){ el?.classList.add('show'); }
                        function closeModal(el){ el?.classList.remove('show'); }
                        function qs(sel){ return document.querySelector(sel); }
                        function qsa(sel){ return document.querySelectorAll(sel); }

                        const addStaffModal = qs('#addStaffModal');
                        const assignShiftModal = qs('#assignShiftModal');
                        const approveLeaveModal = qs('#approveLeaveModal');
                        qs('#addStaffBtnTop')?.addEventListener('click', function(){ openModal(addStaffModal); });
                        qs('#assignShiftBtnTop')?.addEventListener('click', function(){ openModal(assignShiftModal); });
                        qs('#approveLeaveBtnTop')?.addEventListener('click', function(){ openModal(approveLeaveModal); });
                        // close buttons with data-close
                        qsa('[data-close]').forEach(function(btn){
                            btn.addEventListener('click', function(){ const modal = btn.closest('.modal'); if(modal) closeModal(modal); });
                        });
                        // click outside to close
                        window.addEventListener('click', function(e){
                            if (e.target === addStaffModal) closeModal(addStaffModal);
                            if (e.target === assignShiftModal) closeModal(assignShiftModal);
                            if (e.target === approveLeaveModal) closeModal(approveLeaveModal);
                        });

                        // Submit handler (demo)
                        const addStaffForm = qs('#addStaffForm');
                        addStaffForm?.addEventListener('submit', function(e){
                            e.preventDefault();
                            alert('Staff saved successfully!');
                            closeModal(addStaffModal);
                            addStaffForm.reset();
                        });

                        // Assign Shift modal wiring
                        const assignShiftForm = qs('#assignShiftForm');
                        assignShiftForm?.addEventListener('submit', function(e){
                            e.preventDefault();
                            alert('Shift assigned successfully!');
                            closeModal(assignShiftModal);
                            assignShiftForm.reset();
                        });

                        // Approve Leave modal wiring
                        const approveLeaveForm = qs('#approveLeaveForm');
                        // Mock pending leaves (replace with backend data later)
                        const pendingLeaves = [
                            { staff_id: 'S000145', name: 'Dr. Alex Rivera', type: 'sick', start_date: '2025-09-20', end_date: '2025-09-21', reason: 'Fever' },
                            { staff_id: 'S000312', name: 'Nurse Jamie Cruz', type: 'vacation', start_date: '2025-09-22', end_date: '2025-09-24', reason: 'Family trip' }
                        ];

                        function renderPendingLeaves(list){
                            const tbody = document.getElementById('pendingLeaveBody');
                            if (!tbody) return;
                            tbody.innerHTML = '';
                            list.forEach((req, idx) => {
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td style="padding:.5rem; border-bottom:1px solid #f1f5f9;">
                                        <strong>${req.name}</strong><div style="color:#64748b; font-size:.8rem;">${req.staff_id}</div>
                                    </td>
                                    <td style="padding:.5rem; border-bottom:1px solid #f1f5f9; text-transform:capitalize;">${req.type.replace('_',' ')}</td>
                                    <td style="padding:.5rem; border-bottom:1px solid #f1f5f9;">${req.start_date} → ${req.end_date}</td>
                                    <td style="padding:.5rem; border-bottom:1px solid #f1f5f9;">
                                        <button type="button" class="btn btn-primary btn-small" data-pick-leave="${idx}">Select</button>
                                    </td>`;
                                tbody.appendChild(tr);
                            });
                        }

                        function filterLeaves(q){
                            const qq = (q||'').toLowerCase();
                            return pendingLeaves.filter(r => r.staff_id.toLowerCase().includes(qq) || r.name.toLowerCase().includes(qq));
                        }

                        // Initial render when modal opens
                        approveLeaveModal?.addEventListener('transitionstart', () => renderPendingLeaves(pendingLeaves));
                        // Fallback: render on open click
                        qs('#approveLeaveBtnTop')?.addEventListener('click', function(){ renderPendingLeaves(pendingLeaves); });

                        document.getElementById('leaveSearch')?.addEventListener('input', function(){
                            renderPendingLeaves(filterLeaves(this.value));
                        });

                        document.getElementById('pendingLeaveBody')?.addEventListener('click', function(e){
                            const btn = e.target.closest('[data-pick-leave]');
                            if (!btn) return;
                            const idx = parseInt(btn.getAttribute('data-pick-leave'), 10);
                            const req = (filterLeaves(document.getElementById('leaveSearch')?.value) || pendingLeaves)[idx];
                            if (!req) return;
                            // Fill the form
                            approveLeaveForm.querySelector('[name="staff_id"]').value = req.staff_id;
                            approveLeaveForm.querySelector('[name="leave_type"]').value = req.type;
                            approveLeaveForm.querySelector('[name="start_date"]').value = req.start_date;
                            approveLeaveForm.querySelector('[name="end_date"]').value = req.end_date;
                            const reasonEl = approveLeaveForm.querySelector('[name="reason"]');
                            if (reasonEl) reasonEl.value = req.reason || '';
                        });

                        approveLeaveForm?.addEventListener('submit', function(e){
                            e.preventDefault();
                            const decision = (new FormData(approveLeaveForm).get('decision')) || 'approved';
                            alert('Leave ' + decision + ' successfully!');
                            closeModal(approveLeaveModal);
                            approveLeaveForm.reset();
                        });
                    })();
                </script>

            </main>
        </div>
    </body>
</html>



