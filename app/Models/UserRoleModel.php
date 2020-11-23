<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRoleModel extends Model
{
    protected $table = 'user_role';
    protected $allowedFields = ['role_name', 'deleted_at'];

   
}
