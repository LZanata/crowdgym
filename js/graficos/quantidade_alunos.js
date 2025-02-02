let graficoFluxo;

function carregarGraficoFluxo() {
    const intervalo = document.getElementById("intervaloFluxo").value;
    const academiaId = document.getElementById("academiaId").value;

    fetch(`../php/graficos/obter_quantidade_alunos.php?academia_id=${academiaId}&intervalo=${intervalo}`)
        .then(response => response.json())
        .then(data => {
            if (data.erro) {
                console.error("Erro ao carregar gráfico:", data.erro);
                exibirMensagemErro(data.erro);
                return;
            }
            atualizarGrafico(data.labels, data.values);
        })
        .catch(error => console.error("Erro ao carregar gráfico:", error));
}

function atualizarGrafico(labels, values) {
    if (graficoFluxo) {
        graficoFluxo.data.labels = labels;
        graficoFluxo.data.datasets[0].data = values;
        graficoFluxo.update();
    } else {
        const ctx = document.getElementById("graficoFluxo").getContext("2d");
        graficoFluxo = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Fluxo de Alunos',
                    data: values,
                    borderColor: '#f57419',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
}

function exibirMensagemErro(mensagem) {
    const ctx = document.getElementById("graficoFluxo").getContext("2d");
    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height); // Limpa o gráfico anterior

    // Exibe a mensagem de erro
    ctx.fillStyle = "red";
    ctx.font = "16px Arial";
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";
    ctx.fillText(mensagem, ctx.canvas.width / 2, ctx.canvas.height / 2);
}

// Carrega o gráfico na inicialização
document.addEventListener('DOMContentLoaded', carregarGraficoFluxo);
