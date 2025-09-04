// Edit User Management JavaScript
console.log('edit-user.js loaded successfully!');

// Open Add User Modal Function
function openAddUserModal() {
    console.log('Opening add user modal');
    document.getElementById('modalTitle').textContent = 'Add New User';
    document.getElementById('userForm').reset();
    // Clear any existing data-user-id attribute for create mode
    document.getElementById('userForm').removeAttribute('data-user-id');
    document.getElementById('userModal').style.display = 'block';
}

// Enhanced editUser function with full functionality
async function editUser(userId) {
    console.log('Editing user with ID:', userId);
    
    try {
        showLoading(true);
        
        // Fetch user data from server
        const response = await fetch(`/admin/users/${userId}`);
        const result = await response.json();
        
        if (response.ok && result.status === 'success') {
            const user = result.data;
            console.log('User data loaded for editing:', user);
            
            // Set modal title and form data attribute for edit mode
            document.getElementById('modalTitle').textContent = 'Edit User';
            document.getElementById('userForm').setAttribute('data-user-id', userId);
            
            // Populate form fields
            document.getElementById('first_name').value = user.first_name || '';
            document.getElementById('last_name').value = user.last_name || '';
            document.getElementById('email').value = user.email || '';
            document.getElementById('phone').value = user.phone || '';
            document.getElementById('role').value = user.role || '';
            document.getElementById('department').value = user.department || '';
            
            // Show modal
            document.getElementById('userModal').style.display = 'block';
        } else {
            console.error('Failed to load user data:', result);
            showNotification(result.message || 'Failed to load user data', 'error');
        }
    } catch (error) {
        console.error('Error loading user data:', error);
        showNotification('Network error. Please try again.', 'error');
    } finally {
        showLoading(false);
    }
}

// Enhanced delete function with API integration
async function deleteUser(userId) {
    if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        return;
    }

    try {
        showLoading(true);
        
        const response = await fetch(`/admin/users/${userId}`, {
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
        const response = await fetch(`/admin/users/${userId}/reset-password`, {
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

// Load users from API
async function loadUsers() {
    try {
        const response = await fetch('/admin/users/api');
        const result = await response.json();
        
        if (response.ok && result.status === 'success') {
            console.log('User data received:', result.data);
            if (result.data.length > 0) {
                console.log('First user object structure:', result.data[0]);
                console.log('Available fields:', Object.keys(result.data[0]));
            }
            updateUsersTable(result.data);
        } else {
            console.error('Failed to load users:', result.message);
        }
    } catch (error) {
        console.error('Error loading users:', error);
    }
}

// Update user statistics
async function updateUserStats() {
    try {
        const response = await fetch('/admin/users/statistics');
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

// Update users table with dynamic ID handling
function updateUsersTable(users) {
    const tbody = document.getElementById('usersTableBody');
    tbody.innerHTML = '';
    
    users.forEach(user => {
        // Use the correct ID field - try multiple possible field names
        const userId = user.id || user.user_id || user.ID;
        const displayId = user.user_id || user.employee_id || user.id || 'N/A';
        
        const row = document.createElement('tr');
        row.className = 'user-row';
        row.innerHTML = `
            <td><input type="checkbox" class="user-checkbox" data-user-id="${userId}"></td>
            <td>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div class="user-avatar">${getInitials(user.first_name, user.last_name)}</div>
                    <div>
                        <div style="font-weight: 600;">${user.first_name} ${user.last_name}</div>
                        <div style="font-size: 0.8rem; color: #6b7280;">${user.email}</div>
                        <div style="font-size: 0.8rem; color: #6b7280;">ID: ${displayId}</div>
                    </div>
                </div>
            </td>
            <td><span class="role-badge role-${user.role.replace('_', '-')}">${formatRole(user.role)}</span></td>
            <td>${user.department || 'N/A'}</td>
            <td><i class="fas fa-circle status-${user.status}"></i> ${formatStatus(user.status)}</td>
            <td>${formatLastLogin(user.last_login)}</td>
            <td>
                <div class="action-buttons">
                    <button class="action-btn btn-edit" onclick="editUser(${userId})">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="action-btn btn-reset" onclick="resetPassword(${userId})">
                        <i class="fas fa-key"></i> Reset
                    </button>
                    <button class="action-btn btn-delete" onclick="deleteUser(${userId})">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Utility functions for formatting
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

// Search and filter functionality
function filterUsers() {
    console.log('Filtering users...');
    // Implement filtering logic here
}

// Bulk actions functionality
function bulkActions() {
    const selected = document.querySelectorAll('.user-checkbox:checked');
    if (selected.length === 0) {
        alert('Please select users first');
        return;
    }
    alert(`Bulk actions for ${selected.length} selected users`);
}

// Export users functionality
function exportUsers() {
    alert('Exporting users to CSV...');
}

// Form submission handler for edit mode
document.addEventListener('DOMContentLoaded', function() {
    // Load initial data
    loadUsers();
    updateUserStats();
    
    // Select all functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.user-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    }
    
    // Search and filter event listeners
    const searchInput = document.getElementById('searchInput');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    
    if (searchInput) searchInput.addEventListener('input', filterUsers);
    if (roleFilter) roleFilter.addEventListener('change', filterUsers);
    if (statusFilter) statusFilter.addEventListener('change', filterUsers);
    
    // Form submission for edit mode
    const userForm = document.getElementById('userForm');
    if (userForm) {
        userForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            console.log('=== FORM SUBMISSION DEBUG ===');
            console.log('Form element:', this);
            console.log('Form attributes:', this.attributes);
            console.log('All form attributes:');
            for (let i = 0; i < this.attributes.length; i++) {
                const attr = this.attributes[i];
                console.log(`  ${attr.name}: ${attr.value}`);
            }
            
            const userId = this.getAttribute('data-user-id');
            const isEditMode = !!userId;
            
            console.log('Form submission - Edit mode:', isEditMode, 'User ID:', userId);
            console.log('UserId type:', typeof userId);
            console.log('UserId truthy check:', !!userId);
            
            const formData = new FormData(this);
            const userData = {
                first_name: formData.get('first_name') || document.getElementById('first_name').value,
                last_name: formData.get('last_name') || document.getElementById('last_name').value,
                email: formData.get('email') || document.getElementById('email').value,
                phone: formData.get('phone') || document.getElementById('phone').value,
                role: formData.get('role') || document.getElementById('role').value,
                department: formData.get('department') || document.getElementById('department').value
            };

            console.log('Form data being sent:', userData);

            // Different validation for create vs edit mode
            if (isEditMode) {
                // For edit mode, at least one field should be provided
                const hasData = Object.values(userData).some(value => value && value.trim() !== '');
                if (!hasData) {
                    console.error('Validation failed: No data to update');
                    showNotification('Please provide at least one field to update', 'error');
                    return;
                }
                
                // Validate email format only if email is provided
                if (userData.email && userData.email.trim() !== '') {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(userData.email)) {
                        console.error('Validation failed: Invalid email format');
                        showNotification('Please enter a valid email address', 'error');
                        return;
                    }
                }
                
                // Remove empty fields for partial update
                Object.keys(userData).forEach(key => {
                    if (!userData[key] || userData[key].trim() === '') {
                        delete userData[key];
                    }
                });
            } else {
                // For create mode, validate required fields
                if (!userData.first_name || !userData.last_name || !userData.email || !userData.role) {
                    console.error('Validation failed: Missing required fields');
                    showNotification('Please fill in all required fields', 'error');
                    return;
                }
                
                // Validate email format
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(userData.email)) {
                    console.error('Validation failed: Invalid email format');
                    showNotification('Please enter a valid email address', 'error');
                    return;
                }
            }

            try {
                showLoading(true);
                
                const url = isEditMode ? `/admin/users/${userId}` : '/admin/users';
                const method = isEditMode ? 'PUT' : 'POST';
                
                console.log(`Sending ${method} request to ${url} with data:`, JSON.stringify(userData));
                
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(userData)
                });

                console.log('Response status:', response.status);
                const result = await response.json();
                console.log('Server response:', result);

                if (response.ok && result.status === 'success') {
                    const successMsg = isEditMode ? 'User updated successfully!' : 'User created successfully! Temporary password: ' + result.temp_password;
                    showNotification(successMsg, 'success');
                    closeUserModal();
                    loadUsers(); // Refresh the user list
                    updateUserStats(); // Update statistics
                } else {
                    const errorMsg = result.message || (isEditMode ? 'Failed to update user' : 'Failed to create user');
                    console.error('Server response:', result);
                    if (result.errors) {
                        console.error('Validation errors:', result.errors);
                        const errorList = Object.values(result.errors).join(', ');
                        showNotification(`Validation failed: ${errorList}`, 'error');
                    } else {
                        showNotification(errorMsg, 'error');
                    }
                }
            } catch (error) {
                console.error('Network error:', error);
                showNotification('Network error. Please try again.', 'error');
            } finally {
                showLoading(false);
            }
        });
    }
    
    // Logout functionality
    const logoutBtn = document.querySelector('.logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            if(confirm('Are you sure you want to logout?')) {
                window.location.href = '/auth/logout';
            }
        });
    }
});
