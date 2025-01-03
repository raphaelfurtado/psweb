document.addEventListener('DOMContentLoaded', function () {
    const tipoAnexoSelect = document.getElementById('tipo_anexo');
    const moradorSelect = document.getElementById('morador');

    // Função para habilitar/desabilitar o select morador
    function toggleMoradorSelect() {
        if (tipoAnexoSelect.value === '2') {
            moradorSelect.disabled = false;
        } else {
            moradorSelect.disabled = true;
            moradorSelect.value = ''; // Reseta o valor do select
        }
    }

    // Adiciona evento de mudança no select tipo_anexo
    tipoAnexoSelect.addEventListener('change', toggleMoradorSelect);

    // Chama a função inicialmente para garantir o estado correto
    toggleMoradorSelect();
});