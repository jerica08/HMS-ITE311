<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HMS Login - Hospital Management System</title>
        <link rel="stylesheet" href="/assets/css/dashboard-common.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
       <style>
        body {
            background: #4682B4;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
      

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
        }

        .login-form-section {
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-info-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .login-title {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 700;
        }

        .login-subtitle {
            color: #666;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }

        .form-input {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-select {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            background: white;
            cursor: pointer;
        }

        .login-btn {
            width: 100%;
            padding: 1rem;
            background:#764ba2;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
        }

        .info-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .info-description {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .info-features {
            list-style: none;
            padding: 0;
            text-align: left;
        }

        .info-features li {
            padding: 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .info-features i {
            width: 20px;
            text-align: center;
        }

        .demo-credentials {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .demo-title {
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .demo-list {
            list-style: none;
            padding: 0;
            font-size: 0.9rem;
        }

        .demo-list li {
            padding: 0.3rem 0;
            opacity: 0.9;
        }

        .error-message {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .success-message {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .form-input.error {
            border-color: #dc2626;
        }

        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
                max-width: 400px;
            }
            
            .login-info-section {
                order: -1;
                padding: 2rem;
            }
            
            .login-form-section {
                padding: 2rem;
            }
            
            .info-title {
                font-size: 2rem;
            }
        }
    </style>
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
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="role">Role</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="">Select your role</option>
                            <option value="admin">Hospital Administrator</option>
                            <option value="doctor">Doctor</option>
                            <option value="nurse">Nurse</option>
                            <option value="receptionist">Receptionist</option>
                            <option value="lab">Laboratory Staff</option>
                            <option value="pharmacist">Pharmacist</option>
                            <option value="accountant">Accountant</option>
                            <option value="it">IT Staff</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="login-btn">
                        <i class="fas fa-sign-in-alt"></i> Login to Dashboard
                    </button>
                </form>
            </div>
        </div>
        <script>
            // Clear error messages when user starts typing
            document.addEventListener('DOMContentLoaded', function() {
                const inputs = document.querySelectorAll('input, select');
                const errorMessage = document.querySelector('.error-message');
                const successMessage = document.querySelector('.success-message');
                
                // Clear error/success messages when user starts typing
                inputs.forEach(input => {
                    input.addEventListener('input', function() {
                        if (errorMessage) {
                            errorMessage.style.display = 'none';
                        }
                        if (successMessage) {
                            successMessage.style.display = 'none';
                        }
                        
                        // Remove error styling
                        this.classList.remove('error');
                    });
                    
                    // Add focus effects
                    input.addEventListener('focus', function() {
                        this.classList.remove('error');
                    });
                });
                
                // Auto-hide messages after 5 seconds
                if (errorMessage || successMessage) {
                    setTimeout(function() {
                        if (errorMessage) errorMessage.style.display = 'none';
                        if (successMessage) successMessage.style.display = 'none';
                    }, 5000);
                }
            });
        </script>
    </body>
</html>