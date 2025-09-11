<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Electronic Health Record - HMS Doctor</title>
        <link rel="stylesheet" href="/assets/css/dashboard-common.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
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
        </style>
    </head>
    <body class="patient">

        <header class="header">
            <div class="header-content">
                <div class="logo">
                    <h1><i class="fas fa-hospital"></i>HMS-Doctor</h1>                    
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
                         <a href="<?= base_url('doctor/dashboard') ?>" class="nav-link">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                         <a href="<?= base_url('doctor/patients') ?>" class="nav-link">
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
                        <a href="<?= base_url('doctor/medical-records') ?>" class="nav-link">
                            <i class="fas fa-file-medical nav-icon"></i>
                            Medical Records
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
                            <i class="fas fa-flask nav-icon"></i>
                            Electronic Health Record
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('doctor/mySchedule') ?>" class="nav-link">
                            <i class="fas fa-flask nav-icon"></i>
                            My Schedule
                </ul>      
            </nav>
        
            <!--Main Content-->
            <main class="content">
                <h1 class="page-title">Electronic Health Record</h1>
                <div class="page-actions">
                    <button class="btn btn-success">
                        <i class="fas fa-plus"></i> New Record Entry
                    </button>
                </div><br>

                <!--Search patient-->    
                <div class="search-filter">
                    <h3 style="margin-bottom: 1rem;">Search Patient</h3>
                    <div class="filter-row">
                        <div class="filter-group">
                            <label> Search Patient</label>
                            <input type="text" class="filter-input" placeholder="Search by patient name, ID, or record number..." 
                                id="patientSearch" value="">
                        </div>                                           
                        <div class="filter-group">
                            <label>&nbsp;</label>
                            <button class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>     
                    </div>          
                </div><br>

                <!--Dashboard overview cards-->
                <div class="dashboard-overview">

                    <!--Patient Information Card -->
                    <div class="overview-card">
                        <div class="card-header-modern">
                            <div class="card-icon-modern blue">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="card-info">
                                <h3 class="card-title-modern">Patient Demographics</h3>
                                <p class="card-subtitle">Basic information</p>
                            </div>
                        </div>
                        <div class="card-content">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div>
                                <strong>Name:</strong> John Smith<br>
                                <strong>DOB:</strong> March 15, 1970<br>
                                <strong>Age:</strong> 55 years<br>
                                <strong>Gender:</strong> Male
                            </div>
                            <div>
                                <strong>MRN:</strong> P001234<br>
                                <strong>Phone:</strong> (555) 123-4567<br>
                                <strong>Email:</strong> john.smith@email.com<br>
                                <strong>Insurance:</strong> Blue Cross
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Vital Signs Card -->
                    <div class="overview-card">
                        <div class="card-header-modern">
                            <div class="card-icon-modern blue">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                            <div class="card-info">
                                <h3 class="card-title-modern">Vital Signs</h3>
                                <p class="card-subtitle">Latest measurements</p>
                            </div>
                        </div>
                        <div class="card-content">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div>
                                <strong>Blood Pressure:</strong> 140/90 mmHg<br>
                                <strong>Heart Rate:</strong> 78 bpm<br>
                                <strong>Temperature:</strong> 98.6°F
                            </div>
                            <div>
                                <strong>Weight:</strong> 185 lbs<br>
                                <strong>Height:</strong> 5'10"<br>
                                <strong>BMI:</strong> 26.5
                            </div>
                        </div>
                        <div style="margin-top: 1rem;">
                            <small style="color: #666;">Last updated: Aug 20, 2025 10:15 AM</small>
                        </div>
                    </div>                     
                    </div>

                     <!-- Alerts & Alergies Card -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-icon-modern blue">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div>
                                <h3 class="card-title">Alerts & Alergies</h3>
                                <p class="card-content">Important warnings</p>
                            </div>
                        </div>
                        <div class="card-content">
                            <div style="padding: 0.8rem; background: #fed7d7; border-radius: 5px; margin-bottom: 1rem; border-left: 4px solid #f56565;">
                                <strong>Drug Alert:</strong> Example alert notif.
                            </div>
                            <div style="padding: 0.8rem; background: #fed7d7; border-radius: 5px; margin-bottom: 1rem; border-left: 4px solid #f56565;">
                                <strong>Medical Alert:</strong> Example alert notif.
                            </div>
                        </div>
                    </div>
                </div>

                <!--EHR Navigation Tab-->
                <div class="card" style="margin-top: 2rem;">
                    <div class="card-header">
                        <div class="btn-group">
                            <button class="btn btn-primary active" data-tab="summary">Summary</button>
                            <button class="btn btn-secondary" data-tab="visits">Visit History</button>
                            <button class="btn btn-secondary" data-tab="medications">Medications</button>
                            <button class="btn btn-secondary" data-tab="labs">Lab Results</button>
                            <button class="btn btn-secondary" data-tab="imaging">Imaging</button>
                            <button class="btn btn-secondary" data-tab="notes">Clinical Notes</button>
                        </div>
                    </div>
                    <!-- Summary Tab -->
                    <div class="tab-content active" id="summary-tab">
                            <div class="card-content">
                                <h4 style="margin-bottom: 1rem;">Medical Summary</h4>
                                
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                                    <div>
                                        <h5>Active Diagnoses</h5>
                                        <ul style="list-style: none; padding: 0;">
                                            <li style="padding: 0.5rem; background: #f7fafc; margin-bottom: 0.5rem; border-radius: 5px;">
                                                <strong>Essential Hypertension</strong> (I10)<br>
                                                <small>Diagnosed: Jan 15, 2023</small>
                                            </li>
                                            <li style="padding: 0.5rem; background: #f7fafc; margin-bottom: 0.5rem; border-radius: 5px;">
                                                <strong>Hyperlipidemia</strong> (E78.5)<br>
                                                <small>Diagnosed: Mar 22, 2023</small>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    <div>
                                        <h5>Current Medications</h5>
                                        <ul style="list-style: none; padding: 0;">
                                            <li style="padding: 0.5rem; background: #f0fff4; margin-bottom: 0.5rem; border-radius: 5px;">
                                                <strong>Lisinopril 10mg</strong><br>
                                                <small>Once daily - Started: Jan 2023</small>
                                            </li>
                                            <li style="padding: 0.5rem; background: #f0fff4; margin-bottom: 0.5rem; border-radius: 5px;">
                                                <strong>Atorvastatin 20mg</strong><br>
                                                <small>Once daily - Started: Mar 2023</small>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div style="margin-top: 2rem;">
                                    <h5>Recent Activity</h5>
                                    <div style="border-left: 3px solid #4299e1; padding-left: 1rem;">
                                        <div style="margin-bottom: 1rem;">
                                            <strong>Aug 20, 2025</strong> - Follow-up visit for hypertension management<br>
                                            <small>BP: 140/90, adjusted medication dosage</small>
                                        </div>
                                        <div style="margin-bottom: 1rem;">
                                            <strong>Aug 15, 2025</strong> - Lab results reviewed<br>
                                            <small>Lipid panel shows improvement</small>
                                        </div>
                                        <div>
                                            <strong>Jul 30, 2025</strong> - Routine check-up<br>
                                            <small>Patient compliance good, continue current regimen</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!-- Visit History Tab -->
                    <div class="tab-content" id="visits-tab" style="display: none;">
                        <div class="card-content">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Visit Type</th>
                                        <th>Chief Complaint</th>
                                        <th>Diagnosis</th>
                                        <th>Provider</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Aug 20, 2025</td>
                                        <td>Follow-up</td>
                                        <td>Hypertension management</td>
                                        <td>Essential Hypertension</td>
                                        <td>Dr. Sarah Johnson</td>
                                        <td><button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" onclick="openVisitModal('visit1')">View</button></td>
                                    </tr>
                                    <tr>
                                        <td>Jul 30, 2025</td>
                                        <td>Routine</td>
                                        <td>Annual check-up</td>
                                        <td>Routine examination</td>
                                        <td>Dr. Sarah Johnson</td>
                                        <td><button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" onclick="openVisitModal('visit2')">View</button></td>
                                    </tr>
                                    <tr>
                                        <td>Jun 15, 2025</td>
                                        <td>Consultation</td>
                                        <td>Chest pain evaluation</td>
                                        <td>Atypical chest pain</td>
                                        <td>Dr. Sarah Johnson</td>
                                        <td><button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;" onclick="openVisitModal('visit3')">View</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Medications Tab -->
                    <div class="tab-content" id="medications-tab" style="display: none;">
                        <div class="card-content">
                            <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 1rem;">
                                <h4>Medication History</h4>
                                <button class="btn btn-success">Add Medication</button>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Medication</th>
                                        <th>Dosage</th>
                                        <th>Frequency</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Lisinopril</td>
                                        <td>10mg</td>
                                        <td>Once daily</td>
                                        <td>Jan 15, 2023</td>
                                        <td>-</td>
                                        <td><span class="badge badge-success">Active</span></td>
                                        <td>
                                            <button class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">Edit</button>
                                            <button class="btn btn-danger" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">Stop</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Atorvastatin</td>
                                        <td>20mg</td>
                                        <td>Once daily</td>
                                        <td>Mar 22, 2023</td>
                                        <td>-</td>
                                        <td><span class="badge badge-success">Active</span></td>
                                        <td>
                                            <button class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">Edit</button>
                                            <button class="btn btn-danger" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">Stop</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Metoprolol</td>
                                        <td>25mg</td>
                                        <td>Twice daily</td>
                                        <td>Dec 10, 2022</td>
                                        <td>Jan 10, 2023</td>
                                        <td><span class="badge badge-secondary">Discontinued</span></td>
                                        <td>
                                            <button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">View</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Labs Tab -->
                    <div class="tab-content" id="labs-tab" style="display: none;">
                        <div class="card-content">
                            <h4 style="margin-bottom: 1rem;">Laboratory Results</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Test</th>
                                        <th>Result</th>
                                        <th>Reference Range</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Total Cholesterol</td>
                                        <td>195 mg/dL</td>
                                        <td>&lt; 200 mg/dL</td>
                                        <td>Aug 15, 2025</td>
                                        <td><span class="badge badge-success">Normal</span></td>
                                        <td><button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">View</button></td>
                                    </tr>
                                    <tr>
                                        <td>LDL Cholesterol</td>
                                        <td>120 mg/dL</td>
                                        <td>&lt; 100 mg/dL</td>
                                        <td>Aug 15, 2025</td>
                                        <td><span class="badge badge-warning">High</span></td>
                                        <td><button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">View</button></td>
                                    </tr>
                                    <tr>
                                        <td>HDL Cholesterol</td>
                                        <td>45 mg/dL</td>
                                        <td>&gt; 40 mg/dL</td>
                                        <td>Aug 15, 2025</td>
                                        <td><span class="badge badge-success">Normal</span></td>
                                        <td><button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">View</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Imaging Tab -->
                    <div class="tab-content" id="imaging-tab" style="display: none;">
                        <div class="card-content">
                            <h4 style="margin-bottom: 1rem;">Imaging Studies</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Study Type</th>
                                        <th>Date</th>
                                        <th>Indication</th>
                                        <th>Results</th>
                                        <th>Radiologist</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Chest X-Ray</td>
                                        <td>Jun 15, 2025</td>
                                        <td>Chest pain evaluation</td>
                                        <td>Normal cardiac silhouette</td>
                                        <td>Dr. Michael Chen</td>
                                        <td>
                                            <button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">View</button>
                                            <button class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">Download</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>ECG</td>
                                        <td>Aug 20, 2025</td>
                                        <td>Routine follow-up</td>
                                        <td>Normal sinus rhythm</td>
                                        <td>Dr. Sarah Johnson</td>
                                        <td>
                                            <button class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">View</button>
                                            <button class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">Download</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>                                            
                    <!-- Clinical Notes Tab -->
                    <div class="tab-content" id="notes-tab" style="display: none;">
                        <div class="card-content">
                            <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 1rem;">
                                <h4>Clinical Notes</h4>
                                <button class="btn btn-success" onclick="openAddNoteModal()">Add Note</button>
                            </div>
                            
                            <div style="border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 1rem;">
                                <div style="background: #f7fafc; padding: 1rem; border-bottom: 1px solid #e2e8f0;">
                                    <strong>Progress Note - Aug 20, 2025</strong>
                                    <span style="float: right; color: #666;">Dr. Sarah Johnson</span>
                                </div>
                                <div style="padding: 1rem;">
                                    <p><strong>Chief Complaint:</strong> Follow-up for hypertension management</p>
                                    <p><strong>Assessment:</strong> Patient's blood pressure remains elevated at 140/90 despite current medication. Patient reports good compliance with Lisinopril 10mg daily.</p>
                                    <p><strong>Plan:</strong> Increase Lisinopril to 15mg daily. Patient to monitor BP at home and return in 2 weeks. Discussed lifestyle modifications including diet and exercise.</p>
                                </div>
                            </div>

                            <div style="border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 1rem;">
                                <div style="background: #f7fafc; padding: 1rem; border-bottom: 1px solid #e2e8f0;">
                                    <strong>Consultation Note - Jun 15, 2025</strong>
                                    <span style="float: right; color: #666;">Dr. Sarah Johnson</span>
                                </div>
                                <div style="padding: 1rem;">
                                    <p><strong>Chief Complaint:</strong> Chest pain for 2 days</p>
                                    <p><strong>History:</strong> 55-year-old male with history of hypertension presents with intermittent chest discomfort. Pain is non-radiating, not associated with exertion.</p>
                                    <p><strong>Physical Exam:</strong> Vital signs stable. Cardiac exam normal. No signs of distress.</p>
                                    <p><strong>Assessment:</strong> Atypical chest pain, likely musculoskeletal. Low probability of cardiac etiology given presentation.</p>
                                    <p><strong>Plan:</strong> Chest X-ray ordered. Patient advised to return if symptoms worsen. Follow-up in 1 week.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
        <script>
            // Tab functionality
        document.querySelectorAll('[data-tab]').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons and tabs
                document.querySelectorAll('[data-tab]').forEach(btn => {
                    btn.classList.remove('active', 'btn-primary');
                    btn.classList.add('btn-secondary');
                });
                document.querySelectorAll('.tab-content').forEach(tab => {
                    tab.style.display = 'none';
                    tab.classList.remove('active');
                });

                // Add active class to clicked button and corresponding tab
                this.classList.add('active', 'btn-primary');
                this.classList.remove('btn-secondary');
                const tabId = this.getAttribute('data-tab') + '-tab';
                const targetTab = document.getElementById(tabId);
                if (targetTab) {
                    targetTab.style.display = 'block';
                    targetTab.classList.add('active');
                }
            });
        });
        </script>
        <script src="/js/logout.js"></script>
    </body>
</html>