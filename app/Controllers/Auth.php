<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
	public function login()
	{
		// If user is already logged in, redirect to appropriate dashboard
		if (session()->get('logged_in')) {
			$role = session()->get('role');
			switch ($role) {
				case 'admin':
					return redirect()->to('/admin/dashboard');
				case 'nurse':
					return redirect()->to('/nurse/dashboard');
				
			}
		}
		
		return view('login');
	}

	public function loginSubmit()
	{
		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');
		$role = $this->request->getPost('role');

		// Check if all fields are filled
		if (empty($email) || empty($password) || empty($role)) {
			return redirect()->to('/login')->with('error', 'Please fill in all fields');
		}

		$userModel = new UserModel();
		$user = $userModel->where('email', $email)->first();

		// Check if user exists
		if (!$user) {
			return redirect()->to('/login')->with('error', 'Email address not found');
		}

		// Check if password is correct
		if (!password_verify($password, $user['password'])) {
			return redirect()->to('/login')->with('error', 'Incorrect password');
		}

		// Check if role matches
		if ($user['role'] !== $role) {
			return redirect()->to('/login')->with('error', 'Selected role does not match your account');
		}

		// All validations passed, set session
		session()->set([
			'user_id'   => $user['id'],
			'email'     => $user['email'],
			'role'      => $user['role'],
			'logged_in' => true,
			'last_activity' => time(),
		]);

		// Redirect based on role
		switch ($user['role']) {
			case 'admin':
				return redirect()->to('/admin/dashboard');
			case 'doctor':
				return redirect()->to('/doctor/dashboard');
			case 'nurse':
				return redirect()->to('/nurse/dashboard');
			case 'receptionist':
				return redirect()->to('/receptionist/dashboard');
			case 'pharmacist':
				return redirect()->to('/pharmacist/dashboard');
			case 'accountant':
				return redirect()->to('/accountant/dashboard');
			case 'laboratorist':
				return redirect()->to('/laboratorist/dashboard');
			case 'it_staff':
				return redirect()->to('/it_staff/dashboard');
			default:
				return redirect()->to('/login')->with('error', 'Invalid role');
		}
	}

	public function logout()
	{
		$username = session()->get('username');
		session()->destroy();
		return redirect()->to('/login')->with('success', 'Successfully logged out. Goodbye, ' . $username . '!');
	}

	public function heartbeat()
	{
		// Check if user is logged in
		if (!session()->get('logged_in')) {
			return $this->response->setStatusCode(401)->setJSON([
				'status' => 'error',
				'message' => 'Session expired'
			]);
		}

		// Update session activity timestamp
		session()->set('last_activity', time());

		return $this->response->setJSON([
			'status' => 'success',
			'message' => 'Session active',
			'timestamp' => time()
		]);
	}

	public function checkSession()
	{
		$isLoggedIn = session()->get('logged_in');
		$lastActivity = session()->get('last_activity');
		$currentTime = time();

		// Check if session exists and is recent (within 2 hours of inactivity)
		$sessionValid = $isLoggedIn && (!$lastActivity || ($currentTime - $lastActivity) < 7200);

		if (!$sessionValid) {
			return $this->response->setStatusCode(401)->setJSON([
				'valid' => false,
				'message' => 'Session expired or invalid'
			]);
		}

		// Update last activity timestamp
		session()->set('last_activity', $currentTime);

		return $this->response->setJSON([
			'valid' => true,
			'message' => 'Session is valid',
			'user_id' => session()->get('user_id'),
			'role' => session()->get('role')
		]);
	}

	public function logoutBeacon()
	{
		// Handle beacon logout request (from beforeunload event)
		$input = $this->request->getJSON(true);
		
		if ($input && isset($input['action']) && $input['action'] === 'tab_close') {
			// Log the tab close event if needed
			log_message('info', 'User closed tab/browser at ' . date('Y-m-d H:i:s'));
		}

		// Destroy session
		session()->destroy();

		return $this->response->setJSON([
			'status' => 'success',
			'message' => 'Session terminated'
		]);
	}
}