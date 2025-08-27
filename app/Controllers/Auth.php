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
}