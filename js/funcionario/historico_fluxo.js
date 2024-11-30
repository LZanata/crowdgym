const ctx = document.getElementById('graficoFluxo').getContext('2d');
const graficoFluxo = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [{
            label: 'Alunos por Hora',
            data: [],
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

    fetch(`../php/funcionario/obter_historico_fluxo.php?academia_id=${academiaId}`)
        .then(response => response.json())
        .then(data => {
            if (data.erro) {
                console.error(data.erro);
                return;
            }

            // Atualizar as labels e os dados no gráfico
            graficoFluxo.data.labels = data.labels.map(label => {
                // Extrai apenas a hora (hora:minuto)
                const date = new Date(label);
                return `${date.getHours()}:${String(date.getMinutes()).padStart(2, '0')}`;
            });

            graficoFluxo.data.datasets[0].data = data.values;

            // Atualizar o gráfico
            graficoFluxo.update();
        })
        .catch(error => console.error('Erro ao carregar gráfico de fluxo:', error));
}

// Função para reiniciar o gráfico à meia-noite
function reiniciarGraficoAmeiaNoite() {
    const agora = new Date();
    const meiaNoite = new Date();
    meiaNoite.setHours(24, 0, 0, 0); // Define a próxima meia-noite

    // Se já for meia-noite, reinicie o gráfico
    if (agora.getTime() >= meiaNoite.getTime()) {
        carregarGraficoFluxo();
    }

    // Atualiza o gráfico às 00:00:00
    setTimeout(reiniciarGraficoAmeiaNoite, meiaNoite.getTime() - agora.getTime());
}

// Chame a função ao carregar a página
carregarGraficoFluxo();

// Atualizar o gráfico a cada 5 segundos
setInterval(carregarGraficoFluxo, 5000);

// Chama a função para reiniciar o gráfico à meia-noite
reiniciarGraficoAmeiaNoite();
