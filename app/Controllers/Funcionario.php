<?php

namespace App\Controllers;

use App\Models\FuncionarioModel;

class Funcionario extends BaseController
{

    public function index()
    {
        $user_id = session()->get('user_id');
        $user_role = session()->get('user_role');
        $funcionarioModel = new FuncionarioModel();

        $data['titulo'] = 'Lista de Funcionários';
        $data['link'] = '/funcionario/cadastrar';
        $data['role'] = $user_role;
        $data['pager'] = $funcionarioModel->pager;
        $data['informacoes'] = $funcionarioModel->getFuncionariosFormatados();

        // var_dump($data);
        // die();

        echo view('funcionario_index', $data);
    }

    public function cadastrar()
    {
        $funcionarioModel = new FuncionarioModel();

        // Inicialize a variável $responseMessage com uma mensagem padrão
        $responseMessage = '';
        $user_id = session()->get('user_id');

        $data_nascimento_input = $this->request->getPost('data_nascimento'); // Formato dd/mm/yyyy
        $data_nascimento_bd = null;
        $salario = str_replace(['R$', '.', ','], ['', '', '.'], $this->request->getPost('salario'));

        // Verifica se a data foi preenchida e está no formato esperado
        if (!empty($data_nascimento_input)) {
            $data_parts = explode('/', $data_nascimento_input); // Divide a data em [dd, mm, yyyy]
            if (count($data_parts) === 3) {
                $data_nascimento_bd = "{$data_parts[2]}-{$data_parts[1]}-{$data_parts[0]}"; // yyyy-mm-dd
            }
        }

        if ($this->request->getPost()) {
            // Recebe os dados enviados via POST
            $data = [
                'nome_completo' => $this->request->getPost('nome_completo'),
                'data_nascimento' => $data_nascimento_bd,
                'cpf' => $this->request->getPost('cpf'),
                'rg' => $this->request->getPost('rg'),
                'endereco_completo' => $this->request->getPost('endereco_completo'),
                'complemento' => $this->request->getPost('complemento'),
                'cidade' => $this->request->getPost('cidade'),
                'estado' => $this->request->getPost('estado'),
                'cep' => $this->request->getPost('cep'),
                'telefone_whatsapp' => $this->request->getPost('telefone_whatsapp'),
                'salario' => $salario,
                'nome_titular_conta' => $this->request->getPost('nome_titular_conta'),
                'banco' => $this->request->getPost('banco'),
                'agencia' => $this->request->getPost('agencia'),
                'numero_conta' => $this->request->getPost('numero_conta'),
                'tipo_conta' => $this->request->getPost('tipo_conta'),
                'chave_pix' => $this->request->getPost('chave_pix'),
                'observacao' => $this->request->getPost('observacao'),
                'usuario_criacao' => $user_id, // ID do usuário logado, pego da sessão
            ];

            // Validação e inserção
            if ($funcionarioModel->insert($data)) {
                // Retorno em caso de sucesso
                return redirect()->to('/funcionarios')->with('msg_success', 'Funcionário cadastrado com sucesso!');
            } else {
                // Retorno em caso de falha
                return redirect()->back()->withInput()->with('errors', $funcionarioModel->errors());
            }
        }

        $data['link'] = '/funcionarios';
        $data['tituloRedirect'] = 'Voltar para Lista de funcionários';
        $data['titulo'] = 'Cadastrar Funcionário';
        $data['acao'] = 'Inserir';
        $data['msg'] = $responseMessage;

        return view('funcionario_form_cadastrar', $data);
    }

    public function editar($id)
    {
        $funcionarioModel = new FuncionarioModel();

        // Inicialize a variável $responseMessage com uma mensagem padrão
        $responseMessage = '';
        $user_id = session()->get('user_id');

        // Busca os dados do funcionário no banco com base no ID
        $funcionario = $funcionarioModel->find($id);
        if (!$funcionario) {
            return redirect()->to('/funcionarios')->with('msg_error', 'Funcionário não encontrado!');
        }

        // Preenche os dados já existentes para o formulário
        $data_nascimento_bd = null;
        if (!empty($funcionario['data_nascimento'])) {
            $data_parts = explode('-', $funcionario['data_nascimento']); // Divide a data em [yyyy, mm, dd]
            if (count($data_parts) === 3) {
                $data_nascimento_bd = "{$data_parts[2]}/{$data_parts[1]}/{$data_parts[0]}"; // dd/mm/yyyy
            }
        }

        // Converte o salário para o formato exibido no formulário
        $salario_exibido = number_format($funcionario['salario'], 2, ',', '.');

        // Se o formulário foi enviado, processa a edição
        if ($this->request->getPost()) {
            $data_nascimento_input = $this->request->getPost('data_nascimento'); // Formato dd/mm/yyyy
            $data_nascimento_bd = null;
            $salario = str_replace(['R$', '.', ','], ['', '', '.'], $this->request->getPost('salario')); // Remove o formato do salário

            // Verifica se a data foi preenchida e está no formato esperado
            if (!empty($data_nascimento_input)) {
                $data_parts = explode('/', $data_nascimento_input); // Divide a data em [dd, mm, yyyy]
                if (count($data_parts) === 3) {
                    $data_nascimento_bd = "{$data_parts[2]}-{$data_parts[1]}-{$data_parts[0]}"; // yyyy-mm-dd
                }
            }

            // Captura a data e hora atual (corrigido com o uso da barra invertida \)
            $dataHoraAtual = new \DateTime(); // Usando a classe global \DateTime
            $data_atual_bd = $dataHoraAtual->format('Y-m-d H:i:s'); // Formata para o formato de banco de dados


            // Recebe os dados editados via POST
            $data = [
                'id' => $id, // Adiciona o ID no array  
                'nome_completo' => $this->request->getPost('nome_completo'),
                'data_nascimento' => $data_nascimento_bd,
                'cpf' => $this->request->getPost('cpf'),
                'rg' => $this->request->getPost('rg'),
                'endereco_completo' => $this->request->getPost('endereco_completo'),
                'complemento' => $this->request->getPost('complemento'),
                'cidade' => $this->request->getPost('cidade'),
                'estado' => $this->request->getPost('estado'),
                'cep' => $this->request->getPost('cep'),
                'telefone_whatsapp' => $this->request->getPost('telefone_whatsapp'),
                'salario' => $salario,
                'nome_titular_conta' => $this->request->getPost('nome_titular_conta'),
                'banco' => $this->request->getPost('banco'),
                'agencia' => $this->request->getPost('agencia'),
                'numero_conta' => $this->request->getPost('numero_conta'),
                'tipo_conta' => $this->request->getPost('tipo_conta'),
                'chave_pix' => $this->request->getPost('chave_pix'),
                'observacao' => $this->request->getPost('observacao'),
                'usuario_atualizacao' => $user_id, // ID do usuário logado, pego da sessão
                'ultima_atualizacao' => $data_atual_bd
            ];

            // Validação e atualização
            if ($funcionarioModel->update($id, $data)) {
                // Retorno em caso de sucesso
                return redirect()->to('/funcionarios')->with('msg_success', 'Funcionário atualizado com sucesso!');
            } else {
                // Retorno em caso de falha
                return redirect()->back()->withInput()->with('errors', $funcionarioModel->errors());
            }
        }

        // Passa os dados para o formulário de edição
        $data['funcionario'] = $funcionario;
        $data['data_nascimento'] = $data_nascimento_bd;
        $data['salario_exibido'] = $salario_exibido;
        $data['banco_selecionado'] = $funcionario['banco'];
        $data['link'] = '/funcionarios';
        $data['tituloRedirect'] = 'Voltar para Lista de funcionários';
        $data['titulo'] = 'Editar Funcionário';
        $data['acao'] = 'Atualizar';
        $data['msg'] = $responseMessage;

        return view('funcionario_form_editar', $data);
    }
}
