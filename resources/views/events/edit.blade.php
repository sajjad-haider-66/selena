<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Event') }}
        </h2>
    </x-slot>

    <style>
        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            font-weight: bold;
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .action-table th,
        .action-table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
        }

        .category-title {
           background-color: #efeff0;
            color: rgb(0, 0, 0);
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 5px;
        }

        .category-content {
            display: block;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            margin-bottom: 10px;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div id="success-message" class="alert alert-success" style="display: none;"></div>
                    <div id="error-message" class="alert alert-danger" style="display: none;"></div>

                    <form id="eventForm" method="POST" action="{{ route('event.update', $event->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Date</label>
                                    <input type="date" name="date" class="form-control" value="{{ $event->date }}" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Lieu (site / chantier)</label>
                                    <input type="text" name="lieu" class="form-control" value="{{ $event->lieu }}" required>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Type d'événement</label>
                                    <select name="type" class="form-control" required>
                                        <option value="">Sélectionner</option>
                                        <option value="Dangerous situation" {{ $event->type == 'Dangerous situation' ? 'selected' : '' }}>Situation Dangereuse</option>
                                        <option value="Near miss" {{ $event->type == 'Near miss' ? 'selected' : '' }}>Presque Accident</option>
                                        <option value="Work accident" {{ $event->type == 'Work accident' ? 'selected' : '' }}>Accident du Travail (AT)</option>
                                        <option value="Occupational illness" {{ $event->type == 'Occupational illness' ? 'selected' : '' }}>Maladie Professionnelle (MP)</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Émetteur</label>
                                    <input type="text" name="emetteur" class="form-control" value="{{ $event->emetteur }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Catégories</label>
                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="checkbox" name="securite" id="securite" {{ $event->securite ? 'checked' : '' }}>
                                    <label for="securite">Sécurité</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" name="sante" id="sante" {{ $event->sante ? 'checked' : '' }}>
                                    <label for="sante">Santé</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" name="environnement" id="environnement" {{ $event->environnement ? 'checked' : '' }}>
                                    <label for="environnement">Environnement</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" name="rse" id="rse" {{ $event->rse ? 'checked' : '' }}>
                                    <label for="rse">RSE</label>
                                </div>
                                  <div class="checkbox-item">
                                    <input type="checkbox" name="surete" id="surete" {{ $event->surete ? 'checked' : '' }}>
                                    <label for="surete">Surete</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Circonstances détaillées</label>
                            <input type="file" name="image" id="image" accept="image/*" class="form-control mb-2">
                            <textarea name="circonstances" rows="3" class="form-control" placeholder="Enter image description...">{{ $event->circonstances ?? '' }}</textarea>
                        </div>
                        
                        <div class="mb-2">
                            @if ($event->path)
                                <img src="{{ asset('storage/' . $event->path) }}" alt="Uploaded Image"
                                    width="200" height="150" class="rounded shadow">
                            @else
                                <p><em>Aucune image disponible</em></p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="form-label">Risques encourus</label>
                            <textarea name="risques" class="form-control" rows="2">{{ $event->risques }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Analyse simplifiée (Sélectionnez les manquements)</label>
                            @php
                                $analyse = json_decode($event->analyse, true) ?? [];
                            @endphp

                            <!-- Sécurité des accès -->
                            <div class="category-title" onclick="toggleCategory('securite_acces')">Sécurité des accès</div>
                            <div id="securite_acces" class="category-content">
                                <div class="checkbox-group">
                                    @foreach ([
                                        'Chute de plain-pied ou escalier',
                                        'Chute dans trémie sans protection ou mal protégée',
                                        'Chute de hauteur',
                                        'Chute d’objet',
                                        'Franchissement d’un balisage ou d’un garde-corps',
                                        'Cheminement non sécurisé (manque de visibilité, obstacle, etc.)'
                                    ] as $item)
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="analyse[securite_acces][]" value="{{ $item }}"
                                                {{ isset($analyse['securite_acces']) && in_array($item, $analyse['securite_acces']) ? 'checked' : '' }}>
                                            {{ $item }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Matériel de sécurité -->
                            <div class="category-title" onclick="toggleCategory('materiel_securite')">Matériel de sécurité</div>
                            <div id="materiel_securite" class="category-content">
                                <div class="checkbox-group">
                                    @foreach ([
                                        'Matériel de sécurité non vérifié',
                                        'Matériel de sécurité inadapté',
                                        'Matériel de sécurité indisponible',
                                        'Non respect d’une consigne de sécurité',
                                        'Non port des EPI',
                                        'Non utilisation d’EPC'
                                    ] as $item)
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="analyse[materiel_securite][]" value="{{ $item }}"
                                                {{ isset($analyse['materiel_securite']) && in_array($item, $analyse['materiel_securite']) ? 'checked' : '' }}>
                                            {{ $item }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Information sur les risques -->
                            <div class="category-title" onclick="toggleCategory('info_risques')">Information sur les risques</div>
                            <div id="info_risques" class="category-content">
                                <div class="checkbox-group">
                                    @foreach ([
                                        'Absence de PdP ou de PPSPS',
                                        'Non communication du PdP ou du PPSPS au collaborateur',
                                        'Information sur les risques potentiels incomplète ou absente',
                                        'Absence d’accueil sécurité sur le site'
                                    ] as $item)
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="analyse[info_risques][]" value="{{ $item }}"
                                                {{ isset($analyse['info_risques']) && in_array($item, $analyse['info_risques']) ? 'checked' : '' }}>
                                            {{ $item }}
                                        </div>
                                    @endforeach
                                    
                                </div>
                            </div>

                            <!-- Ambiances et situations de travail -->
                            <div class="category-title" onclick="toggleCategory('ambiances')">Ambiances et situations de travail</div>
                            <div id="ambiances" class="category-content">
                                <div class="checkbox-group">
                                    @foreach ([
                                        'Produits toxiques, nocifs',
                                        'Produits corrosifs, irritants',
                                        'Risque électrique',
                                        'Risque d’incendie, d’explosion',
                                        'Risques liés à la coactivité',
                                        'Modification des risques en cours de mission',
                                        'Conditions d’hygiène dans les locaux'
                                    ] as $item)
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="analyse[ambiances][]" value="{{ $item }}"
                                                {{ isset($analyse['ambiances']) && in_array($item, $analyse['ambiances']) ? 'checked' : '' }}>
                                            {{ $item }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Formation sécurité / Habilitations -->
                            <div class="category-title" onclick="toggleCategory('formation')">Formation sécurité / Habilitations</div>
                            <div id="formation" class="category-content">
                                <div class="checkbox-group">
                                    @foreach ([
                                        'Formation sécurité insuffisante ou absente',
                                        'Intervention d’un collaborateur non habilité',
                                        'Habilitation périmée, à réexaminée'
                                    ] as $item)
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="analyse[formation][]" value="{{ $item }}"
                                                {{ isset($analyse['formation']) && in_array($item, $analyse['formation']) ? 'checked' : '' }}>
                                            {{ $item }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Autre</label>
                                <textarea name="autre" id="autre" class="form-control" rows="2">{{ $event->autre ?? '' }}</textarea>
                            </div>
                          
                        </div>

                        <div class="row">
                            <div class="col col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Fréquence d’exposition</label>
                                    <select name="frequence" class="form-control" required>
                                        <option value="1" {{ $event->frequence == 1 ? 'selected' : '' }}>Faible (< 1 fois/an)</option>
                                        <option value="2" {{ $event->frequence == 2 ? 'selected' : '' }}>Moyenne (< 1 fois/mois)</option>
                                        <option value="3" {{ $event->frequence == 3 ? 'selected' : '' }}>Grande (> 1 fois/mois)</option>
                                        <option value="4" {{ $event->frequence == 4 ? 'selected' : '' }}>Grande (> 1 fois/semaine)</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Gravité des dommages</label>
                                    <select name="gravite" class="form-control" required>
                                        <option value="1" {{ $event->gravite == 1 ? 'selected' : '' }}>Gêne ou dommage léger</option>
                                        <option value="2" {{ $event->gravite == 2 ? 'selected' : '' }}>Blessure légère</option>
                                        <option value="3" {{ $event->gravite == 3 ? 'selected' : '' }}>Blessure grave</option>
                                        <option value="4" {{ $event->gravite == 4 ? 'selected' : '' }}>Blessure mortelle</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Propositions pour éviter</label>
                                    @php
                                        $propositions = json_decode($event->propositions, true) ?? [];
                                    @endphp
                                    <textarea name="propositions[0]" class="form-control" rows="2">{{ $propositions[0] ?? '' }}</textarea>
                                </div>
                                <div class="form-group">
                                       <!-- Risk Calculation Display -->
                                    <div id="riskDisplay" class="mt-3">
                                        Cotation du risque : <span id="riskValue"></span>
                                        <div id="riskMessage"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mesures pour éviter accident</label>
                            @php
                                $mesures = json_decode($event->mesures, true) ?? [];
                            @endphp
                            <div class="checkbox-group">
                                @foreach (['Information', 'Organisation', 'Equipement', 'Autre'] as $mesure)
                                    <div class="checkbox-item">
                                        <input type="checkbox"  id="{{ $mesure == 'Autre' ? 'autre_input' : 'mesure_' . strtolower($mesure) }}" name="mesures[]" value="{{ $mesure }}"
                                            {{ in_array($mesure, $mesures) ? 'checked' : '' }}>
                                        <label>{{ $mesure == 'Equipement' ? 'Equipement de sécurité' : $mesure }}</label>
                                    </div>
                                @endforeach
                            </div>
                           <div class="form-group autre_input_show" style="{{ $event->autre_checkbox ? '' : 'display: none;' }}">
                                <input type="text" name="autre_checkbox" id="autre_checkbox" value="{{ $event->autre_checkbox ?? '' }}" class="form-control " placeholder="Veuillez préciser">
                            </div>
                        </div>

                        <div class="form-group">
                        <table class="action-table">
                            <tr>
                                <th colspan="7" class="blue-header">Action(s) à mettre en place</th>
                            </tr>
                                 <tr>
                                <th width="35%">Action(s) à mettre en place</th>
                                <th width="20%">Responsable</th>
                                <th width="20%">Délai</th>
                                <th width="15%">Type d'Action</th>
                                <th width="5%">Remove</th>
                            </tr>
                                <tbody>
                                    @php
                                        $actions = json_decode($event->actions, true) ?? [];
                                    @endphp
                                    @foreach ($actions as $index => $action)
                                        <tr>
                                            <td><input type="text" name="actions[{{ $index }}][description]" class="form-control" value="{{ $action['description'] ?? '' }}"></td>
                                            <td><input type="text" name="actions[{{ $index }}][responsable]" class="form-control" value="{{ $action['responsable'] ?? '' }}"></td>
                                            <td><input type="date" name="actions[{{ $index }}][delai]" class="form-control" value="{{ $action['delai'] ?? '' }}"></td>
                                            <td>
                                                <select name="actions[{{ $index }}][type]" class="form-select">
                                                    <option value="Immediate" {{ ($action['type'] ?? '') == 'Immediate' ? 'selected' : '' }}>Immédiate (I)</option>
                                                    <option value="Corrective" {{ ($action['type'] ?? '') == 'Corrective' ? 'selected' : '' }}>Corrective (C)</option>
                                                    <option value="Preventive" {{ ($action['type'] ?? '') == 'Preventive' ? 'selected' : '' }}>Préventive (P)</option>
                                                </select>
                                            </td>
                                            <td><button type="button" class="btn btn-danger remove-action" {{ $index == 0 ? 'disabled' : '' }}>Remove</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                       <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-800 transition ease-in-out duration-150" style="background-color: blue;">
                                Update
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
         let actionCount = 0;

            // Toggle category visibility
            $('.category-title').click(function() {
                $(this).next('.category-content').toggle();
            });

            // Show/hide "Other Measure" input
            $('#otherMeasure').change(function() {
                $('#otherMeasureInput').toggle(this.checked);
            });

            // Add Action Dynamically
            $('#add-action').on('click', function () {
                actionCount++;
                const newAction = `
                    <tr class="action-row">
                        <td><textarea name="actions[${actionCount}][description]" class="form-control" required></textarea></td>
                        <td><input type="text" name="actions[${actionCount}][responsable]" class="form-control" required></td>
                        <td><input type="date" name="actions[${actionCount}][delai]" class="form-control" id="deadline${actionCount}" required></td>
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
                updateDeadline(actionCount);
            });

            // Remove Action
            $(document).on('click', '.remove-action', function () {
                $(this).closest('tr').remove();
            });

            $('body').on('click', '#autre_input', function (e) {
                if ($('#autre_input').is(":checked")) {
                    $(".autre_input_show").slideDown("fast");
                }
                else {
                    $(".autre_input_show").slideUp("fast");
                }
            });

            // Calculate risk and update deadline
            function calculateRisk() {
                const frequence = parseInt($('select[name="frequence"]').val());
                const gravite = parseInt($('select[name="gravite"]').val());
                const risk = frequence * gravite;
                $('#riskValue').text(risk);

                let message = '';
                if (risk <= 4) {
                    message = 'Action à entreprendre sous 1 semaine (Recueil des faits ci-dessus suffisant)';
                    updateAllDeadlines(7);
                } else if (risk <= 10) {
                    message = 'Action à entreprendre sous 48 h (Recueil des faits ci-dessus suffisant)';
                    updateAllDeadlines(2);
                } else {
                    message = 'Action urgente à entreprendre immédiatement (Réalisation arbre des causes systématiquement)';
                    updateAllDeadlines(0);
                }
                $('#riskMessage').html(`<strong>${message}</strong>`);
            }

            function updateDeadline(index) {
                const risk = parseInt($('#riskValue').text()) || 0;
                const deadlineField = $(`#deadline${index}`);
                if (risk <= 4) {
                    deadlineField.val(getDateAfterDays(7));
                } else if (risk <= 10) {
                    deadlineField.val(getDateAfterDays(2));
                } else {
                    deadlineField.val(new Date().toISOString().split('T')[0]);
                }
            }

            function updateAllDeadlines(days) {
                $('#actions-container table tbody tr').each(function() {
                    const deadlineField = $(this).find('input[type="date"]');
                    deadlineField.val(getDateAfterDays(days));
                });
            }

            function getDateAfterDays(days) {
                const date = new Date();
                date.setDate(date.getDate() + days);
                return date.toISOString().split('T')[0];
            }

            $('body').on('click', '#autre_input', function (e) {
                if ($('#autre_input').is(":checked")) {
                    $(".autre_input_show").slideDown("fast");
                }
                else {
                    $(".autre_input_show").slideUp("fast");
                }
            });

            // Initial calculation
            $('select[name="frequence"], select[name="gravite"]').change(calculateRisk);
            calculateRisk();

            $('#eventForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var submitButton = $(this).find('button[type="submit"]');
                submitButton.prop('disabled', true);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $('#success-message').text(response.message).show();
                            toastr.success(response.message);
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 2000);
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = 'Please fix the following errors:<br>';
                        toastr.error('Please fix the following errors:<br>');
                        $.each(errors, function(key, value) {
                            errorMessage += `- ${value[0]}<br>`;
                        });
                        $('#error-message').html(errorMessage).show();
                        submitButton.prop('disabled', false);
                    }
                });
            });

            window.toggleCategory = function(categoryId) {
                const content = document.getElementById(categoryId);
                content.classList.toggle('active');
            };
        });
    </script>
</x-app-layout>