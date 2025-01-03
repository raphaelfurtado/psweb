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
<script src="<?= base_url('js/defaultLayoutDataTable.js') ?>"></script>

<script>
    // Inicializando tabelas
    $(document).ready(function() {
        // Todas as tabelas com a classe .datatable serão configuradas automaticamente
        $('.datatable').DataTable();
    });
</script>

<!-- Inicializar DataTable com configurações específicas -->
<script src="<?= base_url('js/dataTablePagamentos.js') ?>"></script>
<script src="<?= base_url('js/dataTableMoradores.js') ?>"></script>


</html>