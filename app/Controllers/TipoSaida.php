<?php

namespace App\Controllers;

use App\Models\TipoSaidaModel;

class TipoSaida extends BaseController
{
    public function index()
    {
        $user_id = session()->get('user_id');
        $user_role = session()->get('user_role');

        $tipoSaida = new TipoSaidaModel();
        $data['list'] = $tipoSaida->find();
        $data['titulo'] = 'Lista de Tipos de Saída';
        $data['link'] = 'tipoSaida/cadastrar';
        $data['role'] = $user_role;
        $data['id_user'] = $user_id;

        echo view('saida/tipo_saida_index', $data);
    }

    public function cadastrar()
    {
        $tipoSaidaModel = new TipoSaidaModel();

        if ($this->request->getPost()) {
            $data = [
                'codigo' => $this->request->getPost('codigo'),
                'descricao' => mb_strtoupper($this->request->getPost('descricao'))
            ];

            // Validação e inserção
            if ($tipoSaidaModel->insert($data)) {
                // Retorno em caso de sucesso
                return redirect()->to('/tipoSaida')->with('msg_success', 'Tipo de Saida cadastrado com sucesso!');
            } else {
                // Retorno em caso de falha
                return redirect()->back()->withInput()->with('errors', $tipoSaidaModel->errors());
            }
        }
        // Preparando os dados para enviar para a view
        $data['link'] = '/tipoSaida';
        $data['tituloRedirect'] = 'Voltar para Lista de Tipos de Saída';
        $data['titulo'] = 'Cadastrar Tipo de Saída';
        $data['acao'] = 'Inserir';

        return view('saida/tipo_saida_form_cadastro', $data);
    }

    public function editar($id)
    {
        $tipoSaidaModel = new TipoSaidaModel();
        $tipoSaida = $tipoSaidaModel->find($id);

        if (!$tipoSaida) {
            return redirect()->to('/tipoSaida')->with('msg_error', 'Tipo de saída não encontrada!');
        }

        // Se o formulário foi enviado, processa a edição
        if ($this->request->getPost()) {

            $data = [
                'id' => $id, // Adiciona o ID no array  
                'codigo' => $this->request->getPost('codigo'),
                'descricao' => mb_strtoupper($this->request->getPost('descricao'))
            ];

            // Validação e atualização
            if ($tipoSaidaModel->update($id, $data)) {
                // Retorno em caso de sucesso
                return redirect()->to('/tipoSaida')->with('msg_success', 'Tipo de saída atualizada com sucesso!');
            } else {
                // Retorno em caso de falha
                return redirect()->back()->withInput()->with('errors', $tipoSaidaModel->errors());
            }
        }

        // Passa os dados para o formulário de edição
        $data['tipo_saida'] = $tipoSaida;
        $data['link'] = '/tipoSaida';
        $data['tituloRedirect'] = 'Voltar para Lista de Tipos de Saída';
        $data['titulo'] = 'Editar Tipo de Saída';
        $data['acao'] = 'Atualizar';

        return view('saida/tipo_saida_form_editar', $data);
    }


    public function desativar($id)
    {
        // Carrega o modelo
        $tipoSaidaModel = new TipoSaidaModel();

        // Verifica se o registro existe
        $registro = $tipoSaidaModel->find($id);
        if (!$registro) {
            // Exibe erro se o registro não for encontrado
            return redirect()->back()->with('msg_error', 'Registro não encontrado.');
        }

        // Atualiza o campo registro_ativo para 0 (inativo)
        $tipoSaidaModel->update($id, ['registro_ativo' => 0]);

        // Redireciona com uma mensagem de sucesso
        return redirect()->to('/tipoSaida')->with('msg_success', 'Registro desativado com sucesso.');
    }

    public function ativar($id)
    {
        // Carrega o modelo
        $tipoSaidaModel = new TipoSaidaModel();

        // Verifica se o registro existe
        $registro = $tipoSaidaModel->find($id);
        if (!$registro) {
            // Exibe erro se o registro não for encontrado
            return redirect()->back()->with('msg_error', 'Registro não encontrado.');
        }

        // Atualiza o campo registro_ativo para 0 (inativo)
        $tipoSaidaModel->update($id, ['registro_ativo' => 1]);

        // Redireciona com uma mensagem de sucesso
        return redirect()->to('/tipoSaida')->with('msg_success', 'Registro ativado com sucesso.');
    }
}
