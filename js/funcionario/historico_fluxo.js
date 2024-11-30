// Defina o contexto do canvas
const ctx = document.getElementById('graficoFluxo').getContext('2d');

// Agora, você pode inicializar o gráfico
const graficoFluxo = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [], // Horas
        datasets: [{
            label: 'Alunos por Hora',
            data: [], // Quantidade
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

function carregarGraficoFluxo() {
    fetch('../php/funcionario/obter_historico_fluxo.php')
        .then(response => response.json())
        .then(data => {
            // Preencher as labels (horas) e os dados (quantidade de alunos)
            graficoFluxo.data.labels = data.labels;
            graficoFluxo.data.datasets[0].data = data.values;

            // Atualizar o gráfico com os novos dados
            graficoFluxo.update();
        })
        .catch(error => console.error('Erro ao carregar gráfico de fluxo:', error));
}

// Carregar o gráfico assim que a página for carregada
carregarGraficoFluxo();
