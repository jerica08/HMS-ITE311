// Delete User Management JavaScript
console.log('delete-user.js loaded successfully!');

// Enhanced delete function with API integration
async function deleteUser(userId) {
    console.log('=== DELETE USER DEBUG ===');
    console.log('deleteUser called with userId:', userId, 'Type:', typeof userId);
    
    if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        console.log('User cancelled delete operation');
        return;
    }

    try {
        showLoading(true);
        
        console.log(`Sending DELETE request to /admin/users/${userId}`);
        
        const response = await fetch(`/admin/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json'
            }
        });

        console.log('Delete response status:', response.status);
        const result = await response.json();
        console.log('Delete server response:', result);

        if (response.ok && result.status === 'success') {
            showNotification('User deleted successfully', 'success');
            // Refresh the user list and stats
            if (typeof loadUsers === 'function') {
                loadUsers();
            }
            if (typeof updateUserStats === 'function') {
                updateUserStats();
            }
        } else {
            console.error('Delete failed:', result);
            showNotification(result.message || 'Failed to delete user', 'error');
        }
    } catch (error) {
        console.error('Error deleting user:', error);
        showNotification('Network error. Please try again.', 'error');
    } finally {
        showLoading(false);
    }
}

// Enhanced reset password function
async function resetPassword(userId) {
    console.log('=== RESET PASSWORD DEBUG ===');
    console.log('resetPassword called with userId:', userId, 'Type:', typeof userId);
    
    if (!confirm('Are you sure you want to reset this user\'s password?')) {
        console.log('User cancelled password reset operation');
        return;
    }

    try {
        showLoading(true);
        
        console.log(`Sending POST request to /admin/users/${userId}/reset-password`);
        
        const response = await fetch(`/admin/users/${userId}/reset-password`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json'
            }
        });

        console.log('Reset password response status:', response.status);
        const result = await response.json();
        console.log('Reset password server response:', result);

        if (response.ok && result.status === 'success') {
            showNotification(`Password reset successfully! New password: ${result.temp_password}`, 'success');
        } else {
            console.error('Password reset failed:', result);
            showNotification(result.message || 'Failed to reset password', 'error');
        }
    } catch (error) {
        console.error('Error resetting password:', error);
        showNotification('Network error. Please try again.', 'error');
    } finally {
        showLoading(false);
    }
}

// Bulk delete functionality
async function bulkDeleteUsers() {
    const selectedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
    
    if (selectedCheckboxes.length === 0) {
        showNotification('Please select users to delete', 'error');
        return;
    }
    
    const userIds = Array.from(selectedCheckboxes).map(cb => cb.getAttribute('data-user-id'));
    console.log('Bulk delete user IDs:', userIds);
    
    if (!confirm(`Are you sure you want to delete ${userIds.length} selected users? This action cannot be undone.`)) {
        return;
    }
    
    try {
        showLoading(true);
        
        // Delete users one by one
        let successCount = 0;
        let errorCount = 0;
        
        for (const userId of userIds) {
            try {
                const response = await fetch(`/admin/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (response.ok && result.status === 'success') {
                    successCount++;
                } else {
                    errorCount++;
                    console.error(`Failed to delete user ${userId}:`, result);
                }
            } catch (error) {
                errorCount++;
                console.error(`Error deleting user ${userId}:`, error);
            }
        }
        
        // Show results
        if (successCount > 0) {
            showNotification(`Successfully deleted ${successCount} users`, 'success');
        }
        if (errorCount > 0) {
            showNotification(`Failed to delete ${errorCount} users`, 'error');
        }
        
        // Refresh the user list and stats
        if (typeof loadUsers === 'function') {
            loadUsers();
        }
        if (typeof updateUserStats === 'function') {
            updateUserStats();
        }
        
        // Uncheck select all checkbox
        const selectAllCheckbox = document.getElementById('selectAll');
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = false;
        }
        
    } catch (error) {
        console.error('Error in bulk delete:', error);
        showNotification('Network error during bulk delete', 'error');
    } finally {
        showLoading(false);
    }
}

// Enhanced bulk actions with delete option
function bulkActions() {
    const selected = document.querySelectorAll('.user-checkbox:checked');
    if (selected.length === 0) {
        showNotification('Please select users first', 'error');
        return;
    }
    
    // Create a simple action menu
    const actions = [
        { label: 'Delete Selected Users', action: 'delete', icon: 'fas fa-trash' },
        { label: 'Export Selected Users', action: 'export', icon: 'fas fa-download' },
        { label: 'Bulk Reset Passwords', action: 'reset', icon: 'fas fa-key' }
    ];
    
    // Simple prompt for now - could be enhanced with a proper modal
    const actionChoice = prompt(
        `Selected ${selected.length} users. Choose action:\n` +
        '1 - Delete Selected Users\n' +
        '2 - Export Selected Users\n' +
        '3 - Bulk Reset Passwords\n' +
        'Enter number (1-3):'
    );
    
    switch (actionChoice) {
        case '1':
            bulkDeleteUsers();
            break;
        case '2':
            exportSelectedUsers();
            break;
        case '3':
            bulkResetPasswords();
            break;
        default:
            showNotification('Invalid selection', 'error');
    }
}

// Export selected users functionality
function exportSelectedUsers() {
    const selected = document.querySelectorAll('.user-checkbox:checked');
    const userIds = Array.from(selected).map(cb => cb.getAttribute('data-user-id'));
    
    console.log('Exporting selected users:', userIds);
    showNotification(`Exporting ${userIds.length} selected users...`, 'info');
    
    // TODO: Implement actual export functionality
    setTimeout(() => {
        showNotification('Export functionality coming soon!', 'info');
    }, 1000);
}

// Bulk reset passwords functionality
async function bulkResetPasswords() {
    const selected = document.querySelectorAll('.user-checkbox:checked');
    const userIds = Array.from(selected).map(cb => cb.getAttribute('data-user-id'));
    
    if (!confirm(`Reset passwords for ${userIds.length} selected users?`)) {
        return;
    }
    
    try {
        showLoading(true);
        let successCount = 0;
        let errorCount = 0;
        
        for (const userId of userIds) {
            try {
                const response = await fetch(`/admin/users/${userId}/reset-password`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (response.ok && result.status === 'success') {
                    successCount++;
                } else {
                    errorCount++;
                }
            } catch (error) {
                errorCount++;
                console.error(`Error resetting password for user ${userId}:`, error);
            }
        }
        
        if (successCount > 0) {
            showNotification(`Successfully reset ${successCount} passwords`, 'success');
        }
        if (errorCount > 0) {
            showNotification(`Failed to reset ${errorCount} passwords`, 'error');
        }
        
    } catch (error) {
        console.error('Error in bulk password reset:', error);
        showNotification('Network error during bulk password reset', 'error');
    } finally {
        showLoading(false);
    }
}
