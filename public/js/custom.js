document.addEventListener('DOMContentLoaded', function () {
    const tipoAnexoSelect = document.getElementById('type_anex'); // Pode estar ausente
    const moradorSelect = document.getElementById('morador'); // Pode estar ausente
    const acordoTextarea = document.getElementById('acordo'); // Textarea
    const salarioInput = document.getElementById('salario'); // Campo de salário
    const refCaixa = document.getElementById('ref_caixa');
    const resumoUrlDiv = document.getElementById('resumo-url');
    const BASE_URL = resumoUrlDiv ? resumoUrlDiv.getAttribute('data-url-resumo') : '';

    function toggleMoradorSelect() {
        if (tipoAnexoSelect && moradorSelect) {
            moradorSelect.disabled = tipoAnexoSelect.value !== '2';
            if (moradorSelect.disabled) moradorSelect.value = '';
        }
    }

    function toggleAcordoTextarea() {
        const selectedRadio = document.querySelector('input[name="possui_acordo"]:checked');
        if (selectedRadio) {
            acordoTextarea.disabled = selectedRadio.value !== 'SIM';
            if (acordoTextarea.disabled) acordoTextarea.value = '';
        }
    }

    function formatarSalario() {
        if (salarioInput) {
            let valor = salarioInput.value.replace(/[^\d]/g, '');
            if (valor.length) {
                valor = valor.replace(/(\d)(\d{3})(\d{3})$/, '$1.$2.$3');
                valor = valor.replace(/(\d)(\d{3})(\d{1,2})$/, '$1.$2,$3');
                valor = valor.replace(/(\d)(\d{2})$/, '$1,$2');
            }
            salarioInput.value = valor ? `R$ ${valor}` : '';
        }
    }

    function atualizarResumo() {
        if (refCaixa && BASE_URL) {
            fetch(`${BASE_URL}/${refCaixa.value}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Verifique se o valor está presente e, se não, defina como 0
                    const entrada = data.entrada[0].entrada || "0,00"; // Se for nulo, usa "0,00"
                    const saida = data.saida[0].saida || "0,00"; // Se for nulo, usa "0,00"
                    const valorCaixa = data.valor_caixa[0].total_em_caixa || "0,00"; // Se for nulo, usa "0,00"

                    document.getElementById("entrada").textContent = `R$ ${entrada}`;
                    document.getElementById("saida").textContent = `R$ ${saida}`;
                    document.getElementById("valor_caixa").textContent = `R$ ${valorCaixa}`;
                })
                .catch((error) => {
                    console.error(error); // Para ver detalhes no console
                });
        }
    }

    if (tipoAnexoSelect) {
        tipoAnexoSelect.addEventListener('change', toggleMoradorSelect);
    }

    if (refCaixa) {
        refCaixa.addEventListener('change', atualizarResumo);
    }

    document.getElementsByName('possui_acordo').forEach(radio => {
        radio.addEventListener('change', toggleAcordoTextarea);
    });

    if (salarioInput) {
        salarioInput.addEventListener('input', formatarSalario);
    }

    toggleMoradorSelect();
    toggleAcordoTextarea();
    atualizarResumo();
});