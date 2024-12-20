function carregarFaixaEtaria() {
    const academiaId = document.getElementById("academiaId").value;

    fetch(`../php/graficos/obter_faixa_etaria.php?academiaId=${academiaId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro do servidor: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (!Array.isArray(data)) {
                console.error('Resposta inesperada do servidor:', data);
                alert('Erro: resposta inesperada do servidor.');
                return;
            }

            const labels = data.map(item => item.faixa_etaria);
            const values = data.map(item => parseInt(item.quantidade));

            if (window.graficoFaixaEtaria && typeof window.graficoFaixaEtaria.destroy === 'function') {
                window.graficoFaixaEtaria.destroy();
            }

            const ctx = document.getElementById('graficoFaixaEtaria').getContext('2d');
            window.graficoFaixaEtaria = new Chart(ctx, {
                type: 'pie', // Gráfico de pizza
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Distribuição de Faixa Etária',
                        data: values,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
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

// Carregar o gráfico ao carregar a página
document.addEventListener("DOMContentLoaded", carregarFaixaEtaria);
