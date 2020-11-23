<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserRoleModel;

class Users extends BaseController
{
	public function index()
	{
		$data = [
			'title' => 'Login'
		];
		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'email' => 'required|min_length[6]|max_length[50]|valid_email',
				'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
			];

			$errors = [
				'password' => [
					'validateUser' => 'Email or Password don\'t match'
				]
			];

			if (!$this->validate($rules, $errors)) {
				$data['validation'] = $this->validator;
			} else {
				$model = new UserModel();

				$user = $model->where('email', $this->request->getVar('email'))
					->first();

				$this->setUserSession($user);

				return redirect()->to('/student');
			}
		}
		$data['rolId'] = $this->roleID();
		$data['userId'] = $this->userID();
		echo view('templates/header.php', $data);
		echo view('login.php');
		echo view('templates/footer.php');
	}

	public function profile()
	{

		$data = [
			'title' => 'Profile'
		];
		$model = new UserModel();

		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'firstname' => 'required|min_length[3]|max_length[20]',
				'lastname' => 'required|min_length[3]|max_length[20]',
			];

			if ($this->request->getPost('password') != '') {
				$rules['password'] = 'required|min_length[8]|max_length[255]';
				$rules['password_confirm'] = 'matches[password]';
			}
			if (!empty($_FILES['profile_url']['name'])) {
				$rules['profile_url']  = 'uploaded[profile_url]|mime_in[profile_url,image/jpg,image/jpeg,image/png]|max_size[profile_url,1024]';
			}
			$errors = [
				'password_confirm' => [
					'matches[password]' => 'The confirm password does not match the password.'
				],
				'profile_url' => [
					'mime_in' => 'Profile Picture does not have a valid mime type.',
					'max_size' => 'Profile Picture is too large of a file  upload 1024kb file.'
				]
			];

			if (!$this->validate($rules, $errors)) {
				$data['validation'] = $this->validator;
			} else {


				$newData = [
					'id' => session()->get('id'),
					'firstname' => $this->request->getPost('firstname'),
					'lastname' => $this->request->getPost('lastname'),
				];
				if (!empty($_FILES['profile_url']['name'])) {
					$img = $this->request->getFile('profile_url');
					$img->move(ROOTPATH . 'public/uploads');
					$newData['profile_url'] =  $img->getName();
				}
				if ($this->request->getPost('password') != '') {
					$newData['password'] = $this->request->getPost('password');
				}
				$model->save($newData);

				session()->setFlashdata('success', 'Successfuly Updated');
				return redirect()->to('/profile');
			}
		}

		$data['user'] = $model->where('id', session()->get('id'))->first();
		$data['rolId'] = $this->roleID();
		$data['userId'] = $this->userID();
		echo view('templates/header', $data);
		echo view('profile');
		echo view('templates/footer');
	}
	private function setUserSession($user)
	{
		$data = [
			'id' => $user['id'],
			'firstname' => $user['firstname'],
			'lastname' => $user['lastname'],
			'email' => $user['email'],
			'role_id' => $user['user_role_id'],
			'isLoggedIn' => true,
		];

		session()->set($data);
		return true;
	}

	public function logout()
	{
		session()->destroy();
		return redirect()->to('/');
	}

	public function allUsers()
	{
		$data = [
			'title' => 'Users'
		];
		$model = new UserModel();
		$role = new UserRoleModel();
		$data['allUser'] = $model->where('deleted_at IS NULL', NULL, TRUE)->findAll();
		$data['allRoles'] =  $role->findAll();
		$data['rolId'] = $this->roleID();
		$data['userId'] = $this->userID();
		echo view('templates/header', $data);
		echo view('users');
		echo view('templates/footer');
	}


	public function register()
	{

		$data = [
			'title' => 'Users'
		];
		$model = new UserModel();

		if ($this->request->getMethod() == 'post') {
			if (!empty($_FILES['profile_url']['name'])) {
				$rules['profile_url']  = 'uploaded[profile_url]|mime_in[profile_url,image/jpg,image/jpeg,image/png]|max_size[profile_url,1024]';
			}
			$errors = [
				'password_confirm' => [
					'matches[password]' => 'The confirm password does not match the password.'
				],
				'profile_url' => [
					'mime_in' => 'Profile Picture does not have a valid mime type.',
					'max_size' => 'Profile Picture is too large of a file  upload 1024kb file.'
				]
			];
			if (!empty($this->request->getPost('user_id'))) {
				$rules = [
					'firstname' => 'required|min_length[3]|max_length[20]',
					'lastname' => 'required|min_length[3]|max_length[20]',
					'email' => 'required|min_length[6]|max_length[50]|valid_email',
					'ut_id' => 'required|min_length[1]|max_length[11]',
				];
				if ($this->request->getPost('password') != '') {
					$rules['password'] = 'required|min_length[8]|max_length[255]';
					$rules['password_confirm'] = 'matches[password]';
				}

				if (!$this->validate($rules, $errors)) {
					$data['validation'] = $this->validator;
				} else {
					$newData = [
						'firstname' => $this->request->getVar('firstname'),
						'lastname' => $this->request->getVar('lastname'),
						'email' => $this->request->getVar('email'),
						'user_role_id' => $this->request->getVar('ut_id'),
					];

					if ($this->request->getPost('password') != '') {
						$newData['password'] = $this->request->getPost('password');
					}
					if (!empty($_FILES['profile_url']['name'])) {
						$img = $this->request->getFile('profile_url');
						$img->move(ROOTPATH . 'public/uploads');
						$newData['profile_url'] =  $img->getName();
					}
					$model->update($this->request->getPost('user_id'), $newData);
					$info = [
						'id' => $this->request->getPost('user_id'),
						'userRole' => $this->userRole()
					];
					log_message('info', 'User:{id} updated by {userRole} ', $info);
				}
				return redirect()->to('user');
			} else {

				$rules = [
					'firstname' => 'required|min_length[3]|max_length[20]',
					'lastname' => 'required|min_length[3]|max_length[20]',
					'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
					'password' => 'required|min_length[8]|max_length[255]',
					'ut_id' => 'required|min_length[1]|max_length[11]',
					'password_confirm' => 'matches[password]',
				];

				if (!$this->validate($rules, $errors)) {
					$data['validation'] = $this->validator;
				} else {

					$newData = [
						'firstname' => $this->request->getVar('firstname'),
						'lastname' => $this->request->getVar('lastname'),
						'email' => $this->request->getVar('email'),
						'user_role_id' => $this->request->getVar('ut_id'),
						'password' => $this->request->getVar('password'),
					];
					if (!empty($_FILES['profile_url']['name'])) {
						$img = $this->request->getFile('profile_url');
						$img->move(ROOTPATH . 'public/uploads');
						$newData['profile_url'] =  $img->getName();
					}
					$model->save($newData);
					$info = [
						'id' => $model->insertID(),
						'userRole' => $this->userRole()
					];
					log_message('info', 'User:{id} added by {userRole} ', $info);
					return redirect()->to('user');
				}
			}
		}

		return redirect()->to('user');
	}

	public function deleteUser()
	{
		$user = new UserModel();
		$id = $this->request->getPost('duser_id');
		if ($user->find($id)) {
			$data = [
				'deleted_at' =>  date('Y-m-d H:i:s'),
			];
			$user->update($id, $data);
			$info = [
				'id' => $id,
				'userRole' => $this->userRole()
			];
			log_message('info', 'User:{id} deleted by {userRole} ', $info);
			session()->setFlashdata('message', 'Deleted Successfully!');
			session()->setFlashdata('alert-class', 'alert-success');
		} else {
			session()->setFlashdata('message', 'Record not found!');
			session()->setFlashdata('alert-class', 'alert-danger');
		}
		return redirect()->route('user');
	}
}
