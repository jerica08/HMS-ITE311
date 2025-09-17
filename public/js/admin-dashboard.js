// Admin Dashboard JavaScript Functions
console.log('Admin dashboard JS loaded');

// Function to fetch and update dashboard metrics
async function updateDashboardMetrics() {
    try {
        console.log('Fetching dashboard metrics...');

        // Skip user statistics update - let PHP handle it
        // The user stats are already loaded from PHP in the dashboard
       
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
        // Don't override user stats on error - let PHP values remain
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
