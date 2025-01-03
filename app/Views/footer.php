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

<!-- Inclua o arquivo JS -->
<script src="<?php echo base_url('js/custom.js'); ?>"></script>

</body>

</html>