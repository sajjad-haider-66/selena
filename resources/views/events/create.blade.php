<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report an Event') }}
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

        /* .category-content.active {
            display: block;
        } */
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div id="success-message" class="alert alert-success" style="display: none;"></div>
                    <div id="error-message" class="alert alert-danger" style="display: none;"></div>

                    <form id="eventForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Date</label>
                                    <input type="date" name="date" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Lieu (site / chantier)</label>
                                    <input type="text" name="lieu" class="form-control" required>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Type d'événement</label>
                                    <select name="type" class="form-control" required>
                                        <option value="">Sélectionner</option>
                                        <option value="Dangerous situation">Situation Dangereuse</option>
                                        <option value="Near miss">Presque Accident</option>
                                        <option value="Work accident">Accident du Travail (AT)</option>
                                        <option value="Occupational illness">Maladie Professionnelle (MP)</option>
                                        <option value="Incident">Incident</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Émetteur</label>
                                    <input type="text" name="emetteur" class="form-control">
                                </div>
                            </div>
                        </div>




                        <div class="form-group">
                            <label class="form-label">Catégories</label>
                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="checkbox" name="securite" id="securite">
                                    <label for="securite">Sécurité</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" name="sante" id="sante">
                                    <label for="sante">Santé</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" name="environnement" id="environnement">
                                    <label for="environnement">Environnement</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" name="rse" id="rse">
                                    <label for="rse">RSE</label>
                                </div>
                                 <div class="checkbox-item">
                                    <input type="checkbox" name="surete" id="surete">
                                    <label for="surete">Surete</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Circonstances détaillées</label>
                            <input type="file" name="image" id="image" accept="image/*" class="form-control mb-2">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Risques encourus</label>
                            <textarea name="risques" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Analyse simplifiée (Sélectionnez les manquements)</label>

                            <!-- Sécurité des accès -->
                            <div class="category-title" onclick="toggleCategory('securite_acces')">Sécurité des accès
                            </div>
                            <div id="securite_acces" class="category-content">
                                <div class="checkbox-group">
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[securite_acces][]"
                                        value="Chute de plain-pied ou escalier"> Chute de plain-pied ou escalier
                                    </div>
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[securite_acces][]"
                                            value="Chute dans trémie sans protection ou mal protégée"> Chute dans trémie
                                        sans protection</div>
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[securite_acces][]"
                                            value="Chute de hauteur"> Chute de hauteur</div>
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[securite_acces][]"
                                            value="Chute d’objet"> Chute d’objet</div>
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[securite_acces][]"
                                            value="Franchissement d’un balisage ou d’un garde-corps"> Franchissement
                                        d’un balisage ou garde-corps</div>
                                    <div class="checkbox-item"><input type="checkbox"
                                            name="analyse[securite_acces][]" value="Cheminement non sécurisé">
                                        Cheminement non sécurisé (manque de visibilité, obstacle, etc.)</div>
                                </div>
                            </div>

                            <!-- Matériel de sécurité -->
                            <div class="category-title" onclick="toggleCategory('materiel_securite')">Matériel de
                                sécurité</div>
                            <div id="materiel_securite" class="category-content">
                                <div class="checkbox-group">
                                    <div class="checkbox-item"><input type="checkbox"
                                            name="analyse[materiel_securite][]"
                                            value="Matériel de sécurité non vérifié"> Matériel de sécurité non vérifié
                                    </div>
                                    <div class="checkbox-item"><input type="checkbox"
                                            name="analyse[materiel_securite][]" value="Matériel de sécurité inadapté">
                                        Matériel de sécurité inadapté</div>
                                    <div class="checkbox-item"><input type="checkbox"
                                            name="analyse[materiel_securite][]"
                                            value="Matériel de sécurité indisponible"> Matériel de sécurité
                                        indisponible</div>
                                    <div class="checkbox-item"><input type="checkbox"
                                            name="analyse[materiel_securite][]"
                                            value="Non respect d’une consigne de sécurité"> Non respect d’une consigne
                                        de sécurité</div>
                                    <div class="checkbox-item"><input type="checkbox"
                                            name="analyse[materiel_securite][]" value="Non port des EPI"> Non port des
                                        EPI</div>
                                    <div class="checkbox-item"><input type="checkbox"
                                            name="analyse[materiel_securite][]" value="Non utilisation d’EPC"> Non
                                        utilisation d’EPC</div>
                                </div>
                            </div>

                            <!-- Information sur les risques -->
                            <div class="category-title" onclick="toggleCategory('info_risques')">Information sur les
                                risques</div>
                            <div id="info_risques" class="category-content">
                                <div class="checkbox-group">
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[info_risques][]"
                                            value="Absence de PdP ou de PPSPS"> Absence de PdP ou de PPSPS</div>
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[info_risques][]"
                                            value="Non communication du PdP ou du PPSPS au collaborateur"> Non
                                        communication du PdP/PPSPS</div>
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[info_risques][]"
                                            value="Information sur les risques potentiels incomplète ou absente">
                                        Information sur les risques incomplète</div>
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[info_risques][]"
                                            value="Absence d’accueil sécurité sur le site"> Absence d’accueil sécurité
                                    </div>
                                </div>
                            </div>

                            <!-- Ambiances et situations de travail -->
                            <div class="category-title" onclick="toggleCategory('ambiances')">Ambiances et situations
                                de travail</div>
                            <div id="ambiances" class="category-content">
                                <div class="checkbox-group">
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[ambiances][]"
                                            value="Produits toxiques, nocifs"> Produits toxiques, nocifs</div>
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[ambiances][]"
                                            value="Produits corrosifs, irritants"> Produits corrosifs, irritants</div>
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[ambiances][]"
                                            value="Risque électrique"> Risque électrique</div>
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[ambiances][]"
                                            value="Risque d’incendie, d’explosion"> Risque d’incendie, d’explosion
                                    </div>
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[ambiances][]"
                                            value="Risques liés à la coactivité"> Risques liés à la coactivité</div>
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[ambiances][]"
                                            value="Modification des risques en cours de mission"> Modification des
                                        risques en cours</div>
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[ambiances][]"
                                            value="Conditions d’hygiène dans les locaux"> Conditions d’hygiène
                                        insuffisantes</div>
                                </div>
                            </div>

                            <!-- Formation sécurité / Habilitations -->
                            <div class="category-title" onclick="toggleCategory('formation')">Formation sécurité /
                                Habilitations</div>
                            <div id="formation" class="category-content">
                                <div class="checkbox-group">
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[formation][]"
                                            value="Formation sécurité insuffisante ou absente"> Formation sécurité
                                        insuffisante</div>
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[formation][]"
                                            value="Intervention d’un collaborateur non habilité"> Collaborateur non
                                        habilité</div>
                                    <div class="checkbox-item"><input type="checkbox" name="analyse[formation][]"
                                            value="Habilitation périmée, à réexaminée"> Habilitation périmée</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Autre</label>
                                <textarea name="autre" id="autre" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Fréquence d’exposition</label>
                                    <select name="frequence" class="form-control" required>
                                        <option value="1">Faible (< 1 fois/an)</option>
                                        <option value="2">Moyenne (< 1 fois/mois)</option>
                                        <option value="3">Grande (> 1 fois/mois)</option>
                                        <option value="4">Grande (> 1 fois/semaine)</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Gravité des dommages</label>
                                    <select name="gravite" class="form-control" required>
                                        <option value="1">Gêne ou dommage léger</option>
                                        <option value="2">Blessure légère</option>
                                        <option value="3">Blessure grave</option>
                                        <option value="4">Blessure mortelle</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Propositions pour éviter</label>
                                    <textarea name="propositions[0]" class="form-control" rows="2"></textarea>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mesures pour éviter accident</label>
                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="checkbox" name="mesures[]" value="Information">
                                    <label>Information / Formation</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" name="mesures[]" value="Organisation">
                                    <label>Organisation</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" name="mesures[]" value="Equipement">
                                    <label>Equipement de sécurité</label>
                                </div>
                                <div class="checkbox-item">
                                    <input id="autre_input" type="checkbox" name="mesures[]" value="Autre">
                                    <label>Autre</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group autre_input_show" style="display: none;">
                            <input type="text" name="autre_checkbox" id="autre_checkbox" class="form-control " placeholder="Veuillez préciser">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Actions à mettre en place</label>
                            <div id="actions-container" class="table-responsive mb-3">
                                <table class="table table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Responsable</th>
                                            <th>Délai</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="action-row">
                                            <td><textarea name="actions[0][description]" class="form-control" required></textarea></td>
                                            <td><input type="text" name="actions[0][responsable]" class="form-control" required></td>
                                            <td><input type="date" name="actions[0][delai]" class="form-control" id="deadline" required></td>
                                            <td>
                                                <select name="actions[0][type]" class="form-select" required>
                                                    <option value="I">Imméd. (I)</option>
                                                    <option value="C">Corrective (C)</option>
                                                    <option value="P">Préventive (P)</option>
                                                </select>
                                            </td>
                                            <td><button type="button" class="btn btn-danger remove-actions" disabled>Remove</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" id="add-action" class="btn btn-outline-dark mb-3">Add Action</button>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Attachments (Photos/Videos)</label>
                            <input type="file" name="attachments[]" multiple class="form-control">
                        </div>

                       <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-800 transition ease-in-out duration-150" style="background-color: blue;">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                    <!-- Risk Calculation Display -->
                    <div id="riskDisplay" class="mt-3">
                        Cotation du risque : <span id="riskValue"></span>
                        <div id="riskMessage"></div>
                    </div>
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
                                <option value="I">Imméd. (I)</option>
                                <option value="C">Corrective (C)</option>
                                <option value="P">Préventive (P)</option>
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
                    url: '{{ route('event.store') }}',
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

            // Toggle category content
            window.toggleCategory = function(categoryId) {
                const content = document.getElementById(categoryId);
                content.classList.toggle('active');
            };
        });
    </script>
</x-app-layout>
