function carregarTaxaRenovacao() {
    const intervalo = document.getElementById("intervaloTaxa").value;
    const academiaId = document.getElementById("academiaId").value;
  
    fetch(`../php/graficos/obter_renovacao_dados.php?intervalo=${intervalo}&academiaId=${academiaId}`)
      .then(response => response.json())
      .then(data => {
        const ctx = document.getElementById("taxaRenovacao").getContext("2d");
        
        if (window.taxaRenovacaoChart) {
          window.taxaRenovacaoChart.destroy();
        }
  
        window.taxaRenovacaoChart = new Chart(ctx, {
          type: "doughnut",
          data: {
            labels: ["Renovados", "Expirados"],
            datasets: [{
              label: "Taxa de Renovação",
              data: data,
              backgroundColor: ["#4CAF50", "#F44336"]
            }]
          }
        });
      })
      .catch(error => console.error("Erro ao carregar os dados do gráfico:", error));
  }
  
  // Carregar o gráfico ao carregar a página
  document.addEventListener("DOMContentLoaded", carregarTaxaRenovacao);
  