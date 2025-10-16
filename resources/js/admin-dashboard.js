import Chart from 'chart.js/auto';

window.Chart = Chart;

window.initializeCharts = function(data) {
    const typesCtx = document.getElementById('objectsByTypeChart');
    if (typesCtx) {
        new Chart(typesCtx, {
            type: 'pie',
            data: {
                labels: Object.keys(data.byType),
                datasets: [{
                    label: 'Objects by Type',
                    data: Object.values(data.byType),
                    backgroundColor: [
                        '#06b6d4',
                        '#84cc16',
                        '#fbbf24',
                        '#f43f5e',
                        '#6366f1',
                    ],
                }]
            },
        });
    }

    const statusCtx = document.getElementById('objectsByStatusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(data.byStatus),
                datasets: [{
                    label: 'Objects by Status',
                    data: Object.values(data.byStatus),
                    backgroundColor: [
                        '#f59e0b',
                        '#535353',
                        '#84cc16',
                        '#ef4444',
                    ],
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
}