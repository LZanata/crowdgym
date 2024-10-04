// Função para buscar os dados do PHP usando fetch()
async function fetchDadosTabela() {
    try {
        const response = await fetch('dados_tabela_alunos.php'); // Faz a requisição ao script PHP
        if (!response.ok) {
            throw new Error('Erro na solicitação dos dados'); // Se a resposta não for ok
        }
        const data = await response.json(); // Converte a resposta em JSON
        return data; // Retorna os dados processados
    } catch (error) {
        console.error('Erro ao buscar dados:', error);
        return { semanas: [], alunos: [] }; // Retorna arrays vazios em caso de erro
    }  
}

async function renderGrafico() {
    const dados = await fetchDadosGrafico(); // Espera os dados vindos do PHP

    const ctx = document.getElementById('meuGrafico').getContext('2d');
    
    const meuGrafico = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico: barras
            data: {
                labels: dados.semanas, // Etiquetas (semanas vindas do backend PHP)
                datasets: [{
                    label: 'Número de Pessoas',
                    data: dados.pessoas, // Quantidade de pessoas vindas do backend PHP
                    backgroundColor: 'skyblue',
                    borderColor: 'blue',
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
    }

// Chama a função que renderiza o gráfico ao carregar a página
renderGrafico();