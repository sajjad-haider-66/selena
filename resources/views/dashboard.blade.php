<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <style>
        .card {
            border-radius: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        canvas {
            max-width: 100%;
        }
        .circule-chart canvas{
            max-width: 80%;
            max-height: 70%;
        }
    </style>
    <div class="py-6">
        <div class="container mx-auto px-4">
            <div class="card shadow-lg mb-6 bg-white dark:bg-gray-800">
                                <div class="card-body"> <!-- Filters Section -->
                    <h5 class="card-title mb-3">Filters</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4"> <select class="form-select">
                                <option selected>Project</option> <!-- Dynamic options here -->
                            </select> </div>
                        <div class="col-md-4"> <select class="form-select">
                                <option selected>Site</option> <!-- Dynamic options here -->
                            </select> </div>
                        <div class="col-md-4"> <select class="form-select">
                                <option selected>Timeframe</option>
                                <option>Last 7 Days</option>
                                <option>Last 30 Days</option>
                                <option>Custom Range</option>
                            </select> </div>
                    </div> <!-- Dashboard Widgets -->
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="card text-white bg-primary h-100">
                                <div class="card-body">
                                    <h6 class="card-title">Pending Actions</h6>
                                    <h3>5</h3>
                                    <p class="card-text">Due this week</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-success h-100">
                                <div class="card-body">
                                    <h6 class="card-title">Daily Readiness</h6>
                                    <h3>92%</h3>
                                    <p class="card-text">Operational</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-warning h-100">
                                <div class="card-body">
                                    <h6 class="card-title">Open Events</h6>
                                    <h3>3</h3>
                                    <p class="card-text">Active</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-danger h-100">
                                <div class="card-body">
                                    <h6 class="card-title">Upcoming Audits/Talks</h6>
                                    <h3>2</h3>
                                    <p class="card-text">Next 7 days</p>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Export Buttons -->
                 
                </div>
                <div class="card-body p-6">
                    <!-- Charts Section -->
                    <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Metrics Overview (Last 7 Days)</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Pending Actions Chart -->
                        <div class="card bg-white dark:bg-gray-800 p-4">
                            <h6 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-3">Pending Actions</h6>
                            <canvas id="pendingActionsChart"></canvas>
                        </div>
                        <!-- Daily Readiness Chart -->
                        <div class="card bg-white dark:bg-gray-800 p-4">
                            <h6 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-3">Daily Readiness</h6>
                            <canvas id="dailyReadinessChart"></canvas>
                        </div>
                        <!-- Open Events Chart -->
                        <div class="card bg-white dark:bg-gray-800 p-4">
                            <h6 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-3">Open Events</h6>
                            <canvas id="openEventsChart"></canvas>
                        </div>
                        <!-- Upcoming Audits/Talks Chart -->
                        <div class="card bg-white dark:bg-gray-800 p-4">
                            <h6 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-3">Upcoming Audits/Talks</h6>
                            <canvas id="upcomingAuditsChart"></canvas>
                        </div>
                        <!-- Events Status Chart -->
                        <div class="mt-6 card bg-white dark:bg-gray-800 p-4 circule-chart">
                            <h6 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-3">Events Status Overview</h6>
                            <canvas id="eventsStatusChart"></canvas>
                        </div>
                    </div>
                    <!-- Events Status Chart -->

                    <!-- Export Buttons -->
                    <div class="mt-6 text-end">
                        <button class="btn btn-outline-primary me-2"
                        onclick="exportToPDF()">Export to PDF</button> <button class="btn btn-outline-success"
                        onclick="exportToExcel()">Export to Excel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        $(document).ready(function() {
    // Doughnut Chart for Events Status
    const $canvas = $('#eventsStatusChart');
    if ($canvas.length) {
        const ctx = $canvas[0].getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Completed', 'Processing'],
                datasets: [{
                    label: 'Events Status',
                    data: [5, 8, 3], // Sample data: replace with actual data
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.6)', // Blue for Pending
                        'rgba(34, 197, 94, 0.6)',  // Green for Completed
                        'rgba(234, 179, 8, 0.6)'   // Yellow for Processing
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(234, 179, 8, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: '#4B5563',
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        titleColor: '#FFFFFF',
                        bodyColor: '#FFFFFF',
                        cornerRadius: 8
                    }
                }
            }
        });
    }

    // Optional: Update chart based on filter change (e.g., Timeframe dropdown)
    $('.form-select').on('change', function() {
        // Example AJAX call to fetch new data
        $.ajax({
            url: '/api/events-data', // Replace with your API endpoint
            method: 'GET',
            data: { timeframe: $(this).val() },
            success: function(data) {
                const chart = Chart.getChart('eventsStatusChart');
                if (chart) {
                    chart.data.datasets[0].data = [data.pending, data.completed, data.processing];
                    chart.update();
                }
            },
            error: function() {
                console.error('Failed to fetch events data');
            }
        });
    });
});
        function exportToPDF() {
            alert('Exporting to PDF...');
        }

        function exportToExcel() {
            alert('Exporting to Excel...');
        }

        // Chart configuration function
        function createChart(canvasId, label, data, color) {
            const ctx = document.getElementById(canvasId).getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'],
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: color + '0.6)',
                        borderColor: color + '1)',
                        borderWidth: 1,
                        borderRadius: 8,
                        barThickness: 20
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Value',
                                color: '#4B5563'
                            },
                            grid: {
                                color: '#E5E7EB'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Days',
                                color: '#4B5563'
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1F2937',
                            titleColor: '#FFFFFF',
                            bodyColor: '#FFFFFF',
                            cornerRadius: 8
                        }
                    }
                }
            });
        }

        // Initialize charts
        createChart('pendingActionsChart', 'Pending Actions', [5, 4, 6, 3, 5, 4, 5], 'rgba(59, 130, 246,');
        createChart('dailyReadinessChart', 'Daily Readiness (%)', [90, 92, 88, 95, 91, 93, 92], 'rgba(34, 197, 94,');
        createChart('openEventsChart', 'Open Events', [2, 3, 1, 4, 3, 2, 3], 'rgba(234, 179, 8,');
        createChart('upcomingAuditsChart', 'Upcoming Audits/Talks', [1, 2, 0, 1, 2, 3, 2], 'rgba(239, 68, 68,');
    </script>
    
</x-app-layout>