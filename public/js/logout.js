// Centralized logout functionality for all pages
// This version derives the correct base URL (including host, port, and subdirectory)
// from the script's own absolute URL to avoid hardcoded paths.
(function () {
    function getBaseUrlFromScript() {
        // Try to locate this script tag
        var script = document.currentScript;
        if (!script) {
            var scripts = document.getElementsByTagName('script');
            for (var i = 0; i < scripts.length; i++) {
                if (scripts[i].src && scripts[i].src.indexOf('/js/logout.js') !== -1) {
                    script = scripts[i];
                    break;
                }
            }
        }

        try {
            var url = new URL(script && script.src ? script.src : window.location.href, window.location.href);
            // Remove trailing 'js/logout.js' from pathname and ensure trailing '/'
            var basePath = url.pathname.replace(/\/?js\/logout\.js$/i, '/');
            if (basePath.slice(-1) !== '/') basePath += '/';
            return url.origin + basePath;
        } catch (e) {
            // Fallback: use current origin and root path
            return window.location.origin + '/';
        }
    }

    var BASE_URL = getBaseUrlFromScript();

    // Expose handleLogout globally so inline onclick handlers can call it
    window.handleLogout = function () {
        if (confirm('Are you sure you want to logout?')) {
            try { sessionStorage.clear(); } catch (e) {}
            try { localStorage.clear(); } catch (e) {}
            // Redirect to the logout endpoint using the derived base URL
            window.location.href = BASE_URL + 'auth/logout';
        }
    };

    // Initialize logout functionality when DOM is loaded
    document.addEventListener('DOMContentLoaded', function () {
        var logoutBtn = document.querySelector('.logout-btn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', window.handleLogout);
        }
    });
})();
