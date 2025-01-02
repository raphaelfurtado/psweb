$('#dataTablePagamentos').DataTable({
    footerCallback: function(row, data, start, end, display) {
        // Variável para o total
        let api = this.api();
        var currentPosition = api.colReorder ? api.colReorder.transpose(7) : 7;

        // Remove o formato para obter dados numéricos
        let intVal = function(i) {
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

        // Atualizar o rodapé
        $(api.column(currentPosition).footer()).html(
            'R$ ' + pageTotal.toFixed(2) + ' ( R$' + total.toFixed(2) + ' total)'
        );
    },
    layout: {
        bottom: {
            buttons: [{
                extend: 'excelHtml5',
                autoFilter: true,
                sheetName: '<?= $titulo ?>',
                className: 'bg-green-500 text-white py-2 px-4 rounded flex items-center space-x-2 hover:bg-green-600',
                text: '<i class="fas fa-file-excel"></i> Exportar para Excel'
            }]
        }
    }
});