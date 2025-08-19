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
			if ($role === 'admin') {
				return redirect()->to('/admin/dashboard');
			}
			// For other roles, you can add specific redirects later
			return redirect()->to('/admin/dashboard');
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
			'username'  => $user['username'],
			'role'      => $user['role'],
			'logged_in' => true,
		]);

		// Redirect based on role
		if ($role === 'admin') {
			return redirect()->to('/admin/dashboard')->with('success', 'Welcome back, ' . $user['username'] . '!');
		} else {
			// For other roles, redirect to admin dashboard for now
			// You can add specific redirects for different roles later
			return redirect()->to('/admin/dashboard')->with('success', 'Welcome back, ' . $user['username'] . '!');
		}
	}

	public function logout()
	{
		$username = session()->get('username');
		session()->destroy();
		return redirect()->to('/login')->with('success', 'Successfully logged out. Goodbye, ' . $username . '!');
	}
}