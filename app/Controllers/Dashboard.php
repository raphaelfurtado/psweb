<?php

namespace App\Controllers;

use App\Models\PagamentoModel;

class Dashboard extends BaseController
{
    public function index()
    {

        $pagamentoModel = new PagamentoModel();

        // Verifica se o usuário está logado
        if (!session()->has('user_id')) {
            return redirect()->to('/login');
        }

        $data['titulo'] = 'Home';
        $data['nome'] = session()->get('user_nome');
        $data['role'] = session()->get('user_role');
        $data['informacoes'] = $pagamentoModel->getInfoMensalidadePorReferencia();

        // var_dump($pagamentoModel->getInfoMensalidadePorReferencia());
        // die();

        return view('dashboard', $data);
    }
}
