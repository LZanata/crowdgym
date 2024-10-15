function validarSenha() {
    var senha = document.getElementById('senha').value;
    var confirmaSenha = document.getElementById('confirma_senha').value;

    if (senha !== confirmaSenha) {
        alert("As senhas não coincidem. Por favor, tente novamente.");
        return false; // Impede o envio do formulário
    }
    return true; // Permite o envio do formulário
}