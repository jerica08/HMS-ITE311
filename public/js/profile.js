document.addEventListener('DOMContentLoaded', () => {
    const messageEl = document.getElementById('profile-message');
    const showMessage = (text, type = 'success') => {
        if (!messageEl) return;
        messageEl.textContent = text;
        messageEl.style.padding = '0.75rem 1rem';
        messageEl.style.borderRadius = '6px';
        messageEl.style.background = type === 'success' ? '#c6f6d5' : '#fed7d7';
        messageEl.style.borderLeft = `4px solid ${type === 'success' ? '#48bb78' : '#f56565'}`;
        messageEl.style.color = '#1a202c';
    };

    const saveProfileBtn = document.getElementById('save-profile');
    if (saveProfileBtn) {
        saveProfileBtn.addEventListener('click', async () => {
            const form = document.getElementById('profile-form');
            const formData = new FormData(form);
            try {
                const res = await fetch('/profile/update', {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                });
                const data = await res.json();
                if (!res.ok || data.status !== 'success') {
                    const err = data.errors ? Object.values(data.errors).join(', ') : (data.message || 'Update failed');
                    showMessage(err, 'error');
                    return;
                }
                showMessage('Profile saved.');
            } catch (e) {
                showMessage('Network error saving profile.', 'error');
            }
        });
    }

    const savePasswordBtn = document.getElementById('save-password');
    if (savePasswordBtn) {
        savePasswordBtn.addEventListener('click', async () => {
            const form = document.getElementById('password-form');
            const formData = new FormData(form);
            try {
                const res = await fetch('/profile/password', {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                });
                const data = await res.json();
                if (!res.ok || data.status !== 'success') {
                    showMessage(data.message || 'Password update failed', 'error');
                    return;
                }
                form.reset();
                showMessage('Password updated.');
            } catch (e) {
                showMessage('Network error updating password.', 'error');
            }
        });
    }
});


