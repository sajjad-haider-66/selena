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
                        <tbody>
                            <tr>
                                <td><input type="text" name="external_company_1" value="{{ old('external_company_1', $plan->external_company_1) }}"></td>
                                <td><input type="text" name="main_company_1" value="{{ old('main_company_1', $plan->main_company_1) }}"></td>
                                <td><input type="text" name="subcontractor_1" value="{{ old('subcontractor_1', $plan->subcontractor_1) }}"></td>
                                <td><input type="text" name="intervenant_1" value="{{ old('intervenant_1', $plan->intervenant_1) }}"></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="external_company_2" value="{{ old('external_company_2', $plan->external_company_2) }}"></td>
                                <td><input type="text" name="main_company_2" value="{{ old('main_company_2', $plan->main_company_2) }}"></td>
                                <td><input type="text" name="subcontractor_2" value="{{ old('subcontractor_2', $plan->subcontractor_2) }}"></td>
                                <td><input type="text" name="intervenant_2" value="{{ old('intervenant_2', $plan->intervenant_2) }}"></td>
                            </tr>
                        </tbody>
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
                                    @php $travail = old('travail', json_decode($plan->work_nature, true) ?? []) @endphp
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
                                        <label><input type="checkbox" name="travail[]" value="Autres" {{ in_array('Autres', $travail) ? 'checked' : '' }}> Autres <input type="text" name="work_nature_other" value="{{ old('work_nature_other', $plan->work_nature_other) }}"></label>
                                        <hr><label class="mt-2"><strong><u>SITUATION PARTICULIÈRE</u></strong></label>
                                        <label><input type="checkbox" name="travail[]" value="Présence de public" {{ in_array('Présence de public', $travail) ? 'checked' : '' }}> Présence de public</label>
                                        <label><input type="checkbox" name="travail[]" value="Espace confiné / fouille" {{ in_array('Espace confiné / fouille', $travail) ? 'checked' : '' }}> Espace confiné / fouille</label>
                                        <label><input type="checkbox" name="travail[]" value="Travaux en hauteur" {{ in_array('Travaux en hauteur', $travail) ? 'checked' : '' }}> Travaux en hauteur</label>
                                        <label><input type="checkbox" name="travail[]" value="Volumes de sécurité" {{ in_array('Volumes de sécurité', $travail) ? 'checked' : '' }}> Volumes de sécurité</label>
                                        <label><input type="checkbox" name="travail[]" value="Autres" {{ in_array('Autres', $travail) ? 'checked' : '' }}> Autres (précisez) : <input type="text" name="work_nature_other" value="{{ old('work_nature_other', $plan->work_nature_other) }}"></label>
                                        <hr><label class="mt-2"><strong><u>MOYENS / OUTILS</u></strong></label>
                                        <label><input type="checkbox" name="travail[]" value="Manuel" {{ in_array('Manuel', $travail) ? 'checked' : '' }}> Manuel</label>
                                        <label><input type="checkbox" name="travail[]" value="Matériel électrique" {{ in_array('Matériel électrique', $travail) ? 'checked' : '' }}> Matériel électrique</label>
                                        <label><input type="checkbox" name="travail[]" value="Matériel pneumatique" {{ in_array('Matériel pneumatique', $travail) ? 'checked' : '' }}> Matériel pneumatique</label>
                                        <label><input type="checkbox" name="travail[]" value="Nacelle" {{ in_array('Nacelle', $travail) ? 'checked' : '' }}> Nacelle</label>
                                        <label><input type="checkbox" name="travail[]" value="PIR / PIRL" {{ in_array('PIR / PIRL', $travail) ? 'checked' : '' }}> PIR / PIRL</label>
                                        <label><input type="checkbox" name="travail[]" value="Grue" {{ in_array('Grue', $travail) ? 'checked' : '' }}> Grue</label>
                                        <label><input type="checkbox" name="travail[]" value="Echafaudage" {{ in_array('Echafaudage', $travail) ? 'checked' : '' }}> Echafaudage</label>
                                        <label><input type="checkbox" name="travail[]" value="Autres" {{ in_array('Autres', $travail) ? 'checked' : '' }}> Autres (précisez) : <input type="text" name="work_nature_other" value="{{ old('work_nature_other', $plan->work_nature_other) }}"></label>
                                    </div>
                                </td>
                                <td>
                                    @php $risques = old('risques', json_decode($plan->risk_nature, true) ?? []) @endphp
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
                                        <label><input type="checkbox" name="risques[]" value="Autres" {{ in_array('Autres', $risques) ? 'checked' : '' }}> Autres <input type="text" name="risk_nature_other" value="{{ old('risk_nature_other', $plan->risk_nature_other) }}"></label>
                                        <hr><label class="mt-2"><strong><u>DOCUMENTS DISPONIBLES</u></strong></label>
                                        <label><input type="checkbox" name="risques[]" value="Fiche de Données Sécurité" {{ in_array('Fiche de Données Sécurité', $risques) ? 'checked' : '' }}> Fiche de Données Sécurité</label>
                                        <label><input type="checkbox" name="risques[]" value="Document Technique" {{ in_array('Document Technique', $risques) ? 'checked' : '' }}> Amiante</label>
                                        <label><input type="checkbox" name="risques[]" value="Déclaration d’Intention de" {{ in_array('Déclaration d’Intention de', $risques) ? 'checked' : '' }}> Commencement de Travaux</label>
                                        <label><input type="checkbox" name="risques[]" value="Plans de réseaux" {{ in_array('Plans de réseaux', $risques) ? 'checked' : '' }}> Plans de réseaux</label>
                                        <label><input type="checkbox" name="risques[]" value="Certificat de dégazage" {{ in_array('Certificat de dégazage', $risques) ? 'checked' : '' }}> Certificat de dégazage</label>
                                        <label><input type="checkbox" name="risques[]" value="Autres" {{ in_array('Autres', $risques) ? 'checked' : '' }}> Autres <input type="text" name="risk_nature_other" value="{{ old('risk_nature_other', $plan->risk_nature_other) }}"></label>
                                    </div>
                                </td>
                                <td>
                                    @php $formations = old('formations', json_decode($plan->training_certifications, true) ?? []) @endphp
                                    <div class="checkbox-list">
                                        <label><input type="checkbox" name="formations[]" value="Autorisation de conduite d'un engin de chantier" {{ in_array('Autorisation de conduite dun engin de chantier', $formations) ? 'checked' : '' }}> Autorisation de conduite d'un engin de chantier</label>
                                        <label><input type="checkbox" name="formations[]" value="Habilitation électrique" {{ in_array('Habilitation électrique', $formations) ? 'checked' : '' }}> Habilitation électrique</label>
                                        <label><input type="checkbox" name="formations[]" value="Arrêt de la distribution" {{ in_array('Arrêt de la distribution', $formations) ? 'checked' : '' }}> Arrêt de la distribution</label>
                                        <label><input type="checkbox" name="formations[]" value="Arrêt d’une autre activité" {{ in_array('Arrêt d’une autre activité', $formations) ? 'checked' : '' }}> Arrêt d’une autre activité</label>
                                        <label><input type="checkbox" name="formations[]" value="Arrêt des travaux pendant le dépotage" {{ in_array('Arrêt des travaux pendant le dépotage', $formations) ? 'checked' : '' }}> Arrêt des travaux pendant le dépotage</label>
                                        <label><input type="checkbox" name="formations[]" value="Repérage physique préalable des réseaux enterrés" {{ in_array('Repérage physique préalable des réseaux enterrés', $formations) ? 'checked' : '' }}> Repérage physique préalable des réseaux enterrés</label>
                                        <label><input type="checkbox" name="formations[]" value="Mise à la terre des équipements et test" {{ in_array('Mise à la terre des équipements et test', $formations) ? 'checked' : '' }}> Mise à la terre des équipements et test</label>
                                        <label><input type="checkbox" name="formations[]" value="Surveillance permanente par un 2éme intervenant" {{ in_array('Surveillance permanente par un 2éme intervenant', $formations) ? 'checked' : '' }}> Surveillance permanente par un 2éme intervenant</label>
                                        <label><input type="checkbox" name="formations[]" value="Analyse d’atmosphère en continu" {{ in_array('Analyse d’atmosphère en continu', $formations) ? 'checked' : '' }}> Analyse d’atmosphère en continu</label>
                                        <label><input type="checkbox" name="formations[]" value="Extincteurs adaptés" {{ in_array('Extincteurs adaptés', $formations) ? 'checked' : '' }}> Extincteurs adaptés</label>
                                        <label><input type="checkbox" name="formations[]" value="Réception des échafaudages" {{ in_array('Réception des échafaudages', $formations) ? 'checked' : '' }}> Réception des échafaudages</label>
                                        <label><input type="checkbox" name="formations[]" value="Obturation des égouts / regards" {{ in_array('Obturation des égouts / regards', $formations) ? 'checked' : '' }}> Obturation des égouts / regards</label>
                                        <label><input type="checkbox" name="formations[]" value="Consignation des réseaux électriques / hydrauliques" {{ in_array('Consignation des réseaux électriques / hydrauliques', $formations) ? 'checked' : '' }}> Consignation des réseaux électriques / hydrauliques</label>
                                        <label><input type="checkbox" name="formations[]" value="Outillage / matériel ATEX" {{ in_array('Outillage / matériel ATEX', $formations) ? 'checked' : '' }}> Outillage / matériel ATEX</label>
                                        <label><input type="checkbox" name="formations[]" value="Balisage de la zone, aide à la" {{ in_array('Balisage de la zone, aide à la', $formations) ? 'checked' : '' }}> circulation</label>
                                        <label><input type="checkbox" name="formations[]" value="Autres" {{ in_array('Autres', $formations) ? 'checked' : '' }}> Autres <input type="text" name="training_certifications_other" value="{{ old('training_certifications_other', $plan->training_certifications_other) }}"></label>
                                        <label><input type="checkbox" name="formations[]" value="Port d’EPI et autres équipements spécifiques :" {{ in_array('Port d’EPI et autres équipements spécifiques :', $formations) ? 'checked' : '' }}> Port d’EPI et autres équipements spécifiques :</label>
                                        <label><input type="checkbox" name="formations[]" value="- Appareil respiratoire, ventilation forcée" {{ in_array('- Appareil respiratoire, ventilation forcée', $formations) ? 'checked' : '' }}> - Appareil respiratoire, ventilation forcée</label>
                                        <label><input type="checkbox" name="formations[]" value="- Harnais, baudrier, filet de sécurité,sangle de retenue" {{ in_array('- Harnais, baudrier, filet de sécurité,sangle de retenue', $formations) ? 'checked' : '' }}> - Harnais, baudrier, filet de sécurité,sangle de retenue</label>
                                        <label><input type="checkbox" name="formations[]" value="- Mise à disposition casqueanti-bruit" {{ in_array('- Mise à disposition casqueanti-bruit', $formations) ? 'checked' : '' }}> - Mise à disposition casqueanti-bruit</label>
                                        <label><input type="checkbox" name="formations[]" value="- Aide à la manutention" {{ in_array('- Aide à la manutention', $formations) ? 'checked' : '' }}> - Aide à la manutention</label>
                                        <label><input type="checkbox" name="formations[]" value="Autres" {{ in_array('Autres', $formations) ? 'checked' : '' }}> Autres <input type="text" name="training_certifications_other" value="{{ old('training_certifications_other', $plan->training_certifications_other) }}"></label>
                                        <label><input type="checkbox" name="formations[]" value="Permis spécifique :" {{ in_array('Permis spécifique :', $formations) ? 'checked' : '' }}> Permis spécifique :</label>
                                        <label><input type="checkbox" name="formations[]" value="- Permis de feu" {{ in_array('- Permis de feu', $formations) ? 'checked' : '' }}> - Permis de feu</label>
                                        <label><input type="checkbox" name="formations[]" value="- Permis delevage" {{ in_array('- Permis delevage', $formations) ? 'checked' : '' }}> - Permis delevage</label>
                                        <label><input type="checkbox" name="formations[]" value="- Permis de fouille" {{ in_array('- Permis de fouille', $formations) ? 'checked' : '' }}> - Permis de fouille</label>
                                        <label><input type="checkbox" name="formations[]" value="Autres" {{ in_array('Autres', $formations) ? 'checked' : '' }}> Autres <input type="text" name="training_certifications_other" value="{{ old('training_certifications_other', $plan->training_certifications_other) }}"></label>
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
                                <div class="form-group">
                                    <label>1- Nom:</label>
                                    <input type="text" name="before_company_1" class="form-control" value="{{ old('before_company_1', $plan->before_company_1) }}">
                                </div>
                                <div class="form-group">
                                    <label>2- Nom:</label>
                                    <input type="text" name="before_company_2" class="form-control" value="{{ old('before_company_2', $plan->before_company_2) }}">
                                </div>
                                <div class="form-group">
                                    <label>3- Nom:</label>
                                    <input type="text" name="before_company_3" class="form-control" value="{{ old('before_company_3', $plan->before_company_3) }}">
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
                                <div class="form-group">
                                    <label>1. Nom:</label>
                                    <input type="text" name="after_company_1_name" class="form-control" value="{{ old('after_company_1_name', $plan->after_company_1_name) }}">
                                    <label>Date:</label>
                                    <input type="date" name="after_company_1_date" class="form-control" value="{{ old('after_company_1_date', $plan->after_company_1_date ? $plan->after_company_1_date->format('Y-m-d') : '') }}">
                                </div>
                                <div class="form-group">
                                    <label>2. Nom:</label>
                                    <input type="text" name="after_company_2_name" class="form-control" value="{{ old('after_company_2_name', $plan->after_company_2_name) }}">
                                    <label>Date:</label>
                                    <input type="date" name="after_company_2_date" class="form-control" value="{{ old('after_company_2_date', $plan->after_company_2_date ? $plan->after_company_2_date->format('Y-m-d') : '') }}">
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
</x-app-layout>
