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

        .score-option {
            cursor: pointer;
            padding: 5px 10px;
            border: 1px solid #dee2e6;
            border-radius: 3px;
            display: inline-block;
            margin-right: 5px;
        }

        .score-selected {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
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
    </style>

    <div class="row justify-content-center mt-4">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
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
                                <thead class="table-primary">
                                    <tr>
                                        <th style="width: 50%;">Thèmes abordés</th>
                                        <th>TS</th>
                                        <th>S</th>
                                        <th>I</th>
                                        <th>S2</th>
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

                                        $radios = ['TS', 'S', 'I', 'S2'];
                                        $index = 0;
                                    @endphp

                                    @foreach ($questions as $section => $qs)
                                        <tr class="table-primary fw-bold text-start">
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
                                    <input class="form-check-input" type="radio" name="culture_sse" value="{{ $val }}" id="culture_{{ $val }}" required>
                                    <label class="form-check-label" for="culture_{{ $val }}">{{ $val }}</label>
                                </div>
                            @endforeach
                        </div>

                        <h5 class="mt-4">Actions à mettre en place</h5>
                        <div id="actions-container" class="table-responsive mb-3">
                            <table class="table table-bordered align-middle">
                                <thead class="table-secondary text-center">
                                    <tr class="table-primary">
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
                                                <option value="I">Imméd. (I)</option>
                                                <option value="C">Corrective (C)</option>
                                                <option value="P">Préventive (P)</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" id="add-action" class="btn btn-secondary mb-3">Add Action</button>

                        <!-- Submit -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
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
                                <option value="I">Imméd. (I)</option>
                                <option value="C">Corrective (C)</option>
                                <option value="P">Préventive (P)</option>
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
                if (!$('input[name="culture_sse"]:checked').length) {
                    $('#error-message').text('Please select a Culture SSE score.').show();
                    hasError = true;
                }
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
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 2000);
                        }
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = 'Please fix the following errors:<br>';
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
    </script>
</x-app-layout>