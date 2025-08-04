document.addEventListener('DOMContentLoaded', function () {
    //upload
    const tableConfigs = {
        '#dataTableAnexos': {
            nonSearchable: [0, 9],
            nonOrderable: [2, 3, 5, 6, 7, 9],
            centeredColumns: [0, 2, 3, 5, 6, 7, 9],
            modalTitleColumn: 1
        },
        '#dataTablePagamentos': {
            nonSearchable: [0, 13],
            nonOrderable: [0, 2, 3, 7, 8],
            centeredColumns: [0, 2, 3, 4, 5, 9, 10, 13],
            modalTitleColumn: 1,
            enableButtons: true,
            totalPagamento: true
        },
        '#dataTableMoradores': {
            nonSearchable: [5],
            nonOrderable: [5],
            centeredColumns: [1, 3, 4, 5],
            modalTitleColumn: 1,
            enableButtons: true
        },
        '#dataTableFuncionario': {
            nonSearchable: [0, 4],
            nonOrderable: [0, 3, 4],
            centeredColumns: [0, 4],
            modalTitleColumn: 1
        },
        '#dataTableTipoPagamento': {
            nonSearchable: [3],
            nonOrderable: [2, 3],
            centeredColumns: [0, 2, 3],
            modalTitleColumn: 1
        },
        '#dataTableTipoSaida': {
            nonSearchable: [3],
            nonOrderable: [2, 3],
            centeredColumns: [0, 2, 3],
            modalTitleColumn: 1
        },
        '#dataTableFormaPagamento': {
            nonSearchable: [3],
            nonOrderable: [2, 3],
            centeredColumns: [0, 2, 3],
            modalTitleColumn: 1
        },
        '#dataTableSaida': {
            nonSearchable: [0, 5],
            nonOrderable: [2, 3],
            centeredColumns: [0, 2, 3],
            modalTitleColumn: 1,
            enableButtons: true,
            totalPagamento: true
        },
        '#dataTablePrestContas': {
            nonSearchable: [2],
            nonOrderable: [2],
            centeredColumns: [1, 2],
            modalTitleColumn: 0
        },
        '#dataTablePagamentosFuncionario': {
            nonSearchable: [0, 5],
            nonOrderable: [2, 3],
            centeredColumns: [0, 2, 3],
            modalTitleColumn: 1,
            enableButtons: true,
        }
    };

    Object.keys(tableConfigs).forEach(id => {
        const config = tableConfigs[id];
        const nonSearchableColumns = config.nonSearchable || [];
        const nonOrderableColumns = config.nonOrderable || [];
        const centeredColumns = config.centeredColumns || [];
        const modalTitleColumn = config.modalTitleColumn || 0;

        const tableOptions = {
            pageLength: 100,
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();
                function parseValue(value) {
                    // Remove "R$" e espaços extras
                    let numericValue = value.replace('R$', '').trim();
                    // Substitui o separador de milhar e ajusta o decimal
                    numericValue = numericValue.replace(/\./g, '').replace(',', '.');
                    // Converte para número
                    return parseFloat(numericValue) || 0;
                }

                if (config.totalPagamento) {
                    let filteredTotal = api.rows({
                        search: 'applied'
                    }).data()
                        .reduce((acc, row) => acc + parseValue(row[8]), 0);

                    let pageTotalValor = api.column(7, {
                        page: 'current'
                    }).data()
                        .reduce((acc, val) => acc + parseValue(val), 0);

                    $(api.column(8).footer()).html(
                        `Total: R$ ${filteredTotal.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}`
                    );
                }

                let pageTotal = display.length;
                $(api.column(0).footer()).html(`Registros: ${pageTotal}`);
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
                emptyTable: 'Sem registros',
                infoFiltered: '(filtrado de _MAX_ registros no total)',
                lengthMenu: 'Mostrar _MENU_ registros por página',
                zeroRecords: 'Registro não encontrado',
                search: 'Pesquisar',
                loadingRecords: "Carregando...",
                processing: "Processando...",
                zeroRecords: "Nenhum registro encontrado"
            },
            initComplete: function () {
                let api = this.api();

                // Criar inputs de data
                let filterContainer = document.createElement('div');
                filterContainer.classList.add('d-flex', 'gap-2', 'mb-2');
                filterContainer.innerHTML = `
        <label>Data Inicial: <input type="date" id="filter-start" class="form-control form-control-sm"></label>
        <label>Data Final: <input type="date" id="filter-end" class="form-control form-control-sm"></label>
    `;

                $(this.api().table().container()).before(filterContainer);

                // Filtro personalizado (data de pagamento)
                $.fn.dataTable.ext.search.push(function (settings, data) {
                    if (settings.nTable !== api.table().node()) return true; // Aplica apenas à tabela correta

                    let minDate = document.getElementById('filter-start').value ? new Date(document.getElementById('filter-start').value) : null;
                    let maxDate = document.getElementById('filter-end').value ? new Date(document.getElementById('filter-end').value) : null;
                    let rowDate = data[4]; // Alterar índice conforme necessário (coluna "Data Pagto")

                    if (!rowDate) return false; // Se não houver data, não exibir

                    let dateParts = rowDate.split('/');
                    let formattedDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]); // Formato DD/MM/YYYY

                    if (
                        (minDate === null && maxDate === null) ||
                        (minDate === null && formattedDate <= maxDate) ||
                        (minDate <= formattedDate && maxDate === null) ||
                        (minDate <= formattedDate && formattedDate <= maxDate)
                    ) {
                        return true;
                    }
                    return false;
                });


                // Reaplicar filtro ao mudar as datas
                document.getElementById('filter-start').addEventListener('change', () => api.draw());
                document.getElementById('filter-end').addEventListener('change', () => api.draw());

                this.api()
                    .columns()
                    .every(function () {
                        let column = this;
                        let header = column.header();

                        if (header) {
                            let title = header.textContent.trim();
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

        if (config.enableButtons) {
            tableOptions.dom = '<"top"lf>rt<"bottom d-flex flex-column"<"buttons-container text-center"B><"pagination-container text-center"p>><"clear">';
            tableOptions.buttons = [{
                extend: 'excelHtml5',
                autoFilter: true,
                sheetName: '',
                className: 'btn btn-success btn-rounded btn-icon',
                text: '<i class="mdi mdi-file-excel"></i>',
                exportOptions: {
                    columns: ':not(:last-child)'
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
                    columns: ':not(:last-child)'
                },
                titleAttr: 'Exportar para PDF'
            }
            ];
        }

        let table = new DataTable(id, tableOptions);
        $(window).on('resize', function () {
            table.columns.adjust().responsive.recalc();
        });
    });
});