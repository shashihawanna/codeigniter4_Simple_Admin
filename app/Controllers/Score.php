<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\SubjectModel;
use App\Models\ScoreModel;

class Score extends BaseController
{
    public function index()
    {
        $data = [];
        $scoreModel = new ScoreModel();
        $studentModel = new StudentModel();
        $subjectModel = new SubjectModel();
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'student_id' => 'required|min_length[1]|max_length[11]',
                'subject_id' => 'required|min_length[1]|max_length[11]',
                'marks' => 'required|min_length[1]|max_length[11]',

            ];
            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $data = [
                    'user_id' => session()->get('id'),
                    'student_id' => $this->request->getPost('student_id'),
                    'subject_id' => $this->request->getPost('subject_id'),
                    'marks' => $this->request->getPost('marks'),

                ];
                if (!empty($this->request->getPost('score_id'))) {

                    $scoreModel->update($this->request->getPost('score_id'), $data);
                    $info = [
						'id' => $this->request->getPost('score_id'),
						'userRole' =>$this->userRole()
					];
					log_message('info', 'Score:{id} updated by {userRole} ',$info);
                } else {
                    $scoreModel->save($data);
                    $info = [
						'id' => $scoreModel->insertID(),
						'userRole' =>$this->userRole()
					];
					log_message('info', 'Score:{id} added by {userRole} ',$info);
                }
            }
        }
        $data['title'] = 'Score';
        $data['scores'] = $scoreModel->getScore();
        $data['students'] = $studentModel->where('deleted_at IS NULL', NULL, TRUE)->findAll();
        $data['subjects'] = $subjectModel->where('deleted_at IS NULL', NULL, TRUE)->findAll();
        $data['rolId'] = $this->roleID();
        $data['userId'] = $this->userID();
        echo view('templates/header', $data);
        echo view('score');
        echo view('templates/footer');
    }

    public function delete()
    {
        $score = new ScoreModel();
        $id = $this->request->getPost('dscore_id');
        if ($score->find($id)) {
            $data = [
                'deleted_at' =>  date('Y-m-d H:i:s'),
            ];
            $score->update($id, $data);
            $info = [
                'id' => $id,
                'userRole' => $this->userRole()
            ];
            log_message('info', 'Score:{id} deleted by {userRole} ', $info);
            session()->setFlashdata('message', 'Deleted Successfully!');
            session()->setFlashdata('alert-class', 'alert-success');
        } else {
            session()->setFlashdata('message', 'Record not found!');
            session()->setFlashdata('alert-class', 'alert-danger');
        }
        return redirect()->route('score');
    }
}
