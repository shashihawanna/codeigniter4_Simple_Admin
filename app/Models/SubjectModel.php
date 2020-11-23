<?php namespace App\Models;

use CodeIgniter\Model;

class SubjectModel extends Model{
  protected $table = 'subject';
  protected $allowedFields = ['user_id', 'name', 'max_marks', 'updated_at','deleted_at'];
  protected $beforeInsert = ['beforeInsert'];
  protected $beforeUpdate = ['beforeUpdate'];




  protected function beforeInsert(array $data){
    $data['data']['created_at'] = date('Y-m-d H:i:s');

    return $data;
  }

  protected function beforeUpdate(array $data){
    $data['data']['updated_at'] = date('Y-m-d H:i:s');
    return $data;
  }


}
