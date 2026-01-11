<x-app-layout>
    <div class="p-6">
        <h2 class="text-2xl text-white  font-semibold mb-6">Sales Report</h2>

        <!-- GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- SALES BAR CHART -->
            <div class="bg-white p-4 rounded-lg shadow h-[400px]">
                <h3 class="text-lg font-medium mb-3 text-gray-700">
                    Month Based Sales
                </h3>

                <div
                    x-data="chartComponent(@js($labels), @js($values))"
                    x-init="init()"
                    class="relative h-[320px]"
                >
                    <canvas id="salesChart1"></canvas>
                </div>
            </div>

            <!-- SERVICE PIE CHART -->
            <div class="bg-white p-4 rounded-lg shadow h-[400px]">
                <h3 class="text-lg font-medium mb-3 text-gray-700">
                    Service Based Sales
                </h3>

                <div
                    x-data="serviceChart(@js($serviceLabels), @js($serviceValues))"
                    x-init="init()"
                    class="relative h-[320px]"
                >
                    <canvas id="serviceChart2"></canvas>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Alpine Components -->
    <script>
        function chartComponent(labels, values) {
            return {
                init() {
                    new Chart(document.getElementById('salesChart1'), {
                        type: 'bar',
                        data: {
                            labels,
                            datasets: [{
                                label: 'Total Sales',
                                data: values,
                                backgroundColor: '#2563eb'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: { beginAtZero: true }
                            }
                        }
                    })
                }
            }
        }

        function serviceChart(labels, values) {
            return {
                init() {
                    new Chart(document.getElementById('serviceChart2'), {
                        type: 'pie',
                        data: {
                            labels,
                            datasets: [{
                                data: values,
                                backgroundColor: [
                                    '#2563eb',
                                    '#16a34a',
                                    '#f59e0b',
                                    '#dc2626',
                                    '#7c3aed'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'bottom' },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.label || '';
                                            let value = context.raw || 0;
                                            return label + ': ₹' + value.toLocaleString();
                                        }
                                    }
                                }
                            }
                        }
                    })
                }
            }
        }
    </script>
</x-app-layout>
