<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
	private function requireAuth()
	{
		if (!session()->get('logged_in')) {
			return redirect()->to('/login')->with('error', 'Please log in to access your profile.');
		}
		return null;
	}

	private function getCurrentUserData()
	{
		helper('UserHelper');
		return \App\Helpers\UserHelper::getCurrentUser();
	}

	public function index()
	{
		$auth = $this->requireAuth();
		if ($auth) return $auth;

		$data = [
			'currentUser' => $this->getCurrentUserData(),
		];

		return view('profile/index', $data);
	}

	public function update()
	{
		$auth = $this->requireAuth();
		if ($auth) return $auth;

		$userId = session()->get('user_id');
		$userModel = new UserModel();

		$payload = [
			'first_name' => trim($this->request->getPost('first_name') ?? ''),
			'last_name' => trim($this->request->getPost('last_name') ?? ''),
			'username' => trim($this->request->getPost('username') ?? ''),
			'phone' => trim($this->request->getPost('phone') ?? ''),
			'department' => trim($this->request->getPost('department') ?? ''),
		];

		// Do not let role/email be changed here by default (except email allowed as profile field)
		$email = trim($this->request->getPost('email') ?? '');
		if ($email !== '') {
			$payload['email'] = $email;
		}

		if (!$userModel->update($userId, $payload)) {
			$errors = $userModel->errors();
			return $this->response->setStatusCode(422)->setJSON([
				'status' => 'error',
				'errors' => $errors,
			]);
		}

		return $this->response->setJSON([
			'status' => 'success',
			'message' => 'Profile updated successfully.'
		]);
	}

	public function updatePassword()
	{
		$auth = $this->requireAuth();
		if ($auth) return $auth;

		$userId = session()->get('user_id');
		$userModel = new UserModel();

		$currentPassword = $this->request->getPost('current_password');
		$newPassword = $this->request->getPost('new_password');
		$confirmPassword = $this->request->getPost('confirm_password');

		if (!$currentPassword || !$newPassword || !$confirmPassword) {
			return $this->response->setStatusCode(400)->setJSON([
				'status' => 'error',
				'message' => 'All password fields are required.'
			]);
		}

		if ($newPassword !== $confirmPassword) {
			return $this->response->setStatusCode(400)->setJSON([
				'status' => 'error',
				'message' => 'New passwords do not match.'
			]);
		}

		$existing = $userModel->find($userId);
		if (!$existing || !password_verify($currentPassword, $existing['password'])) {
			return $this->response->setStatusCode(401)->setJSON([
				'status' => 'error',
				'message' => 'Current password is incorrect.'
			]);
		}

		if (!$userModel->update($userId, ['password' => $newPassword])) {
			return $this->response->setStatusCode(422)->setJSON([
				'status' => 'error',
				'errors' => $userModel->errors()
			]);
		}

		return $this->response->setJSON([
			'status' => 'success',
			'message' => 'Password updated successfully.'
		]);
	}
}


