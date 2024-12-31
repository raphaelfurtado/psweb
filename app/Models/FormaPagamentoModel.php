<?php

namespace App\Models;

use CodeIgniter\Model;

class FormaPagamentoModel extends Model
{
    protected $table = 'forma_pagamento';
    protected $primaryKey = 'id';
    protected $allowedFields = ['codigo', 'descricao', 'data_insert'];
    protected $returnType = 'object';
}
