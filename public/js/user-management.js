// User Management JavaScript Functions
console.log('User management JS loaded');

// Function to update user statistics dynamically
async function updateUserStats() {
    try {
        console.log('Updating user statistics...');
        
        const response = await fetch('/admin/users/statistics', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin'
        });

        if (response.ok) {
            const result = await response.json();
            console.log('User statistics response:', result);
            
            if (result.status === 'success') {
                // Update the statistics cards
                const totalUsersElement = document.querySelector('.overview-card:nth-child(1) .metric-value');
                const activeUsersElement = document.querySelector('.overview-card:nth-child(2) .metric-value');
                const inactiveUsersElement = document.querySelector('.overview-card:nth-child(3) .metric-value');
                const adminUsersElement = document.querySelector('.overview-card:nth-child(4) .metric-value');
                
                if (totalUsersElement) totalUsersElement.textContent = result.data.total_users || 0;
                if (activeUsersElement) activeUsersElement.textContent = result.data.active_users || 0;
                if (inactiveUsersElement) inactiveUsersElement.textContent = result.data.inactive_users || 0;
                if (adminUsersElement) adminUsersElement.textContent = result.data.admin_users || 0;
                
                console.log('User statistics updated successfully');
            }
        } else {
            console.error('Failed to fetch user statistics:', response.status);
        }
    } catch (error) {
        console.error('Error updating user statistics:', error);
    }
}

// Toggle user status function
async function toggleUserStatus(userId, currentStatus) {
    try {
        const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
        const action = newStatus === 'active' ? 'activate' : 'deactivate';
        
        if (!confirm(`Are you sure you want to ${action} this user?`)) {
            return;
        }
        
        showLoading(true);
        
        const response = await fetch(`/admin/users/${userId}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: newStatus })
        });
        
        const result = await response.json();
        
        if (response.ok && result.status === 'success') {
            showNotification(`User ${action}d successfully!`, 'success');
            // Update statistics immediately
            updateUserStats();
            // Reload page to reflect changes
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showNotification(result.message || `Failed to ${action} user`, 'error');
        }
    } catch (error) {
        console.error('Error toggling user status:', error);
        showNotification('Network error. Please try again.', 'error');
    } finally {
        showLoading(false);
    }
}

// Modal functions
function openAddUserModal() {
    console.log('Opening add user modal');
    document.getElementById('modalTitle').textContent = 'Add New User';
    document.getElementById('userForm').reset();
    // Clear any existing data-user-id attribute for create mode
    document.getElementById('userForm').removeAttribute('data-user-id');
    document.getElementById('userModal').style.display = 'block';
}

function closeUserModal() {
    document.getElementById('userModal').style.display = 'none';
}

// Initialize user management functionality
document.addEventListener('DOMContentLoaded', function() {
    // Update stats immediately
    updateUserStats();
    
    // Update stats every 30 seconds
    setInterval(updateUserStats, 30000);
    
    // Handle form submission for adding/editing users
    const userForm = document.getElementById('userForm');
    if (userForm) {
        userForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const userData = {
                first_name: formData.get('first_name') || document.getElementById('first_name').value,
                last_name: formData.get('last_name') || document.getElementById('last_name').value,
                email: formData.get('email') || document.getElementById('email').value,
                phone: formData.get('phone') || document.getElementById('phone').value,
                password: formData.get('password') || document.getElementById('password').value,
                role: formData.get('role') || document.getElementById('role').value,
                department: formData.get('department') || document.getElementById('department').value
            };

            console.log('Form data being sent:', userData);

            // Validate Required Fields
            if (!userData.first_name || !userData.last_name || !userData.email || !userData.role || !userData.password) {
                console.error('Validation failed: Missing required fields');
                showNotification('Please fill in all required fields including password', 'error');
                return;
            }

            // Validate Email Format
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(userData.email)) {
                console.error('Validation failed: Invalid email format');
                showNotification('Please enter a valid email address', 'error');
                return;
            }

            // Validate password length
            if (userData.password && userData.password.length < 6) {
                console.error('Validation failed: Password too short');
                showNotification('Password must be at least 6 characters long', 'error');
                return;
            }

            // Validate password confirmation
            const confirmPassword = document.getElementById('confirm_password').value;
            if (userData.password !== confirmPassword) {
                console.error('Validation failed: Passwords do not match');
                showNotification('Passwords do not match', 'error');
                return;
            }

            try {
                showLoading(true);
                
                console.log('Sending POST request to /admin/users with data:', JSON.stringify(userData));
                
                const response = await fetch('/admin/users', {
                    method: 'POST',
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
                    showNotification('User created successfully!', 'success');
                    closeUserModal();
                    // Update statistics immediately after successful creation
                    updateUserStats();
                    // Reload the page to show the new user in the table
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
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
                console.error('Network error creating user:', error);
                showNotification('Network error. Please try again.', 'error');
            } finally {
                showLoading(false);
            }
        });
    }
});
