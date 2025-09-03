// Debug: Confirm users.js is loaded
console.log('users.js loaded successfully!');

//Modal Functions
function openAddUserModal() {
    console.log('Opening add user modal');
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
        first_name: formData.get('first_name') || document.getElementById('first_name').value,
        last_name: formData.get('last_name') || document.getElementById('last_name').value,
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
        
        const response = await fetch('/admin/users', {
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
        const response = await fetch('/admin/users/api');
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

// Load initial data
document.addEventListener('DOMContentLoaded', function() {
    loadUsers();
    updateUserStats();
});

document.querySelector('.logout-btn').addEventListener('click', function() {
    if(confirm('Are you sure you want to logout?')) {
        window.location.href = '/auth/logout';
    }
});
