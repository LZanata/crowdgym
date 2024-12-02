const ctx = document.getElementById('graficoFluxo').getContext('2d');
const graficoFluxo = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [], // Iniciado vazio
        datasets: [{
            label: 'Alunos por Dia',
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

function carregarGraficoFluxo() {
    const academiaId = document.getElementById('academiaId').value; // Certifique-se que este ID existe
    const intervalo = document.getElementById('intervalo').value;

    fetch(`../php/gerente/obter_fluxo_diario.php?academia_id=${academiaId}&intervalo=${intervalo}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro HTTP! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.erro) {
                console.error("Erro no servidor:", data.erro);
                return;
            }

            // Atualizar as labels e os dados no gráfico
            graficoFluxo.data.labels = data.labels;
            graficoFluxo.data.datasets[0].data = data.values;

            // Atualizar o gráfico
            graficoFluxo.update();
        })
        .catch(error => console.error('Erro ao carregar gráfico de fluxo:', error));
}

// Carregar o gráfico na inicialização
carregarGraficoFluxo();