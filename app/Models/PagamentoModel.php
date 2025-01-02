<?php

namespace App\Models;

use CodeIgniter\Model;

class PagamentoModel extends Model
{
    protected $table = 'pagamento';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_usuario', 'id_recebedor', 'id_tipo_pagamento', 'id_forma_pagamento', 'data_pagamento', 'referencia', 'valor', 'situacao', 'observacao', 'data_insert'];
    protected $returnType = 'object';
}
