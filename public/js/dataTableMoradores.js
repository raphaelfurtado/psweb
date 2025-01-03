
$('#dataTableMoradores').DataTable({
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
});

