<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Plan de Prévention') }}
        </h2>
    </x-slot>

    <style>
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000 !important;
            padding: 5px;
        }

        .form-section {
            margin-bottom: 25px;
        }

        .form-section h4 {
            background: #f8f9fa;
            padding: 10px;
            border: 1px solid #000;
            text-align: center;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"],
        textarea {
            width: 100%;
        }

        .checkbox-list {
            columns: 1;
            -webkit-columns: 1;
            -moz-columns: 1;
        }

        .checkbox-list label {
            display: block;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="card-header text-black d-flex justify-content-between align-items-center">
                    <h4>Plan</h4>
                </div>
                <form method="POST" action="{{ route('plan.store') }}">
                    @csrf

                    <!-- N° A & Date -->
                    <div class="form-section">
                        <table class="table table-bordered">
                            <tr>
                                <td style="width:20%"><label for="plan_number">N°</label></td>
                                <td style="width:30%"><input type="text" name="plan_number" id="plan_number"
                                        value="{{ old('plan_number') }}" required>

                                    @error('plan_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td style="width:20%"><label for="work_date">DATE des travaux</label></td>
                                <td style="width:30%"><input type="date" name="work_date" id="work_date" required>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Entreprises -->
                    <div class="form-section">
                        <h4>Nom de l'Entreprise</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Entreprise Extérieure</th>
                                    <th>Entreprise Utilisatrice</th>
                                    <th>Entreprise sous-traitante</th>
                                    <th>Nom de l'intervenant</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="company-body">
                                <tr>
                                    <td><input type="text" name="external_company[0]"></td>
                                    <td><input type="text" name="main_company[0]"></td>
                                    <td><input type="text" name="subcontractor[0]"></td>
                                    <td><input type="text" name="intervenant[0]"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm remove-companys"
                                            disabled>Remove</button></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <button type="button" id="add-company-name"
                                            class="btn btn-outline-dark btn-sm">Add More</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Opération à effectuer -->
                    <div class="form-section">
                        <h4>OPÉRATION À EFFECTUER</h4>
                        <table class="table table-bordered">
                            <tr>
                                <td>Emplacement prévu :</td>
                                <td><input type="text" name="location"></td>
                                <td>Début d'intervention :</td>
                                <td><input type="date" name="start_time"></td>
                            </tr>
                            <tr>
                                <td>Description :</td>
                                <td colspan="3">
                                    <textarea name="description"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>N° mode opératoire :</td>
                                <td><input type="text" name="operative_mode_number"></td>
                                <td>Fin d'intervention prévue :</td>
                                <td><input type="date" name="end_time"></td>
                            </tr>
                        </table>
                    </div>

                    <!-- Nature du travail / Risques / Formations -->
                    <div class="form-section">
                        <h4>NATURE DU TRAVAIL / RISQUES / FORMATIONS</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NATURE DU TRAVAIL</th>
                                    <th>NATURE DES RISQUES</th>
                                    <th>FORMATIONS / HABILITATIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="checkbox-list">
                                            <label><input type="checkbox" name="travail[]"
                                                    value="Travaux sur équipements électriques"> Travaux sur équipements
                                                électriques</label>
                                            <label><input type="checkbox" name="travail[]" value="Travaux de plomberie">
                                                Travaux de plomberie</label>
                                            <label><input type="checkbox" name="travail[]" value="Travaux de peinture">
                                                Travaux de peinture</label>
                                            <label><input type="checkbox" name="travail[]"
                                                    value="Perçage, meulage, découpage, soudage, décapage"> Perçage,
                                                meulage, découpage, soudage, décapage</label>
                                            <label><input type="checkbox" name="travail[]" value="Levage">
                                                Levage</label>
                                            <label><input type="checkbox" name="travail[]"
                                                    value="Travaux sur tuyauterie"> Travaux sur tuyauterie</label>

                                            <label><input type="checkbox" name="travail[]"
                                                    value="Fouille / terrassement"> Fouille / terrassement</label>
                                            <label><input type="checkbox" name="travail[]" value="Forage">
                                                Forage</label>
                                            <label><input type="checkbox" name="travail[]"
                                                    value="Visites / audits / contrôles / études engineering"> Visites
                                                / audits / contrôles / études engineering</label>
                                            <label><input type="checkbox" name="travail[]"
                                                    value="Travaux d'entretien des abords de la station"> Travaux
                                                d'entretien</label>
                                            <label><input type="checkbox" name="travail[]"
                                                    value="Travaux de démolition"> Travaux de démolition</label>
                                            <label><input type="checkbox" name="travail[]"
                                                    value="Intervention sur portique de lavage"> Intervention sur
                                                portique de lavage</label>
                                            <label><input type="checkbox" name="travail[]" value="Autres1"> Autres
                                                <input type="text" name="work_nature_other1"></label>
                                            <hr><label class="mt-2"><strong><u>SITUATION
                                                        PARTICULIÈRE</u></strong></label>
                                            <label><input type="checkbox" name="travail[]"
                                                    value="Présence de public "> Présence de public </label>
                                            <label><input type="checkbox" name="travail[]"
                                                    value="Espace confiné / fouille"> Espace confiné / fouille</label>
                                            <label><input type="checkbox" name="travail[]"
                                                    value="Travaux en hauteur"> Travaux en hauteur</label>
                                            <label><input type="checkbox" name="travail[]"
                                                    value="Volumes de sécurité"> Volumes de sécurité</label>
                                            <label><input type="checkbox" name="travail[]" value="Autres2"> Autres
                                                (précisez) : <input type="text" name="work_nature_other2"></label>
                                            <hr><label class="mt-2"><strong><u>MOYENS / OUTILS </u></strong></label>
                                            <label><input type="checkbox" name="travail[]" value="Manuel "> Manuel
                                            </label>
                                            <label><input type="checkbox" name="travail[]"
                                                    value="Matériel électrique"> Matériel électrique</label>
                                            <label><input type="checkbox" name="travail[]"
                                                    value="Matériel pneumatique"> Matériel pneumatique</label>
                                            <label><input type="checkbox" name="travail[]" value="Nacelle "> Nacelle
                                            </label>
                                            <label><input type="checkbox" name="travail[]" value="PIR / PIRL "> PIR /
                                                PIRL </label>
                                            <label><input type="checkbox" name="travail[]" value="Grue">
                                                Grue</label>
                                            <label><input type="checkbox" name="travail[]" value="Echafaudage">
                                                Echafaudage</label>
                                            <label><input type="checkbox" name="travail[]" value="Autres3"> Autres
                                                (précisez) : <input type="text" name="work_nature_other3"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox-list">
                                            <label><input type="checkbox" name="risques[]"
                                                    value="Circulation routière"> Circulation routière</label>
                                            <label><input type="checkbox" name="risques[]" value="Incendie">
                                                Incendie</label>
                                            <label><input type="checkbox" name="risques[]" value="Explosion">
                                                Explosion</label>
                                            <label><input type="checkbox" name="risques[]" value="Sources d'énergie">
                                                Sources d'énergie</label>
                                            <label><input type="checkbox" name="risques[]"
                                                    value="Risques électriques"> Risques électriques</label>
                                            <label><input type="checkbox" name="risques[]"
                                                    value="Risques hydrauliques"> Risques hydrauliques</label>
                                            <label><input type="checkbox" name="risques[]"
                                                    value="Risques liés à la pression"> Risques liés à la
                                                pression</label>
                                            <label><input type="checkbox" name="risques[]" value="Risques de chute">
                                                Risques de chute</label>
                                            <label><input type="checkbox" name="risques[]"
                                                    value="Eboulement / Écrasement / Ensevelissement"> Eboulement /
                                                Écrasement / Ensevelissement</label>
                                            <label><input type="checkbox" name="risques[]" value="Asphyxie">
                                                Asphyxie</label>
                                            <label><input type="checkbox" name="risques[]"
                                                    value="Coupure, brûlure, choc…"> Coupure, brûlure, choc…</label>
                                            <label><input type="checkbox" name="risques[]" value="Bruit">
                                                Bruit</label>
                                            <label><input type="checkbox" name="risques[]" value="Risques chimiques">
                                                Risques chimiques</label>
                                            <label><input type="checkbox" name="risques[]" value="- Hydrocarbure "> -
                                                Hydrocarbure </label>
                                            <label><input type="checkbox" name="risques[]"
                                                    value="- Autres produits "> - Autres produits </label>
                                            <label><input type="checkbox" name="risques[]" value="Risque biologique">
                                                Risque biologique</label>
                                            <label><input type="checkbox" name="risques[]" value="Risque">
                                                Risque</label>
                                            <label><input type="checkbox" name="risques[]"
                                                    value="- Manipulation de charges"> - Manipulation de
                                                charges</label>
                                            <label><input type="checkbox" name="risques[]"
                                                    value="- Contrainte de postures"> - Contrainte de postures</label>
                                            <label><input type="checkbox" name="risques[]"
                                                    value="Risques pour l’environnement : "> Risques pour
                                                l’environnement : </label>
                                            <label><input type="checkbox" name="risques[]" value="- Pollution air"> -
                                                Pollution air</label>
                                            <label><input type="checkbox" name="risques[]" value="- Pollution sol"> -
                                                Pollution sol</label>
                                            <label><input type="checkbox" name="risques[]" value="- Pollution eau"> -
                                                Pollution eau</label>
                                            <label><input type="checkbox" name="risques[]" value="Autres1"> Autres
                                                <input type="text" name="risk_nature_other1"></label>
                                            <hr><label class="mt-2"><strong><u>DOCUMENTS DISPONIBLES
                                                    </u></strong></label>
                                            <label><input type="checkbox" name="risques[]"
                                                    value="Fiche de Données Sécurité "> Fiche de Données Sécurité
                                            </label>
                                            <label><input type="checkbox" name="risques[]"
                                                    value="Document Technique"> Amiante</label>
                                            <label><input type="checkbox" name="risques[]"
                                                    value="Déclaration d’Intention de"> Commencement de Travaux</label>
                                            <label><input type="checkbox" name="risques[]" value="Plans de réseaux">
                                                Plans de réseaux</label>
                                            <label><input type="checkbox" name="risques[]"
                                                    value="Certificat de dégazage "> Certificat de dégazage </label>
                                            <label><input type="checkbox" name="risques[]" value="Autres2"> Autres
                                                <input type="text" name="risk_nature_other2"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox-list">
                                            <label><input type="checkbox" name="formations[]"
                                                    value="Autorisation de conduite d'un engin de chantier">
                                                Autorisation de conduite d'un engin de chantier</label>
                                            <label><input type="checkbox" name="formations[]"
                                                    value="Habilitation électrique"> Habilitation électrique</label>
                                            <label><input type="checkbox" name="formations[]" value="Autres1"> Autres
                                                <input type="text" name="training_certifications_other1"></label>
                                            <div class="mt-3">
                                                <label><input type="checkbox" name="formations[]"
                                                        value="Port d’EPI et autres équipements spécifiques :"> Port
                                                    d’EPI et autres équipements spécifiques :</label>
                                                <label><input type="checkbox" name="formations[]"
                                                        value="- Appareil respiratoire, ventilation forcée"> - Appareil
                                                    respiratoire, ventilation forcée</label>
                                                <label><input type="checkbox" name="formations[]"
                                                        value="- Harnais, baudrier, filet de sécurité,sangle de retenue">-
                                                    Harnais, baudrier, filet de sécurité,sangle de retenue </label>
                                                <label><input type="checkbox" name="formations[]"
                                                        value="- Mise à disposition casqueanti-bruit">- Mise à
                                                    disposition casqueanti-bruit</label>
                                                <label><input type="checkbox" name="formations[]"
                                                        value="- Aide à la manutention">- Aide à la manutention
                                                </label>
                                                <label><input type="checkbox" name="formations[]" value="Autres4">
                                                    Autres <input type="text"
                                                        name="training_certifications_other4"></label>
                                                <label><input type="checkbox" name="formations[]"
                                                        value="Permis spécifique :">Permis spécifique : </label>
                                                <label><input type="checkbox" name="formations[]"
                                                        value="- Permis de feu"> - Permis de feu</label>
                                                <label><input type="checkbox" name="formations[]"
                                                        value="- Permis delevage">- Permis de levage </label>
                                                <label><input type="checkbox" name="formations[]"
                                                        value="- Permis de fouille">- Permis de fouille </label>
                                                <label><input type="checkbox" name="formations[]"
                                                        value="Permis de pénétrer">Permis de pénétrer</label>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- VALIDATION AVANT LES TRAVAUX -->
                    <div class="card mb-4">
                        <div class="text-center card-header font-weight-bold">
                            VALIDATION
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- ENTREPRISE(S) EXTÉRIEURE(S) INTERVENANTE(S) -->
                                <div class="col-md-6">
                                    <h6>ENTREPRISE(S) EXTÉRIEURE(S) INTERVENANTE(S)</h6>
                                    <div id="nom-container">
                                        <div class="form-group nom-group">
                                            <label>1- Nom:</label>
                                            <div class="d-flex">
                                                <input type="text" name="avant_entreprise[]"
                                                    class="form-control me-2">
                                                <!-- Remove button hidden for first input -->
                                                <button type="button"
                                                    class="btn btn-danger btn-sm remove-nom d-none">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <button type="button" id="add-nom" class="btn btn-outline-dark btn-sm">Add
                                            More</button>
                                    </div>
                                </div>
                                <!-- RESPONSABLE DE LA STATION OU SON REPRÉSENTANT -->
                                <div class="col-md-6">
                                    <h6>Responsable de l'entreprise utilisatrice ou son représentant</h6>
                                    <div class="form-group">
                                        <label>Date :</label>
                                        <input type="date" name="avant_date" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Heure :</label>
                                        <input type="time" name="avant_heure" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Nom :</label>
                                        <input type="text" name="avant_responsable_nom" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Retour d’expérience -->
                    <div class="card mb-4">
                        <div class="text-center card-header font-weight-bold">
                            Retour d’expérience de fin de chantier
                        </div>
                        <div class="card-body">
                            <!-- Row 1 -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Quelles sont les remontées d'information identifiées lors de notre chantier
                                        ?</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" rows="3" name="informations_identifiees"></textarea>
                                </div>
                            </div>

                            <!-- Row 2 -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Ya t il eu des situations dangereuses, presque accidents et accidents
                                        ?</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" rows="3" name="situations_dangereuses"></textarea>
                                </div>
                            </div>

                            <!-- Row 3 -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Les résultats des mesurages liés à la santé des travailleurs (Fiche
                                        d’exposition à jour, avis d’aptitude médicale en cours de validité)</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" rows="3" name="resultats_sante"></textarea>
                                </div>
                            </div>

                            <!-- Row 4 -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Quels sont les impacts sur l’environnement en cas de non respect du tri des
                                        déchets ?</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" rows="3" name="impacts_environnement"></textarea>
                                </div>
                            </div>

                            <!-- Row 5 -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>
                                        Ya t il eu des sous-traitants ou du personnel d’appoint ?<br>
                                        Merci de confirmer le respect des règles de sécurité, port des EPI, connaissance
                                        politique SSE, de nos objectifs tels que le 0 AT, la 0 MP, le 0 Atteinte à l'environnement.
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" rows="3" name="sous_traitants"></textarea>
                                </div>
                            </div>

                            <!-- Row 6 -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>
                                        Ya t il eu des constats suite à un audit SSE, une visite, un contrôle 
                                        (de notre référent SSE, de l'auditeur MASE, du client, de la carsat, de l'inspecteur du travail)
                                         ? Si oui, quel en a ete le résultat ?
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" rows="3" name="audit_constats"></textarea>
                                </div>
                            </div>

                            <!-- Row 7 -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>
                                        Ya t il eu des modifications des conditions opératoires ? Comment les avez-vous
                                        gérées ?
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" rows="3" name="modifications_conditions"></textarea>
                                </div>
                            </div>

                            <!-- Row 8 -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>
                                        Ya t il eu des points positifs, les points à améliorer ? Merci de les indiquer.
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" rows="3" name="points_ameliorer"></textarea>
                                </div>
                            </div>

                            <!-- Row 9 -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>
                                        Les analyses des risques ainsi que des modes opératoires ont-ils été efficaces
                                        ?<br>
                                        <small class="text-muted">(Merci d’expliquer en quelques mots comment ils ont été efficace)</small>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" rows="3" name="analyses_risques"></textarea>
                                </div>
                            </div>

                            <!-- Row 10 -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>
                                        Ya t il eu des faits marquants ?<br>
                                        <small class="text-muted">(merci de decrire en quelques mots les principaux faits,
                                           marquants: visite positive du client, adaptation du mode operatoire suite à modificatio etc.)</small>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" rows="3" name="faits_marquants"></textarea>
                                </div>
                            </div>

                            <!-- Row 11 -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>
                                        Ya til eu des écarts entre la préparation (travail prescrit) et la réalisation (travail réel)
                                        Quelle nalyse en fait vous? (merci de decrire l'impact potentiel sur la prestation)
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" rows="3" name="travail_prescrit"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-800 transition ease-in-out duration-150"
                            style="background-color: blue;">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let companyIndex = 1;

        $('#add-company-name').on('click', function() {
            let newRow = `
                <tr>
                    <td><input type="text" name="external_company[${companyIndex}]"></td>
                    <td><input type="text" name="main_company[${companyIndex}]"></td>
                    <td><input type="text" name="subcontractor[${companyIndex}]"></td>
                    <td><input type="text" name="intervenant[${companyIndex}]"></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-company">Remove</button></td>
                </tr>
            `;
            $('#company-body').append(newRow);
            companyIndex++;
        });

        // Remove Row
        $(document).on('click', '.remove-company', function() {
            $(this).closest('tr').remove();
        });


        let nomIndex = 2;

        $('#add-nom').on('click', function() {
            let newInput = `
                <div class="form-group nom-group mt-2">
                    <label>${nomIndex}- Nom:</label>
                    <div class="d-flex">
                        <input type="text" name="avant_entreprise[]" class="form-control me-2">
                        <button type="button" class="btn btn-danger btn-sm remove-nom">Remove</button>
                    </div>
                </div>
            `;
            $('#nom-container').append(newInput);
            nomIndex++;
        });

        // Remove handler
        $(document).on('click', '.remove-nom', function() {
            $(this).closest('.nom-group').remove();
        });

    </script>
</x-app-layout>
