/**
 * Staff-User Integration JavaScript
 * Handles linking staff members to user accounts
 */

class StaffUserIntegration {
    constructor() {
        this.baseUrl = window.location.origin;
        this.init();
    }

    init() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setupEventListeners());
        } else {
            this.setupEventListeners();
        }
    }

    setupEventListeners() {
        // Load staff without accounts when page loads
        this.loadStaffWithoutAccounts();

        // Setup staff selection change handler (updated to staff_id)
        const staffDropdown = document.getElementById('staff_id');
        if (staffDropdown) {
            staffDropdown.addEventListener('change', (e) => this.handleStaffSelection(e));
        }

        // Setup form reset when modal opens
        const userModal = document.getElementById('userModal');
        if (userModal) {
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                        if (userModal.style.display !== 'none') {
                            this.loadStaffWithoutAccounts();
                        }
                    }
                });
            });
            observer.observe(userModal, { attributes: true });
        }
    }

    async loadStaffWithoutAccounts() {
        try {
            const response = await fetch(`${this.baseUrl}/admin/users/staff-without-accounts`);
            const data = await response.json();

            const dropdown = document.getElementById('staff_id');
            if (!dropdown) return;

            // Clear existing options
            dropdown.innerHTML = '<option value="">-- Select staff to link --</option>';

            if (data.status === 'success' && data.data && Array.isArray(data.data)) {
                data.data.forEach(staff => {
                    const option = document.createElement('option');
                    option.value = staff.id;
                    option.textContent = `${staff.last_name || ''}, ${staff.first_name || ''} (${staff.employee_id || 'No ID'})`;
                    // Provide both a JSON blob and discrete data-* attributes so any listener can work
                    option.dataset.staff = JSON.stringify(staff);
                    option.dataset.firstName = staff.first_name || '';
                    option.dataset.lastName = staff.last_name || '';
                    option.dataset.email = staff.email || '';
                    option.dataset.phone = staff.phone || '';
                    option.dataset.department = staff.department || '';
                    option.dataset.role = staff.role || '';
                    option.dataset.employeeId = staff.employee_id || '';
                    dropdown.appendChild(option);
                });

                console.log(`Loaded ${data.data.length} staff members without user accounts`);
            } else {
                console.log('No staff without accounts found');
            }
        } catch (error) {
            console.error('Error loading staff without accounts:', error);
            this.showNotification('Error loading staff members', 'error');
        }
    }

    handleStaffSelection(event) {
        const selectedOption = event.target.options[event.target.selectedIndex];
        
        if (selectedOption.dataset.staff) {
            const staff = JSON.parse(selectedOption.dataset.staff);
            this.populateFormWithStaffData(staff);
        } else {
            this.clearFormFields();
        }
    }

    populateFormWithStaffData(staff) {
        // Auto-fill hidden fields used by backend
        this.setFieldValue('first_name', staff.first_name);
        this.setFieldValue('last_name', staff.last_name);
        this.setFieldValue('email', staff.email);
        this.setFieldValue('employee_id', staff.employee_id);

        // Suggest a username based on staff name if empty
        const usernameEl = document.getElementById('username');
        if (usernameEl && !usernameEl.value) {
            const base = `${(staff.first_name || '').toLowerCase()}.${(staff.last_name || '').toLowerCase()}`.replace(/\s+/g, '');
            if (base) usernameEl.value = base;
        }

        console.log('Form populated with staff data:', staff);
        this.showNotification(`Form populated with ${staff.first_name} ${staff.last_name}'s information`, 'success');
    }

    clearFormFields() {
        const fieldsToKeep = ['staff_id', 'password', 'confirm_password', 'username'];
        const form = document.getElementById('userForm');
        
        if (form) {
            const inputs = form.querySelectorAll('input, select');
            inputs.forEach(input => {
                if (!fieldsToKeep.includes(input.name)) {
                    input.value = '';
                }
            });
        }
    }

    setFieldValue(fieldId, value) {
        const field = document.getElementById(fieldId);
        if (field && value) {
            field.value = value;
        }
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            border-radius: 4px;
            color: white;
            font-weight: 500;
            z-index: 10000;
            max-width: 300px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        `;

        // Set background color based on type
        switch (type) {
            case 'success':
                notification.style.backgroundColor = '#10b981';
                break;
            case 'error':
                notification.style.backgroundColor = '#ef4444';
                break;
            case 'warning':
                notification.style.backgroundColor = '#f59e0b';
                break;
            default:
                notification.style.backgroundColor = '#3b82f6';
        }

        notification.textContent = message;
        document.body.appendChild(notification);

        // Auto-remove after 3 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 3000);
    }

    // Method to get selected staff ID for form submission
    getSelectedStaffId() {
        const dropdown = document.getElementById('staff_id');
        return dropdown ? dropdown.value : null;
    }

    // Method to refresh staff list (useful after creating new staff)
    refreshStaffList() {
        this.loadStaffWithoutAccounts();
    }
}

// Initialize the integration when script loads
const staffUserIntegration = new StaffUserIntegration();

// Make it globally available for other scripts
window.staffUserIntegration = staffUserIntegration;