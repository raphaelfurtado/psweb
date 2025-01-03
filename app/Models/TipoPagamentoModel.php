<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoPagamentoModel extends Model
{
    protected $table = 'tipo_pagamento';
    protected $primaryKey = 'id';
    protected $allowedFields = ['codigo', 'descricao', 'data_insert'];
    protected $returnType = 'object';
}
