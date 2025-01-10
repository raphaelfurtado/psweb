document.addEventListener('DOMContentLoaded', function () {
    // Configurações das tabelas: mapeia colunas não pesquisáveis, não ordenáveis, centralizadas
    const tableConfigs = {
        '#dataTableAnexos': {
            nonSearchable: [7], // Colunas sem pesquisa
            nonOrderable: [0, 1, 2, 3, 4, 5, 6, 7], // Colunas sem ordenação
            centeredColumns: [1, 2, 4, 5, 7], // Colunas a serem centralizadas
            modalTitleColumn: 0 // Índice da coluna para exibir no título da modal
        },
        '#dataTablePagamentos': {
            nonSearchable: [0, 11], // Colunas sem pesquisa
            nonOrderable: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 11], // Colunas sem ordenação
            centeredColumns: [0, 2, 3, 5, 8, 11], // Colunas a serem centralizadas
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
                                input.placeholder = ``;
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
            columnDefs: [{
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
            tableOptions.dom = '<"top"lf>rt<"bottom d-flex flex-column"<"buttons-container"B><"pagination-container"p>><"clear">';
            tableOptions.buttons = [{
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
                    titleAttr: 'Exportar para PDF'
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