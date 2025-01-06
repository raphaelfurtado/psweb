<?php

namespace App\Models;

use CodeIgniter\Model;

class SaidaModel extends Model
{
    protected $table = 'saida';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_recebedor', 'id_tipo_pagamento', 'id_forma_pagamento', 'data_pagamento', 'referencia', 'valor', 'situacao', 'observacao', 'data_insert'];
    protected $returnType = 'object';

    public function getTotalSaida()
    {
        return $this->selectSum('valor', 'total')
                    ->get()
                    ->getRow();
    }
}
