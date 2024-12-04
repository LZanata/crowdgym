document.addEventListener("DOMContentLoaded", function () {
  const academiaId = document.getElementById("academiaId").value;

  fetch(`../php/graficos/obter_fluxo_por_hora.php?academia_id=${academiaId}`)
      .then((response) => response.json())
      .then((data) => {
          if (data.status === "success") {
              const labels = data.labels; // Horas formatadas
              const valores = data.data;  // Média de alunos

              // Renderiza o gráfico
              const ctx = document.getElementById("graficoFluxoPorHora").getContext("2d");
              new Chart(ctx, {
                  type: "bar",
                  data: {
                      labels: labels,
                      datasets: [
                          {
                              label: "Média de alunos por hora",
                              data: valores,
                              backgroundColor: "rgba(75, 192, 192, 0.2)",
                              borderColor: "rgba(75, 192, 192, 1)",
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
