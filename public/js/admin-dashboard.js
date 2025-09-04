// Admin Dashboard JavaScript Functions
console.log('Admin dashboard JS loaded');

// Modal Functions
function openAddUserModal() {
    console.log('Opening add user modal');
    document.getElementById('modalTitle').textContent = 'Add New User';
    document.getElementById('userForm').reset();
    // Clear any existing data-user-id attribute for create mode
    document.getElementById('userForm').removeAttribute('data-user-id');
    document.getElementById('userModal').style.display = 'block';
}

function closeUserModal() {
    document.getElementById('userModal').style.display = 'none';
}

// Form Submission for dashboard modal
document.addEventListener('DOMContentLoaded', function() {
    const userForm = document.getElementById('userForm');
    if (userForm) {
        userForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const userData = {
                first_name: formData.get('first_name') || document.getElementById('first_name').value,
                last_name: formData.get('last_name') || document.getElementById('last_name').value,
                email: formData.get('email') || document.getElementById('email').value,
                phone: formData.get('phone') || document.getElementById('phone').value,
                role: formData.get('role') || document.getElementById('role').value,
                department: formData.get('department') || document.getElementById('department').value
            };

            console.log('Form data being sent:', userData);

            // Validate Required Fields
            if (!userData.first_name || !userData.last_name || !userData.email || !userData.role) {
                console.error('Validation failed: Missing required fields');
                showNotification('Please fill in all required fields', 'error');
                return;
            }

            // Validate Email Format
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(userData.email)) {
                console.error('Validation failed: Invalid email format');
                showNotification('Please enter a valid email address', 'error');
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
                console.log('Response headers:', response.headers);

                const result = await response.json();
                console.log('Server response:', result);

                if (response.ok && result.status === 'success') {
                    showNotification('User created successfully! Temporary password: ' + result.temp_password, 'success');
                    closeUserModal();
                    // Redirect to user management page to see the new user
                    setTimeout(() => {
                        window.location.href = '/admin/users';
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

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('userModal');
        if (e.target === modal) {
            closeUserModal();
        }
    });
});
