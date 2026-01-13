<?php

namespace App\Controllers;

use App\Models\PagamentoModel;
use App\Models\AnexoModel;

class Dashboard extends BaseController
{
    public function index()
    {

        $pagamentoModel = new PagamentoModel();
        $anexoModel = new AnexoModel();

        // Verifica se o usuário está logado
        if (!session()->has('user_id')) {
            return redirect()->to('/login');
        }

        $year = $this->request->getGet('year') ?? date('Y');

        $data['titulo'] = 'Início';
        $data['nome'] = session()->get('user_nome');
        $data['role'] = session()->get('user_role');
        $data['informacoes'] = $pagamentoModel->getInfoMensalidadePorReferencia($year);
        $data['contas'] = $anexoModel->getDocPrestacaoContas();
        $data['referencias_caixa'] = $pagamentoModel->getMonthsList();
        $data['selected_year'] = $year;

        // var_dump($pagamentoModel->getMonthsList());
        // die();

        return view('dashboard', $data);
    }


    public function getCaixaResumo($ref)
    {
        $pagamentoModel = new PagamentoModel();
        $refCaixa = $ref;

        $dadosCaixa = [
            'entrada' => $pagamentoModel->getEntrada($refCaixa), // Simulação de valores
            'saida' => $pagamentoModel->getSaida($refCaixa),
            'valor_caixa' => $pagamentoModel->getTotalCaixa($refCaixa)
        ];
        return $this->response->setJSON($dadosCaixa);
    }
}
