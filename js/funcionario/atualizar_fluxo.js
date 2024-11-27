function atualizarFluxo() {
    fetch('../php/funcionario/fluxo_ao_vivo.php')
        .then(response => response.json())
        .then(data => {
            if (data.alunos_treinando !== undefined) {
                document.getElementById('contadorFluxo').innerText = data.alunos_treinando;
            } else {
                console.error("Erro ao buscar dados:", data.error);
            }
        })
        .catch(error => console.error("Erro ao atualizar fluxo:", error));
}

// Atualiza o contador a cada 5 segundos
setInterval(atualizarFluxo, 5000);