// Função para carregar os dados do gráfico
function carregarDadosGrafico() {
    fetch('../php/funcionario/dados_grafico.php')
        .then(response => response.json())
        .then(data => {
            if (data.labels && data.data) {
                quantiaAluno.data.labels = data.labels;  // Atualiza as etiquetas (horas)
                quantiaAluno.data.datasets[0].data = data.data;  // Atualiza a quantidade de alunos
                quantiaAluno.update();  // Atualiza o gráfico com os novos dados
            } else {
                console.error("Erro ao carregar dados do gráfico:", data.error);
            }
        })        
        .catch(error => console.error("Erro na requisição do gráfico:", error));
}

// Função para atualizar o contador de fluxo
function atualizarFluxo() {
    fetch('../php/funcionario/fluxo_ao_vivo.php')
        .then(response => response.json())
        .then(data => {
            if (data.alunos_treinando !== undefined) {
                document.getElementById('contadorFluxo').innerText = data.alunos_treinando;
            } else {
                console.error("Erro ao buscar dados:", data.error);
            }
        })
        .catch(error => console.error("Erro ao atualizar fluxo:", error));
}

// Inicializa o gráfico de fluxo
const ctx = document.getElementById('graficoFluxo').getContext('2d');
const quantiaAluno = new Chart(ctx, {
    type: 'bar', // Tipo de gráfico: barras
    data: {
        labels: [], // Etiquetas (horas)
        datasets: [{
            label: 'Alunos',
            data: [], // Quantidade de pessoas
            backgroundColor: '#FFF9F3', // Cor das barras
            borderColor: '#f57419', // Cor das bordas das barras
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true // Começar o eixo Y do zero
            }
        },
        plugins: {
            legend: {
                display: true, // Exibir a legenda
                position: 'top'
            }
        },
        responsive: true, // Responsividade para dispositivos móveis
        maintainAspectRatio: false
    }
});

// Carrega os dados ao inicializar a página
carregarDadosGrafico();

// Atualiza o contador de fluxo a cada 5 segundos
setInterval(atualizarFluxo, 5000);

// Atualiza o gráfico a cada 1 minuto
setInterval(carregarDadosGrafico, 60000); // Atualiza a cada 1 minuto
