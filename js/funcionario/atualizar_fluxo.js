// arquivo: atualizar_fluxo.js
async function atualizarFluxoAoVivo() {
    try {
        // Certifique-se de que as variáveis estão corretas, e definidas
        const alunoId = 1; // Substitua pelo ID do aluno correto
        const academiaId = 1; // Substitua pelo ID da academia correto

        // Verificação para garantir que os dados não são nulos ou indefinidos
        if (!alunoId || !academiaId) {
            console.error("Erro: aluno_id ou academia_id estão ausentes.");
            return;
        }

        const response = await fetch('../php/funcionario/fluxo_ao_vivo.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                aluno_id: alunoId,
                academia_id: academiaId,
            }),
        });

        const data = await response.json();

        if (data.alunos_treinando !== undefined) {
            document.getElementById('contadorFluxo').textContent = data.alunos_treinando;
        } else {
            console.error("Erro no servidor:", data.erro);
        }
    } catch (error) {
        console.error('Erro ao atualizar o fluxo:', error);
    }
}

// Chama a função periodicamente
setInterval(atualizarFluxoAoVivo, 5000); // Atualiza a cada 5 segundos
