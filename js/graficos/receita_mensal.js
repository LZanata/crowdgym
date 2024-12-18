function carregarReceitaMensalPorPlanos() {
    const academiaId = document.getElementById("academiaId").value;

    fetch(`../php/graficos/obter_receita_mensal.php?academiaId=${academiaId}`)
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

            // Organizar os dados para o gráfico
            const meses = [];
            const planos = {};
            data.forEach(item => {
                const mesAno = `${item.mes}-${item.ano}`;
                if (!meses.includes(mesAno)) {
                    meses.push(mesAno);
                }
                if (!planos[item.plano_nome]) {
                    planos[item.plano_nome] = {};
                }
                planos[item.plano_nome][mesAno] = item.receita;
            });

            // Preparar os labels e os datasets
            const labels = meses;
            const datasets = Object.keys(planos).map(plano_nome => {
                return {
                    label: plano_nome,
                    data: meses.map(mesAno => planos[plano_nome][mesAno] || 0),
                    backgroundColor: "#FFF9F3",
                    borderColor: "#f57419",
                    borderWidth: 1
                };
            });

            if (window.graficoReceitaMensal && typeof window.graficoReceitaMensal.destroy === 'function') {
                window.graficoReceitaMensal.destroy();
            }

            const ctx = document.getElementById('graficoReceitaMensal').getContext('2d');
            window.graficoReceitaMensal = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets
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

// Chamar a função ao carregar a página
document.addEventListener("DOMContentLoaded", () => {
    carregarReceitaMensalPorPlanos();
});
