<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoSaidaModel extends Model
{
    protected $table = 'tipo_saida'; // Nome da tabela
    protected $primaryKey = 'id'; // Chave primária
    protected $returnType = 'object';

    // Campos permitidos para inserção e atualização
    protected $allowedFields = [
        'codigo',
        'descricao',
        'registro_ativo',
        'data_insert' // Opcional para updates manuais
    ];

    // Configurações de validação
    protected $validationRules = [
        'codigo' => 'required|max_length[2]|is_unique[tipo_saida.codigo,id,{id}]',
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
