let graficoAtual = null; // Variável global para armazenar a instância do gráfico

function carregarTaxaRenovacao() {
  const intervalo = document.getElementById("intervaloTaxa").value;
  const academiaId = document.getElementById("academiaId").value;

  fetch(`../php/graficos/obter_renovacao_dados.php?intervalo=${intervalo}&academiaId=${academiaId}`)
    .then(response => response.json()) // Garante que os dados retornados sejam JSON
    .then(data => {
      console.log("Dados recebidos:", data); // Verifique se os dados estão corretos no console

      // Extração dos valores retornados pela API
      const renovados = parseInt(data.renovados) || 0;
      const expirados = parseInt(data.expirados) || 0;

      // Configuração do gráfico
      const chartData = {
        labels: ['Renovados', 'Expirados'],
        datasets: [{
          label: 'Taxa de Renovação',
          data: [renovados, expirados],
          backgroundColor: ['#E5FFE8', '#FFE7EA'],
        }]
      };

      // Referência ao canvas
      const ctx = document.getElementById('graficoTaxaRenovacao').getContext('2d');

      // Destruir o gráfico anterior, se existir
      if (graficoAtual) {
        graficoAtual.destroy();
      }

      // Criar um novo gráfico e salvar a instância
      graficoAtual = new Chart(ctx, {
        type: 'bar', // Tipo do gráfico
        data: chartData,
        options: {
          responsive: true,
          plugins: {
            legend: { display: true },
            title: {
              display: true,
              text: 'Taxa de Renovação de Planos'
            }
          }
        }
      });
    })
    .catch(error => {
      console.error('Erro ao carregar os dados do gráfico:', error);
    });
}

// Carregar o gráfico ao carregar a página
document.addEventListener("DOMContentLoaded", carregarTaxaRenovacao);
