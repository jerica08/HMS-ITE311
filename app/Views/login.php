<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Hospital Management System</title>
	<style>
		body{
			font-family: 'Inter', sans-serif;
			background-color: #f0f4f8;
			display:flex;
			flex-direction: column;
			min-height: 100vh;
		}

		.header{
			background-color: #1a4484;
			color: #ffffff;
			justify-content:center;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}
		.header-container{
			max-width: 14px;
			margin-left: auto;
			margin-right: auto;
		}
		.header h1{
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 30px;
			line-height:28px;
			 font-weight: 600;
			 letter-spacing: 0.8px;		
		}
		.main{
			flex-grow: 1;
			display: flex;
			align-items: center;
			justify-content:center;
			padding:16px;
		}
		.login-card{
			background-color: #dbe9f6;
			padding: 36px;
			border-top-left-radius: 12px;
			border-top-right-radius: 12px;
			box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0,0,0, 0.6);
			width:auto;
			
		}
		.login-card-header{
			background-color: #7599e0;
			padding: 2px 2px;
			margin-bottom: 24px;
		}
		.login-card-header h2{
			text-align: center;
			font-size: 20px;
			line-height: 28px;
			font-weight: 700;
			color: #080808;
		}
		.form-group{
			margin-bottom: 16px;
		}
		.form-group-label{
			display: block;
			color: #4b5563;
			font-weight: 600;
			margin-bottom: 8px;			
		}
		.form-group input, .form-group select{
			width: 100%;
			padding: 8px 12px;
			border: 1px solid #d1d5db;
			border-radius: 6px;
			outline: none;
		}
		.button-group{
			display: flex;
			justify-content: center;
		}
		.btn-login{
			background-color: #4a8fe0;
			color:#ffffff;
			padding: 8px 24px;
			border-radius: 6px;
			box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
			transition: background-color 0.3s ease;
		}
		.btn-login:hover{
			background-color: #3b82f6;

		}
		.error-message {
			background-color: #fee2e2;
			color: #dc2626;
			padding: 12px;
			border-radius: 6px;
			margin-bottom: 16px;
			text-align: center;
			font-weight: 600;
			border: 1px solid #fca5a5;
			box-shadow: 0 2px 4px rgba(220, 38, 38, 0.1);
		}
		
		.success-message {
			background-color: #dcfce7;
			color: #16a34a;
			padding: 12px;
			border-radius: 6px;
			margin-bottom: 16px;
			text-align: center;
			font-weight: 600;
			border: 1px solid #86efac;
			box-shadow: 0 2px 4px rgba(22, 163, 74, 0.1);
		}
		
		.form-group input:focus, .form-group select:focus {
			border-color: #3b82f6;
			box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
		}
		
		.form-group input.error, .form-group select.error {
			border-color: #dc2626;
			box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
		}
	</style>
</head>
<body class="flex flex-col min-h-screen">
	<header class="header">
		<div class="header-container">
			<h1> Hospital Management System</h1>
		</div>
	</header>

	<main class="main">
		<div class="login-card">
			<div class="login-card-header">
				<h2>Log In</h2> 
			</div>

			<form action="/auth/loginSubmit" method="POST">
				<!--DISPLAY VALIDATION ERRORS-->
				<?php if (session()->getFlashdata('error')): ?>
					<div class="error-message">
					<?= session()->getFlashdata('error') ?>
					</div>
				<?php endif; ?>
				<div class="form-group">
					<label for="role">User Role</label>
					<select id="role" name="role" required>
						<option value="">Select role to log in</option>
						<option value="admin">Admin</option>
						<option value="doctor">Doctor</option>
						<option value="nurse">Nurse</option>
						<option value="receptionist">Receptionist</option>
						<option value="pharmacist">Pharmacist</option>
						<option value="laboratorist">Laboratorist</option>
						<option value="accountant">Accountant</option>
						<option value="it_staff">IT Staff</option>
					</select>
				</div>

				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" id="email" name="email" placeholder="Enter your email" required>	
				</div>

				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" id="password" name="password" placeholder="Enter your password" required>	
				</div>

				<div class="button-group">
					<button type="submit" class="btn-login">
						Log In
					</button>
				</div>
			</form>
		</div>
	</main>
	
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
