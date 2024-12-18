<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['telefone', 'telefone_2', 'aniversario', 'nome'];
    protected $returnType = 'object';
}
