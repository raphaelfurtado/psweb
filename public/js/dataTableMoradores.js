
$('#dataTableMoradores').DataTable({
    responsive: true,
    footerCallback: function (row, data, start, end, display) {
        let api = this.api();

        // Total geral de moradores
        let totalGeral = api
            .column(0) // Coluna dos nomes
            .data()
            .count();

        // Total de moradores na página atual
        let totalPagina = api
            .column(0, { page: 'current' })
            .data()
            .count();

        // Atualizar o rodapé
        $(api.column(1).footer()).html(
            `${totalPagina} moradores (de ${totalGeral} total)`
        );
    },

    layout: {
        bottom: {
            buttons: [{
                extend: 'excelHtml5',
                autoFilter: true,
                sheetName: '',
                className: 'bg-green-500 text-white py-2 px-4 rounded items-center space-x-2 hover:bg-green-600',
                text: '<i class="fas fa-file-excel"></i> Exportar para Excel',
                exportOptions: {
                    // Exclui a última coluna (coluna de ação, por exemplo)
                    columns: ':not(:last-child)'  // Exclui a última coluna
                }
            },
            {
                extend: 'pdfHtml5',
                download: 'open',
                messageTop: '',
                className: 'bg-red-500 text-white py-2 px-4 rounded items-center space-x-2 hover:bg-red-600',
                text: '<i class="fas fa-file-pdf"></i> Exportar para PDF',
                exportOptions: {
                    // Exclui a última coluna (coluna de ação, por exemplo)
                    columns: ':not(:last-child)'  // Exclui a última coluna
                }
            }
            ]
        }
    }
});

