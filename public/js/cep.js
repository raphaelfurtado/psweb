// Função para mostrar o overlay com a mensagem
function mostrarCarregando() {
    // Cria o overlay
    var overlay = document.createElement('div');
    overlay.id = 'overlay';
    overlay.style.position = 'fixed';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
    overlay.style.color = 'white';
    overlay.style.display = 'flex';
    overlay.style.justifyContent = 'center';
    overlay.style.alignItems = 'center';
    overlay.style.fontSize = '20px';
    overlay.style.zIndex = '9999';
    overlay.innerText = 'Pesquisando CEP...';

    // Adiciona o overlay à página
    document.body.appendChild(overlay);
}

// Função para remover o overlay
function removerCarregando() {
    var overlay = document.getElementById('overlay');
    if (overlay) {
        overlay.remove();
    }
}

// Função para buscar os dados do CEP
function buscarEnderecoPorCEP() {
    var cep = document.getElementById('cep').value.replace('-', '').trim(); // Remover traços e espaços extras
    if (cep.length === 8) { // Verificar se o CEP tem 8 caracteres
        mostrarCarregando(); // Exibe a tela de carregamento

        var url = 'https://viacep.com.br/ws/' + cep + '/json/';

        // Realiza a requisição para a API ViaCEP
        fetch(url)
            .then(response => response.json())
            .then(data => {
                removerCarregando(); // Remove a tela de carregamento

                if (data.erro) {
                    alert("CEP não encontrado.");
                } else {
                    // Preenche os campos com os dados retornados pela API
                    document.getElementById('endereco_completo').value = data.logradouro || '';
                    document.getElementById('cidade').value = data.localidade || '';
                    document.getElementById('estado').value = data.uf || '';
                }
            })
            .catch(error => {
                removerCarregando(); // Remove a tela de carregamento
                alert('Erro ao buscar o CEP.');
                console.error(error);
            });
    }
}

// Adiciona um evento de digitação no campo CEP
document.getElementById('cep').addEventListener('blur', buscarEnderecoPorCEP);