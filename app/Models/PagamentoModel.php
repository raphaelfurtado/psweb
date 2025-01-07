<?php

namespace App\Models;

use CodeIgniter\Model;

class PagamentoModel extends Model
{
    protected $table = 'pagamento';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_usuario', 'id_recebedor', 'id_tipo_pagamento', 'id_forma_pagamento', 'data_pagamento', 'referencia', 'valor', 'situacao', 'observacao', 'data_insert'];
    protected $returnType = 'object';


    public function getTotalPago()
    {
        return $this->selectSum('valor', 'total')
                    ->where('situacao', 'PAGO')
                    ->get()
                    ->getRow();
    }


    public function getInfoMensalidadePorReferencia()
    {
        $currentMonth = date('m'); // Mês atual
        $currentYear = date('Y'); // Ano atual
        $lastYear = $currentYear - 1; // Ano anterior

        $query = $this->select("
            DISTINCT 
            CONCAT(
                CASE 
                    WHEN SUBSTR(referencia, 1, 2) = '01' THEN 'JAN'
                    WHEN SUBSTR(referencia, 1, 2) = '02' THEN 'FEV'
                    WHEN SUBSTR(referencia, 1, 2) = '03' THEN 'MAR'
                    WHEN SUBSTR(referencia, 1, 2) = '04' THEN 'ABR'
                    WHEN SUBSTR(referencia, 1, 2) = '05' THEN 'MAI'
                    WHEN SUBSTR(referencia, 1, 2) = '06' THEN 'JUN'
                    WHEN SUBSTR(referencia, 1, 2) = '07' THEN 'JUL'
                    WHEN SUBSTR(referencia, 1, 2) = '08' THEN 'AGO'
                    WHEN SUBSTR(referencia, 1, 2) = '09' THEN 'SET'
                    WHEN SUBSTR(referencia, 1, 2) = '10' THEN 'OUT'
                    WHEN SUBSTR(referencia, 1, 2) = '11' THEN 'NOV'
                    WHEN SUBSTR(referencia, 1, 2) = '12' THEN 'DEZ'
                END,
                '/',
                SUBSTR(referencia, 3, 4)
            ) AS label,
            referencia AS codigo,
            id_tipo_pagamento,
        
            -- Soma dos valores de 'valor' por referência, situação e tipo de pagamento
            FORMAT(SUM(CASE WHEN situacao = 'PAGO' THEN valor ELSE 0 END), 2, 'pt_BR') AS total_pago,
            FORMAT(SUM(CASE WHEN situacao = 'ABERTO' THEN valor ELSE 0 END), 2, 'pt_BR') AS total_aberto,
            FORMAT(SUM(valor), 2, 'pt_BR') AS total_geral,
        
            -- Contagem de registros por referência, situação e tipo de pagamento
            COUNT(CASE WHEN situacao = 'PAGO' THEN 1 ELSE NULL END) AS total_quantidade_pago,
            COUNT(CASE WHEN situacao = 'ABERTO' THEN 1 ELSE NULL END) AS total_quantidade_aberto,
            COUNT(*) AS total_quantidade_geral
        ", FALSE);

        if ($currentMonth == 1) {
            // Janeiro: incluir dezembro do ano anterior e ano atual
            $query->where("(
                (SUBSTR(referencia, 1, 2) = '12' AND SUBSTR(referencia, 3, 4) = '{$lastYear}') 
                OR 
                (SUBSTR(referencia, 3, 4) = '{$currentYear}')
            )", NULL, FALSE);
        } else {
            // Outros meses: apenas ano corrente
            $query->where("SUBSTR(referencia, 3, 4) = '{$currentYear}'", NULL, FALSE);
        }

        // Inclui o filtro para `id_tipo_pagamento`
        //$query->where("id_tipo_pagamento = '{$tipo_pagamento}'", NULL, FALSE);

        // Agrupa por referência e tipo de pagamento
        $result = $query->groupBy(['referencia', 'id_tipo_pagamento'])
            ->orderBy('referencia', 'ASC')
            ->findAll();

        // Estruturação do resultado
        $formattedResult = [];

        foreach ($result as $row) {
            // Verifica se já existe um item com o código (referência)
            if (!isset($formattedResult[$row->codigo])) {
                // Se não existir, cria um novo
                $formattedResult[$row->codigo] = [
                    'label' => $row->label,
                    'codigo' => $row->codigo,
                    'id_tipo_pagamento' => [],
                ];
            }

            // Adiciona as informações de 'id_tipo_pagamento' na estrutura
            $formattedResult[$row->codigo]['id_tipo_pagamento'][$row->id_tipo_pagamento] = [
                'total_pago' => $row->total_pago,
                'total_aberto' => $row->total_aberto,
                'total_geral' => $row->total_geral,
                'total_quantidade_pago' => $row->total_quantidade_pago,
                'total_quantidade_aberto' => $row->total_quantidade_aberto,
                'total_quantidade_geral' => $row->total_quantidade_geral,
                'tipo' => $row->id_tipo_pagamento,
                'ref' => $row->codigo,
            ];
        }

        // Retorna a estrutura organizada
        return array_values($formattedResult);
    }

}
