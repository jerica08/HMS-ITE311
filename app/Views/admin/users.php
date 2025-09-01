<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - HMS Admin</title>
    <link rel="stylesheet" href="\assets\css\dashboard-common.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .user-filter{
            display:flex;
            gap:1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .filter-group{
            display:flex;
            flex-direction:column;
            gap:0.5rem;
        }
        .filter-group label{
            font-size: 0.9rem;
            font-weight: 500;
            color: #4a5568;
        }
         .filter-input {
            padding: 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            font-size: 0.9rem;
        }
        .user-actions {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .user-table {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .user-row {
            border-bottom: 1px solid #e2e8f0;
        }
        .user-row:last-child {
            border-bottom: none;
        }
        .user-avatar {
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
         .role-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .role-admin { background: #fed7d7; color: #c53030; }
        .role-doctor { background: #c6f6d5; color: #2f855a; }
        .role-nurse { background: #bee3f8; color: #2b6cb0; }
        .role-receptionist { background: #fbb6ce; color: #b83280; }
        .role-lab { background: #faf089; color: #744210; }
        .role-pharmacist { background: #d6f5d6; color: #22543d; }
        .role-accountant { background: #e9d8fd; color: #553c9a; }
        .role-it { background: #fed7cc; color: #c05621; }
        .status-active { color: #22c55e; }
        .status-inactive { color: #ef4444; }
        .status-pending { color: #f59e0b; }
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        .action-btn {
            padding: 0.25rem 0.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        .btn-edit { background: #3b82f6; color: white; }
        .btn-delete { background: #ef4444; color: white; }
        .btn-reset { background: #f59e0b; color: white; }
        .modal {
            display: none;
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
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        .form-input {
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            font-size: 0.9rem;
        }
         .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
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
                    <a href="<?= base_url('admin/dashboard') ?>" class="nav-link active">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                    <a href="<?= base_url('admin/users') ?>" class="nav-link active">
                            <i class="fas fa-users nav-icon"></i>
                            User Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin-analytics.html" class="nav-link">
                            <i class="fas fa-chart-bar nav-icon"></i>
                            Analytics & Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin-system-settings.html" class="nav-link">
                            <i class="fas fa-cogs nav-icon"></i>
                            System Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin-security.html" class="nav-link">
                            <i class="fas fa-shield-alt nav-icon"></i>
                            Security & Access
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin-audit-logs.html" class="nav-link">
                            <i class="fas fa-clipboard-list nav-icon"></i>
                            Audit Logs
                        </a>
                    </li>
                </ul>
            
            </nav>
       
        <!--Main Content-->
        <main class="content">
            <h1 class="page-title"> User Management</h1>

            <!--Dashboard overview cards-->
            <div class="dashboard-overview">
                <!-- Total User Cards -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern blue">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Total Users</h3>
                            <p class="card-subtitle">All Registered Users</p>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value blue">247</div>
                        </div>
                    </div>
                </div>

                <!-- Active User Card -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Actice User</h3>
                            <p class="card-subtitle">Currently active</p>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value purple">1,847</div>
                        </div>
                    </div>   
                </div>

                <!-- Pending Approval Card -->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Pending Approval</h3>
                            <p class="card-subtitle">Awaiting activation</p>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value purple">156</div>
                        </div>
                    </div>
                </div>
                <!--Admin Users Card-->
                <div class="overview-card">
                    <div class="card-header-modern">
                        <div class="card-icon-modern purple">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="card-info">
                            <h3 class="card-title-modern">Admin Users</h3>
                            <p class="card-subtitle">System Administrators</p>
                        </div>
                    </div>
                    <div class="card-metrics">
                        <div class="metric">
                            <div class="metric-value purple">156</div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Filter and Actions-->    
            <div class="user-filter">
                <div class="filter-group">
                    <label> Search Users</label>
                    <input type="text" class="filter-input" placeholder="Search by name, email, or ID..." id="searchInput">
                </div>
                <div class="filter-group">
                     <label> Role Filter</label>
                     <select class="filter-input" id="roleFilter">
                        <option value="">All Roles</option>
                        <option value="admin">Administrator</option>
                        <option value="doctor">Doctor</option>
                        <option value="nurse">Nurse</option>
                        <option value="receptionist">Receptionist</option>
                        <option value="lab">Laboratory Staff</option>
                        <option value="pharmacist">Pharmacist</option>
                        <option value="accountant">Accountant</option>
                        <option value="it">IT Staff</option>
                     </select>
                </div>
                <div class="filter-group">
                    <label>Status Filter</label>
                    <select class="filter-input" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="Active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
            </div>

            <div class="user-action">
                <button class="btn btn-primary" onclick="openAddUserModal()">
                    <i class="fas fa-plus"></i> Add New User
                </button>
                <button class="btn btn-secondary" onclick="exportUser()">
                    <i class="fas fa-download"></i> Export Users
                </button >
                <buttonclass="btn btn-warning" onclick="bulkActions()">
                    <i class="fas fa-tasks"></i> Bulk Actions
                </button>
            </div>

            <!--users Table-->
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                         <tr class="user-row">
                            <td><input type="checkbox" class="user-checkbox" data-user-id="1"></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div class="user-avatar">DJ</div>
                                    <div>
                                        <div style="font-weight: 600;">Dr. John Smith</div>
                                        <div style="font-size: 0.8rem; color: #6b7280;">john.smith@hospital.com</div>
                                        <div style="font-size: 0.8rem; color: #6b7280;">ID: HMS001</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="role-badge role-doctor">Doctor</span></td>
                            <td>Cardiology</td>
                            <td><i class="fas fa-circle status-active"></i> Active</td>
                            <td>2 hours ago</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn btn-edit" onclick="editUser(1)">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="action-btn btn-reset" onclick="resetPassword(1)">
                                        <i class="fas fa-key"></i> Reset
                                    </button>
                                    <button class="action-btn btn-delete" onclick="deleteUser(1)">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!--Add/Edit User Modal-->
            <div id="userModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 id="modalTitle">Add New User</h2>
                        <button class="close-btn" on-click="closeUserModal()">&times;</button>
                    </div>
                    <form id="userForm">
                        <div class="form-grid">
                            <div class="form-group">
                                <label> First Name*</label>
                                <input type="text" class="form-input" id="firstname" name="firstname" required>
                            </div>  
                            <div class="form-group">
                                <label> Last Name*</label>
                                <input type="text" class="form-input" id="lastname" name="lastname" required>
                            </div> 
                            <div class="form-group">
                                <label> Email*</label>
                                <input type="text" class="form-input" id="email" name="email" required>
                            </div> 
                            <div class="form-group">
                                <label>Phone*</label>
                                <input type="text" class="form-input" id="phone" name="phone" required>
                            </div> 
                            <div class="form-group">
                                <label>Role *</label>
                                <select class="form-input" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="hospital_administrator">Administrator</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="nurse">Nurse</option>
                                    <option value="receptionist">Receptionist</option>
                                    <option value="laboratory_staff">Laboratory Staff</option>
                                    <option value="pharmacist">Pharmacist</option>
                                    <option value="accountant">Accountant</option>
                                    <option value="it_staff">IT Staff</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Department</label>
                                <select class="form-input" id="department" name="department" required>
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
                          <div class="form-group full-width">
                            <label>Permission</label>
                                <div class="checkbox-group">
                                    <div class="checkbox-item">
                                        <input type="checkbox">
                                        <label for="perm-read">Read Access</label>
                                    </div>
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="perm-write" value="write">
                                        <label for="perm-write">Write Access</label>
                                    </div>
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="perm-delete" value="delete">
                                        <label for="perm-delete">Delete Access</label>
                                    </div>
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="perm-admin" value="admin">
                                        <label for="perm-admin">Admin Access</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="display:flex;gap:1rem;justify-content:flex-end;margin-top:2rem;">
                            <button type="button" class="btn btn-secondary" onclick="closeUserModal()">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save User</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                //Modal Functions
                function openAddUserModal() {
                    document.getElementById('modalTitle').textContent = 'Add New User';
                    document.getElementById('userForm').reset();
                    document.getElementById('userModal').style.display = 'block';
                }
                 function closeUserModal() {
            document.getElementById('userModal').style.display = 'none';
        }

                function editUser(userId) {
                    document.getElementById('modalTitle').textContent = 'Edit User';
                    // Pre-populate form with user data
                    document.getElementById('userModal').style.display = 'block';
                }

                function deleteUser(userId) {
                    if (confirm('Are you sure you want to delete this user?')) {
                        alert('User deleted successfully');
                    }
                }

                function resetPassword(userId) {
                    if (confirm('Are you sure you want to reset this user\'s password?')) {
                        alert('Password reset email sent');
                    }
                }

                function exportUsers() {
                    alert('Exporting users to CSV...');
                }

                function bulkActions() {
                    const selected = document.querySelectorAll('.user-checkbox:checked');
                    if (selected.length === 0) {
                        alert('Please select users first');
                        return;
                    }
                    alert(`Bulk actions for ${selected.length} selected users`);
                }

                //Select All Functionality
                 document.getElementById('selectAll').addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.user-checkbox');
                    checkboxes.forEach(cb => cb.checked = this.checked);
                });       
                //Search and Filter Functionality
                document.getElementById('searchInput').addEventListener('input', filterUsers);
                    document.getElementById('roleFilter').addEventListener('change', filterUsers);
                    document.getElementById('statusFilter').addEventListener('change', filterUsers);

                    function filterUsers() {
                        // Implement filtering logic here
                        console.log('Filtering users...');
                    }

                //Form Submission
                document.getElementById('userForm').addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const userData = {
                        first_name: formData.get('firstName') || document.getElementById('firstName').value,
                        last_name: formData.get('lastName') || document.getElementById('lastName').value,
                        email: formData.get('email') || document.getElementById('email').value,
                        phone: formData.get('phone') || document.getElementById('phone').value,
                        role: formData.get('role') || document.getElementById('role').value,
                        department: formData.get('department') || document.getElementById('department').value
                    };

                //Validate Required Fields
                if (!userData.first_name || !userData.last_name || !userData.email || !userData.role) {
                        showNotification('Please fill in all required fields', 'error');
                        return;
                    }
                //Validate Email Format
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(userData.email)) {
                        showNotification('Please enter a valid email address', 'error');
                        return;
                    }

                    try {
                        showLoading(true);
                        
                        const response = await fetch('/api/users', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(userData)
                        });

                        const result = await response.json();

                        if (response.ok && result.status === 'success') {
                            showNotification('User created successfully! Temporary password: ' + result.temp_password, 'success');
                            closeUserModal();
                            loadUsers(); // Refresh the user list
                            updateUserStats(); // Update statistics
                        } else {
                            const errorMsg = result.message || 'Failed to create user';
                            showNotification(errorMsg, 'error');
                        }
                    } catch (error) {
                        console.error('Error creating user:', error);
                        showNotification('Network error. Please try again.', 'error');
                    } finally {
                        showLoading(false);
                    }
                });    
                // Close modal when clicking outside
                window.addEventListener('click', function(e) {
                    const modal = document.getElementById('userModal');
                    if (e.target === modal) {
                        closeUserModal();
                    }
                }); 
                
                // Utility functions
                function showNotification(message, type = 'info') {
                    // Create notification element
                    const notification = document.createElement('div');
                    notification.className = `notification notification-${type}`;
                    notification.innerHTML = `
                        <div class="notification-content">
                            <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
                            <span>${message}</span>
                            <button class="notification-close" onclick="this.parentElement.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                 // Add styles if not already present
            if (!document.getElementById('notification-styles')) {
                const styles = document.createElement('style');
                styles.id = 'notification-styles';
                styles.textContent = `
                    .notification {
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        min-width: 300px;
                        max-width: 500px;
                        padding: 1rem;
                        border-radius: 8px;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                        z-index: 10000;
                        animation: slideIn 0.3s ease-out;
                    }
                    .notification-success { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
                    .notification-error { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }
                    .notification-info { background: #d1ecf1; color: #0c5460; border-left: 4px solid #17a2b8; }
                    .notification-content { display: flex; align-items: center; gap: 0.5rem; }
                    .notification-close { background: none; border: none; cursor: pointer; margin-left: auto; }
                    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
                `;
                document.head.appendChild(styles);
            }
            
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

        function showLoading(show) {
            let loader = document.getElementById('loading-overlay');
            if (show) {
                if (!loader) {
                    loader = document.createElement('div');
                    loader.id = 'loading-overlay';
                    loader.innerHTML = `
                        <div class="loading-spinner">
                            <i class="fas fa-spinner fa-spin"></i>
                            <span>Processing...</span>
                        </div>
                    `;
                    
                    // Add loading styles
                    const styles = document.createElement('style');
                    styles.textContent = `
                        #loading-overlay {
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background: rgba(0,0,0,0.5);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            z-index: 10001;
                        }
                        .loading-spinner {
                            background: white;
                            padding: 2rem;
                            border-radius: 8px;
                            text-align: center;
                            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                        }
                        .loading-spinner i {
                            font-size: 2rem;
                            color: #3b82f6;
                            margin-bottom: 1rem;
                        }
                    `;
                    document.head.appendChild(styles);
                    document.body.appendChild(loader);
                }
                loader.style.display = 'flex';
            } else {
                if (loader) {
                    loader.style.display = 'none';
                }
            }
        }

        async function loadUsers() {
            try {
                const response = await fetch('/api/users');
                const result = await response.json();
                
                if (response.ok && result.status === 'success') {
                    updateUsersTable(result.data);
                } else {
                    console.error('Failed to load users:', result.message);
                }
            } catch (error) {
                console.error('Error loading users:', error);
            }
        }

        async function updateUserStats() {
            try {
                const response = await fetch('/api/users/statistics');
                const result = await response.json();
                
                if (response.ok && result.status === 'success') {
                    const stats = result.data;
                    document.querySelector('.dashboard-grid .card:nth-child(1) .stat-number').textContent = stats.total_users || 0;
                    document.querySelector('.dashboard-grid .card:nth-child(2) .stat-number').textContent = stats.active_users || 0;
                    document.querySelector('.dashboard-grid .card:nth-child(3) .stat-number').textContent = stats.inactive_users || 0;
                    document.querySelector('.dashboard-grid .card:nth-child(4) .stat-number').textContent = stats.admin_users || 0;
                }
            } catch (error) {
                console.error('Error updating stats:', error);
            }
        }

        function updateUsersTable(users) {
            const tbody = document.getElementById('usersTableBody');
            tbody.innerHTML = '';
            
            users.forEach(user => {
                const row = document.createElement('tr');
                row.className = 'user-row';
                row.innerHTML = `
                    <td><input type="checkbox" class="user-checkbox" data-user-id="${user.id}"></td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div class="user-avatar">${getInitials(user.first_name, user.last_name)}</div>
                            <div>
                                <div style="font-weight: 600;">${user.first_name} ${user.last_name}</div>
                                <div style="font-size: 0.8rem; color: #6b7280;">${user.email}</div>
                                <div style="font-size: 0.8rem; color: #6b7280;">ID: ${user.user_id}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="role-badge role-${user.role.replace('_', '-')}">${formatRole(user.role)}</span></td>
                    <td>${user.department || 'N/A'}</td>
                    <td><i class="fas fa-circle status-${user.status}"></i> ${formatStatus(user.status)}</td>
                    <td>${formatLastLogin(user.last_login)}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn btn-edit" onclick="editUser(${user.id})">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="action-btn btn-reset" onclick="resetPassword(${user.id})">
                                <i class="fas fa-key"></i> Reset
                            </button>
                            <button class="action-btn btn-delete" onclick="deleteUser(${user.id})">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        function getInitials(firstName, lastName) {
            return (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();
        }

        function formatRole(role) {
            return role.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        }

        function formatStatus(status) {
            return status.charAt(0).toUpperCase() + status.slice(1);
        }

        function formatLastLogin(lastLogin) {
            if (!lastLogin) return 'Never';
            const date = new Date(lastLogin);
            const now = new Date();
            const diffMs = now - date;
            const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
            
            if (diffHours < 1) return 'Just now';
            if (diffHours < 24) return `${diffHours} hours ago`;
            return date.toLocaleDateString();
        }

        // Enhanced delete function with API integration
        async function deleteUser(userId) {
            if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                return;
            }

            try {
                showLoading(true);
                const response = await fetch(`/api/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok && result.status === 'success') {
                    showNotification('User deleted successfully', 'success');
                    loadUsers();
                    updateUserStats();
                } else {
                    showNotification(result.message || 'Failed to delete user', 'error');
                }
            } catch (error) {
                console.error('Error deleting user:', error);
                showNotification('Network error. Please try again.', 'error');
            } finally {
                showLoading(false);
            }
        }

        // Enhanced reset password function
        async function resetPassword(userId) {
            if (!confirm('Are you sure you want to reset this user\'s password?')) {
                return;
            }

            try {
                showLoading(true);
                const response = await fetch(`/api/users/${userId}/reset-password`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok && result.status === 'success') {
                    showNotification(`Password reset successfully! New password: ${result.temp_password}`, 'success');
                } else {
                    showNotification(result.message || 'Failed to reset password', 'error');
                }
            } catch (error) {
                console.error('Error resetting password:', error);
                showNotification('Network error. Please try again.', 'error');
            } finally {
                showLoading(false);
            }
        }

        // Load initial data
        document.addEventListener('DOMContentLoaded', function() {
            loadUsers();
            updateUserStats();
        });

        // Logout functionality
        document.querySelector('.logout-btn').addEventListener('click', function() {
            if(confirm('Are you sure you want to logout?')) {
                window.location.href = '/auth/login';
            }
        });

    </script>

        </main>
    </div>
</body>
</html>