
        // Simple navigation functionality - removed preventDefault to allow page navigation

        // Logout functionality
        document.querySelector('.logout-btn').addEventListener('click', function() {
            if(confirm('Are you sure you want to logout?')) {
                window.location.href = '/auth/logout';
            }
        });
