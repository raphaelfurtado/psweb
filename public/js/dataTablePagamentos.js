$('#dataTablePagamentos').DataTable({
    responsive: {
        breakpoints: [
            { name: 'bigdesktop', width: Infinity },
            { name: 'meddesktop', width: 1480 },
            { name: 'smalldesktop', width: 1280 },
            { name: 'medium', width: 1188 },
            { name: 'tabletl', width: 1024 },
            { name: 'btwtabllandp', width: 848 },
            { name: 'tabletp', width: 768 },
            { name: 'mobilel', width: 480 },
            { name: 'mobilep', width: 320 }
        ]
    },
    footerCallback: function (row, data, start, end, display) {
        // Variável para o total
        let api = this.api();
        var currentPosition = api.colReorder ? api.colReorder.transpose(7) : 7;

        // Remove o formato para obter dados numéricos
        let intVal = function (i) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '') * 1 :
                typeof i === 'number' ?
                    i :
                    0;
        };

        // Total em todas as páginas
        let total = api
            .column(currentPosition)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);

        // Total na página atual
        let pageTotal = api
            .column(currentPosition, {
                page: 'current'
            })
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);

        // Somar os valores dos pagamentos com status "PAGO"
        let pagoTotal = 0;
        api.column(currentPosition).data().each(function (value, index) {
            // Supondo que a coluna de status esteja na coluna 8
            let statusHtml = api.cell({ row: index, column: 8 }).data(); // Ajuste o índice da coluna de status conforme necessário
            let statusText = $(statusHtml).text().trim(); // Extrai apenas o texto do HTML e remove espaços extras
            
            if (statusText.toUpperCase() === 'PAGO') {
                pagoTotal += intVal(value);
            }
        });


        // Atualizar o rodapé com o total e o total dos pagamentos "PAGO"
        $(api.column(currentPosition).footer()).html(
            //'R$ ' + pageTotal.toFixed(2) + ' ( R$ ' + total.toFixed(2) + ' total) | ' +
            'Total página R$ ' + pageTotal.toFixed(2) + ' | ' + 
            'Total PAGO: R$ ' + pagoTotal.toFixed(2)
        );
    },

    layout: {
        bottom: {
            buttons: [{
                extend: 'excelHtml5',
                autoFilter: true,
                sheetName: '',
                className: 'bg-green-500 text-white py-2 px-4 rounded  items-center space-x-2 hover:bg-green-600',
                text: '<i class="fas fa-file-excel"></i> Exportar para Excel',
                exportOptions: {
                    columns: ':not(:last-child)'  // Exclui a última coluna
                }
            },
            {
                extend: 'pdfHtml5',
                download: 'open',
                messageTop: '',
                className: 'bg-red-500 text-white py-2 px-4 rounded  items-center space-x-2 hover:bg-red-600',
                text: '<i class="fas fa-file-pdf"></i> Exportar para PDF',
                orientation: 'landscape',
                exportOptions: {
                    columns: ':not(:last-child)'  // Exclui a última coluna
                }
            }]
        }
    }
});
