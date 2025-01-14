document.addEventListener('DOMContentLoaded', function () {
    const tipoAnexoSelect = document.getElementById('type_anex'); // Pode estar ausente
    const moradorSelect = document.getElementById('morador'); // Pode estar ausente
    const acordoTextarea = document.getElementById('acordo'); // Textarea
    const salarioInput = document.getElementById('salario'); // Campo de salário

    // Função para habilitar/desabilitar o select morador
    function toggleMoradorSelect() {
        if (tipoAnexoSelect && moradorSelect) {
            if (tipoAnexoSelect.value === '2') {
                moradorSelect.disabled = false;
            } else {
                moradorSelect.disabled = true;
                moradorSelect.value = ''; // Reseta o valor do select
            }
        }
    }

    // Função para habilitar/desabilitar a textarea acordo com base nos rádios
    function toggleAcordoTextarea() {
        const selectedRadio = document.querySelector('input[name="possui_acordo"]:checked');
        if (selectedRadio) {
            if (selectedRadio.value === 'SIM') {
                acordoTextarea.disabled = false; // Habilita a textarea
            } else {
                acordoTextarea.disabled = true; // Desabilita a textarea
                acordoTextarea.value = ''; // Limpa o conteúdo da textarea
            }
        }
    }

    // Formatar salário como moeda
    function formatarSalario() {
        if (salarioInput) {
            let valor = salarioInput.value.replace(/[^\d]/g, ''); // Remove caracteres não numéricos

            if (valor.length) {
                // Coloca o ponto a cada 3 dígitos
                valor = valor.replace(/(\d)(\d{3})(\d{3})$/, '$1.$2.$3');
                valor = valor.replace(/(\d)(\d{3})(\d{1,2})$/, '$1.$2,$3');
                // Coloca a vírgula para separar os centavos
                valor = valor.replace(/(\d)(\d{2})$/, '$1,$2');
            }

            salarioInput.value = valor ? `R$ ${valor}` : ''; // Adiciona o símbolo de "R$" no início
        }
    }

    // Adiciona evento de mudança no select tipo_anex, se existir
    if (tipoAnexoSelect) {
        tipoAnexoSelect.addEventListener('change', toggleMoradorSelect);
    }

    // Adiciona evento de mudança nos rádios com o nome "possui_acordo"
    const radioGroup = document.getElementsByName('possui_acordo');
    radioGroup.forEach(radio => {
        radio.addEventListener('change', toggleAcordoTextarea);
    });

    // Adiciona evento de entrada no campo salário, se existir
    if (salarioInput) {
        salarioInput.addEventListener('input', formatarSalario);
    }

    // Garante o estado correto ao carregar a página
    toggleMoradorSelect();
    toggleAcordoTextarea();
});