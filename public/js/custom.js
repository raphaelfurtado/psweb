document.addEventListener('DOMContentLoaded', function () {
    const tipoAnexoSelect = document.getElementById('type_anex'); // Pode estar ausente
    const moradorSelect = document.getElementById('morador'); // Pode estar ausente
    const acordoTextarea = document.getElementById('acordo'); // Textarea
    const salarioInput = document.getElementById('salario'); // Campo de salário
    const refCaixa = document.getElementById('ref_caixa');
    const refConcreto = document.getElementById('ref_concreto');
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

    function atualizarResumo(ref, type) {
        if (ref && BASE_URL) {
            fetch(`${BASE_URL}/${ref}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (type === 'caixa') {
                        const entrada = data.entrada[0].entrada || "0,00";
                        const saida = data.saida[0].saida || "0,00";
                        const valorCaixa = data.valor_caixa[0].total_em_caixa || "0,00";

                        const elEntrada = document.getElementById("entrada");
                        const elSaida = document.getElementById("saida");
                        const elValorCaixa = document.getElementById("valor_caixa");

                        if (elEntrada) elEntrada.textContent = `R$ ${entrada}`;
                        if (elSaida) elSaida.textContent = `R$ ${saida}`;
                        if (elValorCaixa) elValorCaixa.textContent = `R$ ${valorCaixa}`;
                    } else if (type === 'concreto') {
                        const entradaConcreto = data.entrada_concreto[0].entrada || "0,00";
                        const saidaConcreto = data.saida_concreto[0].saida || "0,00";
                        const valorCaixaConcreto = data.valor_caixa_concreto[0].total_em_caixa || "0,00";

                        const elEntradaConc = document.getElementById("entrada_concreto");
                        const elSaidaConc = document.getElementById("saida_concreto");
                        const elValorCaixaConc = document.getElementById("valor_caixa_concreto");

                        if (elEntradaConc) elEntradaConc.textContent = `R$ ${entradaConcreto}`;
                        if (elSaidaConc) elSaidaConc.textContent = `R$ ${saidaConcreto}`;
                        if (elValorCaixaConc) elValorCaixaConc.textContent = `R$ ${valorCaixaConcreto}`;
                    }
                })
                .catch((error) => {
                    console.error(`Error updating ${type}:`, error);
                });
        }
    }

    if (tipoAnexoSelect) {
        tipoAnexoSelect.addEventListener('change', toggleMoradorSelect);
    }

    if (refCaixa) {
        refCaixa.addEventListener('change', () => atualizarResumo(refCaixa.value, 'caixa'));
    }

    if (refConcreto) {
        refConcreto.addEventListener('change', () => atualizarResumo(refConcreto.value, 'concreto'));
    }

    document.getElementsByName('possui_acordo').forEach(radio => {
        radio.addEventListener('change', toggleAcordoTextarea);
    });

    if (salarioInput) {
        salarioInput.addEventListener('input', formatarSalario);
    }

    toggleMoradorSelect();
    toggleAcordoTextarea();
    if (refCaixa) atualizarResumo(refCaixa.value, 'caixa');
    if (refConcreto) atualizarResumo(refConcreto.value, 'concreto');
});