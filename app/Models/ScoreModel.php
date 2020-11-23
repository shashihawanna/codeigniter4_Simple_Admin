<?php

namespace App\Models;

use CodeIgniter\Model;

class ScoreModel extends Model
{
  protected $table = 'scores';
  protected $allowedFields = ['user_id', 'student_id', 'subject_id', 'marks', 'updated_at', 'deleted_at'];
  protected $beforeInsert = ['beforeInsert'];
  protected $beforeUpdate = ['beforeUpdate'];




  protected function beforeInsert(array $data)
  {
    $data['data']['created_at'] = date('Y-m-d H:i:s');
    return $data;
  }

  protected function beforeUpdate(array $data)
  {
    $data['data']['updated_at'] = date('Y-m-d H:i:s');
    return $data;
  }

  public function getScore()
  {
   
    $this->select("sc.id,sc.marks,sc.created_at,sc.user_id,st.id as student_id,st.name as student_name,sub.id as subject_id,sub.name as subject_name,sub.max_marks");
    $this->from('scores as sc');
    $this->join('subject as sub', 'sub.id = sc.subject_id', 'LEFT');
    $this->join('student as st', 'st.id = sc.student_id', 'LEFT');
    $this->where('sc.deleted_at IS NULL', NULL, TRUE);
    $this->groupBy("sc.id");
    $query = $this->get();
    return $query->getResult();
  }
}
