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

    public function fluxoCaixa()
    {
        $pagamentoModel = new PagamentoModel();
        $saidaModel = new SaidaModel();

        $referencia = $this->request->getGet('referencia') ?? date('mY');

        // Entradas agrupadas por tipo
        $entradas = $pagamentoModel->select('tipo_pagamento.descricao, SUM(pagamento.valor) as total')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = pagamento.id_tipo_pagamento')
            ->where('pagamento.situacao', 'PAGO')
            ->where('pagamento.referencia', $referencia)
            ->groupBy(['pagamento.id_tipo_pagamento', 'tipo_pagamento.descricao'])
            ->findAll();

        // Saídas agrupadas por tipo
        $saidas = $saidaModel->select('tipo_pagamento.descricao, SUM(saida.valor) as total')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = saida.id_tipo_pagamento')
            //->where('saida.situacao', 'PAGO')
            ->where('saida.referencia', $referencia)
            ->groupBy(['saida.id_tipo_pagamento', 'tipo_pagamento.descricao'])
            ->findAll();

        $data['titulo'] = 'Relatório de Fluxo de Caixa';
        $data['referencia'] = $referencia;
        $data['mes_extenso'] = $this->getMesExtenso($referencia);
        $data['entradas'] = $entradas;
        $data['saidas'] = $saidas;
        $data['meses'] = $pagamentoModel->getMonthsList();

        return view('relatorios/fluxo_caixa', $data);
    }

    public function inadimplencia()
    {
        $pagamentoModel = new PagamentoModel();

        $referencia = $this->request->getGet('referencia') ?? date('mY');
        $quadra = $this->request->getGet('quadra');

        $query = $pagamentoModel->select('users.nome, users.telefone, endereco.quadra, endereco.numero, pagamento.valor, pagamento.data_vencimento, pagamento.situacao')
            ->join('users', 'users.id = pagamento.id_usuario')
            ->join('endereco', 'endereco.id_usuario = users.id')
            ->whereIn('pagamento.situacao', ['ABERTO', 'PENDENTE'])
            ->where('pagamento.referencia', $referencia);

        if ($quadra) {
            $query->where('endereco.quadra', $quadra);
        }

        $data['inadimplentes'] = $query->orderBy('endereco.quadra', 'ASC')
            ->orderBy('endereco.numero', 'ASC')
            ->findAll();

        $data['titulo'] = 'Relatório de Inadimplência';
        $data['referencia'] = $referencia;
        $data['mes_extenso'] = $this->getMesExtenso($referencia);
        $data['quadra'] = $quadra;
        $data['meses'] = $pagamentoModel->getMonthsList();

        return view('relatorios/inadimplencia', $data);
    }

    public function folhaPagamento()
    {
        $saidaModel = new SaidaModel();
        $referencia = $this->request->getGet('referencia') ?? date('mY');

        $data['pagamentos'] = $saidaModel->select('funcionarios.nome_completo, saida.valor, saida.data_pagamento, saida.observacao, tipo_saida.descricao as tipo')
            ->join('funcionarios', 'funcionarios.id = saida.id_funcionario')
            ->join('tipo_saida', 'tipo_saida.codigo = saida.id_tipo_saida', 'left')
            ->where('saida.id_funcionario IS NOT NULL')
            ->where('saida.referencia', $referencia)
            ->findAll();

        $data['titulo'] = 'Relatório de Folha de Pagamento';
        $data['referencia'] = $referencia;
        $data['mes_extenso'] = $this->getMesExtenso($referencia);
        $data['meses'] = (new PagamentoModel())->getMonthsList();

        return view('relatorios/folha_pagamento', $data);
    }

    public function prestacaoContas()
    {
        $pagamentoModel = new PagamentoModel();
        $saidaModel = new SaidaModel();

        $referencia = $this->request->getGet('referencia') ?? date('mY');

        // 1. Detalhamento de Receitas
        $data['receitas_detalhe'] = $pagamentoModel->select('users.nome, endereco.quadra, endereco.numero, pagamento.valor, pagamento.data_pagamento, pagamento.observacao, tipo_pagamento.descricao as categoria')
            ->join('users', 'users.id = pagamento.id_usuario')
            ->join('endereco', 'endereco.id_usuario = users.id')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = pagamento.id_tipo_pagamento')
            ->where('pagamento.situacao', 'PAGO')
            ->where('pagamento.referencia', $referencia)
            ->orderBy('pagamento.data_pagamento', 'ASC')
            ->findAll();

        // 2. Detalhamento de Despesas (Unificando funcionários e outros recebedores)
        $data['despesas_detalhe'] = $saidaModel->select('
                saida.valor, 
                saida.data_pagamento, 
                saida.observacao, 
                tipo_pagamento.descricao as categoria,
                COALESCE(funcionarios.nome_completo, recebedor.nome, "Não especificado") as favorecido
            ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = saida.id_tipo_pagamento')
            ->join('funcionarios', 'funcionarios.id = saida.id_funcionario', 'left')
            ->join('recebedor', 'recebedor.id = saida.id_recebedor', 'left')
            //->where('saida.situacao', 'PAGO')
            ->where('saida.referencia', $referencia)
            ->orderBy('saida.data_pagamento', 'ASC')
            ->findAll();

        // 3. Totais para o Resumo
        $data['total_receitas'] = array_sum(array_column($data['receitas_detalhe'], 'valor'));
        $data['total_despesas'] = array_sum(array_column($data['despesas_detalhe'], 'valor'));

        $data['titulo'] = 'Prestação de Contas Detalhada';
        $data['referencia'] = $referencia;
        $data['mes_extenso'] = $this->getMesExtenso($referencia);
        $data['meses'] = $pagamentoModel->getMonthsList();

        return view('relatorios/prestacao_contas', $data);
    }

    public function gerarPdfPrestacao()
    {
        $pagamentoModel = new PagamentoModel();
        $saidaModel = new SaidaModel();

        $referencia = $this->request->getGet('referencia') ?? date('mY');

        // Mesma lógica de dados para garantir consistência
        $receitas_detalhe = $pagamentoModel->select('users.nome, endereco.quadra, endereco.numero, pagamento.valor, pagamento.data_pagamento, pagamento.observacao, tipo_pagamento.descricao as categoria')
            ->join('users', 'users.id = pagamento.id_usuario')
            ->join('endereco', 'endereco.id_usuario = users.id')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = pagamento.id_tipo_pagamento')
            ->where('pagamento.situacao', 'PAGO')
            ->where('pagamento.referencia', $referencia)
            ->orderBy('pagamento.data_pagamento', 'ASC')
            ->findAll();

        $despesas_detalhe = $saidaModel->select('
                saida.valor, 
                saida.data_pagamento, 
                saida.observacao, 
                tipo_pagamento.descricao as categoria,
                COALESCE(funcionarios.nome_completo, recebedor.nome, "Não especificado") as favorecido
            ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = saida.id_tipo_pagamento')
            ->join('funcionarios', 'funcionarios.id = saida.id_funcionario', 'left')
            ->join('recebedor', 'recebedor.id = saida.id_recebedor', 'left')
            //->where('saida.situacao', 'PAGO')
            ->where('saida.referencia', $referencia)
            ->orderBy('saida.data_pagamento', 'ASC')
            ->findAll();

        $data = [
            'referencia' => $referencia,
            'mes_extenso' => $this->getMesExtenso($referencia),
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

        // Output do PDF para o browser
        $dompdf->stream("prestacao_contas_{$referencia}.pdf", ["Attachment" => false]);
    }

    public function receitasPorCategoria()
    {
        $pagamentoModel = new PagamentoModel();
        $referencia = $this->request->getGet('referencia') ?? date('mY');

        $data['agrupado'] = $pagamentoModel->select('
                tipo_pagamento.codigo,
                tipo_pagamento.descricao, 
                COUNT(pagamento.id) as quantidade, 
                SUM(pagamento.valor) as total
            ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = pagamento.id_tipo_pagamento')
            ->where('pagamento.situacao', 'PAGO')
            ->where('pagamento.referencia', $referencia)
            ->groupBy(['tipo_pagamento.codigo', 'tipo_pagamento.descricao'])
            ->orderBy('total', 'DESC')
            ->findAll();

        $data['titulo'] = 'Receitas por Categoria';
        $data['referencia'] = $referencia;
        $data['mes_extenso'] = $this->getMesExtenso($referencia);
        $data['meses'] = $pagamentoModel->getMonthsList();

        return view('relatorios/receitas_categoria', $data);
    }

    public function gerarPdfReceitasCategoria()
    {
        $pagamentoModel = new PagamentoModel();
        $referencia = $this->request->getGet('referencia') ?? date('mY');

        $agrupado = $pagamentoModel->select('
                tipo_pagamento.codigo,
                tipo_pagamento.descricao, 
                COUNT(pagamento.id) as quantidade, 
                SUM(pagamento.valor) as total
            ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = pagamento.id_tipo_pagamento')
            ->where('pagamento.situacao', 'PAGO')
            ->where('pagamento.referencia', $referencia)
            ->groupBy(['tipo_pagamento.codigo', 'tipo_pagamento.descricao'])
            ->orderBy('total', 'DESC')
            ->findAll();

        $data = [
            'referencia' => $referencia,
            'mes_extenso' => $this->getMesExtenso($referencia),
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

        $dompdf->stream("receitas_por_categoria_{$referencia}.pdf", ["Attachment" => false]);
    }

    public function resumoCaixa()
    {
        $pagamentoModel = new PagamentoModel();
        $saidaModel = new SaidaModel();

        $referencia = $this->request->getGet('referencia') ?? date('mY');

        // Entradas Agrupadas (inner join para garantir categorias válidas se desejado)
        $entradas = $pagamentoModel->select('
                tipo_pagamento.codigo,
                tipo_pagamento.descricao, 
                SUM(pagamento.valor) as total
            ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = pagamento.id_tipo_pagamento')
            ->where('pagamento.situacao', 'PAGO')
            ->where('pagamento.referencia', $referencia)
            ->groupBy(['tipo_pagamento.codigo', 'tipo_pagamento.descricao'])
            ->findAll();

        // Saídas Agrupadas (usando JOIN com tipo_pagamento conforme solicitado)
        $saidas = $saidaModel->select('
                tipo_pagamento.codigo,
                tipo_pagamento.descricao, 
                SUM(saida.valor) as total
            ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = saida.id_tipo_pagamento')
            //->where('saida.situacao', 'PAGO')
            ->where('saida.referencia', $referencia)
            ->groupBy(['tipo_pagamento.codigo', 'tipo_pagamento.descricao'])
            ->findAll();

        // Saídas Detalhadas (para listar cada uma)
        $saidas_detalhe = $saidaModel->select('
                saida.valor, 
                saida.data_pagamento, 
                saida.observacao, 
                tipo_pagamento.descricao as categoria
            ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = saida.id_tipo_pagamento')
            //->where('saida.situacao', 'PAGO')
            ->where('saida.referencia', $referencia)
            ->orderBy('saida.data_pagamento', 'ASC')
            ->findAll();

        $data = [
            'titulo' => 'Resumo de Caixa por Tipo',
            'referencia' => $referencia,
            'mes_extenso' => $this->getMesExtenso($referencia),
            'entradas' => $entradas,
            'saidas' => $saidas,
            'saidas_detalhe' => $saidas_detalhe,
            'total_entradas' => array_sum(array_column($entradas, 'total')),
            'total_saidas' => array_sum(array_column($saidas_detalhe, 'valor')),
            'meses' => $pagamentoModel->getMonthsList()
        ];

        return view('relatorios/resumo_caixa', $data);
    }

    public function gerarPdfResumoCaixa()
    {
        $pagamentoModel = new PagamentoModel();
        $saidaModel = new SaidaModel();

        $referencia = $this->request->getGet('referencia') ?? date('mY');

        $entradas = $pagamentoModel->select('tipo_pagamento.codigo, tipo_pagamento.descricao, SUM(pagamento.valor) as total')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = pagamento.id_tipo_pagamento')
            ->where('pagamento.situacao', 'PAGO')
            ->where('pagamento.referencia', $referencia)
            ->groupBy(['tipo_pagamento.codigo', 'tipo_pagamento.descricao'])
            ->findAll();

        $saidas = $saidaModel->select('tipo_pagamento.codigo, tipo_pagamento.descricao, SUM(saida.valor) as total')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = saida.id_tipo_pagamento')
            //->where('saida.situacao', 'PAGO')
            ->where('saida.referencia', $referencia)
            ->groupBy(['tipo_pagamento.codigo', 'tipo_pagamento.descricao'])
            ->findAll();

        $saidas_detalhe = $saidaModel->select('
                saida.valor, 
                saida.data_pagamento, 
                saida.observacao, 
                tipo_pagamento.descricao as categoria
            ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = saida.id_tipo_pagamento')
            //->where('saida.situacao', 'PAGO')
            ->where('saida.referencia', $referencia)
            ->orderBy('saida.data_pagamento', 'ASC')
            ->findAll();

        $data = [
            'referencia' => $referencia,
            'mes_extenso' => $this->getMesExtenso($referencia),
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

        $dompdf->stream("resumo_caixa_{$referencia}.pdf", ["Attachment" => false]);
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
