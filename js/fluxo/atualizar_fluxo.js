// Espera o carregamento do DOM
document.addEventListener('DOMContentLoaded', function() {
    // Obtém o ID da academia que está no campo oculto
    const academiaId = document.getElementById('academiaId').value;

    // Atualiza o fluxo a cada 5 segundos
    setInterval(() => {
        atualizarFluxo(academiaId);
    }, 5000);
});

// Função para atualizar o fluxo
function atualizarFluxo(academia_id) {
    // Verifica se o ID da academia está presente
    if (!academia_id) {
        console.error("Academia ID ausente.");
        return;
    }

    // Cria o objeto de dados a ser enviado
    const dados = {
        academia_id: academia_id
    };

    // Envia os dados para o PHP via fetch
    fetch('../php/fluxo/fluxo_ao_vivo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dados)
    })
    .then(response => response.json())
    .then(data => {
        if (data.erro) {
            console.error(data.erro);
        } else {
            // Atualiza o número de alunos treinando no DOM
            document.getElementById("contadorFluxo").textContent = data.alunos_treinando;
        }
    })
    .catch(error => console.error('Erro na requisição:', error));
}
