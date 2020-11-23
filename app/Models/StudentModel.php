<?php namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model{
  protected $table = 'student';
  protected $allowedFields = ['user_id', 'name', 'email', 'address','dob', 'updated_at','deleted_at'];
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
