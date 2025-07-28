<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show - Prevention Plan Details') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="form-section">
                    <h4>PLAN DE PRÉVENTION JOURNALIER</h4>
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>N°</strong></td>
                            <td>{{ $plans->plan_number }}</td>
                            <td><strong>Date</strong></td>
                            <td>{{ $plans->work_date != null ? $plans->work_date->format('Y-m-d') : 'No Date' }}</td>
                        </tr>
                    </table>
                    <h4>Nom de l'Entreprise</h4>
                    <table class="table table-bordered">
                        <thead>
                            
                        </thead>
                     @if($plans->company_name_detail)
                        @php
                            $companies = json_decode($plans->company_name_detail, true);
                        @endphp

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Entreprise Extérieure</th>
                                    <th>Entreprise Utilisatrice</th>
                                    <th>Entreprise Extérieure</th>
                                    <th>Entreprise Utilisatrice</th>
                                    <th>Entreprise sous-traitante</th>
                                    <th>Nom de l'intervenant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($companies as $company)
                                    <tr>
                                        <td>{{ $company['external_company'] ?? '-' }}</td>
                                        <td>{{ $company['main_company'] ?? '-' }}</td>
                                        <td>{{ $company['subcontractor'] ?? '-' }}</td>
                                        <td>{{ $company['intervenant'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No companies available.</p>
                    @endif

                    </table>
                </div>

                <div class="form-section">
                    <h4>OPÉRATION À EFFECTUER</h4>
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Emplacement prévu :</strong></td>
                            <td>{{ $plans->location }}</td>
                            <td><strong>Début d'intervention :</strong></td>
                            <td>{{ $plans->start_time != null ? $plans->start_time->format('Y-m-d') : 'No Date' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Description :</strong></td>
                            <td colspan="3">{{ $plans->description }}</td>
                        </tr>
                        <tr>
                            <td><strong>N° mode opératoire :</strong></td>
                            <td>{{ $plans->operative_mode_number }}</td>
                            <td><strong>Fin d'intervention prévue :</strong></td>
                            <td>{{ $plans->end_time != null ? $plans->end_time->format('Y-m-d') : 'No Date' }}</td>
                        </tr>
                    </table>
                </div>

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
                                    @php 
                                        $travail = json_decode($plans->work_nature, true) ?? [];
                                        $work_nature_other = json_decode($plans->work_nature_other, true) ?? [];
                                    @endphp
                                    <div class="checkbox-list">
                                        <label><input type="checkbox" disabled {{ in_array('Travaux sur équipements électriques', $travail) ? 'checked' : '' }}> Travaux sur équipements électriques</label>
                                        <label><input type="checkbox" disabled {{ in_array('Travaux de plomberie', $travail) ? 'checked' : '' }}> Travaux de plomberie</label>
                                        <label><input type="checkbox" disabled {{ in_array('Travaux de peinture', $travail) ? 'checked' : '' }}> Travaux de peinture</label>
                                        <label><input type="checkbox" disabled {{ in_array('Perçage, meulage, découpage, soudage, décapage', $travail) ? 'checked' : '' }}> Perçage, meulage, découpage, soudage, décapage</label>
                                        <label><input type="checkbox" disabled {{ in_array('Levage', $travail) ? 'checked' : '' }}> Levage</label>
                                        <label><input type="checkbox" disabled {{ in_array('Travaux sur tuyauterie', $travail) ? 'checked' : '' }}> Travaux sur tuyauterie</label>
                                        <label><input type="checkbox" disabled {{ in_array('Fouille / terrassement', $travail) ? 'checked' : '' }}> Fouille / terrassement</label>
                                        <label><input type="checkbox" disabled {{ in_array('Forage', $travail) ? 'checked' : '' }}> Forage</label>
                                        <label><input type="checkbox" disabled {{ in_array('Visites / audits / contrôles / études engineering', $travail) ? 'checked' : '' }}> Visites / audits / contrôles / études engineering</label>
                                        <label><input type="checkbox" disabled {{ in_array('Travaux d\'entretien des abords de la station', $travail) ? 'checked' : '' }}> Travaux d'entretien</label>
                                        <label><input type="checkbox" disabled {{ in_array('Travaux d\'entretien des abords de la station', $travail) ? 'checked' : '' }}> Travaux d'entretien</label>
                                        <label><input type="checkbox" disabled {{ in_array('Travaux de démolition', $travail) ? 'checked' : '' }}> Travaux de démolition</label>
                                        <label><input type="checkbox" disabled {{ in_array('Intervention sur portique de lavage', $travail) ? 'checked' : '' }}> Intervention sur portique de lavage</label>
                                        <label><input type="checkbox" disabled {{ in_array('Autres1', $travail) ? 'checked' : '' }}> Autres: {{ $work_nature_other['Autres1'] ?? '' }}</label>
                                        <hr><label class="mt-2"><strong><u>SITUATION PARTICULIÈRE</u></strong></label>
                                        <label><input type="checkbox" disabled {{ in_array('Présence de public', $travail) ? 'checked' : '' }}> Présence de public</label>
                                        <label><input type="checkbox" disabled {{ in_array('Espace confiné / fouille', $travail) ? 'checked' : '' }}> Espace confiné / fouille</label>
                                        <label><input type="checkbox" disabled {{ in_array('Travaux en hauteur', $travail) ? 'checked' : '' }}> Travaux en hauteur</label>
                                        <label><input type="checkbox" disabled {{ in_array('Volumes de sécurité', $travail) ? 'checked' : '' }}> Volumes de sécurité</label>
                                        <label><input type="checkbox" disabled {{ in_array('Autres2', $travail) ? 'checked' : '' }}> Autres: {{ $work_nature_other['Autres2'] ?? '' }}</label>
                                        <hr><label class="mt-2"><strong><u>MOYENS / OUTILS</u></strong></label>
                                        <label><input type="checkbox" disabled {{ in_array('Manuel', $travail) ? 'checked' : '' }}> Manuel</label>
                                        <label><input type="checkbox" disabled {{ in_array('Matériel électrique', $travail) ? 'checked' : '' }}> Matériel électrique</label>
                                        <label><input type="checkbox" disabled {{ in_array('Matériel pneumatique', $travail) ? 'checked' : '' }}> Matériel pneumatique</label>
                                        <label><input type="checkbox" disabled {{ in_array('Nacelle', $travail) ? 'checked' : '' }}> Nacelle</label>
                                        <label><input type="checkbox" disabled {{ in_array('PIR / PIRL', $travail) ? 'checked' : '' }}> PIR / PIRL</label>
                                        <label><input type="checkbox" disabled {{ in_array('Grue', $travail) ? 'checked' : '' }}> Grue</label>
                                        <label><input type="checkbox" disabled {{ in_array('Echafaudage', $travail) ? 'checked' : '' }}> Echafaudage</label>
                                        <label><input type="checkbox" disabled {{ in_array('Autres3', $travail) ? 'checked' : '' }}> Autres: {{ $work_nature_other['Autres3'] ?? '' }}</label>
                                    </div>
                                </td>
                                <td>
                                    @php
                                         $risques = json_decode($plans->risk_nature, true) ?? [];
                                         $risk_nature_other = json_decode($plans->risk_nature_other, true) ?? [];
                                    @endphp
                                    <div class="checkbox-list">
                                        <label><input type="checkbox" disabled {{ in_array('Circulation routière', $risques) ? 'checked' : '' }}> Circulation routière</label>
                                        <label><input type="checkbox" disabled {{ in_array('Incendie', $risques) ? 'checked' : '' }}> Incendie</label>
                                        <label><input type="checkbox" disabled {{ in_array('Explosion', $risques) ? 'checked' : '' }}> Explosion</label>
                                        <label><input type="checkbox" disabled {{ in_array('Sources d\'énergie', $risques) ? 'checked' : '' }}> Sources d'énergie</label>
                                        <label><input type="checkbox" disabled {{ in_array('Risques électriques', $risques) ? 'checked' : '' }}> Risques électriques</label>
                                        <label><input type="checkbox" disabled {{ in_array('Risques hydrauliques', $risques) ? 'checked' : '' }}> Risques hydrauliques</label>
                                        <label><input type="checkbox" disabled {{ in_array('Risques liés à la pression', $risques) ? 'checked' : '' }}> Risques liés à la pression</label>
                                        <label><input type="checkbox" disabled {{ in_array('Risques de chute', $risques) ? 'checked' : '' }}> Risques de chute</label>
                                        <label><input type="checkbox" disabled {{ in_array('Eboulement / Écrasement / Ensevelissement', $risques) ? 'checked' : '' }}> Eboulement / Écrasement / Ensevelissement</label>
                                        <label><input type="checkbox" disabled {{ in_array('Asphyxie', $risques) ? 'checked' : '' }}> Asphyxie</label>
                                        <label><input type="checkbox" disabled {{ in_array('Coupure, brûlure, choc…', $risques) ? 'checked' : '' }}> Coupure, brûlure, choc…</label>
                                        <label><input type="checkbox" disabled {{ in_array('Bruit', $risques) ? 'checked' : '' }}> Bruit</label>
                                        <label><input type="checkbox" disabled {{ in_array('Risques chimiques', $risques) ? 'checked' : '' }}> Risques chimiques</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Hydrocarbure', $risques) ? 'checked' : '' }}> - Hydrocarbure</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Autres produits', $risques) ? 'checked' : '' }}> - Autres produits</label>
                                        <label><input type="checkbox" disabled {{ in_array('Risque biologique', $risques) ? 'checked' : '' }}> Risque biologique</label>
                                        <label><input type="checkbox" disabled {{ in_array('Risque', $risques) ? 'checked' : '' }}> Risque</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Manipulation de charges', $risques) ? 'checked' : '' }}> - Manipulation de charges</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Contrainte de postures', $risques) ? 'checked' : '' }}> - Contrainte de postures</label>
                                        <label><input type="checkbox" disabled {{ in_array('Risques pour l’environnement :', $risques) ? 'checked' : '' }}> Risques pour l’environnement :</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Pollution air', $risques) ? 'checked' : '' }}> - Pollution air</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Pollution sol', $risques) ? 'checked' : '' }}> - Pollution sol</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Pollution eau', $risques) ? 'checked' : '' }}> - Pollution eau</label>
                                        <label><input type="checkbox" disabled {{ in_array('Autres1', $risques) ? 'checked' : '' }}> Autres: {{ $risk_nature_other['Autres1'] ?? '' }}</label>
                                        <hr><label class="mt-2"><strong><u>DOCUMENTS DISPONIBLES</u></strong></label>
                                        <label><input type="checkbox" disabled {{ in_array('Fiche de Données Sécurité', $risques) ? 'checked' : '' }}> Fiche de Données Sécurité</label>
                                        <label><input type="checkbox" disabled {{ in_array('Document Technique', $risques) ? 'checked' : '' }}> Amiante</label>
                                        <label><input type="checkbox" disabled {{ in_array('Déclaration d’Intention de', $risques) ? 'checked' : '' }}> Commencement de Travaux</label>
                                        <label><input type="checkbox" disabled {{ in_array('Plans de réseaux', $risques) ? 'checked' : '' }}> Plans de réseaux</label>
                                        <label><input type="checkbox" disabled {{ in_array('Certificat de dégazage', $risques) ? 'checked' : '' }}> Certificat de dégazage</label>
                                        <label><input type="checkbox" disabled {{ in_array('Autres2', $risques) ? 'checked' : '' }}> Autres: {{ $risk_nature_other['Autres2'] ?? '' }}</label>
                                    </div>
                                </td>
                                <td>
                                    @php 
                                        $formations = json_decode($plans->training_certifications, true) ?? [];
                                        $training_certifications_other = json_decode($plans->training_certifications_other, true) ?? [];
                                    @endphp
                                    <div class="checkbox-list">
                                        <label><input type="checkbox" disabled {{ in_array('Autorisation de conduite d\'un engin de chantier', $formations) ? 'checked' : '' }}> Autorisation de conduite d'un engin de chantier</label>
                                        <label><input type="checkbox" disabled {{ in_array('Habilitation électrique', $formations) ? 'checked' : '' }}> Habilitation électrique</label>
                                        <label><input type="checkbox" disabled {{ in_array('Autres1', $formations) ? 'checked' : '' }}> Autres: {{ $training_certifications_other['Autres1'] ?? '' }}</label>
                                        <label><input type="checkbox" disabled {{ in_array('Port d’EPI et autres équipements spécifiques :', $formations) ? 'checked' : '' }}> Port d’EPI et autres équipements spécifiques :</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Appareil respiratoire, ventilation forcée', $formations) ? 'checked' : '' }}> - Appareil respiratoire, ventilation forcée</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Harnais, baudrier, filet de sécurité,sangle de retenue', $formations) ? 'checked' : '' }}> - Harnais, baudrier, filet de sécurité, sangle de retenue</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Mise à disposition casqueanti-bruit', $formations) ? 'checked' : '' }}> - Mise à disposition casque anti-bruit</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Aide à la manutention', $formations) ? 'checked' : '' }}> - Aide à la manutention</label>
                                        <label><input type="checkbox" disabled {{ in_array('Autres3', $formations) ? 'checked' : '' }}> Autres: {{ $training_certifications_other['Autres3'] ?? '' }}</label>
                                        <label><input type="checkbox" disabled {{ in_array('Permis spécifique :', $formations) ? 'checked' : '' }}> Permis spécifique :</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Permis de feu', $formations) ? 'checked' : '' }}> - Permis de feu</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Permis delevage', $formations) ? 'checked' : '' }}> - Permis de levage</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Permis de fouille', $formations) ? 'checked' : '' }}> - Permis de fouille</label>
                                        <label><input type="checkbox" disabled {{ in_array('Permis de pénétrer', $formations) ? 'checked' : '' }}>Permis de pénétrer</label>
                                        <label><input type="checkbox" disabled {{ in_array('Permis de pénétrer', $formations) ? 'checked' : '' }}>Permis de pénétrer</label>
                                        <label><input type="checkbox" disabled {{ in_array('Autres4', $formations) ? 'checked' : '' }}> Autres: {{ $training_certifications_other['Autres4'] ?? '' }}</label>
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
                        VALIDATION
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- ENTREPRISE(S) EXTÉRIEURE(S) INTERVENANTE(S) -->
                            <div class="col-md-6">
                                <h6>ENTREPRISE(S) EXTÉRIEURE(S) INTERVENANTE(S)</h6>
                                @php $index = 1; @endphp
                                @forelse(json_decode($plans->avant_entreprise, true) as $entreprise)
                                    <p class="mb-2"><strong>{{ $index }}- Nom:</strong> {{ $entreprise['name'] }}</p>
                                    @php $index++; @endphp
                                @empty
                                    <p>Aucune entreprise spécifiée.</p>
                                @endforelse
                            </div>

                            <!-- RESPONSABLE DE LA STATION OU SON REPRÉSENTANT -->
                            <div class="col-md-6">
                                <h6>Responsable de l'entreprise utilisatrice ou son représentant</h6>
                                <h6>Responsable de l'entreprise utilisatrice ou son représentant</h6>
                                <p><strong>Date:</strong> {{ $plans->before_date ? $plans->before_date->format('d/m/Y') : '—' }}</p>
                                <p><strong>Heure:</strong> {{ $plans->before_time ? $plans->before_time->format('H:i') : '—' }}</p>
                                <p><strong>Nom:</strong> {{ $plans->before_responsible_name ?? '—' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header text-black text-center font-weight-bold rounded-top">
                        📝 Retour d’expérience de fin de chantier
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header text-black text-center font-weight-bold rounded-top">
                        📝 Retour d’expérience de fin de chantier
                    </div>
                    <div class="card-body bg-light">

                        @php
                            $fields = [
                                'informations_identifiees' => "🔹 Quelles sont les remontées d'information identifiées lors de notre chantier ?",
                                'situations_dangereuses' => "⚠️ Ya t il eu des situations dangereuses, presque accidents et accidents ?",
                                'resultats_sante' => "🩺 Les résultats des mesurages liés à la santé des travailleurs",
                                'impacts_environnement' => "🌱 Quels sont les impacts sur l’environnement en cas de non respect du tri des déchets ?",
                                'sous_traitants' => "👷‍♂️ Ya t il eu des sous-traitants ou du personnel d’appoint ?",
                                'audit_constats' => "🔍 Ya t il eu des constats suite à un audit SSE, visite ou contrôle ?",
                                'modifications_conditions' => "⚙️ Ya t il eu des modifications des conditions opératoires ?",
                                'points_ameliorer' => "📌 Points positifs / à améliorer",
                                'analyses_risques' => "🛠️ Analyses des risques et modes opératoires efficaces ?",
                                'faits_marquants' => "⭐ Ya t il eu des faits marquants ?
                                        merci de decrire en quelques mots les principaux faits,
                                           marquants: visite positive du client, adaptation du mode operatoire suite à modificatio etc.",
                                'travail_prescrit' => "⭐ Ya til eu des écarts entre la préparation (travail prescrit) et la réalisation (travail réel)
                                        Quelle nalyse en fait vous? (merci de decrire l'impact potentiel sur la prestation)",
                            ];
                        @endphp

                        @foreach($fields as $key => $label)
                            <div class="mb-3 p-3 bg-white rounded shadow-sm border-left border-primary">
                                <h6 class="font-weight-bold text-primary mb-2">{{ $label }}</h6>
                                <p class="mb-0 text-muted">
                                    {{ $plans->$key ?? '— Non renseigné —' }}
                                </p>
                    <div class="card-body bg-light">

                        @php
                            $fields = [
                                'informations_identifiees' => "🔹 Quelles sont les remontées d'information identifiées lors de notre chantier ?",
                                'situations_dangereuses' => "⚠️ Ya t il eu des situations dangereuses, presque accidents et accidents ?",
                                'resultats_sante' => "🩺 Les résultats des mesurages liés à la santé des travailleurs",
                                'impacts_environnement' => "🌱 Quels sont les impacts sur l’environnement en cas de non respect du tri des déchets ?",
                                'sous_traitants' => "👷‍♂️ Ya t il eu des sous-traitants ou du personnel d’appoint ?",
                                'audit_constats' => "🔍 Ya t il eu des constats suite à un audit SSE, visite ou contrôle ?",
                                'modifications_conditions' => "⚙️ Ya t il eu des modifications des conditions opératoires ?",
                                'points_ameliorer' => "📌 Points positifs / à améliorer",
                                'analyses_risques' => "🛠️ Analyses des risques et modes opératoires efficaces ?",
                                'faits_marquants' => "⭐ Ya t il eu des faits marquants ?
                                        merci de decrire en quelques mots les principaux faits,
                                           marquants: visite positive du client, adaptation du mode operatoire suite à modificatio etc.",
                                'travail_prescrit' => "⭐ Ya til eu des écarts entre la préparation (travail prescrit) et la réalisation (travail réel)
                                        Quelle nalyse en fait vous? (merci de decrire l'impact potentiel sur la prestation)",
                            ];
                        @endphp

                        @foreach($fields as $key => $label)
                            <div class="mb-3 p-3 bg-white rounded shadow-sm border-left border-primary">
                                <h6 class="font-weight-bold text-primary mb-2">{{ $label }}</h6>
                                <p class="mb-0 text-muted">
                                    {{ $plans->$key ?? '— Non renseigné —' }}
                                </p>
                            </div>
                        @endforeach

                        @endforeach

                    </div>
                </div>



                <a href="{{ route('plan.index') }}" class="btn btn-primary">Back to List</a>
            </div>
        </div>
    </div>
</x-app-layout>
