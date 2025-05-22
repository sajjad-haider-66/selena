<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Filters Section -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-4">Filters</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <select class="border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option>Project</option>
                                <!-- Add dynamic project options here -->
                            </select>
                            <select class="border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option>Site</option>
                                <!-- Add dynamic site options here -->
                            </select>
                            <select class="border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option>Timeframe</option>
                                <option>Last 7 Days</option>
                                <option>Last 30 Days</option>
                                <option>Custom Range</option>
                            </select>
                        </div>
                    </div>

                    <!-- Dashboard Widgets -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <!-- Pending Actions -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow">
                            <h4 class="font-medium">Pending Actions</h4>
                            <p class="text-2xl font-bold">5</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Due this week</p>
                        </div>
                        <!-- Daily Readiness Stats -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow">
                            <h4 class="font-medium">Daily Readiness</h4>
                            <p class="text-2xl font-bold">92%</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Operational</p>
                        </div>
                        <!-- Open Events -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow">
                            <h4 class="font-medium">Open Events</h4>
                            <p class="text-2xl font-bold">3</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Active</p>
                        </div>
                        <!-- Upcoming Audits/Talks -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow">
                            <h4 class="font-medium">Upcoming Audits/Talks</h4>
                            <p class="text-2xl font-bold">2</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Next 7 days</p>
                        </div>
                    </div>

                    <!-- Export/Print Buttons -->
                    <div class="flex justify-end space-x-4">
                        <button class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700" onclick="exportToPDF()">Export to PDF</button>
                        <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700" onclick="exportToExcel()">Export to Excel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function exportToPDF() {
            // Placeholder for PDF export logic
            alert('Exporting to PDF...');
        }

        function exportToExcel() {
            // Placeholder for Excel export logic
            alert('Exporting to Excel...');
        }
    </script>
</x-app-layout>
