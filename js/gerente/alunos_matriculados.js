const ctx2 = document.getElementById('alunosMatriculados').getContext('2d');
        const grafico2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun','Jul','Ago','Set','Out','Nov','Dez'],
                datasets: [{
                    label: 'Alunos Matriculados',
                    data: [800, 1700, 2500, 400, 1800, 2900],
                    backgroundColor: '#FFF9F3',
                    borderColor: '#f57419',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });