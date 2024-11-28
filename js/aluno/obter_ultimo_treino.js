document.addEventListener('DOMContentLoaded', () => {
    const atualizarDados = async () => {
        try {
            const resposta = await fetch('../php/aluno/obter_ultimo_treino.php');
            const dados = await resposta.json();

            document.querySelector('.last-train p').textContent = dados.ultimo_treino || "Nenhum treino registrado";
            document.querySelector('.time-arrive p').textContent = dados.horario_entrada || "--:--";
            document.querySelector('.time-left p').textContent = dados.horario_saida || "--:--";
        } catch (error) {
            console.error("Erro ao atualizar os dados:", error);
        }
    };

    atualizarDados();
    setInterval(atualizarDados, 60000); // Atualiza os dados a cada 60 segundos
});
