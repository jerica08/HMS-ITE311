/**
 * Patient Registration Management System
 * Provides real-time tracking, form validation, and AJAX functionality
 */

class PatientRegistrationManager {
    constructor() {
        this.baseUrl = window.location.origin;
        this.debounceTimer = null;
        this.init();
    }

    init() {
        this.bindEvents();
        this.initializeFormValidation();
        this.loadRecentPatients();
        console.log('Patient Registration Manager initialized');
    }

    bindEvents() {
        // Search functionality
        const searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.debounceSearch(e.target.value);
            });
        }

        // Filter dropdowns
        const statusFilter = document.getElementById('status');
        const typeFilter = document.getElementById('patient_type');
        
        if (statusFilter) {
            statusFilter.addEventListener('change', () => this.performSearch());
        }
        
        if (typeFilter) {
            typeFilter.addEventListener('change', () => this.performSearch());
        }

        // Form validation
        const registrationForm = document.getElementById('patientRegistrationForm');
        if (registrationForm) {
            registrationForm.addEventListener('submit', (e) => this.handleFormSubmit(e));
        }

        // Real-time age calculation
        const dobInput = document.getElementById('dob');
        if (dobInput) {
            dobInput.addEventListener('change', (e) => this.calculateAge(e.target.value));
        }

        // Phone number formatting
        const phoneInputs = document.querySelectorAll('input[type="tel"]');
        phoneInputs.forEach(input => {
            input.addEventListener('input', (e) => this.formatPhoneNumber(e.target));
        });

        // Auto-refresh dashboard stats every 2 minutes
        if (window.location.pathname.includes('dashboard')) {
            setInterval(() => this.refreshDashboardStats(), 120000);
        }
    }

    debounceSearch(searchTerm) {
        clearTimeout(this.debounceTimer);
        this.debounceTimer = setTimeout(() => {
            this.performSearch(searchTerm);
        }, 500);
    }

    async performSearch(searchTerm = null) {
        const searchInput = document.getElementById('search');
        const statusFilter = document.getElementById('status');
        const typeFilter = document.getElementById('patient_type');
        const resultsContainer = document.getElementById('search-results');

        if (!resultsContainer) return;

        // Show loading state
        this.showLoadingState(resultsContainer);

        const params = new URLSearchParams();
        
        if (searchTerm || (searchInput && searchInput.value)) {
            params.append('search', searchTerm || searchInput.value);
        }
        
        if (statusFilter && statusFilter.value) {
            params.append('status', statusFilter.value);
        }
        
        if (typeFilter && typeFilter.value) {
            params.append('patient_type', typeFilter.value);
        }

        try {
            const response = await fetch(`${this.baseUrl}/receptionist/patient-registration/api/search?${params}`);
            const data = await response.json();

            if (response.ok) {
                this.displaySearchResults(data.patients, data.count);
            } else {
                this.showError('Failed to search patients');
            }
        } catch (error) {
            console.error('Search error:', error);
            this.showError('Network error occurred');
        }
    }

    displaySearchResults(patients, count) {
        const resultsContainer = document.getElementById('search-results');
        if (!resultsContainer) return;

        let html = `
            <div class="search-results-header">
                <h4>Search Results (${count} found)</h4>
            </div>
        `;

        if (patients.length > 0) {
            html += '<div class="patients-grid">';
            patients.forEach(patient => {
                html += this.createPatientCard(patient);
            });
            html += '</div>';
        } else {
            html += `
                <div class="empty-results">
                    <i class="fas fa-search fa-2x"></i>
                    <p>No patients found matching your criteria</p>
                </div>
            `;
        }

        resultsContainer.innerHTML = html;
    }

    createPatientCard(patient) {
        const statusClass = patient.status === 'Active' ? 'success' : 
                           patient.status === 'Inactive' ? 'warning' : 'secondary';
        const typeClass = patient.patient_type === 'Emergency' ? 'danger' : 
                         patient.patient_type === 'Inpatient' ? 'warning' : 'info';

        return `
            <div class="patient-card">
                <div class="patient-header">
                    <h5>${this.escapeHtml(patient.first_name)} ${this.escapeHtml(patient.last_name)}</h5>
                    <span class="badge badge-${statusClass}">${patient.status}</span>
                </div>
                <div class="patient-details">
                    <p><strong>ID:</strong> ${patient.patient_id}</p>
                    <p><strong>Age:</strong> ${patient.age || 'N/A'} years</p>
                    <p><strong>Gender:</strong> ${patient.gender}</p>
                    <p><strong>Phone:</strong> ${patient.phone}</p>
                    <p><strong>Type:</strong> <span class="badge badge-${typeClass}">${patient.patient_type}</span></p>
                </div>
                <div class="patient-actions">
                    <a href="${this.baseUrl}/receptionist/patient-registration/show/${patient.id}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-eye"></i> View
                    </a>
                    <a href="${this.baseUrl}/receptionist/patient-registration/edit/${patient.id}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
        `;
    }

    async loadRecentPatients() {
        const recentContainer = document.getElementById('recent-patients-table');
        if (!recentContainer) return;

        try {
            const response = await fetch(`${this.baseUrl}/receptionist/patient-registration/api/search?limit=5`);
            const data = await response.json();

            if (response.ok && data.patients) {
                this.updateRecentPatientsTable(data.patients);
            }
        } catch (error) {
            console.error('Error loading recent patients:', error);
        }
    }

    updateRecentPatientsTable(patients) {
        const tbody = document.querySelector('#recent-patients-table');
        if (!tbody) return;

        if (patients.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center text-muted">No recent patient registrations found</td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = patients.map(patient => {
            const statusClass = patient.status === 'Active' ? 'success' : 'secondary';
            const typeClass = patient.patient_type === 'Emergency' ? 'danger' : 
                             patient.patient_type === 'Inpatient' ? 'warning' : 'info';
            
            return `
                <tr>
                    <td><strong>${this.escapeHtml(patient.patient_id)}</strong></td>
                    <td>${this.escapeHtml(patient.first_name)} ${this.escapeHtml(patient.last_name)}</td>
                    <td>${patient.age || 'N/A'}</td>
                    <td>${this.escapeHtml(patient.gender)}</td>
                    <td>
                        <span class="badge badge-${typeClass}">
                            ${this.escapeHtml(patient.patient_type)}
                        </span>
                    </td>
                    <td>${this.formatDate(patient.created_at)}</td>
                    <td>
                        <span class="badge badge-${statusClass}">
                            ${this.escapeHtml(patient.status)}
                        </span>
                    </td>
                    <td>
                        <a href="${this.baseUrl}/receptionist/patient-registration/show/${patient.id}" 
                           class="btn btn-sm btn-secondary">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </td>
                </tr>
            `;
        }).join('');
    }

    async refreshDashboardStats() {
        try {
            const response = await fetch(`${this.baseUrl}/receptionist/dashboard/stats`);
            const stats = await response.json();

            if (response.ok) {
                this.updateDashboardMetrics(stats);
                this.showNotification('Dashboard updated', 'success');
            }
        } catch (error) {
            console.error('Error refreshing dashboard:', error);
        }
    }

    updateDashboardMetrics(stats) {
        const metrics = {
            'patients-today': stats.patients_today,
            'patients-week': stats.patients_this_week,
            'pending-patients': stats.pending_patients,
            'total-patients': stats.total_patients,
            'active-patients': stats.active_patients,
            'patients-month': stats.patients_this_month,
            'insured-patients': stats.insured_patients,
            'uninsured-patients': stats.uninsured_patients
        };

        Object.entries(metrics).forEach(([id, value]) => {
            const element = document.getElementById(id);
            if (element) {
                element.style.transform = 'scale(1.1)';
                element.textContent = value;
                setTimeout(() => {
                    element.style.transform = 'scale(1)';
                }, 200);
            }
        });
    }

    initializeFormValidation() {
        const form = document.getElementById('patientRegistrationForm');
        if (!form) return;

        // Real-time validation
        const inputs = form.querySelectorAll('input[required], select[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearFieldError(input));
        });

        // Email validation
        const emailInput = document.getElementById('email');
        if (emailInput) {
            emailInput.addEventListener('blur', () => this.validateEmail(emailInput));
        }

        // Phone validation
        const phoneInputs = document.querySelectorAll('input[type="tel"]');
        phoneInputs.forEach(input => {
            input.addEventListener('blur', () => this.validatePhone(input));
        });
    }

    handleFormSubmit(event) {
        event.preventDefault();
        
        const form = event.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        
        if (!this.validateForm(form)) {
            this.showNotification('Please correct the errors in the form', 'error');
            return;
        }

        // Show loading state
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        submitBtn.disabled = true;

        // Submit form
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                this.showNotification('Patient registered successfully!', 'success');
                setTimeout(() => {
                    window.location.href = `${this.baseUrl}/receptionist/patient-registration`;
                }, 1500);
            } else {
                throw new Error('Registration failed');
            }
        })
        .catch(error => {
            console.error('Registration error:', error);
            this.showNotification('Failed to register patient', 'error');
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }

    validateForm(form) {
        let isValid = true;
        const inputs = form.querySelectorAll('input[required], select[required]');
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isValid = false;
            }
        });

        return isValid;
    }

    validateField(input) {
        const value = input.value.trim();
        let isValid = true;
        let message = '';

        if (input.hasAttribute('required') && !value) {
            isValid = false;
            message = 'This field is required';
        } else if (input.type === 'email' && value && !this.isValidEmail(value)) {
            isValid = false;
            message = 'Please enter a valid email address';
        } else if (input.type === 'tel' && value && !this.isValidPhone(value)) {
            isValid = false;
            message = 'Please enter a valid phone number';
        }

        if (!isValid) {
            this.showFieldError(input, message);
        } else {
            this.clearFieldError(input);
        }

        return isValid;
    }

    validateEmail(input) {
        const value = input.value.trim();
        if (value && !this.isValidEmail(value)) {
            this.showFieldError(input, 'Please enter a valid email address');
            return false;
        }
        this.clearFieldError(input);
        return true;
    }

    validatePhone(input) {
        const value = input.value.trim();
        if (value && !this.isValidPhone(value)) {
            this.showFieldError(input, 'Please enter a valid phone number');
            return false;
        }
        this.clearFieldError(input);
        return true;
    }

    showFieldError(input, message) {
        this.clearFieldError(input);
        
        input.classList.add('error');
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.textContent = message;
        
        input.parentNode.appendChild(errorDiv);
    }

    clearFieldError(input) {
        input.classList.remove('error');
        const errorDiv = input.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    calculateAge(dateOfBirth) {
        if (!dateOfBirth) return;
        
        const today = new Date();
        const birthDate = new Date(dateOfBirth);
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        // Display age if there's an age display element
        const ageDisplay = document.getElementById('calculated-age');
        if (ageDisplay) {
            ageDisplay.textContent = `${age} years old`;
        }
    }

    formatPhoneNumber(input) {
        let value = input.value.replace(/\D/g, '');
        
        // Philippine mobile number format
        if (value.startsWith('63')) {
            value = '+' + value;
        } else if (value.startsWith('09') && value.length === 11) {
            value = value.replace(/^09/, '+639');
        }
        
        input.value = value;
    }

    showLoadingState(container) {
        container.innerHTML = `
            <div class="loading-state">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <p>Searching patients...</p>
            </div>
        `;
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            ${message}
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => notification.classList.add('show'), 100);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    showError(message) {
        this.showNotification(message, 'error');
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    isValidPhone(phone) {
        const phoneRegex = /^[\+]?[0-9\-\(\)\s]{7,}$/;
        return phoneRegex.test(phone);
    }

    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.patientManager = new PatientRegistrationManager();
});

// Export for global access
window.PatientRegistrationManager = PatientRegistrationManager;
