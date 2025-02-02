function carregarFluxoPorDiaSemana() {
    const academiaId = document.getElementById("academiaId").value;

    fetch(`../php/graficos/obter_fluxo_por_dia_semana.php?academiaId=${academiaId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro do servidor: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.erro) {
                console.error('Erro:', data.erro);
                exibirMensagemErro(data.erro);
                return;
            }

            console.log('Dados recebidos:', data);

            // Mapeando os dias da semana (1=Domingo, 7=Sábado)
            const diasSemana = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];

            // Mapeando os dados recebidos para os rótulos e valores
            const labels = data.map(item => diasSemana[item.dia_semana - 1]);
            const values = data.map(item => parseFloat(item.media_alunos));  // Convertendo o valor para float

            // Verificar se os dados estão corretos
            console.log('Labels (dias da semana):', labels);
            console.log('Values (média de alunos):', values);

            // Atualizar o gráfico se ele já existir
            if (window.graficoFluxoPorDiaSemana && typeof window.graficoFluxoPorDiaSemana.destroy === 'function') {
                window.graficoFluxoPorDiaSemana.destroy();
            }

            const ctx = document.getElementById('graficoFluxoPorDiaSemana').getContext('2d');
            window.graficoFluxoPorDiaSemana = new Chart(ctx, {
                type: 'bar',  // Tipo de gráfico de barras
                data: {
                    labels: labels,  // Labels dos dias da semana
                    datasets: [{
                        label: 'Média de Alunos por Dia da Semana',
                        data: values,  // Dados com a média de alunos
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',  // Cor de fundo das barras
                        borderColor: 'rgba(54, 162, 235, 1)',  // Cor da borda das barras
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

function exibirMensagemErro(mensagem) {
    const ctx = document.getElementById('graficoFluxoPorDiaSemana').getContext('2d');
    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);  // Limpa o gráfico anterior

    // Exibe a mensagem de erro
    ctx.fillStyle = "red";
    ctx.font = "16px Arial";
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";
    ctx.fillText(mensagem, ctx.canvas.width / 2, ctx.canvas.height / 2);
}

// Atualizar o gráfico a cada 5 segundos
setInterval(carregarFluxoPorDiaSemana, 5000);

// Carregar o gráfico ao carregar a página
document.addEventListener("DOMContentLoaded", carregarFluxoPorDiaSemana);
