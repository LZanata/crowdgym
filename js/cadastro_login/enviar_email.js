function sendEmail() {
    const templateParams = {
        nomeAcademia: document.getElementById("nomeAcademia").value,
        nomeGerente: document.getElementById("nomeGerente").value,
        telefoneAcademia: document.getElementById("telefoneAcademia").value,
        telefoneGerente: document.getElementById("telefoneGerente").value,
        email: document.getElementById("email").value,
        cep: document.getElementById("cep").value,
        estado: document.getElementById("estado").value,
        cidade: document.getElementById("cidade").value,
        bairro: document.getElementById("bairro").value,
        rua: document.getElementById("rua").value,
        numero: document.getElementById("numero").value,
        complemento: document.getElementById("complemento").value       
    };

    emailjs.send('service_zzwirtl', 'template_y90vtvb', templateParams)
        .then(function(response) {
            alert('E-mail enviado com sucesso!');
        }, function(error) {
            alert('Falha ao enviar e-mail: ' + error.text);
        });
}