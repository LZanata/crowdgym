function carregarFluxoReceitaMensal() {
    // Defina o ID da academia de forma dinâmica ou estática
    const academiaId = document.getElementById("academiaId").value; 

    fetch(`../php/graficos/obter_fluxo_receita_mensal.php?academiaId=${academiaId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro do servidor: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Dados recebidos:', data);

            if (data.error) {
                console.error('Erro no servidor:', data.error);
                alert('Erro ao carregar os dados.');
                return;
            }

            // Preparar os dados para o gráfico
            const labels = data.map(item => item.mes);
            const values = data.map(item => item.receita_total);

            // Verificar se o gráfico já existe e destruí-lo antes de criar um novo
            if (window.graficoFluxoReceitaMensal && typeof window.graficoFluxoReceitaMensal.destroy === 'function') {
                console.log('Destruindo gráfico existente.');
                window.graficoFluxoReceitaMensal.destroy();
            }

            const ctx = document.getElementById('graficoFluxoReceitaMensal').getContext('2d');
            window.graficoFluxoReceitaMensal = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Receita Mensal (R$)',
                        data: values,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        tension: 0.3, // Deixa a linha suavizada
                        fill: true // Preenche a área abaixo da linha
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Mês'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Receita Total (R$)'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Erro ao carregar os dados do gráfico:', error);
            alert('Erro ao carregar os dados. Consulte o console para mais detalhes.');
        });
}

// Chamar a função ao carregar a página
document.addEventListener("DOMContentLoaded", () => {
    carregarFluxoReceitaMensal();
});
