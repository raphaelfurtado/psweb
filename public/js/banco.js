// Função para carregar os bancos e preencher o combo box
function carregarBancos(bancoSelecionado = '') {
    const url = 'https://brasilapi.com.br/api/banks/v1'; // URL da API BrasilAPI

    // Faz a requisição para a API de bancos
    fetch(url)
        .then(response => response.json())
        .then(bancos => {
            const selectBanco = document.getElementById('banco');
            selectBanco.innerHTML = ''; // Limpa o combo box

            // Adiciona uma opção padrão
            const optionPadrao = document.createElement('option');
            optionPadrao.value = '';
            optionPadrao.textContent = '-- Selecione --';
            selectBanco.appendChild(optionPadrao);

            // Filtra os bancos com código válido (não nulo)
            const bancosValidos = bancos
                .filter(banco => banco.code !== null) // Remove bancos sem código
                .sort((a, b) => a.name.localeCompare(b.name)); // Ordena pelo nome

            // Preenche o combo box com os bancos filtrados
            bancosValidos.forEach(banco => {
                const option = document.createElement('option');
                option.value = banco.code; // Código do banco
                option.textContent = banco.name; // Nome do banco

                if (String(banco.code) === String(bancoSelecionado)) {
                    option.selected = true; // Define como selecionado
                }
                selectBanco.appendChild(option);
            });

            // Remove mensagem de erro (se houver) após o carregamento bem-sucedido
            const errorElement = document.getElementById('banco-error');
            if (errorElement) {
                errorElement.remove();
            }
        })
        .catch(error => {
            console.error('Erro ao carregar os bancos:', error);

            // Adiciona uma mensagem de erro abaixo do campo
            let errorElement = document.getElementById('banco-error');
            if (!errorElement) {
                errorElement = document.createElement('div');
                errorElement.id = 'banco-error';
                errorElement.className = 'error';
                errorElement.textContent = 'Não foi possível carregar a lista de bancos. Tente novamente mais tarde.';
                document.getElementById('banco').after(errorElement);
            }

            // Caso necessário, também pode alertar o usuário
            alert('Não foi possível carregar a lista de bancos.');
        });
}

// Chama a função ao carregar a página
document.addEventListener('DOMContentLoaded', function () {
    // Valor do banco selecionado vindo do back-end
    const bancoSelecionado = document.getElementById('banco').getAttribute('data-banco-selecionado');
    carregarBancos(bancoSelecionado);
});