</div>
</main>
<footer class="bg-gray-800 text-white text-center py-4">
    <p class="text-sm">
        Feito por
        <a href="https://softbean.com" target="_blank" class="text-primary hover:underline">
            Softbean
        </a>
    </p>
</footer>

<script>
    // Script para alternar o menu
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('menu');

    menuToggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>

</body>

<script src="<?= base_url('js/jquery-3.7.1.js') ?>"></script>
<script src="<?= base_url('js/dataTables.js') ?>"></script>
<script src="<?= base_url('js/dataTables.tailwindcss.js') ?>"></script>
<script src="<?= base_url('js/dataTables.buttons.js') ?>"></script>
<script src="<?= base_url('js/buttons.dataTables.js') ?>"></script>
<script src="<?= base_url('js/jszip.min.js') ?>"></script>
<script src="<?= base_url('js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('js/dataTables.colReorder.js') ?>"></script>
<script src="<?= base_url('js/colReorder.dataTables.js') ?>"></script>

<script>
    let options = {
        language: {
            info: 'Mostrando _PAGE_ página de _PAGES_',
            infoEmpty: 'Nenhum registro encontrado',
            infoFiltered: '(filtrado no total de _MAX_ registros)',
            lengthMenu: 'Mostrar _MENU_ registros por página',
            zeroRecords: 'Nada encontrado - Desculpa',
            sSearch: "Pesquisar: "
        },
        footerCallback: function(row, data, start, end, display) {
            // Variável para o total
            let api = this.api();
            var currentPosition = api.colReorder.transpose(7);

            // Remove the formatting to get integer data for summation
            let intVal = function(i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i :
                    0;
            };

            // Total over all pages
            let total = api
                .column(currentPosition)
                .data()
                .reduce((a, b) => intVal(a) + intVal(b), 0);

            let pageTotal = api
                .column(currentPosition, {
                    page: 'current'
                })
                .data()
                .reduce((a, b) => intVal(a) + intVal(b), 0);

            // Update footer
            api.column(currentPosition).footer().innerHTML =
                 'R$ ' + pageTotal.toFixed(2) + ' ( R$' + total.toFixed(2) + ' total)';
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
    };

    new DataTable('#dataTablePagamentos', options);
</script>

</html>