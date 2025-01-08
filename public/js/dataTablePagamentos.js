$('#dataTablePagamentos').DataTable({
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
