document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById("graficoRenovacao").getContext("2d");
  
    // Fetch data from the server
    fetch("../php/graficos/obter_renovacao_dados.php")
      .then((response) => response.json())
      .then((data) => {
        const renovados = data.renovados || 0;
        const expirados = data.expirados || 0;
  
        new Chart(ctx, {
          type: "doughnut", // Use 'pie' para pizza ou 'doughnut' para rosca
          data: {
            labels: ["Renovados", "Expirados"],
            datasets: [
              {
                data: [renovados, expirados],
                backgroundColor: ["#4caf50", "#f44336"],
              },
            ],
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: "top",
              },
            },
          },
        });
      })
      .catch((error) => console.error("Erro ao carregar dados:", error));
  });
  