<x-app-layout> <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark"> {{ __('Dashboard') }} </h2>
    </x-slot>
    <style>
        .card {
            border-radius: 20px;
        }
    </style>
    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm mb-4">
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
                    <div class="mt-4 text-end"> <button class="btn btn-outline-primary me-2"
                            onclick="exportToPDF()">Export to PDF</button> <button class="btn btn-outline-success"
                            onclick="exportToExcel()">Export to Excel</button> </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function exportToPDF() {
            alert('Exporting to PDF...');
        }

        function exportToExcel() {
            alert('Exporting to Excel...');
        }
    </script>
</x-app-layout>
