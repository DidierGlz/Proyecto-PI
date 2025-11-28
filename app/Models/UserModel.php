<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'user';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['name', 'login', 'password_hash', 'role'];
    protected $useTimestamps = false;

    protected $validationRules = [
        'name'     => 'required|min_length[3]',
        'login'    => 'required|min_length[3]',
        'password' => 'permit_empty|min_length[4]',
    ];
}
