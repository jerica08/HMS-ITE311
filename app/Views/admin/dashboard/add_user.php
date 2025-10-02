<div id="userModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:2rem; border-radius:8px; max-width:960px; width:98%; margin:auto; position:relative; max-height:90vh; overflow:auto; box-sizing:border-box; -webkit-overflow-scrolling:touch;">
        <div style="display:flex; align-items:center; justify-content:space-between; padding:0 0 1rem 0; border-bottom:1px solid #e5e7eb; margin-bottom:1rem; background:#f8f9ff;">
            <div style="display:flex; align-items:center; gap:0.5rem; font-weight:600; color:#1e293b;">
                <i class="fas fa-user-plus" style="color:#4f46e5"></i>
                <h2 id="modalTitle" style="margin:0; font-size:1.25rem;">Add New User</h2>
            </div>
            <button type="button" onclick="closeUserModal()" aria-label="Close" class="btn btn-secondary btn-small" style="background:#6b7280; color:#fff; border:none; padding:0.4rem 0.6rem; border-radius:4px; cursor:pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="userForm" style="padding-bottom:5rem;">
            <div style="margin-bottom:1rem;">
                <label for="staff_id">Select Staff</label>
                <select id="staff_id" name="staff_id" required style="width:100%; padding:0.5rem; border:1px solid #ddd; border-radius:4px;">
                    <option value="">-- Select staff to link --</option>
                </select>
            </div>
            <input type="hidden" id="employee_id" name="employee_id" />
            <input type="hidden" id="first_name" name="first_name" />
            <input type="hidden" id="last_name" name="last_name" />
            <input type="hidden" id="email" name="email" />

            <div style="margin-bottom:1rem;">
                <label for="username">Username*</label>
                <input type="text" id="username" name="username" required placeholder="e.g., j.doe" style="width:100%; padding:0.5rem; border:1px solid #ddd; border-radius:4px;">
            </div>
            <div style="margin-bottom:1rem;">
                <label for="password">Password*</label>
                <input type="password" id="password" name="password" required placeholder="Enter password (min 6 characters)" autocomplete="new-password" style="width:100%; padding:0.5rem; border:1px solid #ddd; border-radius:4px;">
            </div>
            <div style="margin-bottom:1rem;">
                <label for="confirm_password">Confirm Password*</label>
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="Re-enter password" autocomplete="new-password" style="width:100%; padding:0.5rem; border:1px solid #ddd; border-radius:4px;">
            </div>
            <div style="margin-bottom:1rem;">
                <label for="role">Role / Privilege*</label>
                <select id="role" name="role" required style="width:100%; padding:0.5rem; border:1px solid #ddd; border-radius:4px;">
                    <option value="">Select Role</option>
                    <option value="admin">Administrator</option>
                    <option value="doctor">Doctor</option>
                    <option value="nurse">Nurse</option>
                    <option value="receptionist">Receptionist</option>
                    <option value="laboratorist">Laboratory Staff</option>
                    <option value="pharmacist">Pharmacist</option>
                    <option value="accountant">Accountant</option>
                    <option value="it_staff">IT Staff</option>
                </select>
            </div>
            <div style="display:flex; gap:1rem; justify-content:flex-end; margin-top:1.5rem; position:sticky; bottom:0; background:#fff; padding-top:1rem; border-top:1px solid #e5e7eb;">
                <button type="submit" style="background:#2563eb; color:#fff; border:none; padding:0.75rem 1.5rem; border-radius:4px; cursor:pointer;">Save User</button>
            </div>
        </form>
    </div>
</div>
<script src="<?= base_url('js/staff-user-integration.js') ?>"></script>
<script>
    // Modal open/close helpers for Add User
    (function(){
        var overlay = document.getElementById('userModal');
        window.openUserModal = function(){ if (overlay) overlay.style.display = 'flex'; };
        window.closeUserModal = function(){ if (overlay) overlay.style.display = 'none'; };
        // Close on overlay click
        document.addEventListener('click', function(e){ if (overlay && e.target === overlay) closeUserModal(); });
        // Close on Escape
        document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeUserModal(); });
    })();
</script>
<style>
    #userModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    #userModal > div {
        background: #fff;
        padding: 2rem;
        border-radius: 8px;
        max-width: 960px;
        width: 98%;
        margin: auto;
        position: relative;
        max-height: 90vh;
        overflow: auto;
        box-sizing: border-box;
        -webkit-overflow-scrolling: touch;
    }
    #userModal > div > div:first-child {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 0 1rem 0;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 1rem;
        background: #f8f9ff;
    }
    #userModal > div > div:first-child > div {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: #1e293b;
    }
    #userModal > div > div:first-child > button {
        background: #6b7280;
        color: #fff;
        border: none;
        padding: 0.4rem 0.6rem;
        border-radius: 4px;
        cursor: pointer;
    }
</style>