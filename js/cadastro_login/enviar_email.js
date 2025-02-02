function sendEmail() {
    const sendButton = document.getElementById("enviarEmail"); // Pegando o botão de envio
    sendButton.disabled = true; // Desabilita o botão para evitar duplo clique

    const templateParams = {
        nomeAcademia: document.getElementById("nomeAcademia").value,
        nomeGerente: document.getElementById("nomeGerente").value,
        telefoneAcademia: document.getElementById("telefoneAcademia").value,
        telefoneGerente: document.getElementById("telefoneGerente").value,
        email: document.getElementById("email").value,
        cpf: document.getElementById("cpf").value,
        cep: document.getElementById("cep").value,
        estado: document.getElementById("estado").value,
        cidade: document.getElementById("cidade").value,
        bairro: document.getElementById("bairro").value,
        rua: document.getElementById("rua").value,
        numero: document.getElementById("numero").value,
        complemento: document.getElementById("complemento").value,
        abertura: document.getElementById("abertura").value,
        fechamento: document.getElementById("fechamento").value,
        funcionamento: document.querySelector('input[name="dia_semana"]:checked').value // Pega o valor do rádio selecionado
    };

    emailjs.send('service_zzwirtl', 'template_y90vtvb', templateParams)
        .then(function(response) {
            alert('E-mail enviado com sucesso!');
            window.location.href = '../index.php';
        })
        .catch(function(error) {
            alert('Falha ao enviar e-mail: ' + error.text);
            sendButton.disabled = false; // Habilita o botão novamente em caso de erro
        });
}
