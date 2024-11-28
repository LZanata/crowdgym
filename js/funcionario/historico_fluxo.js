document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('graficoFluxo').getContext('2d');
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

    // Função para buscar dados e atualizar o gráfico
    function atualizarGrafico() {
        fetch('../php/funcionario/get_historico_fluxo.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    return;
                }
                const horas = data.map(item => item.hora);
                const totais = data.map(item => item.total);

                // Atualiza os dados do gráfico
                graficoFluxo.data.labels = horas;
                graficoFluxo.data.datasets[0].data = totais;
                graficoFluxo.update();
            })
            .catch(error => console.error('Erro ao buscar dados do gráfico:', error));
    }

    // Atualiza o gráfico ao carregar a página
    atualizarGrafico();
});
