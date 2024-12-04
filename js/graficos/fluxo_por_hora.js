document.addEventListener('DOMContentLoaded', () => {
    const academiaId = document.getElementById('academiaId').value;
    const ctx = document.getElementById('graficoFluxoHora').getContext('2d');
  
    fetch(`../php/graficos/obter_fluxo_por_hora.php?academia_id=${academiaId}`)
    .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        if (data.error) {
          throw new Error(data.error);
        }
        atualizarGrafico(data); // Assumindo que esta função desenha o gráfico
      })
      .catch(error => {
        console.error('Erro ao carregar gráfico de fluxo por hora:', error.message);
      });
  
        new Chart(ctx, {
          type: 'line', // Alterne para 'bar' se preferir barras
          data: {
            datasets: datasets,
          },
          options: {
            scales: {
              x: {
                type: 'linear',
                position: 'bottom',
                title: {
                  display: true,
                  text: 'Hora do Dia',
                },
                ticks: {
                  stepSize: 1,
                  max: 23,
                },
              },
              y: {
                title: {
                  display: true,
                  text: 'Média de Alunos',
                },
                beginAtZero: true,
              },
            },
            plugins: {
              title: {
                display: true,
                text: 'Fluxo Médio por Hora',
              },
            },
          },
        });
      })
      .catch(error => {
        console.error('Erro ao carregar gráfico de fluxo por hora:', error);
      });
  