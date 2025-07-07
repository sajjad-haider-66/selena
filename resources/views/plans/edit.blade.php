<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit - Plan') }}
        </h2>
    </x-slot>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="card-header text-black d-flex justify-content-between align-items-center">
                <h4>Plan</h4>
            </div>
            <form method="POST" action="{{ route('plan.update', $plan) }}">
                @csrf
                @method('PUT')

                <!-- N° A & Date -->
                <div class="form-section">
                    <table class="table table-bordered">
                        <tr>
                            <td style="width:20%"><label for="plan_number">N° A</label></td>
                            <td style="width:30%"><input type="text" name="plan_number" id="plan_number" value="{{ old('plan_number', $plan->plan_number) }}" required></td>
                            <td style="width:20%"><label for="work_date">DATE des travaux</label></td>
                            <td style="width:30%"><input type="date" name="work_date" id="work_date" value="{{ old('work_date', $plan->work_date ? $plan->work_date->format('Y-m-d') : '') }}" required></td>
                        </tr>
                    </table>
                </div>

                <!-- Entreprises -->
                <div class="form-section">
                    <h4>Nom de l'Entreprise</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Extérieure</th>
                                <th>Entreprise principale</th>
                                <th>Entreprise sous-traitante</th>
                                <th>Nom de l'intervenant</th>
                            </tr>
                        </thead>
                        <tbody id="company-body">
                            @php $i = 0; @endphp
                            @foreach (json_decode($plan->company_name_detail, true) as $index => $company)
                                <tr>
                                    <td><input type="text" name="external_company[{{ $i }}]" class="form-control" value="{{ $company['external_company'] }}"></td>
                                    <td><input type="text" name="main_company[{{ $i }}]" class="form-control" value="{{ $company['main_company'] }}"></td>
                                    <td><input type="text" name="subcontractor[{{ $i }}]" class="form-control" value="{{ $company['subcontractor'] }}"></td>
                                    <td><input type="text" name="intervenant[{{ $i }}]" class="form-control" value="{{ $company['intervenant'] }}"></td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-company" {{ $i == 0 ? 'disabled' : '' }}>Remove</button>
                                    </td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach

                            @if (empty($plan->company_name_detail))
                                <tr>
                                    <td><input type="text" name="external_company[0]" class="form-control"></td>
                                    <td><input type="text" name="main_company[0]" class="form-control"></td>
                                    <td><input type="text" name="subcontractor[0]" class="form-control"></td>
                                    <td><input type="text" name="intervenant[0]" class="form-control"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm remove-company" disabled>Remove</button></td>
                                </tr>
                                @php $i = 1; @endphp
                            @endif
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <button type="button" id="add-company-name" class="btn btn-outline-dark btn-sm">Add More</button>
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
                            <td><input type="text" name="location" value="{{ old('location', $plan->location) }}"></td>
                            <td>Début d'intervention :</td>
                            <td><input type="time" name="start_time" value="{{ old('start_time', $plan->start_time ? $plan->start_time->format('H:i') : '') }}"></td>
                        </tr>
                        <tr>
                            <td>Description :</td>
                            <td colspan="3"><textarea name="description">{{ old('description', $plan->description) }}</textarea></td>
                        </tr>
                        <tr>
                            <td>N° mode opératoire :</td>
                            <td><input type="text" name="operative_mode_number" value="{{ old('operative_mode_number', $plan->operative_mode_number) }}"></td>
                            <td>Fin d'intervention prévue :</td>
                            <td><input type="time" name="end_time" value="{{ old('end_time', $plan->end_time ? $plan->end_time->format('H:i') : '') }}"></td>
                        </tr>
                    </table>
                </div>

                <!-- Risques d'interférence -->
                <div class="form-section">
                    <h4>RISQUES D'INTERFÉRENCE AVEC L'OPÉRATION</h4>
                    <table class="table table-bordered">
                        <tr>
                            <td>Dépotage prévu à :</td>
                            <td><input type="time" name="depotage_time" value="{{ old('depotage_time', $plan->depotage_time ? $plan->depotage_time->format('H:i') : '') }}"></td>
                        </tr>
                        <tr>
                            <td>Présence dans la zone de Travail de :</td>
                            <td><input type="text" name="presence_zone" placeholder="bouteilles de gaz, fûts…" value="{{ old('presence_zone', $plan->presence_zone) }}"></td>
                        </tr>
                        <tr>
                            <td>Autres travaux prévus ce jour :</td>
                            <td><textarea name="other_works">{{ old('other_works', $plan->other_works) }}</textarea></td>
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
                                    @php 
                                        $travail = old('travail', json_decode($plan->work_nature, true) ?? []);
                                        $work_nature_other = old('work_nature_other', json_decode($plan->work_nature_other, true) ?? []);
                                    @endphp
                                    <div class="checkbox-list">
                                        <label><input type="checkbox" name="travail[]" value="Travaux sur appareil de distribution" {{ in_array('Travaux sur appareil de distribution', $travail) ? 'checked' : '' }}> Travaux sur appareil de distribution</label>
                                        <label><input type="checkbox" name="travail[]" value="Nettoyage de la piste" {{ in_array('Nettoyage de la piste', $travail) ? 'checked' : '' }}> Nettoyage de la piste</label>
                                        <label><input type="checkbox" name="travail[]" value="Travaux sur équipements électriques" {{ in_array('Travaux sur équipements électriques', $travail) ? 'checked' : '' }}> Travaux sur équipements électriques</label>
                                        <label><input type="checkbox" name="travail[]" value="Travaux de plomberie" {{ in_array('Travaux de plomberie', $travail) ? 'checked' : '' }}> Travaux de plomberie</label>
                                        <label><input type="checkbox" name="travail[]" value="Travaux de peinture" {{ in_array('Travaux de peinture', $travail) ? 'checked' : '' }}> Travaux de peinture</label>
                                        <label><input type="checkbox" name="travail[]" value="Perçage, meulage, découpage, soudage, décapage" {{ in_array('Perçage, meulage, découpage, soudage, décapage', $travail) ? 'checked' : '' }}> Perçage, meulage, découpage, soudage, décapage</label>
                                        <label><input type="checkbox" name="travail[]" value="Levage" {{ in_array('Levage', $travail) ? 'checked' : '' }}> Levage</label>
                                        <label><input type="checkbox" name="travail[]" value="Travaux sur tuyauterie" {{ in_array('Travaux sur tuyauterie', $travail) ? 'checked' : '' }}> Travaux sur tuyauterie</label>
                                        <label><input type="checkbox" name="travail[]" value="Vidange/dégazage/nettoyage cuve hydrocarbures" {{ in_array('Vidange/dégazage/nettoyage cuve hydrocarbures', $travail) ? 'checked' : '' }}> Vidange/dégazage/nettoyage cuve hydrocarbures</label>
                                        <label><input type="checkbox" name="travail[]" value="Vidange/dégazage/brûlage/nettoyage cuve GPLC" {{ in_array('Vidange/dégazage/brûlage/nettoyage cuve GPLC', $travail) ? 'checked' : '' }}> Vidange/dégazage/brûlage/nettoyage cuve GPLC</label>
                                        <label><input type="checkbox" name="travail[]" value="Ré-épreuve cuve" {{ in_array('Ré-épreuve cuve', $travail) ? 'checked' : '' }}> Ré-épreuve cuve</label>
                                        <label><input type="checkbox" name="travail[]" value="Fouille / terrassement" {{ in_array('Fouille / terrassement', $travail) ? 'checked' : '' }}> Fouille / terrassement</label>
                                        <label><input type="checkbox" name="travail[]" value="Forage" {{ in_array('Forage', $travail) ? 'checked' : '' }}> Forage</label>
                                        <label><input type="checkbox" name="travail[]" value="Visites / audits / contrôles / études engineering" {{ in_array('Visites / audits / contrôles / études engineering', $travail) ? 'checked' : '' }}> Visites / audits / contrôles / études engineering</label>
                                        <label><input type="checkbox" name="travail[]" value="Travaux d'entretien des abords de la station" {{ in_array('Travaux dentretien des abords de la station', $travail) ? 'checked' : '' }}> Travaux d'entretien des abords de la station</label>
                                        <label><input type="checkbox" name="travail[]" value="Travaux de démolition" {{ in_array('Travaux de démolition', $travail) ? 'checked' : '' }}> Travaux de démolition</label>
                                        <label><input type="checkbox" name="travail[]" value="Intervention sur portique de lavage" {{ in_array('Intervention sur portique de lavage', $travail) ? 'checked' : '' }}> Intervention sur portique de lavage</label>
                                        <label><input type="checkbox" name="travail[]" value="Autres1" {{ in_array('Autres1', $travail) ? 'checked' : '' }}> Autres <input type="text" name="work_nature_other1" value="{{ old('work_nature_other1', $work_nature_other['Autres1']) }}"></label>
                                        <hr><label class="mt-2"><strong><u>SITUATION PARTICULIÈRE</u></strong></label>
                                        <label><input type="checkbox" name="travail[]" value="Présence de public" {{ in_array('Présence de public', $travail) ? 'checked' : '' }}> Présence de public</label>
                                        <label><input type="checkbox" name="travail[]" value="Espace confiné / fouille" {{ in_array('Espace confiné / fouille', $travail) ? 'checked' : '' }}> Espace confiné / fouille</label>
                                        <label><input type="checkbox" name="travail[]" value="Travaux en hauteur" {{ in_array('Travaux en hauteur', $travail) ? 'checked' : '' }}> Travaux en hauteur</label>
                                        <label><input type="checkbox" name="travail[]" value="Volumes de sécurité" {{ in_array('Volumes de sécurité', $travail) ? 'checked' : '' }}> Volumes de sécurité</label>
                                        <label><input type="checkbox" name="travail[]" value="Autres2" {{ in_array('Autres2', $travail) ? 'checked' : '' }}> Autres (précisez) : <input type="text" name="work_nature_other2" value="{{ old('work_nature_other2', $work_nature_other['Autres2']) }}"></label>
                                        <hr><label class="mt-2"><strong><u>MOYENS / OUTILS</u></strong></label>
                                        <label><input type="checkbox" name="travail[]" value="Manuel" {{ in_array('Manuel', $travail) ? 'checked' : '' }}> Manuel</label>
                                        <label><input type="checkbox" name="travail[]" value="Matériel électrique" {{ in_array('Matériel électrique', $travail) ? 'checked' : '' }}> Matériel électrique</label>
                                        <label><input type="checkbox" name="travail[]" value="Matériel pneumatique" {{ in_array('Matériel pneumatique', $travail) ? 'checked' : '' }}> Matériel pneumatique</label>
                                        <label><input type="checkbox" name="travail[]" value="Nacelle" {{ in_array('Nacelle', $travail) ? 'checked' : '' }}> Nacelle</label>
                                        <label><input type="checkbox" name="travail[]" value="PIR / PIRL" {{ in_array('PIR / PIRL', $travail) ? 'checked' : '' }}> PIR / PIRL</label>
                                        <label><input type="checkbox" name="travail[]" value="Grue" {{ in_array('Grue', $travail) ? 'checked' : '' }}> Grue</label>
                                        <label><input type="checkbox" name="travail[]" value="Echafaudage" {{ in_array('Echafaudage', $travail) ? 'checked' : '' }}> Echafaudage</label>
                                        <label><input type="checkbox" name="travail[]" value="Autres3" {{ in_array('Autres3', $travail) ? 'checked' : '' }}> Autres (précisez) : <input type="text" name="work_nature_other3" value="{{ old('work_nature_other3', $work_nature_other['Autres3']) }}"></label>
                                    </div>
                                </td>
                                <td>
                                    @php
                                         $risques = old('risques', json_decode($plan->risk_nature, true) ?? []);
                                         $risk_nature_other = old('risk_nature_other', json_decode($plan->risk_nature_other, true) ?? []);
                                    @endphp
                                    <div class="checkbox-list">
                                        <label><input type="checkbox" name="risques[]" value="Circulation routière" {{ in_array('Circulation routière', $risques) ? 'checked' : '' }}> Circulation routière</label>
                                        <label><input type="checkbox" name="risques[]" value="Incendie" {{ in_array('Incendie', $risques) ? 'checked' : '' }}> Incendie</label>
                                        <label><input type="checkbox" name="risques[]" value="Explosion" {{ in_array('Explosion', $risques) ? 'checked' : '' }}> Explosion</label>
                                        <label><input type="checkbox" name="risques[]" value="Sources d'énergie" {{ in_array('Sources dénergie', $risques) ? 'checked' : '' }}> Sources d'énergie</label>
                                        <label><input type="checkbox" name="risques[]" value="Risques électriques" {{ in_array('Risques électriques', $risques) ? 'checked' : '' }}> Risques électriques</label>
                                        <label><input type="checkbox" name="risques[]" value="Risques hydrauliques" {{ in_array('Risques hydrauliques', $risques) ? 'checked' : '' }}> Risques hydrauliques</label>
                                        <label><input type="checkbox" name="risques[]" value="Risques liés à la pression" {{ in_array('Risques liés à la pression', $risques) ? 'checked' : '' }}> Risques liés à la pression</label>
                                        <label><input type="checkbox" name="risques[]" value="Risques de chute" {{ in_array('Risques de chute', $risques) ? 'checked' : '' }}> Risques de chute</label>
                                        <label><input type="checkbox" name="risques[]" value="Eboulement / Écrasement / Ensevelissement" {{ in_array('Eboulement / Écrasement / Ensevelissement', $risques) ? 'checked' : '' }}> Eboulement / Écrasement / Ensevelissement</label>
                                        <label><input type="checkbox" name="risques[]" value="Asphyxie" {{ in_array('Asphyxie', $risques) ? 'checked' : '' }}> Asphyxie</label>
                                        <label><input type="checkbox" name="risques[]" value="Coupure, brûlure, choc…" {{ in_array('Coupure, brûlure, choc…', $risques) ? 'checked' : '' }}> Coupure, brûlure, choc…</label>
                                        <label><input type="checkbox" name="risques[]" value="Bruit" {{ in_array('Bruit', $risques) ? 'checked' : '' }}> Bruit</label>
                                        <label><input type="checkbox" name="risques[]" value="Risques chimiques" {{ in_array('Risques chimiques', $risques) ? 'checked' : '' }}> Risques chimiques</label>
                                        <label><input type="checkbox" name="risques[]" value="- Hydrocarbure" {{ in_array('- Hydrocarbure', $risques) ? 'checked' : '' }}> - Hydrocarbure</label>
                                        <label><input type="checkbox" name="risques[]" value="- GPLC / GNC / GNL" {{ in_array('- GPLC / GNC / GNL', $risques) ? 'checked' : '' }}> - GPLC / GNC / GNL</label>
                                        <label><input type="checkbox" name="risques[]" value="- Autres produits" {{ in_array('- Autres produits', $risques) ? 'checked' : '' }}> - Autres produits</label>
                                        <label><input type="checkbox" name="risques[]" value="Risque biologique" {{ in_array('Risque biologique', $risques) ? 'checked' : '' }}> Risque biologique</label>
                                        <label><input type="checkbox" name="risques[]" value="Risque" {{ in_array('Risque', $risques) ? 'checked' : '' }}> Risque</label>
                                        <label><input type="checkbox" name="risques[]" value="- Manipulation de charges" {{ in_array('- Manipulation de charges', $risques) ? 'checked' : '' }}> - Manipulation de charges</label>
                                        <label><input type="checkbox" name="risques[]" value="- Contrainte de postures" {{ in_array('- Contrainte de postures', $risques) ? 'checked' : '' }}> - Contrainte de postures</label>
                                        <label><input type="checkbox" name="risques[]" value="Risques pour l’environnement :" {{ in_array('Risques pour l’environnement :', $risques) ? 'checked' : '' }}> Risques pour l’environnement :</label>
                                        <label><input type="checkbox" name="risques[]" value="- Pollution air" {{ in_array('- Pollution air', $risques) ? 'checked' : '' }}> - Pollution air</label>
                                        <label><input type="checkbox" name="risques[]" value="- Pollution sol" {{ in_array('- Pollution sol', $risques) ? 'checked' : '' }}> - Pollution sol</label>
                                        <label><input type="checkbox" name="risques[]" value="- Pollution eau" {{ in_array('- Pollution eau', $risques) ? 'checked' : '' }}> - Pollution eau</label>
                                        <label><input type="checkbox" name="risques[]" value="Autres1" {{ in_array('Autres1', $risques) ? 'checked' : '' }}> Autres <input type="text" name="risk_nature_other1" value="{{ old('risk_nature_other1', $risk_nature_other['Autres1']) }}"></label>
                                        <hr><label class="mt-2"><strong><u>DOCUMENTS DISPONIBLES</u></strong></label>
                                        <label><input type="checkbox" name="risques[]" value="Fiche de Données Sécurité" {{ in_array('Fiche de Données Sécurité', $risques) ? 'checked' : '' }}> Fiche de Données Sécurité</label>
                                        <label><input type="checkbox" name="risques[]" value="Document Technique" {{ in_array('Document Technique', $risques) ? 'checked' : '' }}> Amiante</label>
                                        <label><input type="checkbox" name="risques[]" value="Déclaration d’Intention de" {{ in_array('Déclaration d’Intention de', $risques) ? 'checked' : '' }}> Commencement de Travaux</label>
                                        <label><input type="checkbox" name="risques[]" value="Plans de réseaux" {{ in_array('Plans de réseaux', $risques) ? 'checked' : '' }}> Plans de réseaux</label>
                                        <label><input type="checkbox" name="risques[]" value="Certificat de dégazage" {{ in_array('Certificat de dégazage', $risques) ? 'checked' : '' }}> Certificat de dégazage</label>
                                        <label><input type="checkbox" name="risques[]" value="Autres2" {{ in_array('Autres2', $risques) ? 'checked' : '' }}> Autres <input type="text" name="risk_nature_other2" value="{{ old('risk_nature_other2', $risk_nature_other['Autres2']) }}"></label>
                                    </div>
                                </td>
                                <td>
                                    @php 
                                        $formations = old('formations', json_decode($plan->training_certifications, true) ?? []);
                                        $training_certifications_other = old('training_certifications_other', json_decode($plan->training_certifications_other, true) ?? []);
                                    @endphp
                                    <div class="checkbox-list">
                                        <label><input type="checkbox" name="formations[]" value="Autorisation de conduite d'un engin de chantier" {{ in_array("Autorisation de conduite d'un engin de chantier", $formations) ? 'checked' : '' }}> Autorisation de conduite d'un engin de chantier</label>
                                        <label><input type="checkbox" name="formations[]" value="Habilitation électrique" {{ in_array('Habilitation électrique', $formations) ? 'checked' : '' }}> Habilitation électrique</label>
                                        <label><input type="checkbox" name="formations[]" value="Autres3" {{ in_array('Autres1', $formations) ? 'checked' : '' }}> Autres <input type="text" name="training_certifications_other1" value="{{ old('training_certifications_other3', $training_certifications_other['Autres3']) }}"></label>
                                        <div class="font-weight-bold">
                                            <u><b>MESURES PRÉVENTIVES</b></u>
                                        </div>
                                        <label>
                                            <input type="checkbox" name="formations[]" value="Arrêt de la distribution : partiel"
                                                {{ in_array('Arrêt de la distribution : partiel', $formations) ? 'checked' : '' }}>
                                            Arrêt de la distribution : partiel
                                        </label>

                                        <label>
                                            <input type="checkbox" name="formations[]" value="Arrêt de la distribution : total"
                                                {{ in_array('Arrêt de la distribution : total', $formations) ? 'checked' : '' }}>
                                            Arrêt de la distribution : total
                                        </label>

                                        <label>
                                            <input type="checkbox" name="formations[]" value="Fermeture de la station"
                                                {{ in_array('Fermeture de la station', $formations) ? 'checked' : '' }}>
                                            Fermeture de la station
                                        </label>

                                        <label>
                                            <input type="checkbox" name="formations[]" value="Arrêt d'une autre activité"
                                                {{ in_array("Arrêt d'une autre activité", $formations) ? 'checked' : '' }}>
                                            Arrêt d'une autre activité
                                            <input type="text" name="formations_autre" class="form-control mt-1" value="{{ $training_certifications_other['Autres2'] ?? '' }}" placeholder="Précisez ici...">
                                        </label>

                                        <hr>

                                        <label>
                                            <input type="checkbox" name="formations[]" value="Arrêt des travaux pendant le dépotage"
                                                {{ in_array('Arrêt des travaux pendant le dépotage', $formations) ? 'checked' : '' }}>
                                            Arrêt des travaux pendant le dépotage
                                        </label>

                                        <label>
                                            <input type="checkbox" name="formations[]" value="Repérage physique préalable des réseaux enterrés"
                                                {{ in_array('Repérage physique préalable des réseaux enterrés', $formations) ? 'checked' : '' }}>
                                            Repérage physique préalable des réseaux enterrés
                                        </label>

                                        <label>
                                            <input type="checkbox" name="formations[]" value="Mise à la terre des équipements et test"
                                                {{ in_array('Mise à la terre des équipements et test', $formations) ? 'checked' : '' }}>
                                            Mise à la terre des équipements et test
                                        </label>

                                        <label>
                                            <input type="checkbox" name="formations[]" value="Surveillance permanente par un 2ème intervenant"
                                                {{ in_array('Surveillance permanente par un 2ème intervenant', $formations) ? 'checked' : '' }}>
                                            Surveillance permanente par un 2ème intervenant
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- VALIDATION AVANT LES TRAVAUX -->
                <div class="card mb-4">
                    <div class="text-center card-header font-weight-bold">
                        VALIDATION AVANT LES TRAVAUX
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- ENTREPRISE(S) EXTÉRIEURE(S) INTERVENANTE(S) -->
                            <div class="col-md-6">
                                <h6>ENTREPRISE(S) EXTÉRIEURE(S) INTERVENANTE(S)</h6>
                                <div id="nom-container">
                                    @php $index = 1; @endphp
                                    @forelse(json_decode($plan->avant_entreprise, true) as $entreprise)
                                 
                                        <div class="form-group nom-group mt-2">
                                            <label>{{ $index }}- Nom:</label>
                                            <div class="d-flex">
                                                <input type="text" name="avant_entreprise[]" class="form-control me-2" value="{{ $entreprise['name'] }}">
                                                <button type="button" class="btn btn-danger btn-sm remove-nom {{ $index == 1 ? 'd-none' : '' }}">Remove</button>
                                            </div>
                                        </div>
                                        @php $index++; @endphp
                                    @empty
                                        <div class="form-group nom-group mt-2">
                                            <label>1- Nom:</label>
                                            <div class="d-flex">
                                                <input type="text" name="avant_entreprise[]" class="form-control me-2">
                                                <button type="button" class="btn btn-danger btn-sm remove-nom d-none">Remove</button>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>

                                <div class="form-group mt-2">
                                    <button type="button" id="add-nom" class="btn btn-outline-dark btn-sm">Add More</button>
                                </div>
                            </div>

                            <!-- RESPONSABLE DE LA STATION OU SON REPRÉSENTANT -->
                            <div class="col-md-6">
                                <h6>RESPONSABLE DE LA STATION OU SON REPRÉSENTANT</h6>
                                <div class="form-group">
                                    <label>Date :</label>
                                    <input type="date" name="before_date" class="form-control" value="{{ old('before_date', $plan->before_date ? $plan->before_date->format('Y-m-d') : '') }}">
                                </div>
                                <div class="form-group">
                                    <label>Heure :</label>
                                    <input type="time" name="before_time" class="form-control" value="{{ old('before_time', $plan->before_time ? $plan->before_time->format('H:i') : '') }}">
                                </div>
                                <div class="form-group">
                                    <label>Nom :</label>
                                    <input type="text" name="before_responsible_name" class="form-control" value="{{ old('before_responsible_name', $plan->before_responsible_name) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- VALIDATION APRÈS LES TRAVAUX -->
                <div class="card mb-4">
                    <div class="text-center card-header font-weight-bold">
                        VALIDATION APRÈS LES TRAVAUX
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="apres_travail_termine" id="apres_travail_termine" {{ old('apres_travail_termine', $plan->work_completed) ? 'checked' : '' }}>
                            <label class="form-check-label" for="apres_travail_termine">
                                Le travail est terminé
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="apres_travail_non_termine" id="apres_travail_non_termine" {{ old('apres_travail_non_termine', $plan->work_not_completed) ? 'checked' : '' }}>
                            <label class="form-check-label" for="apres_travail_non_termine">
                                Le travail n'est pas terminé
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="apres_station_normale" id="apres_station_normale" {{ old('apres_station_normale', $plan->station_normal) ? 'checked' : '' }}>
                            <label class="form-check-label" for="apres_station_normale">
                                La station est rendue à une exploitation normale
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="apres_chantier_propre" id="apres_chantier_propre" {{ old('apres_chantier_propre', $plan->site_clean_safe) ? 'checked' : '' }}>
                            <label class="form-check-label" for="apres_chantier_propre">
                                Le chantier a été propre et en sécurité, la reprise du travail fera l’objet d’une nouvelle autorisation de travail prévue le :
                            </label>
                            <input type="date" name="new_authorization_date" class="form-control mt-2" style="width:auto;" value="{{ old('new_authorization_date', $plan->new_authorization_date ? $plan->new_authorization_date->format('Y-m-d') : '') }}">
                        </div>

                        <div class="row">
                            <!-- ENTREPRISE(S) EXTÉRIEURE(S) INTERVENANTE(S) -->
                        <div class="col-md-6">
                            <h6>ENTREPRISE(S) EXTÉRIEURE(S) INTERVENANTE(S)</h6>
                            <div id="apres-container">
                                @foreach (json_decode($plan->company_nom_date, true) as $index => $entreprise)
                                    <div class="form-group apres-group mt-2">
                                        <label>{{ $index + 1 }}. Nom:</label>
                                        <input type="text" name="apres_entreprise_nom[]" class="form-control"
                                            value="{{ $entreprise['name'] ?? '' }}">

                                        <label>Date:</label>
                                        <input type="date" name="apres_entreprise_date[]" class="form-control"
                                            value="{{ $entreprise['date'] ?? '' }}">

                                        @if($index > 0)
                                            <button type="button" class="btn btn-danger btn-sm mt-2 remove-apres">Remove</button>
                                        @else
                                            <button type="button" class="btn btn-danger btn-sm mt-2 remove-apres d-none">Remove</button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group mt-2">
                                <button type="button" id="add-apres" class="btn btn-outline-dark btn-sm">Add More</button>
                            </div>
                        </div>

                            <!-- RESPONSABLE DE LA STATION (OU SON REPRÉSENTANT) -->
                            <div class="col-md-6">
                                <h6>RESPONSABLE DE LA STATION (OU SON REPRÉSENTANT)</h6>
                                <div class="form-group">
                                    <label>Date :</label>
                                    <input type="date" name="after_responsible_date" class="form-control" value="{{ old('after_responsible_date', $plan->after_responsible_date ? $plan->after_responsible_date->format('Y-m-d') : '') }}">
                                </div>
                                <div class="form-group">
                                    <label>Heure :</label>
                                    <input type="time" name="after_responsible_time" class="form-control" value="{{ old('after_responsible_time', $plan->after_responsible_time ? $plan->after_responsible_time->format('H:i') : '') }}">
                                </div>
                                <div class="form-group">
                                    <label>Nom :</label>
                                    <input type="text" name="after_responsible_name" class="form-control" value="{{ old('after_responsible_name', $plan->after_responsible_name) }}">
                                </div>
                            </div>
                        </div>
                    </div>
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
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let nomIndex = {{ isset($index) ? $index : 2 }};

$('#add-nom').on('click', function () {
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

$(document).on('click', '.remove-nom', function () {
    $(this).closest('.nom-group').remove();
});
    let apresIndex = {{ count(json_decode($plan->company_nom_date, true)) + 1 }};

    $('#add-apres').on('click', function () {
        let newInput = `
            <div class="form-group apres-group mt-2">
                <label>${apresIndex}. Nom:</label>
                <input type="text" name="apres_entreprise_nom[]" class="form-control">
                <label>Date:</label>
                <input type="date" name="apres_entreprise_date[]" class="form-control">
                <button type="button" class="btn btn-danger btn-sm mt-2 remove-apres">Remove</button>
            </div>
        `;
        $('#apres-container').append(newInput);
        apresIndex++;
    });

    $(document).on('click', '.remove-apres', function () {
        $(this).closest('.apres-group').remove();
    });

    let companyIndex = {{ $i ?? 1 }};

    $('#add-company-name').on('click', function () {
        let newRow = `
            <tr>
                <td><input type="text" name="external_company[${companyIndex}]" class="form-control"></td>
                <td><input type="text" name="main_company[${companyIndex}]" class="form-control"></td>
                <td><input type="text" name="subcontractor[${companyIndex}]" class="form-control"></td>
                <td><input type="text" name="intervenant[${companyIndex}]" class="form-control"></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-company">Remove</button></td>
            </tr>
        `;
        $('#company-body').append(newRow);
        companyIndex++;
    });

    $(document).on('click', '.remove-company', function () {
        $(this).closest('tr').remove();
    });

</script>
</x-app-layout>
