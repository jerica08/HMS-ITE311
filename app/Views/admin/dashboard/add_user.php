    <div id="userModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:2rem; border-radius:8px; max-width:400px; margin:auto; position:relative;">
        <h2 id="modalTitle">Add New User</h2>
        <form id="userForm">
            <div style="margin-bottom:1rem;">
                <label for="first_name">First Name*</label>
                <input type="text" id="first_name" name="first_name" required style="width:100%;">
            </div>
            <div style="margin-bottom:1rem;">
                <label for="last_name">Last Name*</label>
                <input type="text" id="last_name" name="last_name" required style="width:100%;">
            </div>
            <div style="margin-bottom:1rem;">
                <label for="email">Email*</label>
                <input type="email" id="email" name="email" required style="width:100%;">
            </div>
            <div style="margin-bottom:1rem;">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" style="width:100%;">
            </div>
            <div style="margin-bottom:1rem;">
                <label for="password">Password*</label>
                <input type="password" id="password" name="password" required placeholder="Enter password (min 6 characters)" style="width:100%;">
            </div>
            <div style="margin-bottom:1rem;">
                <label for="confirm_password">Confirm Password*</label>
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="Re-enter password" style="width:100%;">
            </div>
            <div style="margin-bottom:1rem;">
                <label for="role">Role*</label>
                <select id="role" name="role" required style="width:100%;">
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="doctor">Doctor</option>
                    <option value="nurse">Nurse</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
            <div style="margin-bottom:1rem;">
                <label for="department">Department</label>
                <input type="text" id="department" name="department" style="width:100%;">
            </div>
            <div style="display:flex; gap:1rem; justify-content:flex-end;">
                <button type="button" onclick="closeUserModal()" style="background:#eee; border:none; padding:0.5rem 1rem; border-radius:4px;">Cancel</button>
                <button type="submit" style="background:#2563eb; color:#fff; border:none; padding:0.5rem 1rem; border-radius:4px;">Save</button>
            </div>
        </form>
    </div>
</div>