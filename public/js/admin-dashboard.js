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

// Initialize dashboard on page load
document.addEventListener('DOMContentLoaded', function() {
    // Update dashboard metrics on page load
    updateDashboardMetrics();

    // Set up real-time updates every 30 seconds
    setInterval(updateDashboardMetrics, 30000);
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
