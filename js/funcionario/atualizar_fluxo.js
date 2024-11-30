// Função para atualizar o fluxo
function atualizarFluxo(aluno_id, academia_id) {
    // Verifica se os IDs estão presentes
    if (!aluno_id || !academia_id) {
        console.error("Dados incompletos: aluno_id ou academia_id ausente.");
        return;
    }

    // Cria o objeto de dados a ser enviado
    const dados = {
        aluno_id: aluno_id,
        academia_id: academia_id
    };

    // Envia os dados para o PHP via fetch
    fetch('../php/funcionario/fluxo_ao_vivo.php', {
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
            // Manipula a resposta bem-sucedida, como atualizar o número de alunos treinando
            document.getElementById("contadorFluxo").textContent = data.alunos_treinando;
        }
    })
    .catch(error => console.error('Erro na requisição:', error));
}
