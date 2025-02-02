function carregarAlunosAtivosInativos() {
    const intervalo = document.getElementById("intervaloAlunosAtivos").value;
    const academiaId = document.getElementById("academiaId").value;  // Alterado para pegar o valor do input escondido

    fetch(`../php/graficos/obter_alunos_ativos_inativos.php?intervalo=${intervalo}&academia_id=${academiaId}`)
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

        const labels = ['Ativos', 'Inativos'];
        const values = [data.ativos || 0, data.inativos || 0];  // Garantir que valores nulos sejam convertidos para 0

        if (window.graficoAlunosAtivosInativos && typeof window.graficoAlunosAtivosInativos.destroy === 'function') {
            console.log('Destruindo gráfico existente.');
            window.graficoAlunosAtivosInativos.destroy();
        }

        const ctx = document.getElementById('graficoAlunosAtivosInativos').getContext('2d');
        window.graficoAlunosAtivosInativos = new Chart(ctx, {
            type: 'pie',
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

document.addEventListener("DOMContentLoaded", () => {
    carregarAlunosAtivosInativos();
});
