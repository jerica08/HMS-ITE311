<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Patient Management - HMS Doctor</title>
        <link rel="stylesheet" href="<?= base_url('assets/css/dashboard-common.css') ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
            .patient-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }
            .patient-section {
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
            .patient-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1rem 0;
                border-bottom: 1px solid #f3f4f6;
            }
            .patient-item:last-child {
                border-bottom: none;
            }
            .patient-info {
                flex: 1;
            }
            .patient-name {
                font-weight: 500;
                color: #1f2937;
                margin-bottom: 0.25rem;
            }
            .patient-details {
                font-size: 0.8rem;
                color: #6b7280;
            }
            .patient-status {
                padding: 0.25rem 0.75rem;
                border-radius: 15px;
                font-size: 0.8rem;
                font-weight: 500;
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
            .patient-avatar {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: #4299e1;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: bold;
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
            .patient-flow {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem;
                background: #f8fafc;
                border-radius: 6px;
                margin: 0.5rem 0;
                font-size: 0.9rem;
            }
            .flow-number {
                font-weight: bold;
                color: #3b82f6;
            }
        </style>
    </head>
    <body class="doctor">

        <header class="header">
            <div class="header-content">
                <div class="logo">
                    <h1><i class="fas fa-user-md"></i> Doctor</h1>                    
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
                         <a href="<?= base_url('doctor/dashboard') ?>" class="nav-link">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                         <a href="<?= base_url('doctor/patients') ?>" class="nav-link active">
                            <i class="fas fa-users nav-icon"></i>
                            My Patients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('doctor/appointments') ?>" class="nav-link">
                            <i class="fas fa-calendar-alt nav-icon"></i>
                            Appointments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('doctor/prescriptions') ?>" class="nav-link">
                            <i class="fas fa-prescription-bottle nav-icon"></i>
                            Prescriptions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('doctor/lab-results') ?>" class="nav-link">
                            <i class="fas fa-flask nav-icon"></i>
                            Lab Results
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('doctor/ehr') ?>" class="nav-link">
                            <i class="fas fa-file-medical nav-icon"></i>
                            Electronic Health Record
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('doctor/mySchedule') ?>" class="nav-link">
                            <i class="fas fa-clock nav-icon"></i>
                            My Schedule
                        </a>
                    </li>
                </ul>      
            </nav>
        
            <!--Main Content-->
            <main class="content">
                <h1 class="page-title">My Patients</h1>
                <div class="page-actions">
                    <button class="btn btn-success" id="addPatientBtn">
                        <i class="fas fa-plus"></i> Add New Patient
                    </button>
                </div><br>

                <!--Dashboard overview cards-->
                <div class="dashboard-overview">

                    <!-- Total Patient Cards -->
                    <div class="overview-card">
                        <div class="card-header-modern">
                            <div class="card-icon-modern blue">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-info">
                                <h3 class="card-title-modern">Total Patients</h3>
                                <p class="card-subtitle">Under your care</p>
                            </div>
                        </div>
                        <div class="card-metrics">
                            <div class="metric">
                                <div class="metric-value blue">0</div>
                                <div class="metric-label">Active</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value green">0</div>
                                <div class="metric-label">New this week</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value orange">0</div>
                                <div class="metric-label">Critical</div>
                            </div>
                        </div>
                    </div>                           
                </div>
      
                <!--Filter and Actions-->    
                <div class="search-filter">
                    <h3 style="margin-bottom: 1rem;">Search Patient</h3>
                    <div class="filter-row">
                        <div class="filter-group">
                            <label> Search Patient</label>
                            <input type="text" class="filter-input" placeholder="Search by name, email, or condition..." 
                                id="searchInput" value="">
                        </div>
                        <div class="filter-group">
                            <label>All Conditions</label>
                            <select class="filter-input" id="conditionsFilter">
                                <option value="hypertension">Hypertension</option>                  
                                <option value="diabetes">Diabetes</option>
                                <option value="heart-disease">Heart Disease</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>All Status</label>
                            <select class="filter-input" id="roleFilter">
                                <option value="">All Status</option>
                                <option value="stable">Stable</option>
                                <option value="monitoring">Monitoring</option>
                                <option value="critical">Critical</option>
                            </select>                           
                        </div>                                             
                        <div class="filter-group">
                            <label>&nbsp;</label>
                            <button class="btn btn-primary" onclick="applyFilters()">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>     
                    </div>          
                </div><br>
                
                <!-- Patient Table -->
                <div class="patient-table">
                    <div class="table-header">
                        <h3>Patient List</h3>
                        <div style="display: flex; gap: 0.5rem;">
                            <button class="btn btn-secondary btn-small" id="exportBtn">
                                <i class="fas fa-download"></i> Export
                            </button>
                            <button class="btn btn-primary btn-small" id="advanceFilterBtn">
                                <i class="fas fa-filter"></i> Advance Filter
                            </button>
                            <button class="btn btn-primary btn-small" id="printBtn">
                                <i class="fas fa-print"></i> Print List
                            </button>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Patient ID</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Primary Condition</th>
                                <th>Last Visit</th>
                                <th>Room</th>
                                <th>Status</th> 
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                           <tr>
                            <td>P001247</td>
                            <td>Sarah Wilson</td>
                            <td>45</td>
                            <td>Female</td>
                            <td>Atrial Fibrillation</td>
                            <td>Aug 19, 2025</td>
                            <td>301</td>
                            <td><span class="badge badge-success">Stable</span></td>
                            <td>
                                <button class="btn btn-primary view-patient-btn" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" data-patient-id="P001247">View</button>
                                <button class="btn btn-secondary edit-patient-btn" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" data-patient-id="P001247">Edit</button>
                                <button class="btn btn-info visit-history-btn" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" data-patient-id="P001247">History</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            
            <!-- Modals -->
            <div class="modal" id="newPatientModal">
                <div class="modal-content" style="max-width: 720px;">
                    <div class="modal-header">
                        <h3 id="newPatientTitle">New Patient</h3>
                        <button class="modal-close" data-close>&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="newPatientForm">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Full Name *</label>
                                    <input type="text" class="form-input" placeholder="e.g., John Doe" required>
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Age *</label>
                                    <input type="number" min="0" class="form-input" required>
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Gender *</label>
                                    <select class="form-select" required>
                                        <option value="">Select</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Phone</label>
                                    <input type="tel" class="form-input" placeholder="e.g., 0917 123 4567">
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Primary Condition</label>
                                    <input type="text" class="form-input" placeholder="e.g., Hypertension">
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Room</label>
                                    <input type="text" class="form-input" placeholder="e.g., 301">
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Status</label>
                                    <select class="form-select">
                                        <option>Stable</option>
                                        <option>Monitoring</option>
                                        <option>Critical</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Last Visit</label>
                                    <input type="date" class="form-input">
                                </div>
                            </div>
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Notes</label>
                                <textarea class="form-input" rows="3" placeholder="Additional information"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-close>Cancel</button>
                        <button type="submit" form="newPatientForm" class="btn btn-success">Save Patient</button>
                    </div>
                </div>
            </div>

            <div class="modal" id="viewPatientModal">
                <div class="modal-content" style="max-width: 800px;">
                    <div class="modal-header">
                        <h3>Patient Details</h3>
                        <button class="modal-close" data-close>&times;</button>
                    </div>
                    <div class="modal-body">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                            <div>
                                <h4 style="margin-bottom: 1rem; color: #2d3748;">Profile</h4>
                                <div style="background: #f7fafc; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                                    <div style="margin-bottom: 0.5rem;"><strong>ID:</strong> <span>P001247</span></div>
                                    <div style="margin-bottom: 0.5rem;"><strong>Name:</strong> <span>Sarah Wilson</span></div>
                                    <div style="margin-bottom: 0.5rem;"><strong>Age:</strong> <span>45</span></div>
                                    <div style="margin-bottom: 0.5rem;"><strong>Gender:</strong> <span>Female</span></div>
                                    <div style="margin-bottom: 0.5rem;"><strong>Phone:</strong> <span>(555) 123-4567</span></div>
                                    <div><strong>Status:</strong> <span class="badge badge-success">Stable</span></div>
                                </div>
                                <h4 style="margin-bottom: 1rem; color: #2d3748;">Primary Condition</h4>
                                <div style="background: #e6fffa; padding: 1rem; border-radius: 8px;">Atrial Fibrillation</div>
                            </div>
                            <div>
                                <h4 style="margin-bottom: 1rem; color: #2d3748;">Recent Visits</h4>
                                <div style="background: #fff5f5; padding: 1rem; border-radius: 8px;">
                                    <div style="margin-bottom: 0.5rem;">Aug 19, 2025 - Check-up</div>
                                    <div style="margin-bottom: 0.5rem;">Jun 01, 2025 - Follow-up</div>
                                    <div>Mar 10, 2025 - Consultation</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-close>Close</button>
                        <button type="button" class="btn btn-primary" id="editFromViewPatient">Edit</button>
                    </div>
                </div>
            </div>

            <div class="modal" id="editPatientModal">
                <div class="modal-content" style="max-width: 720px;">
                    <div class="modal-header">
                        <h3>Edit Patient</h3>
                        <button class="modal-close" data-close>&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="editPatientForm">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Full Name *</label>
                                    <input type="text" class="form-input" value="Sarah Wilson" required>
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Age *</label>
                                    <input type="number" min="0" class="form-input" value="45" required>
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Gender *</label>
                                    <select class="form-select" required>
                                        <option>Female</option>
                                        <option>Male</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Phone</label>
                                    <input type="tel" class="form-input" value="(555) 123-4567">
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Primary Condition</label>
                                    <input type="text" class="form-input" value="Atrial Fibrillation">
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Room</label>
                                    <input type="text" class="form-input" value="301">
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Status</label>
                                    <select class="form-select">
                                        <option>Stable</option>
                                        <option>Monitoring</option>
                                        <option>Critical</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Last Visit</label>
                                    <input type="date" class="form-input" value="2025-08-19">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-close>Cancel</button>
                        <button type="submit" form="editPatientForm" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </div>

            <div class="modal" id="advancedFilterModal">
                <div class="modal-content" style="max-width: 680px;">
                    <div class="modal-header">
                        <h3>Advanced Filter</h3>
                        <button class="modal-close" data-close>&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="advancedFilterForm">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Condition</label>
                                    <select class="form-select">
                                        <option value="">All</option>
                                        <option>Hypertension</option>
                                        <option>Diabetes</option>
                                        <option>Heart Disease</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Status</label>
                                    <select class="form-select">
                                        <option value="">All</option>
                                        <option>Stable</option>
                                        <option>Monitoring</option>
                                        <option>Critical</option>
                                    </select>
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Last Visit From</label>
                                    <input type="date" class="form-input">
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">To</label>
                                    <input type="date" class="form-input">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-close>Close</button>
                        <button type="submit" form="advancedFilterForm" class="btn btn-primary">Apply</button>
                    </div>
                </div>
            </div>

            <div class="modal" id="visitHistoryModal">
                <div class="modal-content" style="max-width: 800px;">
                    <div class="modal-header">
                        <h3>Visit History</h3>
                        <button class="modal-close" data-close>&times;</button>
                    </div>
                    <div class="modal-body">
                        <div style="background: #f8fafc; padding: 1rem; border-radius: 8px;">
                            <div style="margin-bottom: 0.5rem;">Aug 19, 2025 - Routine Check-up</div>
                            <div style="margin-bottom: 0.5rem;">Jun 01, 2025 - Follow-up</div>
                            <div>Mar 10, 2025 - Consultation</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-close>Close</button>
                    </div>
                </div>
            </div>

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
            </style>

            <script>
            (function() {
                function openModal(el) { el.classList.add('show'); }
                function closeModal(el) { el.classList.remove('show'); }
                function qs(sel) { return document.querySelector(sel); }
                function qsa(sel) { return document.querySelectorAll(sel); }

                const newPatientModal = qs('#newPatientModal');
                const viewPatientModal = qs('#viewPatientModal');
                const editPatientModal = qs('#editPatientModal');
                const advancedFilterModal = qs('#advancedFilterModal');
                const visitHistoryModal = qs('#visitHistoryModal');

                // Openers
                qs('#addPatientBtn') && qs('#addPatientBtn').addEventListener('click', function() { openModal(newPatientModal); });
                qsa('.view-patient-btn').forEach(function(btn){ btn.addEventListener('click', function(){ openModal(viewPatientModal); }); });
                qsa('.edit-patient-btn').forEach(function(btn){ btn.addEventListener('click', function(){ openModal(editPatientModal); }); });
                qs('#advanceFilterBtn') && qs('#advanceFilterBtn').addEventListener('click', function(){ openModal(advancedFilterModal); });
                qsa('.visit-history-btn').forEach(function(btn){ btn.addEventListener('click', function(){ openModal(visitHistoryModal); }); });
                qs('#editFromViewPatient') && qs('#editFromViewPatient').addEventListener('click', function(){ closeModal(viewPatientModal); openModal(editPatientModal); });

                // Closers
                qsa('[data-close]').forEach(function(btn){ btn.addEventListener('click', function(){ const modal = btn.closest('.modal'); if(modal) closeModal(modal); }); });
                window.addEventListener('click', function(e){
                    [newPatientModal, viewPatientModal, editPatientModal, advancedFilterModal, visitHistoryModal].forEach(function(m){ if(e.target === m) closeModal(m); });
                });

                // Submit handlers (demo only)
                qs('#newPatientForm') && qs('#newPatientForm').addEventListener('submit', function(e){ e.preventDefault(); alert('Patient saved successfully!'); closeModal(newPatientModal); this.reset(); });
                qs('#editPatientForm') && qs('#editPatientForm').addEventListener('submit', function(e){ e.preventDefault(); alert('Changes saved.'); closeModal(editPatientModal); });
                qs('#advancedFilterForm') && qs('#advancedFilterForm').addEventListener('submit', function(e){ e.preventDefault(); alert('Filters applied.'); closeModal(advancedFilterModal); });
            })();
            </script>

            </main>
        </div>
        <script src="<?= base_url('js/logout.js') ?>"></script>
    </body>
</html>