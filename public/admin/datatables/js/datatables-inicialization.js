document.addEventListener('DOMContentLoaded', function () {
    // Configurações das tabelas: mapeia colunas não pesquisáveis, não ordenáveis, centralizadas, visíveis e visíveis no mobile
    const tableConfigs = {
        '#example': {
            nonSearchable: [7], // Colunas sem pesquisa
            nonOrderable: [0, 1, 2, 3, 4, 5, 6, 7], // Colunas sem ordenação
            centeredColumns: [1, 2, 4, 5], // Colunas a serem centralizadas
            mobileVisibleColumns: [1, 2, 3], // Colunas visíveis no mobile (defina dinamicamente)
            modalTitleColumn: 0 // Índice da coluna para exibir no título da modal
        }
    };

    Object.keys(tableConfigs).forEach(id => {
        const config = tableConfigs[id]; // Obter a configuração para a tabela atual
        const nonSearchableColumns = config.nonSearchable || [];
        const nonOrderableColumns = config.nonOrderable || [];
        const centeredColumns = config.centeredColumns || [];
        const mobileVisibleColumns = config.mobileVisibleColumns || []; // Colunas visíveis no mobile
        const modalTitleColumn = config.modalTitleColumn || 0; // Índice da coluna para o título da modal

        let table = new DataTable(id, {
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            const data = row.data();
                            const titleData = data[modalTitleColumn];
                            return titleData ? 'Detalhes: ' + titleData : 'Detalhes';
                        },
                        renderer: function (api, rowIdx, columns) {
                            let data = '';
                            columns.forEach(function (col) {
                                if (col.columnIndex === 0) {
                                    data += '<strong>' + col.title + ':</strong> ' + col.data + '<br>';
                                } else {
                                    data += '<strong>' + col.title + ':</strong> ' + col.data + '<br>';
                                }
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

                            // Aplica visibilidade nas colunas no mobile
                            if (mobileVisibleColumns.includes(column.index())) {
                                $(header).css('display', 'table-cell');
                                $(column.footer()).css('display', 'table-cell');
                            } else {
                                $(header).css('display', 'none');
                                $(column.footer()).css('display', 'none');
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

                mobileVisibleColumns.forEach(function (colIndex) {
                    $('td', row).eq(colIndex).css('display', 'table-cell');
                });
            },
            columnDefs: [{
                    targets: nonSearchableColumns,
                    searchable: false
                },
                {
                    targets: nonOrderableColumns,
                    orderable: false
                },
                {
                    targets: mobileVisibleColumns,
                    visible: true
                }
            ]
        });

        // Força a atualização da tabela quando a janela é redimensionada
        $(window).on('resize', function () {
            table.columns.adjust().responsive.recalc();
        });
    });
});