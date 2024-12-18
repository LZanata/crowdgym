function carregarDistribuicaoPlanos() {
    const academiaId = document.getElementById("academiaId").value; // Caso necessário
    const dias = document.getElementById("intervaloDistribuicaoPlanos").value;

    // URL com o parâmetro de dias
    fetch(`../php/graficos/obter_distribuicao_planos.php?intervalo=${dias}&academiaId=${academiaId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro do servidor: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Dados recebidos:', data);

            if (!Array.isArray(data)) {
                console.error('Resposta inesperada do servidor:', data);
                alert('Erro: resposta inesperada do servidor.');
                return;
            }

            const labels = data.map(item => item.plano_nome);
            const values = data.map(item => item.quantidade);

            console.log('Labels:', labels);
            console.log('Values:', values);

            // Verificar se o gráfico existe antes de destruí-lo
            if (window.graficoDistribuicaoPlanos instanceof Chart) {
                console.log('Destruindo gráfico existente.');
                window.graficoDistribuicaoPlanos.destroy();
            }

            // Criar novo gráfico
            const ctx = document.getElementById('graficoDistribuicaoPlanos').getContext('2d');
            window.graficoDistribuicaoPlanos = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Distribuição de Planos',
                        data: values,
                        backgroundColor: '#FFF9F3',
                        borderColor: '#f57419',
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
            alert('Erro ao carregar os dados. Consulte o console para mais detalhes.');
        });
}

// Chamar a função ao carregar a página com 30 dias como padrão
document.addEventListener("DOMContentLoaded", () => {
    carregarDistribuicaoPlanos();
});
