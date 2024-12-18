function carregarAlunosAtivosVsInativos() {
    const academiaId = document.getElementById("academiaId").value;

    fetch(`../php/graficos/obter_alunos_ativos_inativos.php?academiaId=${academiaId}`)
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
                alert('Erro ao carregar os dados. Consulte o console para mais detalhes.');
                return;
            }

            // Preparando os dados para o gráfico
            const labels = ['Ativos', 'Inativos'];
            const valores = [data.ativos, data.inativos];

            if (window.graficoAlunosAtivosVsInativos && typeof window.graficoAlunosAtivosVsInativos.destroy === 'function') {
                window.graficoAlunosAtivosVsInativos.destroy();
            }

            const ctx = document.getElementById('graficoAlunosAtivosVsInativos').getContext('2d');
            window.graficoAlunosAtivosVsInativos = new Chart(ctx, {
                type: 'pie',  // Tipo de gráfico pizza
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Alunos Ativos vs Inativos',
                        data: valores,
                        backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(255, 99, 132, 0.6)'],  // Cores para os setores
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],  // Cores das bordas
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `${tooltipItem.label}: ${tooltipItem.raw} alunos`;
                                }
                            }
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
    carregarAlunosAtivosVsInativos();
});
