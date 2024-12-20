let graficoFluxo;

function carregarGraficoFluxo() {
    const intervalo = document.getElementById("intervalo").value;

    // Verificar se o elemento academiaId existe
    const academiaIdElement = document.getElementById("academiaId");
    if (!academiaIdElement) {
        console.error("Elemento 'academiaId' não encontrado!");
        return;
    }
    
    const academiaId = academiaIdElement.value;

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
document.addEventListener('DOMContentLoaded', function() {
    // Adiciona o ouvinte de evento para a alteração do intervalo
    document.getElementById("intervalo").addEventListener('change', function() {
        carregarGraficoFluxo();
    });

    // Atualizar o gráfico a cada 5 segundos
    setInterval(carregarGraficoFluxo, 5000);

    // Inicializa o gráfico com os valores padrão ao carregar a página
    carregarGraficoFluxo();
});
