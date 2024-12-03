const ctx = document.getElementById('graficoFluxo').getContext('2d');
const graficoFluxo = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: Array.from({ length: 24 }, (_, i) => `${String(i).padStart(2, '0')}:00`), // Horários de 00:00 a 23:00
        datasets: [{
            label: 'Alunos por Hora',
            data: Array(24).fill(0), // Inicializa com 0
            backgroundColor: '#FFF9F3',
            borderColor: '#f57419',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        },
        responsive: true,
        maintainAspectRatio: false
    }
});

// Função para carregar o gráfico
function carregarGraficoFluxo() {
    const academiaId = document.getElementById('academiaId').value;

    fetch(`../php/graficos/obter_historico_fluxo.php?academia_id=${academiaId}`)
        .then(response => response.json())
        .then(data => {
            if (data.erro) {
                console.error(data.erro);
                return;
            }

            // Atualizar os dados no gráfico
            graficoFluxo.data.datasets[0].data = data.values;

            // Atualizar o gráfico
            graficoFluxo.update();
        })
        .catch(error => console.error('Erro ao carregar gráfico de fluxo:', error));
}

// Atualizar o gráfico a cada 5 segundos
setInterval(carregarGraficoFluxo, 5000);

// Carregar os dados do gráfico ao carregar a página
carregarGraficoFluxo();
