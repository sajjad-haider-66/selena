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
                        
                    <!-- The Form -->
                    <form method="POST" action="" class="mt-5">
                        @csrf
                        
                        <!-- Title and Progress -->
                        {{-- <div class="header-yellow">The requested Actions table</div>
                        <div style="text-align: center; margin-bottom: 10px;">
                            <div>Plan d'Actions Global SSE</div>
                            <div>Taux d'avancement global des actions : <progress value="60" max="100"></progress> 60%</div>
                            <input type="text" placeholder="Rechercher action, source, pilote...">
                            <button>Filtrer/Rechercher</button>
                        </div> --}}

                        <div class="header-yellow mb-2 p-2">Plan d'Actions Global SSE</div>
                        <div class="mb-4">
                            <label class="block">Taux d'avancement global des actions</label>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 75%">75%</div>
                            </div>
                          <div class="mt-2">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Rechercher action, source, pilote...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">Filtrer/Rechercher</button>
                                </div>
                            </div>
                        </div>
                        </div>
                        
                        <!-- Origin Table -->
                        <table class="mb-6">
                            {{-- <tr>
                                <th class="narrow-col">N° de l'action</th>
                                <th class="narrow-col vertical-text">Audit système MASE</th>
                                <th class="narrow-col vertical-text">Revue de direction / Bilan SSE</th>
                                <th class="narrow-col vertical-text">Vérifications périodiques</th>
                                <th class="narrow-col vertical-text">Document unique / Évaluation des risques</th>
                                <th class="narrow-col vertical-text">AUDITS TERRAINS</th>
                                <th class="narrow-col vertical-text">Accident</th>
                                <th class="narrow-col vertical-text">Incident / Situation dangereuse</th>
                                <th class="narrow-col vertical-text">Animations SSE (causerie)/1/4 h SSE</th>
                                <th class="narrow-col vertical-text">Demandes client</th>
                                <th class="narrow-col vertical-text">Communication</th>
                                <th class="narrow-col vertical-text">Veille Règlementaire (CODIT/ AMADEO)</th>
                                <th class="narrow-col vertical-text">Comité SSE TRIMESTRIELS</th>
                                <th class="medium-col">Descriptions du dysfonctionnement / amélioration</th>
                                <th class="medium-col">Date d'émission</th>
                            </tr> --}}
                    
                            <!-- Sample Data Row 3 -->
                            {{-- <tr>
                                <td>2025-003</td>
                                <td><input type="checkbox" name="origin[2][mase]"></td>
                                <td><input type="checkbox" name="origin[2][direction]"></td>
                                <td><input type="checkbox" name="origin[2][verifications]"></td>
                                <td><input type="checkbox" name="origin[2][document]"></td>
                                <td><input type="checkbox" name="origin[2][audits]"></td>
                                <td><input type="checkbox" name="origin[2][accident]"></td>
                                <td><input type="checkbox" name="origin[2][incident]" checked></td>
                                <td><input type="checkbox" name="origin[2][animations]"></td>
                                <td><input type="checkbox" name="origin[2][demandes]"></td>
                                <td><input type="checkbox" name="origin[2][communication]"></td>
                                <td><input type="checkbox" name="origin[2][veille]"></td>
                                <td><input type="checkbox" name="origin[2][comite]"></td>
                                <td>Presque accident lors de la manipulation de produits corrosifs</td>
                                <td>23/03/2025</td>
                            </tr> --}}
                            
                        
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
                                        <tr>
                                            <td>{{ $action['id'] }}</td>
                                            <td>{{ $action['origin'] }}</td>
                                            <td>{{ $action['comments'] }}</td>
                                            <td>{{ $action['start_date'] }}</td>
                                            <td>{{ $action['description'] }}</td>
                                            <td>{{ $action['type'] }}</td>
                                            <td>{{ $action['pilot_id'] }}</td>
                                            <td>{{ $action['due_date'] }}</td>
                                            <td><input type="date" id="start_on" name="start_on"></td>
                                            <td><input type="date" id="finished_on" name="finished_on"></td>
                                            <td><input type="text" id="auditor" name="auditor"></td>
                                            <td><input type="date" id="start_on" name="start_on"></td>
                                            <td>
                                                <progress value="{{ $action['progress_rate'] }}" max="100"></progress>
                                                {{ $action['progress_rate'] }}%
                                            </td>
                                            <td>{{ $action['efficiency'] }}</td>
                                            <td><textarea name="" id=""  rows="2"></textarea></td>
                                            <td><button class="btn btn-success btn-sm">Enregistrer</button></td>
                                            <td><button class="btn btn-primary btn-sm">Voir détail</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mb-4 mt-6">
                            <p class="text-sm text-gray-600">I : Action Immédiate ; C : Action Corrective ; P : Action Préventive</p>
                        </div>
                        
                        {{-- <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest  focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-800 transition ease-in-out duration-150" style="background-color: #0066cc">
                                Enregistrer les modifications
                            </button>
                        </div> --}}
                    </form>
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
            $('#actionsTable').DataTable({
                responsive: true,
                "lengthChange": false,
                scrollX: true,
            });

            $('#submitForm').on('click', function(e) {
                e.preventDefault();

                var formData = new FormData($('#actionForm')[0]);
                var progress = $('#progress').val();
                $('#progress-fill').css('width', progress + '%');

                $.ajax({
                    url: '{{ route('action.store') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $('#success-message p').text(response.message);
                            $('#success-message').show();
                            setTimeout(() => {
                                $('#success-message').hide();
                            }, 3000);
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '<p><strong>Opps Something went wrong</strong></p><ul>';
                        $.each(errors, function(key, value) {
                            errorMessage += '<li>' + value[0] + '</li>';
                        });
                        errorMessage += '</ul>';
                        $('#error-message ul').html(errorMessage);
                        $('#error-message').show();
                        setTimeout(() => {
                            $('#error-message').hide();
                        }, 5000);
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