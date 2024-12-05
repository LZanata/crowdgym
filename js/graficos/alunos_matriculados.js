function carregarGraficoAlunosMatriculados() {
    const academiaId = document.getElementById("academiaId").value;
    const intervalo = document.getElementById("intervaloMatriculados").value;

    // Verificar se o intervalo é um valor numérico válido
    if (isNaN(intervalo) || intervalo <= 0) {
        console.error("Intervalo inválido: ", intervalo);
        return;
    }

    // Fazer a requisição fetch
    fetch(`../php/graficos/obter_alunos_matriculados.php?academia_id=${academiaId}&dias=${intervalo}`)
        .then(response => response.json())  // Mudança para json() para analisar o JSON corretamente
        .then(data => {
            console.log("Dados em JSON:", data);  // Veja os dados convertidos para JSON
            if (data && data.alunos_matriculados !== undefined) {
                const ctx = document.getElementById("alunosMatriculados").getContext("2d");

                // Se um gráfico já existir, destruí-lo antes de criar um novo
                if (window.alunosMatriculadosChart) {
                    window.alunosMatriculadosChart.destroy();
                }

                // Criar um novo gráfico
                window.alunosMatriculadosChart = new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: ["Alunos Matriculados"],
                        datasets: [{
                            label: `Alunos com plano principal nos últimos ${intervalo} dias`,
                            data: [data.alunos_matriculados],  // Dados de alunos matriculados
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
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: "Quantidade de Alunos" }
                            },
                        },
                    },
                });
            } else {
                console.error("Erro ao carregar dados de alunos matriculados, dados não encontrados.");
            }
        })
        .catch(error => {
            console.error("Erro ao carregar gráfico de alunos matriculados: ", error);
        });
}

// Chama a função ao carregar a página
document.addEventListener("DOMContentLoaded", function() {
    carregarGraficoAlunosMatriculados();
});
