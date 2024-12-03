let graficoFluxo;

function carregarGraficoFluxo() {
    const intervalo = document.getElementById("intervalo").value;
    const academiaId = document.getElementById("academiaId").value;

    fetch(`../php/graficos/obter_fluxo_diario.php?academia_id=${academiaId}&intervalo=${intervalo}`)
        .then(response => response.json())
        .then(data => {
            if (data.erro) {
                console.error("Erro ao carregar gráfico:", data.erro);
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

// Carrega o gráfico na inicialização
document.addEventListener('DOMContentLoaded', carregarGraficoFluxo);
