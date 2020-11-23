<?php

namespace App\Controllers;

use App\Models\StudentModel;

class Student extends BaseController
{
	public function index()
	{
		$data = [];
		$studentModel = new StudentModel();
		if ($this->request->getMethod() == 'post') {
			$rules = [
				'email' => 'required|min_length[6]|max_length[50]|valid_email',
				'name' => 'required|min_length[3]|max_length[255]',
				'dob' => 'required',
				'address' => 'required|min_length[3]|max_length[255]',

			];
			$id = $this->request->getPost('student_id');
			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {
				$data = [
					'user_id' => session()->get('id'),
					'email' => $this->request->getPost('email'),
					'name' => $this->request->getPost('name'),
					'dob' => date("Y-m-d", strtotime($this->request->getPost('dob'))),
					'address' => $this->request->getPost('address'),
				];
				if (!empty($id)) {
					
					$studentModel->update($this->request->getPost('student_id'), $data);
					$info = [
						'id' => $id,
						'userRole' =>$this->userRole()
					];
					log_message('info', 'Student:{id} updated by {userRole} ',$info);

				} else {
					$studentModel->save($data);
					$info = [
						'id' => $studentModel->insertID(),
						'userRole' =>$this->userRole()
					];
					log_message('info', 'Student:{id} added by {userRole} ',$info);
				}
			}
		}
		$data['title'] = 'Student';
		$data['students'] = $studentModel->where('deleted_at IS NULL', NULL, TRUE)->findAll();
		$data['rolId'] = $this->roleID();
		$data['userId'] = $this->userID();
		echo view('templates/header', $data);
		echo view('student');
		echo view('templates/footer');
	}

	public function delete()
	{
		$student = new StudentModel();
		$id = $this->request->getPost('dstudent_id');
		if ($student->find($id)) {
			$data = [
				'deleted_at' =>  date('Y-m-d H:i:s'),
			];
			$student->update($id, $data);
			$info = [
				'id' => $id,
				'userRole' =>$this->userRole()
			];
			log_message('info', 'Student:{id} deleted by {userRole} ',$info);
			session()->setFlashdata('message', 'Deleted Successfully!');
			session()->setFlashdata('alert-class', 'alert-success');
		} else {
			session()->setFlashdata('message', 'Record not found!');
			session()->setFlashdata('alert-class', 'alert-danger');
		}
		return redirect()->route('student');
	}
}
