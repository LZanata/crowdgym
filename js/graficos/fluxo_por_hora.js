function carregarGraficoFluxoPorHora() {
    const academiaIdElement = document.getElementById("academiaId");

    // Verifique se o elemento existe
    if (!academiaIdElement) {
        console.error("Elemento com ID 'academiaId' não encontrado.");
        return;
    }

    const academiaId = academiaIdElement.value;
    const intervalo = document.getElementById("intervaloFluxoPorHora").value; // Selecionador de intervalo

    fetch(`../php/graficos/obter_fluxo_por_hora.php?academia_id=${academiaId}&dias=${intervalo}`)
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                const labels = Array.from({ length: 24 }, (_, i) => `${i}:00`);
                const valores = data.map(item => item.media_alunos);

                const ctx = document.getElementById("graficoFluxoPorHora").getContext("2d");
                if (window.fluxoPorHoraChart) {
                    window.fluxoPorHoraChart.destroy();
                }
                window.fluxoPorHoraChart = new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: labels,
                        datasets: [{
                            label: "Média de alunos por hora",
                            data: valores,
                            backgroundColor: "#FFF9F3",
                            borderColor: "#f57419",
                            borderWidth: 1,
                        }],
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: true, position: "top" },
                        },
                        scales: {
                            x: { title: { display: true, text: "Horas do dia" } },
                            y: { title: { display: true, text: "Quantidade de alunos" }, beginAtZero: true },
                        },
                    },
                });
            } else {
                console.error("Erro na resposta do servidor: ", data.message);
            }
        })
        .catch(error => console.error("Erro ao carregar gráfico de fluxo por hora: ", error));
}

// Chama a função ao carregar a página
document.addEventListener("DOMContentLoaded", function() {
    carregarGraficoFluxoPorHora();
});
