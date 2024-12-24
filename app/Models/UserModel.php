<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['telefone', 'telefone_2', 'aniversario', 'nome', 'senha', 'role'];
    protected $returnType = 'object';

    public function login($telefone, $senha)
    {
        $user = $this->where('telefone', $telefone)->first();

        if ($user && password_verify($senha, $user->senha)) {
            return $user;
        }

        return false;
    }
}
