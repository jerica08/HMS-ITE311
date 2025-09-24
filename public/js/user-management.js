// User Management JavaScript Functions
console.log('User management JS loaded');

// Function to update user statistics dynamically
async function updateUserStats() {
    try {
        console.log('Updating user statistics...');
        
        const response = await fetch('/admin/users/statistics', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin'
        });

        if (response.ok) {
            const result = await response.json();
            console.log('User statistics response:', result);
            
            if (result.status === 'success') {
                // Update the statistics cards
                const totalUsersElement = document.querySelector('.overview-card:nth-child(1) .metric-value');
                const activeUsersElement = document.querySelector('.overview-card:nth-child(2) .metric-value');
                const inactiveUsersElement = document.querySelector('.overview-card:nth-child(3) .metric-value');
                const adminUsersElement = document.querySelector('.overview-card:nth-child(4) .metric-value');
                
                if (totalUsersElement) totalUsersElement.textContent = result.data.total_users || 0;
                if (activeUsersElement) activeUsersElement.textContent = result.data.active_users || 0;
                if (inactiveUsersElement) inactiveUsersElement.textContent = result.data.inactive_users || 0;
                if (adminUsersElement) adminUsersElement.textContent = result.data.admin_users || 0;
                
                console.log('User statistics updated successfully');
            }
        } else {
            console.error('Failed to fetch user statistics:', response.status);
        }
    } catch (error) {
        console.error('Error updating user statistics:', error);
    }
}

// Toggle user status function
async function toggleUserStatus(userId, currentStatus) {
    try {
        const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
        const action = newStatus === 'active' ? 'activate' : 'deactivate';
        
        if (!confirm(`Are you sure you want to ${action} this user?`)) {
            return;
        }
        
        showLoading(true);
        
        const response = await fetch(`/admin/users/${userId}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: newStatus })
        });
        
        const result = await response.json();
        
        if (response.ok && result.status === 'success') {
            showNotification(`User ${action}d successfully!`, 'success');
            // Update statistics immediately
            updateUserStats();
            // Reload page to reflect changes
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showNotification(result.message || `Failed to ${action} user`, 'error');
        }
    } catch (error) {
        console.error('Error toggling user status:', error);
        showNotification('Network error. Please try again.', 'error');
    } finally {
        showLoading(false);
    }
}

// Modal functions
function openAddUserModal() {
    console.log('Opening add user modal');
    document.getElementById('modalTitle').textContent = 'Add New User';
    document.getElementById('userForm').reset();
    // Clear any existing data-user-id attribute for create mode
    document.getElementById('userForm').removeAttribute('data-user-id');
    // Load staff without accounts to help link existing staff
    loadStaffWithoutAccounts();
    document.getElementById('userModal').style.display = 'block';
}

function closeUserModal() {
    document.getElementById('userModal').style.display = 'none';
}

// Load staff who don't have user accounts yet and populate the select
async function loadStaffWithoutAccounts() {
    const select = document.getElementById('staff_id');
    if (!select) return;

    // Clear options except the first placeholder
    select.innerHTML = '<option value="">-- Select staff to link --</option>';

    try {
        const res = await fetch('/admin/users/staff-without-accounts', { headers: { 'Accept': 'application/json' } });
        if (!res.ok) throw new Error('Failed to load staff list');
        const data = await res.json();
        const list = data?.data || [];
        list.forEach(s => {
            const opt = document.createElement('option');
            const fullName = `${s.first_name || ''} ${s.last_name || ''}`.trim();
            opt.value = String(s.id);
            opt.textContent = `${fullName} • ${s.role || ''} • ${s.department || ''}`;
            opt.dataset.firstName = s.first_name || '';
            opt.dataset.lastName = s.last_name || '';
            opt.dataset.email = s.email || '';
            opt.dataset.phone = s.phone || '';
            opt.dataset.department = s.department || '';
            opt.dataset.role = s.role || '';
            opt.dataset.employeeId = s.employee_id || '';
            select.appendChild(opt);
        });
    } catch (e) {
        console.error('Could not load staff without accounts:', e);
    }
}

// When a staff is selected, autofill the user form fields
function bindLinkStaffAutofill() {
    const select = document.getElementById('staff_id');
    if (!select) return;
    select.addEventListener('change', () => {
        const opt = select.options[select.selectedIndex];
        if (!opt || !opt.value) return; // do nothing if placeholder
        const setVal = (id, val) => { const el = document.getElementById(id); if (el) el.value = val; };
        // Prefer explicit data-* attributes; fallback to parsed JSON if present
        const get = (key) => opt.dataset[key] || (opt.dataset.staff ? (JSON.parse(opt.dataset.staff)[key] || '') : '');
        setVal('first_name', get('firstName') || get('first_name'));
        setVal('last_name', get('lastName') || get('last_name'));
        setVal('email', get('email'));
        // Suggest username if empty
        const usernameEl = document.getElementById('username');
        if (usernameEl && !usernameEl.value) {
            const base = `${(get('firstName') || '').toLowerCase()}.${(get('lastName') || '').toLowerCase()}`.replace(/\s+/g, '');
            if (base) usernameEl.value = base;
        }
        setVal('employee_id', opt.dataset.employeeId || (opt.dataset.staff ? (JSON.parse(opt.dataset.staff)['employee_id'] || '') : ''));
    });
}

// Enhanced search functionality with debouncing
let searchTimeout;
function handleSearchInput() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        performDatabaseSearch();
    }, 500); // Wait 500ms after user stops typing
}

// Perform real-time database search
async function performDatabaseSearch() {
    const searchInput = document.getElementById("searchInput");
    const roleFilter = document.getElementById("roleFilter");
    const statusFilter = document.getElementById("statusFilter");
    
    if (!searchInput || !roleFilter || !statusFilter) {
        console.error('Filter elements not found');
        return;
    }

    let search = searchInput.value.trim();
    let role = roleFilter.value;
    let status = statusFilter.value;

    // Show loading state
    showSearchLoading(true);
    showTableLoading(true);

    try {
        // Build query string for API call
        let queryParams = new URLSearchParams();
        if (search) queryParams.append('search', search);
        if (role) queryParams.append('role', role);
        if (status) queryParams.append('status', status);

        console.log('Performing database search with params:', queryParams.toString());

        // Make API call to get filtered users
        const response = await fetch(`/admin/users/api?${queryParams.toString()}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin'
        });

        if (response.ok) {
            const result = await response.json();
            console.log('Search results:', result);
            
            if (result.status === 'success') {
                // Update the table with filtered results
                updateUserTable(result.data || []);
                // Update search result count
                updateSearchResultCount(result.data ? result.data.length : 0);
                // Update statistics
                updateUserStats();
            } else {
                showNotification(result.message || 'Search failed', 'error');
                updateUserTable([]);
            }
        } else {
            console.error('Search request failed:', response.status);
            showNotification('Search request failed. Please try again.', 'error');
            updateUserTable([]);
        }
    } catch (error) {
        console.error('Error performing search:', error);
        showNotification('Network error during search. Please try again.', 'error');
        updateUserTable([]);
    } finally {
        showSearchLoading(false);
        showTableLoading(false);
    }
}

// Apply filters function with database search
function applyFilters() {
    performDatabaseSearch();
}

// Clear all filters and reload all users
async function clearFilters() {
    console.log('Clearing all filters');
    
    // Clear form inputs
    const searchInput = document.getElementById("searchInput");
    const roleFilter = document.getElementById("roleFilter");
    const statusFilter = document.getElementById("statusFilter");
    
    if (searchInput) searchInput.value = '';
    if (roleFilter) roleFilter.value = '';
    if (statusFilter) statusFilter.value = '';
    
    // Load all users
    await performDatabaseSearch();
}

// Update user table with new data
function updateUserTable(users) {
    const tableBody = document.getElementById('usersTableBody');
    if (!tableBody) {
        console.error('Users table body not found');
        return;
    }

    if (!users || users.length === 0) {
        // Show no results message
        tableBody.innerHTML = `
            <tr>
                <td colspan="7" style="text-align: center; padding: 2rem;">
                    <i class="fas fa-search" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                    <p>No users found matching your search criteria.</p>
                    <button onclick="clearFilters()" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear Filters
                    </button>
                </td>
            </tr>
        `;
        return;
    }

    // Build table rows
    let tableHTML = '';
    users.forEach(user => {
        const fullName = `${user.first_name || ''} ${user.last_name || ''}`.trim();
        const initials = `${(user.first_name || 'U').charAt(0)}${(user.last_name || 'U').charAt(0)}`.toUpperCase();
        const userRole = (user.role || 'user').replace('_', ' ');
        const userStatus = user.status || 'inactive';
        
        // Calculate last login display
        let lastLoginDisplay = 'Never';
        if (user.updated_at || user.created_at) {
            const lastLogin = user.updated_at || user.created_at;
            const diff = Math.floor((Date.now() - new Date(lastLogin).getTime()) / 1000);
            if (diff < 3600) {
                lastLoginDisplay = 'Less than 1 hour ago';
            } else if (diff < 86400) {
                lastLoginDisplay = Math.floor(diff / 3600) + ' hours ago';
            } else {
                lastLoginDisplay = new Date(lastLogin).toLocaleDateString('en-US', { 
                    month: 'short', 
                    day: 'numeric', 
                    year: 'numeric' 
                });
            }
        }

        tableHTML += `
            <tr class="user-row">
                <td><input type="checkbox" class="user-checkbox" data-user-id="${user.id}"></td>
                <td>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div class="user-avatar">
                            ${initials}
                        </div>
                        <div>
                            <div style="font-weight: 600;">
                                ${fullName || 'Unknown User'}
                            </div>
                            <div style="font-size: 0.8rem; color: #6b7280;">
                                ${user.email || ''}
                            </div>
                            <div style="font-size: 0.8rem; color: #6b7280;">
                                ID: ${user.employee_id || user.username || 'N/A'}
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="role-badge role-${userRole.replace(' ', '-').toLowerCase()}">
                        ${userRole.charAt(0).toUpperCase() + userRole.slice(1)}
                    </span>
                </td>
                <td>${user.department || 'N/A'}</td>
                <td>
                    <i class="fas fa-circle status-${userStatus}"></i> 
                    ${userStatus.charAt(0).toUpperCase() + userStatus.slice(1)}
                </td>
                <td>${lastLoginDisplay}</td>
                <td>
                    <div class="action-buttons">
                        <button class="action-btn btn-edit" onclick="editUser(${user.id})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="action-btn btn-reset" onclick="resetPassword(${user.id})">
                            <i class="fas fa-key"></i> Reset
                        </button>
                        <button class="action-btn btn-delete" onclick="deleteUser(${user.id})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });

    tableBody.innerHTML = tableHTML;
    console.log(`Updated table with ${users.length} users`);
}

// Show loading state for search
function showSearchLoading(show) {
    const applyButton = document.querySelector('button[onclick="applyFilters()"]');
    if (applyButton) {
        if (show) {
            applyButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
            applyButton.disabled = true;
        } else {
            applyButton.innerHTML = '<i class="fas fa-search"></i> Apply Filters';
            applyButton.disabled = false;
        }
    }
}

// Show loading state for table
function showTableLoading(show) {
    const tableBody = document.getElementById('usersTableBody');
    if (!tableBody) return;

    if (show) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="7" style="text-align: center; padding: 2rem;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #007bff; margin-bottom: 1rem;"></i>
                    <p>Searching users...</p>
                </td>
            </tr>
        `;
    }
}

// Real-time search functionality
function initializeRealTimeSearch() {
    const searchInput = document.getElementById("searchInput");
    const roleFilter = document.getElementById("roleFilter");
    const statusFilter = document.getElementById("statusFilter");

    if (searchInput) {
        // Add event listener for real-time search
        searchInput.addEventListener('input', handleSearchInput);
        
        // Add placeholder animation
        let placeholderIndex = 0;
        const placeholders = [
            "Search by name, email, or ID...",
            "Try typing a name...",
            "Search by email address...",
            "Enter employee ID..."
        ];
        
        setInterval(() => {
            if (document.activeElement !== searchInput) {
                searchInput.placeholder = placeholders[placeholderIndex];
                placeholderIndex = (placeholderIndex + 1) % placeholders.length;
            }
        }, 3000);
    }

    if (roleFilter) {
        roleFilter.addEventListener('change', performDatabaseSearch);
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', performDatabaseSearch);
    }
}

// Enhanced keyboard shortcuts
function initializeKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + F to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            const searchInput = document.getElementById("searchInput");
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }
        
        // Escape to clear search
        if (e.key === 'Escape') {
            const searchInput = document.getElementById("searchInput");
            if (searchInput && document.activeElement === searchInput) {
                searchInput.value = '';
                handleSearchInput();
            }
        }
        
        // Enter to apply filters when search is focused
        if (e.key === 'Enter' && document.activeElement === document.getElementById("searchInput")) {
            e.preventDefault();
            applyFilters();
        }
    });
}

// Initialize user management functionality
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing user management functionality...');
    
    // Update stats immediately
    updateUserStats();
    
    // Update stats every 30 seconds
    setInterval(updateUserStats, 30000);
    
    // Initialize search functionality
    initializeRealTimeSearch();
    
    // Initialize keyboard shortcuts
    initializeKeyboardShortcuts();
    // Bind staff linking autofill for Add User modal
    bindLinkStaffAutofill();
    
    // Handle form submission for adding/editing users
    const userForm = document.getElementById('userForm');
    if (userForm) {
        userForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const userData = {
                // Linkage
                staff_id: formData.get('staff_id') || (document.getElementById('staff_id') ? document.getElementById('staff_id').value : ''),
                employee_id: formData.get('employee_id') || (document.getElementById('employee_id') ? document.getElementById('employee_id').value : ''),
                // Credentials
                username: formData.get('username') || (document.getElementById('username') ? document.getElementById('username').value : ''),
                password: formData.get('password') || document.getElementById('password').value,
                role: formData.get('role') || document.getElementById('role').value,
                // Identity (hidden fields populated from staff selection)
                first_name: formData.get('first_name') || (document.getElementById('first_name') ? document.getElementById('first_name').value : ''),
                last_name: formData.get('last_name') || (document.getElementById('last_name') ? document.getElementById('last_name').value : ''),
                email: formData.get('email') || (document.getElementById('email') ? document.getElementById('email').value : ''),
            };

            console.log('Form data being sent:', userData);

            // Validate Required Fields
            if (!userData.username || !userData.role || !userData.password) {
                console.error('Validation failed: Missing required fields');
                showNotification('Please fill in username, role, and password', 'error');
                return;
            }

            // Validate Email Format
            if (userData.email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(userData.email)) {
                    console.error('Validation failed: Invalid email format');
                    showNotification('Please enter a valid email address', 'error');
                    return;
                }
            }

            // Validate password length
            if (userData.password && userData.password.length < 6) {
                console.error('Validation failed: Password too short');
                showNotification('Password must be at least 6 characters long', 'error');
                return;
            }

            // Validate password confirmation
            const confirmPassword = document.getElementById('confirm_password').value;
            if (userData.password !== confirmPassword) {
                console.error('Validation failed: Passwords do not match');
                showNotification('Passwords do not match', 'error');
                return;
            }

            try {
                showLoading(true);
                
                console.log('Sending POST request to /admin/users with data:', JSON.stringify(userData));
                
                const response = await fetch('/admin/users', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(userData)
                });

                console.log('Response status:', response.status);
                const result = await response.json();
                console.log('Server response:', result);

                if (response.ok && result.status === 'success') {
                    showNotification('User created successfully!', 'success');
                    closeUserModal();
                    // Update statistics immediately after successful creation
                    updateUserStats();
                    // Reload the page to show the new user in the table
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    const errorMsg = result.message || 'Failed to create user';
                    console.error('Server response:', result);
                    if (result.errors) {
                        console.error('Validation errors:', result.errors);
                        const errorList = Object.values(result.errors).join(', ');
                        showNotification(`Validation failed: ${errorList}`, 'error');
                    } else {
                        showNotification(errorMsg, 'error');
                    }
                }
            } catch (error) {
                console.error('Network error creating user:', error);
                showNotification('Network error. Please try again.', 'error');
            } finally {
                showLoading(false);
            }
        });
    }
    
    // Add search result count display
    updateSearchResultCount();
    
    // Load initial data
    performDatabaseSearch();
});

// Function to update search result count
function updateSearchResultCount(count = null) {
    const searchInput = document.getElementById("searchInput");
    const roleFilter = document.getElementById("roleFilter");
    const statusFilter = document.getElementById("statusFilter");
    
    const hasFilters = (searchInput && searchInput.value.trim()) || 
                      (roleFilter && roleFilter.value) || 
                      (statusFilter && statusFilter.value);
    
    if (hasFilters) {
        // Create or update result count display
        let resultCount = document.getElementById('searchResultCount');
        if (!resultCount) {
            resultCount = document.createElement('div');
            resultCount.id = 'searchResultCount';
            resultCount.style.cssText = 'margin: 1rem 0; padding: 0.5rem; background: #f8f9fa; border-radius: 4px; font-size: 0.9rem; color: #6c757d;';
            
            const tableContainer = document.querySelector('.table-container');
            if (tableContainer) {
                tableContainer.parentNode.insertBefore(resultCount, tableContainer);
            }
        }
        
        // Use provided count or count from DOM
        const userCount = count !== null ? count : document.querySelectorAll('.user-row').length;
        resultCount.innerHTML = `<i class="fas fa-search"></i> Found ${userCount} user${userCount !== 1 ? 's' : ''} matching your criteria`;
        resultCount.style.display = 'block';
    } else {
        // Hide result count if no filters
        const resultCount = document.getElementById('searchResultCount');
        if (resultCount) {
            resultCount.style.display = 'none';
        }
    }
}
