    <div id="userModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:2rem; border-radius:8px; max-width:500px; margin:auto; position:relative;">
        <h2 id="modalTitle">Add New User</h2>
        <form id="userForm">
            <div style="margin-bottom:1rem;">
                <label for="link_staff">Link Staff (no user account yet)</label>
                <select id="link_staff" name="link_staff" style="width:100%; padding:0.5rem; border:1px solid #ddd; border-radius:4px;">
                    <option value="">-- Select staff to link (optional) --</option>
                </select>

            </div>
            <input type="hidden" id="employee_id" name="employee_id" />

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                <div>
                    <label for="first_name">First Name*</label>
                    <input type="text" id="first_name" name="first_name" required style="width:100%; padding:0.5rem; border:1px solid #ddd; border-radius:4px;">
                </div>
                <div>
                    <label for="last_name">Last Name*</label>
                    <input type="text" id="last_name" name="last_name" required style="width:100%; padding:0.5rem; border:1px solid #ddd; border-radius:4px;">
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                <div>
                    <label for="email">Email*</label>
                    <input type="email" id="email" name="email" required style="width:100%; padding:0.5rem; border:1px solid #ddd; border-radius:4px;">
                </div>
                <div>
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" style="width:100%; padding:0.5rem; border:1px solid #ddd; border-radius:4px;">
                </div>
            </div>
            <div style="margin-bottom:1rem;">
                <label for="password">Password*</label>
                <input type="password" id="password" name="password" required placeholder="Enter password (min 6 characters)" autocomplete="new-password" style="width:100%; padding:0.5rem; border:1px solid #ddd; border-radius:4px;">
            </div>
            <div style="margin-bottom:1rem;">
                <label for="confirm_password">Confirm Password*</label>
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="Re-enter password" autocomplete="new-password" style="width:100%; padding:0.5rem; border:1px solid #ddd; border-radius:4px;">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                <div>
                    <label for="role">Role*</label>
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
                <div>
                    <label for="department">Department</label>
                    <select id="department" name="department" style="width:100%; padding:0.5rem; border:1px solid #ddd; border-radius:4px;">
                        <option value="">Select Department</option>
                        <option value="Cardiology">Cardiology</option>
                        <option value="Emergency">Emergency</option>
                        <option value="Laboratory">Laboratory</option>
                        <option value="Pharmacy">Pharmacy</option>
                        <option value="Administration">Administration</option>
                        <option value="IT Department">IT Department</option>
                        <option value="Accounting">Accounting</option>
                    </select>
                </div>
            </div>
            <div style="display:flex; gap:1rem; justify-content:flex-end; margin-top:1.5rem;">
                <button type="button" onclick="closeUserModal()" style="background:#6b7280; color:#fff; border:none; padding:0.75rem 1.5rem; border-radius:4px; cursor:pointer;">Cancel</button>
                <button type="submit" style="background:#2563eb; color:#fff; border:none; padding:0.75rem 1.5rem; border-radius:4px; cursor:pointer;">Save User</button>
            </div>
        </form>
    </div>
</div>
<script src="<?= base_url('js/staff-user-integration.js') ?>"></script>