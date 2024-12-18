<?php

namespace App\Models;

use CodeIgniter\Model;

class RecebedorModel extends Model
{
    protected $table = 'recebedor';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome', 'telefone', 'telefone_2', 'data_nascimento', 'data_insert'];
    protected $returnType = 'object';
}
