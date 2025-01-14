// Captura o clique no item "Alterar Senha"
document.getElementById('changePasswordLink').addEventListener('click', function (event) {
    event.preventDefault(); // Impede a navegação do link
    var myModal = new bootstrap.Modal(document.getElementById('changePasswordModal'), {
        keyboard: false
    });
    myModal.show(); // Abre o modal
});


// Função para alternar a visibilidade das senhas
function togglePasswordVisibility(inputId, iconId) {
    var passwordInput = document.getElementById(inputId);
    var icon = document.getElementById(iconId);

    if (passwordInput.type === "password") {
        passwordInput.type = "text"; // Torna a senha visível
        icon.classList.remove("mdi-eye-off");
        icon.classList.add("mdi-eye"); // Altera o ícone para "olho aberto"
    } else {
        passwordInput.type = "password"; // Torna a senha oculta
        icon.classList.remove("mdi-eye");
        icon.classList.add("mdi-eye-off"); // Altera o ícone para "olho fechado"
    }
}

// Adiciona eventos de clique para alternar as senhas
document.getElementById("showNewPassword").addEventListener("click", function () {
    togglePasswordVisibility("newPassword", "showNewPassword");
});
document.getElementById("showConfirmPassword").addEventListener("click", function () {
    togglePasswordVisibility("confirmPassword", "showConfirmPassword");
});