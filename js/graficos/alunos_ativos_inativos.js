function carregarAlunosAtivosInativos() {
    const intervalo = document.getElementById("intervaloAlunosAtivos").value;

    fetch(`../php/graficos/obter_alunos_ativos_inativos.php?intervalo=${intervalo}`)
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

            // Verificar se os dados estão no formato esperado
            const labels = ['Ativos', 'Inativos'];
            const values = [data.ativos, data.inativos];

            // Verificar se o gráfico já existe e destruí-lo antes de criar um novo
            if (window.graficoAlunosAtivosInativos && typeof window.graficoAlunosAtivosInativos.destroy === 'function') {
                console.log('Destruindo gráfico existente.');
                window.graficoAlunosAtivosInativos.destroy();
            }

            const ctx = document.getElementById('graficoAlunosAtivosInativos').getContext('2d');
            window.graficoAlunosAtivosInativos = new Chart(ctx, {
                type: 'pie',  // Gráfico do tipo pizza
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(255, 99, 132, 0.6)'],
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
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
    carregarAlunosAtivosInativos();
});
