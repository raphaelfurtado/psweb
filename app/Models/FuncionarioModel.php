<?php

namespace App\Models;

use CodeIgniter\Model;

class FuncionarioModel extends Model
{
    protected $table = 'funcionarios'; // Nome da tabela
    protected $primaryKey = 'id'; // Chave primária

    // Campos permitidos para inserção e atualização
    protected $allowedFields = [
        'nome_completo',
        'data_nascimento',
        'cpf',
        'rg',
        'endereco_completo',
        'complemento',
        'cidade',
        'estado',
        'cep',
        'telefone_whatsapp',
        'salario',
        'nome_titular_conta',
        'banco',
        'agencia',
        'numero_conta',
        'tipo_conta',
        'chave_pix',
        'observacao',
        'usuario_criacao',
        'usuario_atualizacao',
        'data_criacao', // Opcional para updates manuais
        'ultima_atualizacao' // Opcional para updates manuais
    ];

    // Configurações de validação
    protected $validationRules = [
        'nome_completo' => 'required|max_length[255]',
        'data_nascimento' => 'required|valid_date',
        'cpf' => 'required|exact_length[11]|is_unique[funcionarios.cpf,id,{id}]', // Verifica unicidade no CPF
        'rg' => 'required|max_length[20]',
        'endereco_completo' => 'required|max_length[255]',
        'cidade' => 'required|max_length[100]',
        'estado' => 'required|exact_length[2]',
        'cep' => 'required|exact_length[8]',
        'telefone_whatsapp' => 'required|max_length[20]',
        'salario' => 'required',
        'nome_titular_conta' => 'required|max_length[255]',
        'banco' => 'required|max_length[100]',
        'agencia' => 'required|max_length[20]',
        'numero_conta' => 'required|max_length[50]',
        'tipo_conta' => 'required|in_list[01,02,03]',
        'chave_pix' => 'required|max_length[255]',
        'observacao' => 'permit_empty',
        'usuario_criacao' => 'required|integer',
        'usuario_atualizacao' => 'permit_empty|integer'
    ];

    // Configurações de mensagens personalizadas de validação
    protected $validationMessages = [
        'cpf' => [
            'is_unique' => 'O CPF informado já está cadastrado.',
            'exact_length' => 'O CPF deve conter exatamente 11 caracteres.',
            'required' => 'Campo obrigatório.'
        ],
        'estado' => [
            'exact_length' => 'O estado deve conter exatamente 2 caracteres (UF).',
            'required' => 'Campo obrigatório.'
        ],
        'tipo_conta' => [
            'in_list' => 'O tipo de conta deve ser: corrente, poupança ou salário.',
            'required' => 'Campo obrigatório.'
        ],
        'nome_completo' => [
            'required' => 'Campo obrigatório.'
        ],
        'data_nascimento' => [
            'required' => 'Campo obrigatório.'
        ],
        'rg' => [
            'required' => 'Campo obrigatório.'
        ],
        'endereco_completo' => [
            'required' => 'Campo obrigatório.'
        ],
        'cidade' => [
            'required' => 'Campo obrigatório.'
        ],
        'cep' => [
            'required' => 'Campo obrigatório.'
        ],
        'telefone_whatsapp' => [
            'required' => 'Campo obrigatório.'
        ],
        'nome_titular_conta' => [
            'required' => 'Campo obrigatório.'
        ],
        'banco' => [
            'required' => 'Campo obrigatório.'
        ],
        'agencia' => [
            'required' => 'Campo obrigatório.'
        ],
        'numero_conta' => [
            'required' => 'Campo obrigatório.'
        ],
        'chave_pix' => [
            'required' => 'Campo obrigatório.'
        ],
        'salario' => [
            'required' => 'Campo obrigatório.'
        ]
    ];

    // Habilita o uso de timestamps
    protected $useTimestamps = true; // Utiliza os campos data_criacao e ultima_atualizacao
    protected $createdField = 'data_criacao'; // Campo para data de criação
    protected $updatedField = 'ultima_atualizacao'; // Campo para data de atualização

    public function getFuncionariosFormatados()
    {
        // Realizando a consulta com CPF e Salário já formatados no SQL
        $builder = $this->db->table($this->table);

        // Monta o SELECT com formatação
        $builder->select([
            'id',
            'UPPER(nome_completo) AS nome_completo', // Nome em maiúsculas
            "CONCAT(SUBSTRING(cpf, 1, 3), '.', SUBSTRING(cpf, 4, 3), '.', SUBSTRING(cpf, 7, 3), '-', SUBSTRING(cpf, 10, 2)) AS cpf_formatado", // CPF formatado
            "FORMAT(salario, 2, 'de_DE') AS salario_formatado" // Salário formatado como moeda brasileira
        ]);

        // Executa a consulta e retorna os resultados
        return $builder->get()->getResultArray();
    }
}
