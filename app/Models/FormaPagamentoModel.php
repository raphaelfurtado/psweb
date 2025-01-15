<?php

namespace App\Models;

use CodeIgniter\Model;

class FormaPagamentoModel extends Model
{
    protected $table = 'forma_pagamento';
    protected $primaryKey = 'id';
    protected $allowedFields = ['codigo', 'descricao', 'registro_ativo', 'data_insert'];
    protected $returnType = 'object';



    // Configurações de validação
    protected $validationRules = [
        'codigo' => 'required|max_length[2]|is_unique[forma_pagamento.codigo,id,{id}]',
        'descricao' => 'required|max_length[50]'
    ];

    // Configurações de mensagens personalizadas de validação
    protected $validationMessages = [
        'codigo' => [
            'is_unique' => 'O Código informado já está cadastrado.',
            'required' => 'Campo obrigatório.'
        ],
        'descricao' => [
            'required' => 'Campo obrigatório.'
        ]
    ];
}
