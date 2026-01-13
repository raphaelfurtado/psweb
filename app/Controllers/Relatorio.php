<?php

namespace App\Controllers;

use App\Models\PagamentoModel;
use App\Models\SaidaModel;
use App\Models\UserModel;
use App\Models\TipoSaidaModel;
use CodeIgniter\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;

class Relatorio extends BaseController
{
    public function index()
    {
        $data['titulo'] = 'Relatórios';
        return view('relatorios/index', $data);
    }

    private function handleDateRange()
    {
        $referencia = $this->request->getGet('referencia');
        $referencia_inicio = $this->request->getGet('referencia_inicio');
        $referencia_fim = $this->request->getGet('referencia_fim');

        if ($referencia) {
            // Legacy behavior or single month selection
            return [
                'inicio' => $referencia,
                'fim' => $referencia,
                'is_periodo' => false
            ];
        }

        if ($referencia_inicio && $referencia_fim) {
            return [
                'inicio' => $referencia_inicio,
                'fim' => $referencia_fim,
                'is_periodo' => true
            ];
        }

        // Default to current month
        $current = date('mY');
        return [
            'inicio' => $current,
            'fim' => $current,
            'is_periodo' => false
        ];
    }

    private function applyDateRangeFilter($query, $table, $inicio, $fim)
    {
        // Convert mY strings to dates for comparison
        // Using string substitution to create a comparable YYYYMM format would be safer/faster but let's stick to standard SQL
        // Actually, since format is mmYYYY, we can't just compare directly.
        // We can reconstruct dates: STR_TO_DATE(CONCAT('01', referencia), '%d%m%Y')

        $coluna = "$table.referencia";
        $query->where("STR_TO_DATE(CONCAT('01', $coluna), '%d%m%Y') BETWEEN STR_TO_DATE(CONCAT('01', '$inicio'), '%d%m%Y') AND STR_TO_DATE(CONCAT('01', '$fim'), '%d%m%Y')");

        return $query;
    }

    public function fluxoCaixa()
    {
        $pagamentoModel = new PagamentoModel();
        $saidaModel = new SaidaModel();

        $range = $this->handleDateRange();

        // Entradas agrupadas por tipo
        $entradasQuery = $pagamentoModel->select('tipo_pagamento.descricao, SUM(pagamento.valor) as total')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = pagamento.id_tipo_pagamento')
            ->where('pagamento.situacao', 'PAGO');

        $this->applyDateRangeFilter($entradasQuery, 'pagamento', $range['inicio'], $range['fim']);

        $entradas = $entradasQuery->groupBy(['pagamento.id_tipo_pagamento', 'tipo_pagamento.descricao'])
            ->findAll();

        // Saídas agrupadas por tipo
        $saidasQuery = $saidaModel->select('tipo_pagamento.descricao, SUM(saida.valor) as total')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = saida.id_tipo_pagamento');
        //->where('saida.situacao', 'PAGO')

        $this->applyDateRangeFilter($saidasQuery, 'saida', $range['inicio'], $range['fim']);

        $saidas = $saidasQuery->groupBy(['saida.id_tipo_pagamento', 'tipo_pagamento.descricao'])
            ->findAll();

        $data['titulo'] = 'Relatório de Fluxo de Caixa';

        if ($range['is_periodo']) {
            $data['referencia'] = $this->getMesExtenso($range['inicio']) . ' até ' . $this->getMesExtenso($range['fim']);
            $data['referencia_inicio'] = $range['inicio'];
            $data['referencia_fim'] = $range['fim'];
            $data['is_periodo'] = true;
        } else {
            $data['referencia'] = $range['inicio'];
            $data['mes_extenso'] = $this->getMesExtenso($range['inicio']);
            $data['is_periodo'] = false;
        }

        $data['entradas'] = $entradas;
        $data['saidas'] = $saidas;
        $data['meses'] = $pagamentoModel->getMonthsList();

        return view('relatorios/fluxo_caixa', $data);
    }

    public function inadimplencia()
    {
        $pagamentoModel = new PagamentoModel();

        $range = $this->handleDateRange();
        $quadra = $this->request->getGet('quadra');

        $query = $pagamentoModel->select('users.nome, users.telefone, endereco.quadra, endereco.numero, pagamento.valor, pagamento.data_vencimento, pagamento.situacao')
            ->join('users', 'users.id = pagamento.id_usuario')
            ->join('endereco', 'endereco.id_usuario = users.id')
            ->whereIn('pagamento.situacao', ['ABERTO', 'PENDENTE']);

        $this->applyDateRangeFilter($query, 'pagamento', $range['inicio'], $range['fim']);

        if ($quadra) {
            $query->where('endereco.quadra', $quadra);
        }

        $data['inadimplentes'] = $query->orderBy('endereco.quadra', 'ASC')
            ->orderBy('endereco.numero', 'ASC')
            ->findAll();

        $data['titulo'] = 'Relatório de Inadimplência';

        if ($range['is_periodo']) {
            $data['referencia'] = $this->getMesExtenso($range['inicio']) . ' até ' . $this->getMesExtenso($range['fim']);
            $data['referencia_inicio'] = $range['inicio'];
            $data['referencia_fim'] = $range['fim'];
            $data['is_periodo'] = true;
        } else {
            $data['referencia'] = $range['inicio'];
            $data['mes_extenso'] = $this->getMesExtenso($range['inicio']);
            $data['is_periodo'] = false;
        }

        $data['quadra'] = $quadra;
        $data['meses'] = $pagamentoModel->getMonthsList();

        return view('relatorios/inadimplencia', $data);
    }

    public function folhaPagamento()
    {
        $saidaModel = new SaidaModel();

        $range = $this->handleDateRange();

        $query = $saidaModel->select('funcionarios.nome_completo, saida.valor, saida.data_pagamento, saida.observacao, tipo_saida.descricao as tipo')
            ->join('funcionarios', 'funcionarios.id = saida.id_funcionario')
            ->join('tipo_saida', 'tipo_saida.codigo = saida.id_tipo_saida', 'left')
            ->where('saida.id_funcionario IS NOT NULL');

        $this->applyDateRangeFilter($query, 'saida', $range['inicio'], $range['fim']);

        $data['pagamentos'] = $query->findAll();

        $data['titulo'] = 'Relatório de Folha de Pagamento';

        if ($range['is_periodo']) {
            $data['referencia'] = $this->getMesExtenso($range['inicio']) . ' até ' . $this->getMesExtenso($range['fim']);
            $data['referencia_inicio'] = $range['inicio'];
            $data['referencia_fim'] = $range['fim'];
            $data['is_periodo'] = true;
        } else {
            $data['referencia'] = $range['inicio'];
            $data['mes_extenso'] = $this->getMesExtenso($range['inicio']);
            $data['is_periodo'] = false;
        }

        $data['meses'] = (new PagamentoModel())->getMonthsList();

        return view('relatorios/folha_pagamento', $data);
    }

    public function prestacaoContas()
    {
        $pagamentoModel = new PagamentoModel();
        $saidaModel = new SaidaModel();

        $range = $this->handleDateRange();

        // 1. Detalhamento de Receitas
        $receitasQuery = $pagamentoModel->select('users.nome, endereco.quadra, endereco.numero, pagamento.valor, pagamento.data_pagamento, pagamento.observacao, tipo_pagamento.descricao as categoria')
            ->join('users', 'users.id = pagamento.id_usuario')
            ->join('endereco', 'endereco.id_usuario = users.id')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = pagamento.id_tipo_pagamento')
            ->where('pagamento.situacao', 'PAGO');

        $this->applyDateRangeFilter($receitasQuery, 'pagamento', $range['inicio'], $range['fim']);

        $data['receitas_detalhe'] = $receitasQuery->orderBy('pagamento.data_pagamento', 'ASC')
            ->findAll();

        // 2. Detalhamento de Despesas (Unificando funcionários e outros recebedores)
        $despesasQuery = $saidaModel->select('
                saida.valor, 
                saida.data_pagamento, 
                saida.observacao, 
                tipo_pagamento.descricao as categoria,
                COALESCE(funcionarios.nome_completo, recebedor.nome, "Não especificado") as favorecido
            ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = saida.id_tipo_pagamento')
            ->join('funcionarios', 'funcionarios.id = saida.id_funcionario', 'left')
            ->join('recebedor', 'recebedor.id = saida.id_recebedor', 'left');
        //->where('saida.situacao', 'PAGO')

        $this->applyDateRangeFilter($despesasQuery, 'saida', $range['inicio'], $range['fim']);

        $data['despesas_detalhe'] = $despesasQuery->orderBy('saida.data_pagamento', 'ASC')
            ->findAll();

        // 3. Totais para o Resumo
        $data['total_receitas'] = array_sum(array_column($data['receitas_detalhe'], 'valor'));
        $data['total_despesas'] = array_sum(array_column($data['despesas_detalhe'], 'valor'));

        $data['titulo'] = 'Prestação de Contas Detalhada';

        if ($range['is_periodo']) {
            $data['referencia'] = $this->getMesExtenso($range['inicio']) . ' até ' . $this->getMesExtenso($range['fim']);
            $data['referencia_inicio'] = $range['inicio'];
            $data['referencia_fim'] = $range['fim'];
            $data['is_periodo'] = true;
        } else {
            $data['referencia'] = $range['inicio'];
            $data['mes_extenso'] = $this->getMesExtenso($range['inicio']);
            $data['is_periodo'] = false;
        }

        $data['meses'] = $pagamentoModel->getMonthsList();

        return view('relatorios/prestacao_contas', $data);
    }

    public function gerarPdfPrestacao()
    {
        $pagamentoModel = new PagamentoModel();
        $saidaModel = new SaidaModel();

        $range = $this->handleDateRange();

        // Mesma lógica de dados para garantir consistência
        $receitasQuery = $pagamentoModel->select('users.nome, endereco.quadra, endereco.numero, pagamento.valor, pagamento.data_pagamento, pagamento.observacao, tipo_pagamento.descricao as categoria')
            ->join('users', 'users.id = pagamento.id_usuario')
            ->join('endereco', 'endereco.id_usuario = users.id')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = pagamento.id_tipo_pagamento')
            ->where('pagamento.situacao', 'PAGO');

        $this->applyDateRangeFilter($receitasQuery, 'pagamento', $range['inicio'], $range['fim']);

        $receitas_detalhe = $receitasQuery->orderBy('pagamento.data_pagamento', 'ASC')
            ->findAll();

        $despesasQuery = $saidaModel->select('
                saida.valor, 
                saida.data_pagamento, 
                saida.observacao, 
                tipo_pagamento.descricao as categoria,
                COALESCE(funcionarios.nome_completo, recebedor.nome, "Não especificado") as favorecido
            ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = saida.id_tipo_pagamento')
            ->join('funcionarios', 'funcionarios.id = saida.id_funcionario', 'left')
            ->join('recebedor', 'recebedor.id = saida.id_recebedor', 'left');
        //->where('saida.situacao', 'PAGO')

        $this->applyDateRangeFilter($despesasQuery, 'saida', $range['inicio'], $range['fim']);

        $despesas_detalhe = $despesasQuery->orderBy('saida.data_pagamento', 'ASC')
            ->findAll();

        $data = [
            'referencia' => $range['is_periodo'] ? $this->getMesExtenso($range['inicio']) . ' até ' . $this->getMesExtenso($range['fim']) : $this->getMesExtenso($range['inicio']),
            'mes_extenso' => $range['is_periodo'] ? $this->getMesExtenso($range['inicio']) . ' até ' . $this->getMesExtenso($range['fim']) : $this->getMesExtenso($range['inicio']),
            'receitas_detalhe' => $receitas_detalhe,
            'despesas_detalhe' => $despesas_detalhe,
            'total_receitas' => array_sum(array_column($receitas_detalhe, 'valor')),
            'total_despesas' => array_sum(array_column($despesas_detalhe, 'valor')),
        ];

        // Configuração do Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $html = view('relatorios/prestacao_contas_pdf', $data);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $refName = $range['is_periodo'] ? "{$range['inicio']}_{$range['fim']}" : $range['inicio'];
        $this->response->setContentType('application/pdf');
        $this->response->setHeader('Content-Disposition', 'inline; filename="prestacao_contas_' . $refName . '.pdf"');
        $this->response->setBody($dompdf->output());
        return $this->response;
    }

    public function receitasPorCategoria()
    {
        $pagamentoModel = new PagamentoModel();

        $range = $this->handleDateRange();

        $query = $pagamentoModel->select('
                tipo_pagamento.codigo,
                tipo_pagamento.descricao, 
                COUNT(pagamento.id) as quantidade, 
                SUM(pagamento.valor) as total
            ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = pagamento.id_tipo_pagamento')
            ->where('pagamento.situacao', 'PAGO');

        $this->applyDateRangeFilter($query, 'pagamento', $range['inicio'], $range['fim']);

        $data['agrupado'] = $query->groupBy(['tipo_pagamento.codigo', 'tipo_pagamento.descricao'])
            ->orderBy('total', 'DESC')
            ->findAll();

        $data['titulo'] = 'Receitas por Categoria';

        if ($range['is_periodo']) {
            $data['referencia'] = $this->getMesExtenso($range['inicio']) . ' até ' . $this->getMesExtenso($range['fim']);
            $data['referencia_inicio'] = $range['inicio'];
            $data['referencia_fim'] = $range['fim'];
            $data['is_periodo'] = true;
        } else {
            $data['referencia'] = $range['inicio'];
            $data['mes_extenso'] = $this->getMesExtenso($range['inicio']);
            $data['is_periodo'] = false;
        }

        $data['meses'] = $pagamentoModel->getMonthsList();

        return view('relatorios/receitas_categoria', $data);
    }

    public function gerarPdfReceitasCategoria()
    {
        $pagamentoModel = new PagamentoModel();

        $range = $this->handleDateRange();

        $query = $pagamentoModel->select('
                tipo_pagamento.codigo,
                tipo_pagamento.descricao, 
                COUNT(pagamento.id) as quantidade, 
                SUM(pagamento.valor) as total
            ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = pagamento.id_tipo_pagamento')
            ->where('pagamento.situacao', 'PAGO');

        $this->applyDateRangeFilter($query, 'pagamento', $range['inicio'], $range['fim']);

        $agrupado = $query->groupBy(['tipo_pagamento.codigo', 'tipo_pagamento.descricao'])
            ->orderBy('total', 'DESC')
            ->findAll();

        $data = [
            'referencia' => $range['is_periodo'] ? $this->getMesExtenso($range['inicio']) . ' até ' . $this->getMesExtenso($range['fim']) : $this->getMesExtenso($range['inicio']),
            'mes_extenso' => $range['is_periodo'] ? $this->getMesExtenso($range['inicio']) . ' até ' . $this->getMesExtenso($range['fim']) : $this->getMesExtenso($range['inicio']),
            'agrupado' => $agrupado,
            'total_geral' => array_sum(array_column($agrupado, 'total')),
            'qtd_geral' => array_sum(array_column($agrupado, 'quantidade'))
        ];

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $html = view('relatorios/receitas_categoria_pdf', $data);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $refName = $range['is_periodo'] ? "{$range['inicio']}_{$range['fim']}" : $range['inicio'];
        $this->response->setContentType('application/pdf');
        $this->response->setHeader('Content-Disposition', 'inline; filename="receitas_por_categoria_' . $refName . '.pdf"');
        $this->response->setBody($dompdf->output());
        return $this->response;
    }

    public function resumoCaixa()
    {
        $pagamentoModel = new PagamentoModel();
        $saidaModel = new SaidaModel();

        $range = $this->handleDateRange();

        // Entradas Agrupadas (inner join para garantir categorias válidas se desejado)
        $entradasQuery = $pagamentoModel->select('
                tipo_pagamento.codigo,
                tipo_pagamento.descricao, 
                SUM(pagamento.valor) as total
            ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = pagamento.id_tipo_pagamento')
            ->where('pagamento.situacao', 'PAGO');

        $this->applyDateRangeFilter($entradasQuery, 'pagamento', $range['inicio'], $range['fim']);

        $entradas = $entradasQuery->groupBy(['tipo_pagamento.codigo', 'tipo_pagamento.descricao'])
            ->findAll();

        // Saídas Agrupadas (usando JOIN com tipo_pagamento conforme solicitado)
        $saidasQuery = $saidaModel->select('
                tipo_pagamento.codigo,
                tipo_pagamento.descricao, 
                SUM(saida.valor) as total
            ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = saida.id_tipo_pagamento');
        //->where('saida.situacao', 'PAGO')

        $this->applyDateRangeFilter($saidasQuery, 'saida', $range['inicio'], $range['fim']);

        $saidas = $saidasQuery->groupBy(['tipo_pagamento.codigo', 'tipo_pagamento.descricao'])
            ->findAll();

        // Saídas Detalhadas (para listar cada uma)
        $saidasDetalheQuery = $saidaModel->select('
                saida.valor, 
                saida.data_pagamento, 
                saida.observacao, 
                tipo_pagamento.descricao as categoria
            ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = saida.id_tipo_pagamento');
        //->where('saida.situacao', 'PAGO')

        $this->applyDateRangeFilter($saidasDetalheQuery, 'saida', $range['inicio'], $range['fim']);

        $saidas_detalhe = $saidasDetalheQuery->orderBy('saida.data_pagamento', 'ASC')
            ->findAll();

        $data = [
            'titulo' => 'Resumo de Caixa por Tipo',
            'entradas' => $entradas,
            'saidas' => $saidas,
            'saidas_detalhe' => $saidas_detalhe,
            'total_entradas' => array_sum(array_column($entradas, 'total')),
            'total_saidas' => array_sum(array_column($saidas_detalhe, 'valor')),
            'meses' => $pagamentoModel->getMonthsList()
        ];

        if ($range['is_periodo']) {
            $data['referencia'] = $this->getMesExtenso($range['inicio']) . ' até ' . $this->getMesExtenso($range['fim']);
            $data['referencia_inicio'] = $range['inicio'];
            $data['referencia_fim'] = $range['fim'];
            $data['is_periodo'] = true;
            $data['mes_extenso'] = $this->getMesExtenso($range['inicio']) . ' até ' . $this->getMesExtenso($range['fim']);
        } else {
            $data['referencia'] = $range['inicio'];
            $data['mes_extenso'] = $this->getMesExtenso($range['inicio']);
            $data['is_periodo'] = false;
        }


        return view('relatorios/resumo_caixa', $data);
    }

    public function gerarPdfResumoCaixa()
    {
        $pagamentoModel = new PagamentoModel();
        $saidaModel = new SaidaModel();

        $range = $this->handleDateRange();

        $entradasQuery = $pagamentoModel->select('tipo_pagamento.codigo, tipo_pagamento.descricao, SUM(pagamento.valor) as total')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = pagamento.id_tipo_pagamento')
            ->where('pagamento.situacao', 'PAGO');

        $this->applyDateRangeFilter($entradasQuery, 'pagamento', $range['inicio'], $range['fim']);

        $entradas = $entradasQuery->groupBy(['tipo_pagamento.codigo', 'tipo_pagamento.descricao'])
            ->findAll();

        $saidasQuery = $saidaModel->select('tipo_pagamento.codigo, tipo_pagamento.descricao, SUM(saida.valor) as total')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = saida.id_tipo_pagamento');
        //->where('saida.situacao', 'PAGO')

        $this->applyDateRangeFilter($saidasQuery, 'saida', $range['inicio'], $range['fim']);

        $saidas = $saidasQuery->groupBy(['tipo_pagamento.codigo', 'tipo_pagamento.descricao'])
            ->findAll();

        $saidasDetalheQuery = $saidaModel->select('
                saida.valor, 
                saida.data_pagamento, 
                saida.observacao, 
                tipo_pagamento.descricao as categoria
            ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = saida.id_tipo_pagamento');
        //->where('saida.situacao', 'PAGO')

        $this->applyDateRangeFilter($saidasDetalheQuery, 'saida', $range['inicio'], $range['fim']);

        $saidas_detalhe = $saidasDetalheQuery->orderBy('saida.data_pagamento', 'ASC')
            ->findAll();

        $data = [
            'referencia' => $range['is_periodo'] ? $this->getMesExtenso($range['inicio']) . ' até ' . $this->getMesExtenso($range['fim']) : $this->getMesExtenso($range['inicio']),
            'mes_extenso' => $range['is_periodo'] ? $this->getMesExtenso($range['inicio']) . ' até ' . $this->getMesExtenso($range['fim']) : $this->getMesExtenso($range['inicio']),
            'entradas' => $entradas,
            'saidas' => $saidas,
            'saidas_detalhe' => $saidas_detalhe,
            'total_entradas' => array_sum(array_column($entradas, 'total')),
            'total_saidas' => array_sum(array_column($saidas, 'total')),
        ];

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $html = view('relatorios/resumo_caixa_pdf', $data);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $refName = $range['is_periodo'] ? "{$range['inicio']}_{$range['fim']}" : $range['inicio'];
        $this->response->setContentType('application/pdf');
        $this->response->setHeader('Content-Disposition', 'inline; filename="resumo_caixa_' . $refName . '.pdf"');
        $this->response->setBody($dompdf->output());
        return $this->response;
    }

    private function getMesExtenso($referencia)
    {
        $mesNum = substr($referencia, 0, 2);
        $ano = substr($referencia, 2);

        $meses = [
            '01' => 'JANEIRO',
            '02' => 'FEVEREIRO',
            '03' => 'MARÇO',
            '04' => 'ABRIL',
            '05' => 'MAIO',
            '06' => 'JUNHO',
            '07' => 'JULHO',
            '08' => 'AGOSTO',
            '09' => 'SETEMBRO',
            '10' => 'OUTUBRO',
            '11' => 'NOVEMBRO',
            '12' => 'DEZEMBRO'
        ];

        return ($meses[$mesNum] ?? '') . ' ' . $ano;
    }
}
