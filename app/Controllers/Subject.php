<?php

namespace App\Controllers;

use App\Models\SubjectModel;

class Subject extends BaseController
{
	public function index()
	{
		$data = [];
		$subjectModel = new SubjectModel();
		if ($this->request->getMethod() == 'post') {
			$rules = [
				'name' => 'required|min_length[2]|max_length[255]',
				'max_marks' => 'required|min_length[1]|max_length[11]',

			];
			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {
				$data = [
					'user_id' => session()->get('id'),
					'name' => $this->request->getPost('name'),
					'max_marks' => $this->request->getPost('max_marks'),

				];
				if (!empty($this->request->getPost('subject_id'))) {

					$subjectModel->update($this->request->getPost('subject_id'), $data);
					$info = [
						'id' => $this->request->getPost('subject_id'),
						'userRole' =>$this->userRole()
					];
					log_message('info', 'Subject:{id} updated by {userRole} ',$info);
				} else {
					$subjectModel->save($data);
					$info = [
						'id' => $subjectModel->insertID(),
						'userRole' =>$this->userRole()
					];
					log_message('info', 'Subject:{id} added by {userRole} ',$info);
				}
			}
		}
		$data['title'] = 'Subject';
		$data['subjects'] = $subjectModel->where('deleted_at IS NULL', NULL, TRUE)->findAll();
		$data['rolId'] = $this->roleID();
		$data['userId'] = $this->userID();
		echo view('templates/header', $data);
		echo view('subject');
		echo view('templates/footer');
	}

	public function delete()
	{
		$subject = new SubjectModel();
		$id = $this->request->getPost('dsubject_id');
		if ($subject->find($id)) {
			$data = [
				'deleted_at' =>  date('Y-m-d H:i:s'),
			];
			$subject->update($id, $data);
			$info = [
				'id' => $id,
				'userRole' =>$this->userRole()
			];
			log_message('info', 'Subject:{id} deleted by {userRole} ',$info);
			session()->setFlashdata('message', 'Deleted Successfully!');
			session()->setFlashdata('alert-class', 'alert-success');
		} else {
			session()->setFlashdata('message', 'Record not found!');
			session()->setFlashdata('alert-class', 'alert-danger');
		}
		return redirect()->route('subject');
	}
}
