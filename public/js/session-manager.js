// Session Management JavaScript
console.log('Session manager loaded');

class SessionManager {
    constructor() {
        this.sessionKey = 'hms_session_active';
        this.heartbeatInterval = null;
        this.heartbeatFrequency = 30000; // 30 seconds
        this.init();
    }

    init() {
        // Mark session as active when page loads
        this.markSessionActive();
        
        // Start heartbeat to keep session alive while user is active
        this.startHeartbeat();
        
        // Handle page visibility changes
        this.handleVisibilityChange();
        
        // Handle beforeunload event (tab/browser close)
        this.handleBeforeUnload();
        
        // Handle page unload event
        this.handleUnload();
        
        // Check session validity on page load
        this.checkSessionValidity();
    }

    markSessionActive() {
        sessionStorage.setItem(this.sessionKey, Date.now().toString());
        localStorage.setItem(this.sessionKey + '_browser', Date.now().toString());
    }

    startHeartbeat() {
        this.heartbeatInterval = setInterval(() => {
            if (document.visibilityState === 'visible') {
                this.sendHeartbeat();
            }
        }, this.heartbeatFrequency);
    }

    async sendHeartbeat() {
        try {
            const response = await fetch('/auth/heartbeat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                console.warn('Heartbeat failed, session may have expired');
                this.handleSessionExpired();
            } else {
                this.markSessionActive();
            }
        } catch (error) {
            console.error('Heartbeat error:', error);
        }
    }

    handleVisibilityChange() {
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') {
                // Page became visible, check if session is still valid
                this.checkSessionValidity();
            } else {
                // Page became hidden, stop heartbeat to save resources
                if (this.heartbeatInterval) {
                    clearInterval(this.heartbeatInterval);
                    this.heartbeatInterval = null;
                }
            }
        });
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

    async checkSessionValidity() {
        try {
            const response = await fetch('/auth/check-session', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (!response.ok || response.status === 401) {
                this.handleSessionExpired();
                return false;
            }

            const result = await response.json();
            if (!result.valid) {
                this.handleSessionExpired();
                return false;
            }

            // Session is valid, restart heartbeat if needed
            if (!this.heartbeatInterval && document.visibilityState === 'visible') {
                this.startHeartbeat();
            }

            return true;
        } catch (error) {
            console.error('Session check error:', error);
            return false;
        }
    }

    handleSessionExpired() {
        // Clear all session data
        sessionStorage.clear();
        localStorage.removeItem(this.sessionKey + '_browser');
        
        // Stop heartbeat
        if (this.heartbeatInterval) {
            clearInterval(this.heartbeatInterval);
            this.heartbeatInterval = null;
        }

        // Show notification and redirect to login
        this.showSessionExpiredNotification();
        
        // Redirect to login after a short delay
        setTimeout(() => {
            window.location.href = '/login?reason=session_expired';
        }, 2000);
    }

    showSessionExpiredNotification() {
        // Create and show notification
        const notification = document.createElement('div');
        notification.className = 'session-expired-notification';
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Your session has expired. You will be redirected to login.</span>
            </div>
        `;
        
        // Add styles
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 15px 20px;
            z-index: 10000;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            font-family: Arial, sans-serif;
            max-width: 300px;
        `;
        
        document.body.appendChild(notification);
        
        // Remove notification after 3 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 3000);
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
            
            if (this.heartbeatInterval) {
                clearInterval(this.heartbeatInterval);
                this.heartbeatInterval = null;
            }

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
