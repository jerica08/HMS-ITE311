
// Centralized logout functionality for all admin pages
function handleLogout() {
    if(confirm('Are you sure you want to logout?')) {
        // Clear any session data
        sessionStorage.clear();
        localStorage.clear();
        
        // Redirect to logout endpoint
        window.location.href = '/auth/logout';
    }
}

// Initialize logout functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const logoutBtn = document.querySelector('.logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', handleLogout);
    }
});
