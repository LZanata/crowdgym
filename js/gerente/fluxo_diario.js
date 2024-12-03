let graficoFluxo;

function carregarGraficoFluxo() {
  const intervalo = document.getElementById("intervalo").value;
  const academiaId = document.getElementById("academiaId").value;

  fetch(`/Projeto_CrowdGym/php/gerente/obter_fluxo_diario.php?academia_id=${academiaId}&intervalo=${intervalo}`)
    .then(response => response.json())
    .then(data => {
      if (data.erro) {
        console.error("Erro ao carregar gráfico:", data.erro);
        return;
      }

      const labels = data.labels;
      const values = data.values;

      // Chama a função para atualizar o gráfico com os dados obtidos
      atualizarGrafico(labels, values);
    })
    .catch(error => {
      console.error("Erro ao carregar gráfico:", error);
    });
}

// Função para atualizar o gráfico
function atualizarGrafico(labels, values) {
  if (!graficoFluxo) {
    const ctx = document.getElementById("graficoFluxo").getContext("2d");
    graficoFluxo = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Fluxo de Alunos',
          data: values,
          borderColor: 'rgb(75, 192, 192)',
          fill: false
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });
  } else {
    graficoFluxo.data.labels = labels;
    graficoFluxo.data.datasets[0].data = values;
    graficoFluxo.update();
  }
}
