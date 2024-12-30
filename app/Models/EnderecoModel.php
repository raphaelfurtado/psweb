<?php

namespace App\Models;

use CodeIgniter\Model;

class EnderecoModel extends Model
{
    protected $table = 'endereco';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_usuario', 'rua', 'numero', 'quadra', 'qtd_lote','data_insert'];
    protected $returnType = 'object';

    public function getEnderecoByUsuarioId($usuarioId)
    {
        return $this->where('id_usuario', $usuarioId)->first();
    }
}
