const ctx = document.getElementById('meuGrafico').getContext('2d');
    
        const meuGrafico = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico: barras
            data: {
                labels: ['Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado', 'Domingo'], // Etiquetas (semanas)
                datasets: [{
                    label: 'Horas Treinadas',
                    data: [1.5,,2,1.7,2.1,,2], // Quantidade de pessoas por semana
                    backgroundColor: '#FFF9F3', // Cor das barras
                    borderColor: '#f57419', // Cor das bordas das barras
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Começar o eixo Y do zero
                    }
                },
                plugins: {
                    legend: {
                        display: true, // Exibir a legenda
                        position: 'top'
                    }
                },
                responsive: true, // Responsividade para dispositivos móveis
                maintainAspectRatio: false
            }
        });