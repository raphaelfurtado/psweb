document.addEventListener('DOMContentLoaded', function () {
    const tipoAnexoSelect = document.getElementById('type_anex');
    const moradorSelect = document.getElementById('morador');
    const salarioInput = document.getElementById('salario'); // Campo de salário

    // Função para habilitar/desabilitar o select morador
    function toggleMoradorSelect() {
        if (tipoAnexoSelect.value === '2') {
            moradorSelect.disabled = false;
        } else {
            moradorSelect.disabled = true;
            moradorSelect.value = ''; // Reseta o valor do select
        }
    }

    // Formatar salário como moeda
    function formatarSalario() {
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

    // Adiciona evento de mudança no select tipo_anexo
    tipoAnexoSelect.addEventListener('change', toggleMoradorSelect);

    // Adiciona evento de entrada no campo salário
    if (salarioInput) {
        salarioInput.addEventListener('input', formatarSalario);
    }

    // Chama a função inicialmente para garantir o estado correto
    toggleMoradorSelect();
});

// Formatar data no formato dd/mm/yyyy
function formatInputDate(input) {
    let value = input.value.replace(/\D/g, ''); // Remove caracteres não numéricos

    // Ajusta o dia (adiciona o zero para dias com 1 dígito)
    if (value.length >= 1 && value.length <= 2) {
        value = value.padStart(2, '0'); // Garante que o dia tenha 2 dígitos
    }

    // Adiciona a barra depois do dia
    if (value.length > 2) {
        value = value.slice(0, 2) + '/' + value.slice(2);
    }

    // Ajusta o mês (adiciona o zero para meses com 1 dígito)
    if (value.length >= 4 && value.length <= 5) {
        const dayPart = value.slice(0, 3); // Inclui "dd/"
        const monthPart = value.slice(3).padStart(2, '0'); // Garante que o mês tenha 2 dígitos
        value = dayPart + monthPart;
    }

    // Adiciona a barra depois do mês e ajusta o ano
    if (value.length > 5) {
        value = value.slice(0, 5) + '/' + value.slice(5, 9);
    }

    // Limita a 10 caracteres (dd/mm/yyyy)
    input.value = value.slice(0, 10);
}