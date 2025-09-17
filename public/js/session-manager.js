// Session Management JavaScript
console.log('Session manager loaded');

class SessionManager {
    constructor() {
        this.sessionKey = 'hms_session_active';
        this.init();
    }

    init() {
        // Mark session as active when page loads
        this.markSessionActive();
        
        // Handle beforeunload event (tab/browser close)
        this.handleBeforeUnload();
        
        // Handle page unload event
        this.handleUnload();
    }

    markSessionActive() {
        sessionStorage.setItem(this.sessionKey, Date.now().toString());
        localStorage.setItem(this.sessionKey + '_browser', Date.now().toString());
    }

    handleBeforeUnload() {
        window.addEventListener('beforeunload', (event) => {
            // Only clear session if user is actually leaving the site
            // Check if it's a page refresh or navigation within the same domain
            const isPageRefresh = event.persisted || (window.performance && window.performance.navigation.type === 1);
            const isInternalNavigation = document.referrer && document.referrer.includes(window.location.hostname);
            
            // Don't clear session for internal navigation or page refresh
            if (!isPageRefresh && !isInternalNavigation) {
                // Mark that we're potentially leaving the site
                sessionStorage.setItem(this.sessionKey + '_leaving', Date.now().toString());
                
                // Use a timeout to check if we're really leaving
                setTimeout(() => {
                    const leavingTime = sessionStorage.getItem(this.sessionKey + '_leaving');
                    if (leavingTime && (Date.now() - parseInt(leavingTime)) > 100) {
                        // We're really leaving, send logout beacon
                        navigator.sendBeacon('/auth/logout-beacon', JSON.stringify({
                            action: 'tab_close',
                            timestamp: Date.now()
                        }));
                    }
                }, 150);
            }
        });
    }

    handleUnload() {
        window.addEventListener('unload', () => {
            // Only clear session storage if we're actually leaving the site
            const leavingTime = sessionStorage.getItem(this.sessionKey + '_leaving');
            if (leavingTime) {
                sessionStorage.removeItem(this.sessionKey);
                sessionStorage.removeItem(this.sessionKey + '_leaving');
            }
        });
    }

    // Method to manually logout
    async logout() {
        try {
            const response = await fetch('/auth/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            });

            // Clear session data regardless of response
            sessionStorage.clear();
            localStorage.removeItem(this.sessionKey + '_browser');

            // Redirect to login
            window.location.href = '/login?reason=logout';
        } catch (error) {
            console.error('Logout error:', error);
            // Force redirect even if logout request failed
            window.location.href = '/login?reason=logout';
        }
    }
}

// Initialize session manager when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Only initialize on pages that require authentication
    const currentPath = window.location.pathname;
    const publicPaths = ['/login', '/register', '/'];
    
    if (!publicPaths.includes(currentPath)) {
        window.sessionManager = new SessionManager();
    }
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = SessionManager;
}
