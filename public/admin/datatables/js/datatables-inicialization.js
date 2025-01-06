document.addEventListener('DOMContentLoaded', function () {
    const tableIds = ['#example']; // Adicione mais IDs se necessário

    tableIds.forEach(id => {
        new DataTable(id, {
            responsive: true,
            language: {
                info: 'Página _PAGE_ de _PAGES_',
                infoEmpty: 'Sem registros',
                infoFiltered: '(filtrado de _MAX_ registros no total)',
                lengthMenu: 'Mostrar _MENU_ registros por página',
                zeroRecords: 'Registro não encontrado',
                search: 'Pesquisar'
            },
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        let column = this;
                        let header = column.header(); // Referência ao cabeçalho da coluna

                        if (header) { // Certifique-se de que o cabeçalho existe
                            let title = header.textContent.trim(); // Obter o título da coluna

                            // Se a coluna for pesquisável, adicione o campo de entrada
                            if (column.index() !== 4) { // Exemplo: colunas não pesquisáveis como a 4 (índice 4)
                                // Crie um elemento div para adicionar o campo de pesquisa abaixo do título
                                let searchDiv = document.createElement('div');
                            
                                // Crie o campo de input
                                let input = document.createElement('input');

                                input.placeholder = `Pesquisar`; // Define o placeholder
                                searchDiv.appendChild(input); // Adiciona o campo de entrada dentro da div

                                // Insira a div com o input abaixo do título da coluna
                                header.appendChild(searchDiv);

                                // Listener para buscar os dados ao digitar
                                input.addEventListener('input', () => {
                                    if (column.search() !== input.value) {
                                        column.search(input.value).draw();
                                    }
                                });
                            } else {
                                header.textContent = title; // Mantém o texto original se não for pesquisável
                            }
                        }
                    });
            },
            columnDefs: [{
                targets: [4], // Exemplo: desativa a pesquisa na coluna 4
                searchable: false
            }],
            className: 'table table-striped table-bordered table-hover table-sm'
        });
    });
});