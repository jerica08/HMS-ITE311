// Admin Dashboard JavaScript Functions
console.log('Admin dashboard JS loaded');

// Function to fetch and update dashboard metrics
async function updateDashboardMetrics() {
    try {
        console.log('Fetching dashboard metrics...');

        // Fetch user statistics
        const userStatsResponse = await fetch('/admin/users/statistics', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin' // Include cookies for session authentication
        });

        if (userStatsResponse.ok) {
            const userStats = await userStatsResponse.json();
            console.log('User statistics:', userStats);

            if (userStats.status === 'success') {
                // Update user management card
                document.getElementById('totalUsers').textContent = userStats.data.total_users || 0;
                document.getElementById('activeRoles').textContent = userStats.data.active_users || 0;
                document.getElementById('pendingUsers').textContent = userStats.data.inactive_users || 0;
                console.log('User stats loaded:', userStats.data);
            }
        } else {
            console.error('Failed to fetch user statistics:', userStatsResponse.status);
            const errorText = await userStatsResponse.text();
            console.error('Error response:', errorText);
        }

        // Fetch additional metrics (patients, visits, revenue, etc.)
        // For now, we'll use placeholder/mock data for other cards
        // In a real implementation, you'd have API endpoints for these

        // Update system analytics card (mock data for now)
        document.getElementById('totalPatients').textContent = '1,847'; // Replace with real API call
        document.getElementById('todaysVisits').textContent = '342'; // Replace with real API call
        document.getElementById('revenue').textContent = '$47K'; // Replace with real API call

        // Update security card (mock data for now)
        document.getElementById('activeSessions').textContent = '156'; // Replace with real API call
        document.getElementById('failedLogins').textContent = '3'; // Replace with real API call
        document.getElementById('securityScore').textContent = '99.9%'; // Replace with real API call

    } catch (error) {
        console.error('Error updating dashboard metrics:', error);
        // Set fallback values if API fails
        document.getElementById('totalUsers').textContent = '0';
        document.getElementById('activeRoles').textContent = '0';
        document.getElementById('pendingUsers').textContent = '0';
    }
}
// Modal Functions
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

// Initialize dashboard on page load
document.addEventListener('DOMContentLoaded', function() {
    // Update dashboard metrics on page load
    updateDashboardMetrics();

    // Set up real-time updates every 30 seconds
    setInterval(updateDashboardMetrics, 30000);
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
                console.log('Response headers:', response.headers);

                const result = await response.json();
                console.log('Server response:', result);

                if (response.ok && result.status === 'success') {
                    showNotification('User created successfully!', 'success');
                    closeUserModal();
                    // Redirect to user management page to see the new user
                    setTimeout(() => {
                        window.location.href = '/admin/users';
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

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('userModal');
        if (e.target === modal) {
            closeUserModal();
        }
    });
});

// Handle logout functionality
function handleLogout() {
    if (window.sessionManager) {
        window.sessionManager.logout();
    } else {
        // Fallback if session manager is not available
        window.location.href = '/auth/logout';
    }
}
