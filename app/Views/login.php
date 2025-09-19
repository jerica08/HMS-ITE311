<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HMS Login - Hospital Management System</title>
        <link rel="stylesheet" href="/assets/css/dashboard-common.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="/assets/css/login.css">
    </head>
    <body>
        <div class="login-container">
            <div class="login-form-section">
                <div class="login-title">
                    <i class="fas fa-hospital"></i>Lifecare Medical Center
                    <h4 style="display: flex;align-items:center;justify-content: center;">HMS Login</h4>                    
                </div>
                <h5 class="login-subtitle" style="display: flex;align-items:center;justify-content:center;">Healing with Heart, Caring for Life</h5>
            
                <form id="loginForm" action="/auth/loginSubmit" method="POST">
                    
                    <!--DISPLAY VALIDATION ERRORS-->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="error-message">
                        <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                     <div class="form-group">
                        <label class="form-label" for="role">Role</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="">Select your role</option>
                            <option value="admin">Hospital Administrator</option>
                            <option value="doctor">Doctor</option>
                            <option value="nurse">Nurse</option>
                            <option value="receptionist">Receptionist</option>
                            <option value="laboratorist">Laboratory Staff</option>
                            <option value="pharmacist">Pharmacist</option>
                            <option value="accountant">Accountant</option>
                            <option value="it_staff">IT Staff</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required>
                    </div>
                    
                   
                    
                    <button type="submit" class="login-btn">
                        <i class="fas fa-sign-in-alt"></i> Login to Dashboard
                    </button>
                </form>
            </div>
        </div>
        <script src="js/login.js"></script>
    </body>
</html>