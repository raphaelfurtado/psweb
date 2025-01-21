function formatarMoeda(campo) {
    let valor = campo.value;
    // Remove tudo que não for número ou vírgula/ponto
    valor = valor.replace(/\D/g, '');

    // Formata o valor para moeda brasileira
    valor = (valor / 100).toFixed(2).replace('.', ',');
    valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    // Atualiza o valor do campo
    campo.value = valor;
}

