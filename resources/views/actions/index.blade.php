<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Suivi des actions SSE
        </h2>
    </x-slot>
    
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #ececee;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #fefbfb;
            color: black;
            font-weight: bold;
        }
        .header-yellow {
            background-color: #FFD700;
            color: black;
            font-weight: bold;
            text-align: left;
            padding: 10px;
            font-size: 18px;
        }
        .header-blue {
            background-color: #d2d2d2;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        input[type="text"], input[type="date"], select {
            width: 100%;
            border: 1px solid #d1d5db;
            padding: 5px;
            box-sizing: border-box;
        }
        input[type="checkbox"] {
            width: 18px;
            height: 18px;
        }
        .narrow-col {
            width: 40px;
        }
        .medium-col {
            width: 80px;
        }
        .vertical-text {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            white-space: nowrap;
            padding: 10px 0;
            height: 120px;
            vertical-align: middle;
        }
        .progress-bar {
            height: 20px;
            background-color: #e2e8f0;
            border-radius: 5px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background-color: #10b981;
        }
    </style>
    
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Success and Error Messages -->
                    @if (session('success'))
                        <div class="alert alert-success bg-green-100 border-t-4 border-green-500 rounded-b text-green-600 px-4 py-3 shadow-md my-3" role="alert">
                            <div class="flex">
                                <div>
                                    <p class="text-sm text-success">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-b text-red-600 px-4 py-3 shadow-md my-3" role="alert">
                            <p><strong>Opps Something went wrong</strong></p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger rounded-b text-red-600 px-4 py-3 shadow-md my-3" role="alert">
                            <div class="flex">
                                <div>
                                    <p class="text-sm text-danger">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Permission based button -->
                    <a href="{{ route('action.create') }}" class="btn btn-primary inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold uppercase bg-green-600 text-white rounded-md hover:bg-green-500" style="float: right">
                        {{ __('Create Action') }}
                    </a>
                        
                        <div class="header-yellow mt-5 mb-2 p-2">Plan d'Actions Global SSE</div>
                        <div class="mb-4">
                            <label class="block">Taux d'avancement global des actions</label>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $progress }}%">{{ $progress }}%</div>
                            </div>
                        <div class="mt-2">
                            <div class="input-group">
                                <input type="text" id="customSearch" class="form-control" placeholder="Rechercher action, source, pilote...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="filterBtn">Filtrer/Rechercher</button>
                                </div>
                            </div>
                        </div>
                        </div>
                       
                    
                        <!-- Actions Table -->
                        <div class="table-responsive">
                            <table id="actionsTable" class="display">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Origine</th>
                                        <th>DESC. DYSFONCTIONNEMENT/ AMELIORATION</th>
                                        <th>Emission</th>
                                        <th>Description action</th>
                                        <th>Type</th>
                                        <th>Pilote</th>
                                        <th>Délai</th>
                                        <th>Démarrée le</th>
                                        <th>Terminée le</th>
                                        <th>Vérificateur</th>
                                        <th>Vérifiée le</th>
                                        <th>Avancement</th>
                                        <th>Efficacité</th>
                                        <th>Commentaire</th>
                                        <th><b>Save</b></th>
                                        <th><b>More details</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($actions as $action)
                                        @php
                                            $routeName = isset($action['action_origin']) ? $action['action_origin'] . '.show' : null;
                                        @endphp
                                        <tr class="action-row">
                                            <td>{{ $action['id'] }}</td>
                                            <td>{{ $action['origin'] }}</td>
                                            <td>{{ $action['comments'] }}</td>
                                            <td>{{ $action['emission'] }}</td>
                                            <td>{{ $action['description'] }}</td>
                                            <td>{{ $action['type'] }}</td>
                                            <td>{{ $action['pilot_id'] }}</td>
                                            <td>{{ $action['due_date'] }}</td>
                                            <td>
                                                <input type="date" name="start_on" id="start_on" 
                                                value="{{ isset($action['start_date']) ? \Carbon\Carbon::parse($action['start_date'])->format('Y-m-d') : '' }}"></td>

                                            <td><input type="date" id="finished_on" name="finished_on" value="{{ isset($action['end_date']) ? \Carbon\Carbon::parse($action['end_date'])->format('Y-m-d') : '' }}"></td>
                                            <td><input type="text" id="auditor" name="auditor" value="{{ $action['auditor'] ?? '' }}"></td>
                                            <td><input type="date" id="checked_on" name="checked_on" value="{{ isset($action['checked_on']) ? \Carbon\Carbon::parse($action['checked_on'])->format('Y-m-d') : '' }}"></td>
                                            <td>
                                                <progress value="{{ $action['progress_rate'] }}" max="100"></progress>
                                                {{ $action['progress_rate'] }}%
                                            </td>
                                            <td>{{ $action['efficiency'] }}</td>
                                            <td><textarea name="comments" id="comments"  rows="2">{{ $action['comments'] }}</textarea></td>
                                            <td><button class="btn btn-success btn-sm save-actions-btn" data-id="{{ $action['id'] }}" id="save-actions-btn">Enregistrer</button></td>
                                            <td>
                                                @if ($routeName && Route::has($routeName))
                                                    <a href="{{ route($routeName, $action['origin_view_id']) }}" class="btn btn-primary btn-sm">
                                                        Voir détail
                                                    </a>
                                                @else
                                                    <span class="text-muted">N/A</span> {{-- Or just leave it blank --}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mb-4 mt-6">
                            <p class="text-sm text-gray-600">I : Action Immédiate ; C : Action Corrective ; P : Action Préventive</p>
                        </div>
                </div>
            </div>
        </div>
    </div>
        <!-- jQuery -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
           let table = $('#actionsTable').DataTable({
                responsive: true,
                "lengthChange": false,
                scrollX: true,
            });

            // Search on button click
            $('#filterBtn').on('click', function () {
                let query = $('#customSearch').val();
                table.search(query).draw();
            });

            // Optional: search on "Enter" key
            $('#customSearch').on('keyup', function (e) {
                if (e.key === 'Enter') {
                    $('#filterBtn').click();
                }
                // Optional: Live clear as you type
                if ($(this).val() === '') {
                    table.search('').draw(); // clear filter and show all
                }
            });

            $('.save-actions-btn').on('click', function () {

                let actionId = $(this).data('id');
                // Collect data from the row
                let row = $(this).closest('.action-row');
                let data = {
                    start_on: row.find('#start_on').val(),
                    finished_on: row.find('#finished_on').val(),
                    auditor: row.find('#auditor').val(),
                    checked_on: row.find('#checked_on').val(),
                    comments: row.find('#comments').val(),
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    action_id: actionId
                };
                // Send AJAX request to save the action
                $.ajax({
                    url: 'index/'+actionId+'/action',
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.responseCode == 200) {
                            // Show success message
                            toastr.success('Action saved successfully!', 'Success', {
                                position: 'top-right',
                                duration: 3000,
                            });
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        $('#error-message ul').html(xhr);
                    }
                });
            });
                

            $('#progress').on('change', function() {
                var progress = $(this).val();
                $('#progress-fill').css('width', progress + '%');
            });
        });
    </script>
</x-app-layout>