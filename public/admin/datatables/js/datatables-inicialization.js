document.addEventListener('DOMContentLoaded', function () {
    const tableConfigs = {
        '#dataTableAnexos': {
            nonSearchable: [7],
            nonOrderable: [0, 1, 2, 3, 4, 5, 6, 7],
            centeredColumns: [1, 2, 4, 5, 7],
            modalTitleColumn: 0
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
            centeredColumns: [1, 2, 4, 5],
            modalTitleColumn: 1,
            enableButtons: true
        },
        '#dataTableFuncionario': {
            nonSearchable: [0, 4],
            nonOrderable: [0, 3, 4],
            centeredColumns: [0, 4],
            modalTitleColumn: 1
        }
    };

    Object.keys(tableConfigs).forEach(id => {
        const config = tableConfigs[id];
        const nonSearchableColumns = config.nonSearchable || [];
        const nonOrderableColumns = config.nonOrderable || [];
        const centeredColumns = config.centeredColumns || [];
        const modalTitleColumn = config.modalTitleColumn || 0;

        const tableOptions = {
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();
                const parseValue = (value) => {
                    if (typeof value === 'string') {
                        return parseFloat(value.replace(/\./g, '').replace(',', '.')) || 0;
                    }
                    return typeof value === 'number' ? value : 0;
                };

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