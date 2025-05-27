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
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #0066cc;
            color: white;
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
            background-color: #0066cc;
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
                    @can('sse-create')
                    <a title="new" href="{{ route('sse.create') }}" class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-black uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25">
                        Créer Nouvelle Action SSE
                    </a>
                    @endcan
                    
                    <!-- The Form -->
                    <form method="POST" action="">
                        @csrf
                        
                        <!-- Title and Progress -->
                        <div class="header-yellow mb-2 p-2">Suivi des actions SSE</div>
                        <div class="mb-4">
                            <label class="block">l'avancement = 75%</label>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 75%"></div>
                            </div>
                        </div>
                        
                        <!-- Origin Table -->
                        <table class="mb-6">
                            <tr>
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
                            </tr>
                            
                            <!-- Sample Data Row 1 -->
                            <tr>
                                <td>2025-001</td>
                                <td><input type="checkbox" name="origin[0][mase]" checked></td>
                                <td><input type="checkbox" name="origin[0][direction]"></td>
                                <td><input type="checkbox" name="origin[0][verifications]"></td>
                                <td><input type="checkbox" name="origin[0][document]"></td>
                                <td><input type="checkbox" name="origin[0][audits]"></td>
                                <td><input type="checkbox" name="origin[0][accident]"></td>
                                <td><input type="checkbox" name="origin[0][incident]"></td>
                                <td><input type="checkbox" name="origin[0][animations]"></td>
                                <td><input type="checkbox" name="origin[0][demandes]"></td>
                                <td><input type="checkbox" name="origin[0][communication]"></td>
                                <td><input type="checkbox" name="origin[0][veille]"></td>
                                <td><input type="checkbox" name="origin[0][comite]"></td>
                                <td>Manque de formation sur les risques chimiques</td>
                                <td>04/01/2025</td>
                            </tr>
                            
                            <!-- Sample Data Row 2 -->
                            <tr>
                                <td>2025-002</td>
                                <td><input type="checkbox" name="origin[1][mase]"></td>
                                <td><input type="checkbox" name="origin[1][direction]"></td>
                                <td><input type="checkbox" name="origin[1][verifications]"></td>
                                <td><input type="checkbox" name="origin[1][document]"></td>
                                <td><input type="checkbox" name="origin[1][audits]" checked></td>
                                <td><input type="checkbox" name="origin[1][accident]"></td>
                                <td><input type="checkbox" name="origin[1][incident]"></td>
                                <td><input type="checkbox" name="origin[1][animations]"></td>
                                <td><input type="checkbox" name="origin[1][demandes]"></td>
                                <td><input type="checkbox" name="origin[1][communication]"></td>
                                <td><input type="checkbox" name="origin[1][veille]"></td>
                                <td><input type="checkbox" name="origin[1][comite]"></td>
                                <td>EPI non conformes sur chantier Bâtiment C</td>
                                <td>15/02/2025</td>
                            </tr>
                            
                            <!-- Sample Data Row 3 -->
                            <tr>
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
                            </tr>
                            
                            <!-- Add New Row -->
                            <tr>
                                <td><input type="text" name="new_action_number" placeholder="N° action"></td>
                                <td><input type="checkbox" name="new_origin[mase]"></td>
                                <td><input type="checkbox" name="new_origin[direction]"></td>
                                <td><input type="checkbox" name="new_origin[verifications]"></td>
                                <td><input type="checkbox" name="new_origin[document]"></td>
                                <td><input type="checkbox" name="new_origin[audits]"></td>
                                <td><input type="checkbox" name="new_origin[accident]"></td>
                                <td><input type="checkbox" name="new_origin[incident]"></td>
                                <td><input type="checkbox" name="new_origin[animations]"></td>
                                <td><input type="checkbox" name="new_origin[demandes]"></td>
                                <td><input type="checkbox" name="new_origin[communication]"></td>
                                <td><input type="checkbox" name="new_origin[veille]"></td>
                                <td><input type="checkbox" name="new_origin[comite]"></td>
                                <td><input type="text" name="new_description" placeholder="Description"></td>
                                <td><input type="date" name="new_date"></td>
                            </tr>
                        </table>
                        
                        <!-- Actions Table -->
                        <table>
                            <tr>
                                <th rowspan="2">Date d'émission</th>
                                <th rowspan="2">Description</th>
                                <th rowspan="2" class="narrow-col">I</th>
                                <th rowspan="2" class="narrow-col">C</th>
                                <th rowspan="2" class="narrow-col">P</th>
                                <th rowspan="2">Pilote</th>
                                <th rowspan="2">Delai</th>
                                <th colspan="2">Avancement de l'action</th>
                                <th colspan="5">Vérification de l'efficacité de l'action</th>
                            </tr>
                            <tr>
                                <th class="narrow-col">Action démarrée le</th>
                                <th class="narrow-col">Action terminée le</th>
                                <th>Vérificateur</th>
                                <th>Action vérifiée le</th>
                                <th class="narrow-col">Taux d'avancement</th>
                                <th class="narrow-col">Efficacité : O / N</th>
                                <th>Commentaire</th>
                            </tr>
                            
                            <!-- Sample Data Row 1 -->
                            <tr>
                                <td>04/01/2025</td>
                                <td>Mettre en place une formation sur les risques chimiques pour tout le personnel</td>
                                <td><input type="checkbox" name="actions[0][i]"></td>
                                <td><input type="checkbox" name="actions[0][c]" checked></td>
                                <td><input type="checkbox" name="actions[0][p]" checked></td>
                                <td>Martin D.</td>
                                <td>31/03/2025</td>
                                <td>15/01/2025</td>
                                <td>20/03/2025</td>
                                <td>Dubois J.</td>
                                <td>05/04/2025</td>
                                <td>100%</td>
                                <td>O</td>
                                <td>Formation complète réalisée pour 100% du personnel</td>
                            </tr>
                            
                            <!-- Sample Data Row 2 -->
                            <tr>
                                <td>15/02/2025</td>
                                <td>Audit complet des EPI sur tous les chantiers</td>
                                <td><input type="checkbox" name="actions[1][i]" checked></td>
                                <td><input type="checkbox" name="actions[1][c]"></td>
                                <td><input type="checkbox" name="actions[1][p]"></td>
                                <td>Robert L.</td>
                                <td>15/03/2025</td>
                                <td>20/02/2025</td>
                                <td>14/03/2025</td>
                                <td>Lambert P.</td>
                                <td>20/03/2025</td>
                                <td>100%</td>
                                <td>O</td>
                                <td>Tous les EPI ont été vérifiés et remplacés si nécessaire</td>
                            </tr>
                            
                            <!-- Sample Data Row 3 -->
                            <tr>
                                <td>23/03/2025</td>
                                <td>Révision des procédures de manipulation des produits corrosifs</td>
                                <td><input type="checkbox" name="actions[2][i]"></td>
                                <td><input type="checkbox" name="actions[2][c]"></td>
                                <td><input type="checkbox" name="actions[2][p]" checked></td>
                                <td>Sophie M.</td>
                                <td>30/04/2025</td>
                                <td>01/04/2025</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>50%</td>
                                <td></td>
                                <td>Procédures en cours de révision</td>
                            </tr>
                            
                            <!-- Add New Action Row -->
                            <tr>
                                <td><input type="date" name="new_action_date"></td>
                                <td><input type="text" name="new_action_description" placeholder="Description"></td>
                                <td><input type="checkbox" name="new_action_i"></td>
                                <td><input type="checkbox" name="new_action_c"></td>
                                <td><input type="checkbox" name="new_action_p"></td>
                                <td><input type="text" name="new_action_pilot" placeholder="Pilote"></td>
                                <td><input type="date" name="new_action_deadline"></td>
                                <td><input type="date" name="new_action_started"></td>
                                <td><input type="date" name="new_action_completed"></td>
                                <td><input type="text" name="new_action_verifier" placeholder="Vérificateur"></td>
                                <td><input type="date" name="new_action_verified"></td>
                                <td><input type="text" name="new_action_progress" placeholder="%"></td>
                                <td>
                                    <select name="new_action_efficiency">
                                        <option value="">-</option>
                                        <option value="O">O</option>
                                        <option value="N">N</option>
                                    </select>
                                </td>
                                <td><input type="text" name="new_action_comment" placeholder="Commentaire"></td>
                            </tr>
                        </table>
                        
                        <div class="mb-4 mt-6">
                            <p class="text-sm text-gray-600">I : Action Immédiate ; C : Action Corrective ; P : Action Préventive</p>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest  focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-800 transition ease-in-out duration-150" style="background-color: #0066cc">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
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