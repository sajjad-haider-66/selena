<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create - Audit') }}
        </h2>
    </x-slot>

    <style>
        .section-title {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .score-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .score-table th,
        .score-table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
        }

        .score-table th {
            background-color: #007bff;
            color: white;
        }

        .action-row {
            background-color: #f8f9fa;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        #success-message,
        #error-message {
            display: none;
            margin-bottom: 20px;
        }

        .btn.btn-primary {
            background-color: #0d6efd !important;
            color: white !important;
        }

        .btn.btn-secondary {
            background-color: #d4d4d4 !important;
            color: white !important;
        }

        .btn.btn-danger {
            background-color: #fd290d !important;
            color: white !important;
        }
           th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: rgba(0, 0, 0, .03);
            color: rgb(0, 0, 0);
        }
         .blue-header {
            background-color: rgba(0, 0, 0, .03);
            color: #000000;
            text-align: center;
        }
          .action-legend {
            font-size: 12px;
            text-align: center;
            padding: 5px;
        }
    </style>

    <div class="row justify-content-center mt-4">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header text-dark d-flex justify-content-between align-items-center">
                    <h4>Formulaire d'Audit</h4>
                </div>
                <div class="card-body">
                    <div id="success-message" class="alert alert-success"></div>
                    <div id="error-message" class="alert alert-danger"></div>
                    <form id="auditForm">
                        @csrf

                        <!-- Meta Info -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Date</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Lieu (site / chantier)</label>
                                <input type="text" name="lieu" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Auditeur</label>
                                <input type="text" name="auditeur" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Nom de l'intervenant</label>
                                <input type="text" name="intervenant" class="form-control" required>
                            </div>
                        </div>

                        <!-- Questions Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle">
                                <thead class="table-secondry">
                                    <tr>
                                        <th style="width: 50%;">Thèmes abordés</th>
                                        <th>TS</th>
                                        <th>S</th>
                                        <th>IS</th>
                                        <th>SO</th>
                                        <th>Commentaires</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $questions = [
                                            'L\'intervenant et son métier' => [
                                                'Quelle est votre mission, les enjeux client, les résultats à fournir ?',
                                                'Quels sont les risques associés à votre métier (risques classiques, coactivité, produits chimiques) ?',
                                                'Quelles sont les formations nécessaires (habilitation électrique, autorisations, GIES ½, etc..) ?',
                                                'Quelles sont les habilitations nécessaires ? Sont-elles suffisantes ?',
                                                'Quelles sont les consignes d’urgence du site ? Alerte Gaz / H2S / incendie ?',
                                            ],
                                            'L\'intervenant et ses moyens' => [
                                                'Quels sont les EPI pour cette mission ?',
                                                'État visuel ?',
                                                'Sont-ils adaptés au travail ?',
                                                'Correctement porté ?',
                                            ],
                                            'L\'intervenant et son environnement' => [
                                                'Quels sont les risques liés à l\'environnement client (Culture SSE) ?',
                                                'Quels sont les moyens d\'accès au site et zone d\'intervention ?',
                                                'Respecte-t-il les consignes de sécurité du chantier ?',
                                                'Quelle est la démarche MASE de votre entreprise ?',
                                                'Y a-t-il un Plan de Prévention ou PPSPS ? 3 principaux risques ?',
                                            ],
                                            'L\'intervenant et son relationnel' => [
                                                'Attentes du client en termes de savoir-être ?',
                                                'Remontées d’informations récentes ?',
                                                '(difficultés, aléas, bonnes pratiques, SD…) que vous avez réalisé récemment ?',
                                                'Dernier thème de causerie / animation SSE ?',
                                            ],
                                        ];

                                        $radios = ['TS', 'S', 'IS', 'SO'];
                                        $index = 0;
                                    @endphp

                                    @foreach ($questions as $section => $qs)
                                        <tr class="table-secondry fw-bold text-start">
                                            <td colspan="6">{{ $section }}</td>
                                        </tr>

                                        @foreach ($qs as $q)
                                            <tr>
                                                <td class="text-start">{{ $q }}</td>
                                                @foreach ($radios as $r)
                                                    <td>
                                                        <input type="radio" name="responses[{{ $index }}][note]" value="{{ $r }}" class="form-check-input" required>
                                                    </td>
                                                @endforeach
                                                <td>
                                                    <textarea name="responses[{{ $index }}][comment]" class="form-control" rows="1"></textarea>
                                                </td>
                                            </tr>
                                            @php $index++; @endphp
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <h5>Culture SSE terrain</h5>
                        <div class="mb-3">
                            @foreach(['++', '+', '=/-', '-', '--'] as $val)
                                <div class="form-check form-check-inline">
                                    {{-- <input class="form-check-input" type="radio" name="culture_sse" value="{{ $val }}" id="culture_{{ $val }}" required> --}}
                                    <label class="form-check-label" for="culture_{{ $val }}">{{ $val }}</label>
                                </div>
                            @endforeach
                        </div>
                        <p id="qser-display" class="mt-2"></p>

                        <h5 class="mt-4">Actions à mettre en place</h5>
                        <div id="actions-container" class="table-responsive mb-3">
                            <table class="table table-bordered align-middle">
                                <thead class="table-secondary text-center">
                                    <tr class="table-secondry">
                                        <th>Action(s)</th>
                                        <th>Responsable</th>
                                        <th>Délai</th>
                                        <th>Type d'Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="action-row">
                                        <td><textarea name="actions[0][description]" class="form-control"></textarea></td>
                                        <td><input type="text" name="actions[0][responsable]" class="form-control"></td>
                                        <td><input type="date" name="actions[0][delai]" class="form-control"></td>
                                        <td>
                                            <select name="actions[0][type]" class="form-select">
                                                <option value="Immediate">Imméd. (I)</option>
                                                <option value="Corrective">Corrective (C)</option>
                                                <option value="Preventive">Préventive (P)</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" id="add-action" class="btn btn-outline-dark mb-3">Add Action</button>
                        <div class="action-legend mt-2">I : Action Immédiate ; C : Action Corrective ; P : Action Préventive</div>

                        <!-- Submit -->
                          <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-800 transition ease-in-out duration-150" style="background-color: blue;">
                                Enregistrer
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
        $(document).ready(function () {
            let actionCount = 0;

            // Add Action Dynamically
            $('#add-action').on('click', function () {
                actionCount++;
                const newAction = `
                    <tr class="action-row">
                        <td><textarea name="actions[${actionCount}][description]" class="form-control" required></textarea></td>
                        <td><input type="text" name="actions[${actionCount}][responsable]" class="form-control" required></td>
                        <td><input type="date" name="actions[${actionCount}][delai]" class="form-control" required></td>
                        <td>
                            <select name="actions[${actionCount}][type]" class="form-select" required>
                                <option value="Immediate">Imméd. (I)</option>
                                <option value="Corrective">Corrective (C)</option>
                                <option value="Preventive">Préventive (P)</option>
                            </select>
                        </td>
                        <td><button type="button" class="btn btn-danger remove-action">Remove</button></td>
                    </tr>
                `;
                $('#actions-container table tbody').append(newAction);
            });

            // Remove Action
            $(document).on('click', '.remove-action', function () {
                $(this).closest('tr').remove();
            });

            // AJAX Form Submission
            $('#auditForm').on('submit', function (e) {
                e.preventDefault();

                // Reset messages
                $('#success-message').hide();
                $('#error-message').hide();
                $('.form-control').removeClass('is-invalid');
                $('.form-check-input').removeClass('is-invalid');

                // Client-side validation
                let hasError = false;
                $('input[required], textarea[required], select[required]').each(function () {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        hasError = true;
                    }
                });
                if (hasError) return;

                const formData = $(this).serialize();
                const submitButton = $(this).find('button[type="submit"]');
                submitButton.prop('disabled', true);

                $.ajax({
                    url: '{{ route("audit.store") }}',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            $('#success-message').text(response.message).show();
                             toastr.success(response.message);
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 2000);
                        }
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = 'Please fix the following errors:<br>';
                         toastr.error('Please fix the following errors:<br>');
                        $.each(errors, function (key, value) {
                            errorMessage += `- ${value[0]}<br>`;
                            $(`[name="${key}"]`).addClass('is-invalid');
                        });
                        $('#error-message').html(errorMessage).show();
                        submitButton.prop('disabled', false);
                    }
                });
            });
        });
        $(document).ready(function() {
            $('input[type="radio"]').change(function() {
                calculateScore();
            });

            function calculateScore() {
                let totalWeightedScore = 0;
                let totalMaxWeightedScore = 0;

                $('tbody tr').each(function() {
                    let $row = $(this);
                    let selectedScore = $row.find('input[type="radio"]:checked').val();
                    let section = $row.closest('tr.fw-bold').find('td').text();

                    let score = 0;
                    switch(selectedScore) {
                        case 'TS': score = 100; break;
                        case 'S': score = 75; break;
                        case 'IS': score = 25; break;
                        case 'SO': score = 0; break;
                    }

                    let coefficient = 0;
                    switch(section) {
                        case "L'intervenant et son métier": coefficient = 1; break;
                        case "L'intervenant et ses moyens": coefficient = 3; break;
                        case "L'intervenant et son environnement": coefficient = 3; break;
                        case "L'intervenant et son relationnel": coefficient = 2; break;
                    }

                    let answeredQuestions = $row.find('input[type="radio"]:checked').length > 0 ? 1 : 0;
                    totalWeightedScore += score * coefficient * answeredQuestions;
                    totalMaxWeightedScore += 100 * coefficient * answeredQuestions;
                });

                let finalScore = totalMaxWeightedScore > 0 ? (totalWeightedScore / totalMaxWeightedScore) * 100 : 0;
                let cultureLevel = getCultureLevel(finalScore);

                $('#qser-display').text(`Final Score: ${finalScore.toFixed(2)}% - Culture SSE Level: ${cultureLevel}`);
            }

            function getCultureLevel(score) {
                if (score >= 90) return '++';
                if (score >= 75) return '+';
                if (score >= 50) return '=/-';
                if (score >= 25) return '-';
                return '--';
            }
        });
    </script>
</x-app-layout>