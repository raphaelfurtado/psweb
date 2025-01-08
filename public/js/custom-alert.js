function fadeOut(element, duration) {
    let opacity = 1;  // Começar com opacidade total
    const interval = 50; // Intervalo para diminuir a opacidade
    const gap = interval / duration;  // O valor que vai ser subtraído da opacidade
    // Função de animação
    const fade = setInterval(function () {
        opacity -= gap;
        if (opacity <= 0) {
            clearInterval(fade); // Parar a animação quando a opacidade atingir 0
            element.style.display = 'none'; // Esconder o elemento
        } else {
            element.style.opacity = opacity; // Atualiza a opacidade do elemento
        }
    }, interval);
}
// Aplicar o fadeOut nas mensagens 
setTimeout(function () {
    const successMessage = document.getElementById('flash-message');
    if (successMessage) {
        fadeOut(successMessage, 1000); // 1 segundo de fade
    }
}, 5000); // Atraso de 3 segundos antes de iniciar o fade
