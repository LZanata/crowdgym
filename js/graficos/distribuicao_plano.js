function carregarDistribuicaoPlanos(dias) {
    fetch(`distribuicao_plano.php?dias=${dias}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro do servidor: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            // Verificar se o gráfico existe e destruí-lo antes de criar um novo
            if (window.graficoDistribuicaoPlanos && typeof window.graficoDistribuicaoPlanos.destroy === 'function') {
                window.graficoDistribuicaoPlanos.destroy();
            }

            // Criar o gráfico com os dados recebidos
            const ctx = document.getElementById('graficoDistribuicaoPlanos').getContext('2d');
            window.graficoDistribuicaoPlanos = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Distribuição de Planos',
                        data: data.values,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Erro ao carregar os dados do gráfico:', error);
        });
}
