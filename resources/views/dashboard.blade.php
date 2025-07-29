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
                        {{-- <div class="col-md-4"> <select class="form-select">
                                <option selected>Project</option> <!-- Dynamic options here -->
                            </select> </div>
                        <div class="col-md-4"> <select class="form-select">
                                <option selected>Site</option> <!-- Dynamic options here -->
                            </select> </div> --}}
                        <div class="col-md-4">   
                            <select class="form-select" id="timeframeFilter">
                                <option value="7" selected>Last 7 Days</option>
                                <option value="30">Last 30 Days</option>
                            </select>
                        </div>
                    </div> <!-- Dashboard Widgets -->
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="card text-white bg-primary h-100">
                                <div class="card-body">
                                    <h6 class="card-title">Pending Actions</h6>
                                    <h3>{{ $pendingActionsCount }}</h3>
                                    <p class="card-text">Due this week</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-success h-100">
                                <div class="card-body">
                                    <h6 class="card-title">Daily Readiness</h6>
                                    <h3>{{ $dailyReadinessCount }}</h3>
                                    <p class="card-text">Operational</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-warning h-100">
                                <div class="card-body">
                                    <h6 class="card-title">Open Events</h6>
                                    <h3>{{ $pendingEvents }}</h3>
                                    <p class="card-text">Active</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-danger h-100">
                                <div class="card-body">
                                    <h6 class="card-title">Audits Completed</h6>
                                    <h3>{{ $upcomingAuditsCount }}</h3>
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
                            <h6 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-3">Talks Animation</h6>
                            <canvas id="upcomingTalksChart"></canvas>
                        </div>
                        <!-- Events Status Chart -->
                        <div class="mt-6 card bg-white dark:bg-gray-800 p-4 circule-chart">
                            <h6 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-3">Events Status Overview</h6>
                            <canvas id="eventsStatusChart"></canvas>
                        </div>
                        <!-- audits Chart -->
                        <div class="mt-6 card bg-white dark:bg-gray-800 p-4">
                            <h6 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-3">Audits</h6>
                            <canvas id="openAuditsChart"></canvas>
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
     
        function exportToPDF() {
            alert('Exporting to PDF...');
        }

        function exportToExcel() {
            alert('Exporting to Excel...');
        }

        // Chart configuration function
        function createChart(canvasId, label, data, color, timeframe) {
            const ctx = document.getElementById(canvasId).getContext('2d');
            const labels = timeframe === '7' 
                ? Array.from({length: 7}, (_, i) => `Day ${i + 1}`)
                : Array.from({length: 30}, (_, i) => `Day ${i + 1}`);
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
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
        // Doughnut Chart for Events Status
        function createEventsStatusChart(){
            const $canvas = $('#eventsStatusChart');
            if ($canvas.length) {
                const ctx = $canvas[0].getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pending', 'Completed', 'Processing'],
                        datasets: [{
                            label: 'Events Status',
                            data: [
                                {{ $chartData['events_status']['pending'] }},
                                {{ $chartData['events_status']['completed'] }},
                                {{ $chartData['events_status']['processing'] }}
                            ], // Sample data: replace with actual data
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
        }

        // Function to update charts based on timeframe
        function updateCharts() {
            const timeframe = $('#timeframeFilter').val();
            $.ajax({
                url: "updatechart?timeframe=" + timeframe,
                method: 'GET',
                success: function(chartData) {
                    // Destroy existing charts
                    Object.values(Chart.instances).forEach(chart => chart.destroy());
                    createEventsStatusChart()
                    // Create new charts with updated data
                    createChart('pendingActionsChart', 'Pending Actions', chartData.pending_actions, 'rgba(59, 130, 246,', timeframe);
                    createChart('dailyReadinessChart', 'Daily Readiness (%)', chartData.daily_readiness, 'rgba(34, 197, 94,', timeframe);
                    createChart('openEventsChart', 'Open Events', chartData.open_events, 'rgba(234, 179, 8,', timeframe);
                    createChart('openAuditsChart', 'Open Audits',chartData.upcoming_audits, 'rgba(235, 175, 8,', timeframe);
                    createChart('upcomingTalksChart', 'Talks', chartData.upcoming_talks, 'rgba(239, 68, 68,', timeframe);
                },
                error: function(error) {
                    console.error('Error updating charts:', error);
                }
            });
        }

        // Create new charts with updated data
        createChart('pendingActionsChart', 'Pending Actions', @json($chartData['pending_actions']), 'rgba(59, 130, 246,');
        createChart('dailyReadinessChart', 'Daily Readiness (%)', @json($chartData['daily_readiness']), 'rgba(34, 197, 94,');
        createChart('openEventsChart', 'Open Events', @json($chartData['open_events']), 'rgba(234, 179, 8,');
        createChart('openAuditsChart', 'Open Audits',@json($chartData['upcoming_audits']), 'rgba(235, 175, 8,');
        createChart('upcomingTalksChart', 'Talks', @json($chartData['upcoming_talks']), 'rgba(239, 68, 68,');

        // jQuery document ready
        $(document).ready(function() {
            // Bind change event to timeframe filter
            $('#timeframeFilter').on('change', updateCharts);
            // Initial chart load
            updateCharts();
        });
        $(document).ready(function() {
            // Optional: Update chart based on filter change (e.g., Timeframe dropdown)
            $('.form-select').on('change', function() {
                // Example AJAX call to fetch new data
                $.ajax({
                    url: 'admin/dashboard/events-data', // Updated to your controller route
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
    </script>
    
</x-app-layout>