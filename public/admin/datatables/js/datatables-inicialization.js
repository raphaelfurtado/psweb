document.addEventListener('DOMContentLoaded', function () {
    // Configurações das tabelas: mapeia colunas não pesquisáveis, não ordenáveis, centralizadas, visíveis e visíveis no mobile
    const tableConfigs = {
        '#example': {
            nonSearchable: [7], // Colunas sem pesquisa
            nonOrderable: [0, 1, 2, 3, 4, 5, 6, 7], // Colunas sem ordenação
            centeredColumns: [1, 2, 4, 5], // Colunas a serem centralizadas
            modalTitleColumn: 0 // Índice da coluna para exibir no título da modal
        },
        '#dataTablePagamentos': {
            nonSearchable: [0], // Colunas sem pesquisa
            nonOrderable: [0, 2, 3, 7, 10], // Colunas sem ordenação
            centeredColumns: [1, 2, 4, 5], // Colunas a serem centralizadas
            modalTitleColumn: 1, // Índice da coluna para exibir no título da modal
            enableButtons: true // Adicionar botões de exportação para esta tabela
        },
        '#dataTableMoradores': {
            nonSearchable: [5], // Colunas sem pesquisa
            nonOrderable: [5], // Colunas sem ordenação
            centeredColumns: [1, 2, 4, 5], // Colunas a serem centralizadas
            modalTitleColumn: 1, // Índice da coluna para exibir no título da modal
            enableButtons: true // Adicionar botões de exportação para esta tabela
        },
    };

    Object.keys(tableConfigs).forEach(id => {
        const config = tableConfigs[id];
        const nonSearchableColumns = config.nonSearchable || [];
        const nonOrderableColumns = config.nonOrderable || [];
        const centeredColumns = config.centeredColumns || [];
        const modalTitleColumn = config.modalTitleColumn || 0;

        const tableOptions = {
            order: [[0, 'asc'], [1, 'asc']],
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();
            
                const parseValue = (value) => {
                    // Remove separadores de milhares (.) e converte vírgula decimal (,) para ponto (.)
                    if (typeof value === 'string') {
                        return parseFloat(value.replace(/\./g, '').replace(',', '.')) || 0;
                    }
                    return typeof value === 'number' ? value : 0;
                };
            
                // Soma total de todos os valores filtrados (todas as páginas do filtro aplicado)
                let filteredTotal = api
                    .rows({ search: 'applied' }) // Seleciona todas as linhas filtradas
                    .data()
                    .reduce((acc, row) => acc + parseValue(row[7]), 0); // Ajuste o índice da coluna conforme necessário
            
                // Soma total apenas dos valores exibidos na página atual
                let pageTotal = api
                    .column(7, { page: 'current' }) // Ajuste o índice da coluna conforme necessário
                    .data()
                    .reduce((acc, val) => acc + parseValue(val), 0);
            
                // Atualiza o rodapé
                $(api.column(7).footer()).html(
                    `Total: R$ ${filteredTotal.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}`
                );
            },            
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            const data = row.data();
                            const titleData = data[modalTitleColumn];
                            return titleData ? titleData : 'Detalhes';
                        },
                        renderer: function (api, rowIdx, columns) {
                            let data = '';
                            columns.forEach(function (col) {
                                data += `<strong>${col.title}:</strong> ${col.data}<br>`;
                            });
                            return data;
                        }
                    }),
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: 'table'
                    })
                }
            },
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
                        let header = column.header();

                        if (header) {
                            let title = header.textContent.trim();

                            // Adiciona o filtro de pesquisa na coluna
                            if (!nonSearchableColumns.includes(column.index())) {
                                let searchDiv = document.createElement('div');
                                searchDiv.classList.add('input-group', 'mt-2');
                                let input = document.createElement('input');
                                input.classList.add('form-control');
                                input.placeholder = `Pesquisar`;
                                searchDiv.appendChild(input);
                                header.appendChild(searchDiv);

                                input.addEventListener('input', () => {
                                    if (column.search() !== input.value) {
                                        column.search(input.value).draw();
                                    }
                                });
                            }

                            // Aplica a centralização nas colunas
                            if (centeredColumns.includes(column.index())) {
                                header.style.textAlign = 'center';
                                header.style.verticalAlign = 'middle';
                            }
                        }
                    });
            },
            createdRow: function (row, data, dataIndex) {
                centeredColumns.forEach(function (colIndex) {
                    $('td', row).eq(colIndex).css({
                        'text-align': 'center',
                        'vertical-align': 'middle'
                    });
                });
            },
            columnDefs: [
                {
                    targets: nonSearchableColumns,
                    searchable: false
                },
                {
                    targets: nonOrderableColumns,
                    orderable: false
                }
            ]
        };

        // Adicionar botões somente para a tabela #dataTablePagamentos
        if (config.enableButtons) {
            tableOptions.dom = '<"top"lf>rt<"bottom d-flex flex-column align-items-center"Bp><"clear">';
            tableOptions.buttons = [
                {
                    extend: 'excelHtml5',
                    autoFilter: true,
                    sheetName: '',
                    className: 'btn btn-success btn-rounded btn-icon',
                    text: '<i class="mdi mdi-file-excel"></i>',
                    exportOptions: {
                        columns: ':not(:last-child)' // Exclui a última coluna
                    },
                    titleAttr: 'Exportar para Excel'
                },
                {
                    extend: 'pdfHtml5',
                    download: 'open',
                    messageTop: '',
                    className: 'btn btn-danger btn-rounded btn-icon',
                    text: '<i class="mdi mdi-file-pdf"></i>',
                    orientation: 'landscape',
                    exportOptions: {
                        columns: ':not(:last-child)' // Exclui a última coluna
                    },
                    titleAttr: 'Exportar para PDF',
                }
            ];
        }

        let table = new DataTable(id, tableOptions);

        // Força a atualização da tabela quando a janela é redimensionada
        $(window).on('resize', function () {
            table.columns.adjust().responsive.recalc();
        });
    });
});
