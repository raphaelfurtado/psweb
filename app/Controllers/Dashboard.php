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

        $data['titulo'] = 'Início';
        $data['nome'] = session()->get('user_nome');
        $data['role'] = session()->get('user_role');
        $data['informacoes'] = $pagamentoModel->getInfoMensalidadePorReferencia();
        $data['contas'] = $anexoModel->getDocPrestacaoContas();

        // var_dump($pagamentoModel->getInfoMensalidadePorReferencia());
        // die();

        return view('dashboard', $data);
    }
}
