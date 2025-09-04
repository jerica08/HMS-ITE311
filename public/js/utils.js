// Shared utility functions for HMS application
console.log('Utils.js loaded');

// Modal Functions
function closeUserModal() {
    document.getElementById('userModal').style.display = 'none';
    // Clear form data attribute when closing
    const form = document.getElementById('userForm');
    if (form) {
        form.removeAttribute('data-user-id');
    }
}

// Close modal when clicking outside
window.addEventListener('click', function(e) {
    const modal = document.getElementById('userModal');
    if (modal && e.target === modal) {
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
