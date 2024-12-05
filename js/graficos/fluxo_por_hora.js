document.addEventListener("DOMContentLoaded", function () {
  const academiaId = document.getElementById("academiaId").value;

  fetch(`../php/graficos/obter_fluxo_por_hora.php?academia_id=${academiaId}`)
      .then((response) => response.json())
      .then((data) => {
          if (data.status !== "error") {
              // Preenchendo os rótulos (horas) e os valores de média de alunos
              const labels = Array.from({ length: 24 }, (_, i) => `${i}:00`); // Rótulos de 00:00 a 23:00
              const valores = data.map(item => item.media_alunos); // Média de alunos

              // Definição do gráfico
              const ctx = document.getElementById("graficoFluxoPorHora").getContext("2d");
              new Chart(ctx, {
                  type: "bar", // Pode ser 'line' ou 'bar'
                  data: {
                      labels: labels,
                      datasets: [
                          {
                              label: "Média de alunos por hora",
                              data: valores,
                              backgroundColor: "#FFF9F3",
                              borderColor: "#f57419",
                              borderWidth: 1,
                          },
                      ],
                  },
                  options: {
                      responsive: true,
                      plugins: {
                          legend: {
                              display: true,
                              position: "top",
                          },
                      },
                      scales: {
                          x: {
                              title: {
                                  display: true,
                                  text: "Horas do dia",
                              },
                          },
                          y: {
                              title: {
                                  display: true,
                                  text: "Quantidade de alunos",
                              },
                              beginAtZero: true,
                          },
                      },
                  },
              });
          } else {
              console.error("Erro na resposta do servidor: ", data.message);
          }
      })
      .catch((error) => {
          console.error("Erro ao carregar gráfico de fluxo por hora: ", error);
      });
});
