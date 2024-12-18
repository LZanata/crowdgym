function carregarDistribuicaoPlanos(dias) {
    fetch(`distribuicao_plano.php?dias=${dias}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro do servidor: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Dados recebidos:', data);  // Verificar os dados recebidos

            // Verificar se os dados estão no formato esperado
            if (!data.labels || !data.values) {
                console.error('Dados ausentes ou inválidos para o gráfico');
                return;
            }

            // Verificar se o gráfico já existe e destruí-lo antes de criar um novo
            if (window.graficoDistribuicaoPlanos && typeof window.graficoDistribuicaoPlanos.destroy === 'function') {
                window.graficoDistribuicaoPlanos.destroy();
            }

            // Criar o gráfico com os dados recebidos
            const ctx = document.getElementById('graficoDistribuicaoPlanos').getContext('2d');
            window.graficoDistribuicaoPlanos = new Chart(ctx, {
                type: 'bar',  // Tipo de gráfico (barra)
                data: {
                    labels: data.labels,  // Labels dos planos
                    datasets: [{
                        label: 'Distribuição de Planos',  // Título do gráfico
                        data: data.values,  // Dados dos planos
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',  // Cor de fundo das barras
                        borderColor: 'rgba(75, 192, 192, 1)',  // Cor da borda das barras
                        borderWidth: 1  // Largura da borda
                    }]
                },
                options: {
                    responsive: true,  // Responsivo
                    plugins: {
                        legend: {
                            display: true  // Exibir legenda
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Erro ao carregar os dados do gráfico:', error);
        });
}
