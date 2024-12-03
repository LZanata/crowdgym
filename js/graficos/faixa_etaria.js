const ctx3 = document.getElementById('faixaEtaria').getContext('2d');
        const faixaEtaria = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: ['Crianças', 'Adolescentes', 'Adultos', 'Idosos'],
                datasets: [{
                    label: 'Quantidade de Alunos',
                    data: [30, 50, 20, 40],
                    backgroundColor: [
                        '#FFE7EA','#FEE1F7','#F3F0FF','#E5FFE8'
                    ],
                    borderColor: [
                        '#f57419'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });