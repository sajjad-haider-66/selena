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
                            <td>{{ $plans->work_date }}</td>
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
                                    <th>Extérieure</th>
                                    <th>Entreprise principale</th>
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
                            <td>{{ $plans->start_time }}</td>
                        </tr>
                        <tr>
                            <td><strong>Description :</strong></td>
                            <td colspan="3">{{ $plans->description }}</td>
                        </tr>
                        <tr>
                            <td><strong>N° mode opératoire :</strong></td>
                            <td>{{ $plans->operative_mode_number }}</td>
                            <td><strong>Fin d'intervention prévue :</strong></td>
                            <td>{{ $plans->end_time }}</td>
                        </tr>
                    </table>
                </div>

                <div class="form-section">
                    <h4>RISQUES D'INTERFÉRENCE AVEC L'OPÉRATION</h4>
                    <table class="table table-bordered">
                        <tr>
                            <td>Dépotage prévu à :</td>
                            <td>{{ old('depotage_time', $plans->depotage_time ? $plans->depotage_time->format('H:i') : '') }}</td>
                        </tr>
                        <tr>
                            <td>Présence dans la zone de Travail de :</td>
                            <td>{{ old('presence_zone', $plans->presence_zone) }}</td>
                        </tr>
                        <tr>
                            <td>Autres travaux prévus ce jour :</td>
                            <td>{{ old('other_works', $plans->other_works) }}</td>
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
                                    @php $travail = json_decode($plans->work_nature, true) ?? [] @endphp
                                    <div class="checkbox-list">
                                        <label><input type="checkbox" disabled {{ in_array('Travaux sur appareil de distribution', $travail) ? 'checked' : '' }}> Travaux sur appareil de distribution</label>
                                        <label><input type="checkbox" disabled {{ in_array('Nettoyage de la piste', $travail) ? 'checked' : '' }}> Nettoyage de la piste</label>
                                        <label><input type="checkbox" disabled {{ in_array('Travaux sur équipements électriques', $travail) ? 'checked' : '' }}> Travaux sur équipements électriques</label>
                                        <label><input type="checkbox" disabled {{ in_array('Travaux de plomberie', $travail) ? 'checked' : '' }}> Travaux de plomberie</label>
                                        <label><input type="checkbox" disabled {{ in_array('Travaux de peinture', $travail) ? 'checked' : '' }}> Travaux de peinture</label>
                                        <label><input type="checkbox" disabled {{ in_array('Perçage, meulage, découpage, soudage, décapage', $travail) ? 'checked' : '' }}> Perçage, meulage, découpage, soudage, décapage</label>
                                        <label><input type="checkbox" disabled {{ in_array('Levage', $travail) ? 'checked' : '' }}> Levage</label>
                                        <label><input type="checkbox" disabled {{ in_array('Travaux sur tuyauterie', $travail) ? 'checked' : '' }}> Travaux sur tuyauterie</label>
                                        <label><input type="checkbox" disabled {{ in_array('Vidange/dégazage/nettoyage cuve hydrocarbures', $travail) ? 'checked' : '' }}> Vidange/dégazage/nettoyage cuve hydrocarbures</label>
                                        <label><input type="checkbox" disabled {{ in_array('Vidange/dégazage/brûlage/nettoyage cuve GPLC', $travail) ? 'checked' : '' }}> Vidange/dégazage/brûlage/nettoyage cuve GPLC</label>
                                        <label><input type="checkbox" disabled {{ in_array('Ré-épreuve cuve', $travail) ? 'checked' : '' }}> Ré-épreuve cuve</label>
                                        <label><input type="checkbox" disabled {{ in_array('Fouille / terrassement', $travail) ? 'checked' : '' }}> Fouille / terrassement</label>
                                        <label><input type="checkbox" disabled {{ in_array('Forage', $travail) ? 'checked' : '' }}> Forage</label>
                                        <label><input type="checkbox" disabled {{ in_array('Visites / audits / contrôles / études engineering', $travail) ? 'checked' : '' }}> Visites / audits / contrôles / études engineering</label>
                                        <label><input type="checkbox" disabled {{ in_array('Travaux d\'entretien des abords de la station', $travail) ? 'checked' : '' }}> Travaux d'entretien des abords de la station</label>
                                        <label><input type="checkbox" disabled {{ in_array('Travaux de démolition', $travail) ? 'checked' : '' }}> Travaux de démolition</label>
                                        <label><input type="checkbox" disabled {{ in_array('Intervention sur portique de lavage', $travail) ? 'checked' : '' }}> Intervention sur portique de lavage</label>
                                        <label><input type="checkbox" disabled {{ in_array('Autres', $travail) ? 'checked' : '' }}> Autres: {{ $plans->work_nature_other ?? '' }}</label>
                                        <hr><label class="mt-2"><strong><u>SITUATION PARTICULIÈRE</u></strong></label>
                                        <label><input type="checkbox" disabled {{ in_array('Présence de public', $travail) ? 'checked' : '' }}> Présence de public</label>
                                        <label><input type="checkbox" disabled {{ in_array('Espace confiné / fouille', $travail) ? 'checked' : '' }}> Espace confiné / fouille</label>
                                        <label><input type="checkbox" disabled {{ in_array('Travaux en hauteur', $travail) ? 'checked' : '' }}> Travaux en hauteur</label>
                                        <label><input type="checkbox" disabled {{ in_array('Volumes de sécurité', $travail) ? 'checked' : '' }}> Volumes de sécurité</label>
                                        <label><input type="checkbox" disabled {{ in_array('Autres', $travail) ? 'checked' : '' }}> Autres: {{ $plans->work_nature_other ?? '' }}</label>
                                        <hr><label class="mt-2"><strong><u>MOYENS / OUTILS</u></strong></label>
                                        <label><input type="checkbox" disabled {{ in_array('Manuel', $travail) ? 'checked' : '' }}> Manuel</label>
                                        <label><input type="checkbox" disabled {{ in_array('Matériel électrique', $travail) ? 'checked' : '' }}> Matériel électrique</label>
                                        <label><input type="checkbox" disabled {{ in_array('Matériel pneumatique', $travail) ? 'checked' : '' }}> Matériel pneumatique</label>
                                        <label><input type="checkbox" disabled {{ in_array('Nacelle', $travail) ? 'checked' : '' }}> Nacelle</label>
                                        <label><input type="checkbox" disabled {{ in_array('PIR / PIRL', $travail) ? 'checked' : '' }}> PIR / PIRL</label>
                                        <label><input type="checkbox" disabled {{ in_array('Grue', $travail) ? 'checked' : '' }}> Grue</label>
                                        <label><input type="checkbox" disabled {{ in_array('Echafaudage', $travail) ? 'checked' : '' }}> Echafaudage</label>
                                        <label><input type="checkbox" disabled {{ in_array('Autres', $travail) ? 'checked' : '' }}> Autres: {{ $plans->work_nature_other ?? '' }}</label>
                                    </div>
                                </td>
                                <td>
                                    @php $risques = json_decode($plans->risk_nature, true) ?? [] @endphp
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
                                        <label><input type="checkbox" disabled {{ in_array('- GPLC / GNC / GNL', $risques) ? 'checked' : '' }}> - GPLC / GNC / GNL</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Autres produits', $risques) ? 'checked' : '' }}> - Autres produits</label>
                                        <label><input type="checkbox" disabled {{ in_array('Risque biologique', $risques) ? 'checked' : '' }}> Risque biologique</label>
                                        <label><input type="checkbox" disabled {{ in_array('Risque', $risques) ? 'checked' : '' }}> Risque</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Manipulation de charges', $risques) ? 'checked' : '' }}> - Manipulation de charges</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Contrainte de postures', $risques) ? 'checked' : '' }}> - Contrainte de postures</label>
                                        <label><input type="checkbox" disabled {{ in_array('Risques pour l’environnement :', $risques) ? 'checked' : '' }}> Risques pour l’environnement :</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Pollution air', $risques) ? 'checked' : '' }}> - Pollution air</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Pollution sol', $risques) ? 'checked' : '' }}> - Pollution sol</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Pollution eau', $risques) ? 'checked' : '' }}> - Pollution eau</label>
                                        <label><input type="checkbox" disabled {{ in_array('Autres', $risques) ? 'checked' : '' }}> Autres: {{ $plans->risk_nature_other ?? '' }}</label>
                                        <hr><label class="mt-2"><strong><u>DOCUMENTS DISPONIBLES</u></strong></label>
                                        <label><input type="checkbox" disabled {{ in_array('Fiche de Données Sécurité', $risques) ? 'checked' : '' }}> Fiche de Données Sécurité</label>
                                        <label><input type="checkbox" disabled {{ in_array('Document Technique', $risques) ? 'checked' : '' }}> Amiante</label>
                                        <label><input type="checkbox" disabled {{ in_array('Déclaration d’Intention de', $risques) ? 'checked' : '' }}> Commencement de Travaux</label>
                                        <label><input type="checkbox" disabled {{ in_array('Plans de réseaux', $risques) ? 'checked' : '' }}> Plans de réseaux</label>
                                        <label><input type="checkbox" disabled {{ in_array('Certificat de dégazage', $risques) ? 'checked' : '' }}> Certificat de dégazage</label>
                                        <label><input type="checkbox" disabled {{ in_array('Autres', $risques) ? 'checked' : '' }}> Autres: {{ $plans->risk_nature_other ?? '' }}</label>
                                    </div>
                                </td>
                                <td>
                                    @php $formations = json_decode($plans->training_certifications, true) ?? [] @endphp
                                    <div class="checkbox-list">
                                        <label><input type="checkbox" disabled {{ in_array('Autorisation de conduite d\'un engin de chantier', $formations) ? 'checked' : '' }}> Autorisation de conduite d'un engin de chantier</label>
                                        <label><input type="checkbox" disabled {{ in_array('Habilitation électrique', $formations) ? 'checked' : '' }}> Habilitation électrique</label>
                                        <label><input type="checkbox" disabled {{ in_array('Arrêt de la distribution', $formations) ? 'checked' : '' }}> Arrêt de la distribution</label>
                                        <label><input type="checkbox" disabled {{ in_array('Arrêt d’une autre activité', $formations) ? 'checked' : '' }}> Arrêt d’une autre activité</label>
                                        <label><input type="checkbox" disabled {{ in_array('Arrêt des travaux pendant le dépotage', $formations) ? 'checked' : '' }}> Arrêt des travaux pendant le dépotage</label>
                                        <label><input type="checkbox" disabled {{ in_array('Repérage physique préalable des réseaux enterrés', $formations) ? 'checked' : '' }}> Repérage physique préalable des réseaux enterrés</label>
                                        <label><input type="checkbox" disabled {{ in_array('Mise à la terre des équipements et test', $formations) ? 'checked' : '' }}> Mise à la terre des équipements et test</label>
                                        <label><input type="checkbox" disabled {{ in_array('Surveillance permanente par un 2éme intervenant', $formations) ? 'checked' : '' }}> Surveillance permanente par un 2éme intervenant</label>
                                        <label><input type="checkbox" disabled {{ in_array('Analyse d’atmosphère en continu', $formations) ? 'checked' : '' }}> Analyse d’atmosphère en continu</label>
                                        <label><input type="checkbox" disabled {{ in_array('Extincteurs adaptés', $formations) ? 'checked' : '' }}> Extincteurs adaptés</label>
                                        <label><input type="checkbox" disabled {{ in_array('Réception des échafaudages', $formations) ? 'checked' : '' }}> Réception des échafaudages</label>
                                        <label><input type="checkbox" disabled {{ in_array('Obturation des égouts / regards', $formations) ? 'checked' : '' }}> Obturation des égouts / regards</label>
                                        <label><input type="checkbox" disabled {{ in_array('Consignation des réseaux électriques / hydrauliques', $formations) ? 'checked' : '' }}> Consignation des réseaux électriques / hydrauliques</label>
                                        <label><input type="checkbox" disabled {{ in_array('Outillage / matériel ATEX', $formations) ? 'checked' : '' }}> Outillage / matériel ATEX</label>
                                        <label><input type="checkbox" disabled {{ in_array('Balisage de la zone, aide à la', $formations) ? 'checked' : '' }}> Balisage de la zone, aide à la circulation</label>
                                        <label><input type="checkbox" disabled {{ in_array('Autres', $formations) ? 'checked' : '' }}> Autres: {{ $plans->training_certifications_other ?? '' }}</label>
                                        <label><input type="checkbox" disabled {{ in_array('Port d’EPI et autres équipements spécifiques :', $formations) ? 'checked' : '' }}> Port d’EPI et autres équipements spécifiques :</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Appareil respiratoire, ventilation forcée', $formations) ? 'checked' : '' }}> - Appareil respiratoire, ventilation forcée</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Harnais, baudrier, filet de sécurité,sangle de retenue', $formations) ? 'checked' : '' }}> - Harnais, baudrier, filet de sécurité, sangle de retenue</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Mise à disposition casqueanti-bruit', $formations) ? 'checked' : '' }}> - Mise à disposition casque anti-bruit</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Aide à la manutention', $formations) ? 'checked' : '' }}> - Aide à la manutention</label>
                                        <label><input type="checkbox" disabled {{ in_array('Autres', $formations) ? 'checked' : '' }}> Autres: {{ $plans->training_certifications_other ?? '' }}</label>
                                        <label><input type="checkbox" disabled {{ in_array('Permis spécifique :', $formations) ? 'checked' : '' }}> Permis spécifique :</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Permis de feu', $formations) ? 'checked' : '' }}> - Permis de feu</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Permis delevage', $formations) ? 'checked' : '' }}> - Permis de levage</label>
                                        <label><input type="checkbox" disabled {{ in_array('- Permis de fouille', $formations) ? 'checked' : '' }}> - Permis de fouille</label>
                                        <label><input type="checkbox" disabled {{ in_array('Autres', $formations) ? 'checked' : '' }}> Autres: {{ $plans->training_certifications_other ?? '' }}</label>
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
                <h6>RESPONSABLE DE LA STATION OU SON REPRÉSENTANT</h6>
                <p><strong>Date:</strong> {{ $plans->before_date ? $plans->before_date->format('d/m/Y') : '—' }}</p>
                <p><strong>Heure:</strong> {{ $plans->before_time ? $plans->before_time->format('H:i') : '—' }}</p>
                <p><strong>Nom:</strong> {{ $plans->before_responsible_name ?? '—' }}</p>
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
        <ul class="mb-3">
            @if($plans->work_completed)
                <li>✔️ Le travail est terminé</li>
            @endif
            @if($plans->work_not_completed)
                <li>❌ Le travail n'est pas terminé</li>
            @endif
            @if($plans->station_normal)
                <li>✅ La station est rendue à une exploitation normale</li>
            @endif
            @if($plans->site_clean_safe)
                <li>🧹 Le chantier a été propre et en sécurité.</li>
                <li><strong>Nouvelle autorisation prévue le:</strong> {{ $plans->new_authorization_date ? \Carbon\Carbon::parse($plans->new_authorization_date)->format('d/m/Y') : '—' }}</li>
            @endif
        </ul>

        <div class="row">
            <!-- ENTREPRISE(S) EXTÉRIEURE(S) INTERVENANTE(S) -->
            <div class="col-md-6">
                <h6>ENTREPRISE(S) EXTÉRIEURE(S) INTERVENANTE(S)</h6>
                @php $i = 1; @endphp
                @foreach (json_decode($plans->company_nom_date, true) as $entreprise)
                    <div class="mb-3">
                        <p><strong>{{ $i }}. Nom:</strong> {{ $entreprise['name'] ?? '—' }}</p>
                        <p><strong>Date:</strong> {{ $entreprise['date'] ?? '—' }}</p>
                    </div>
                    @php $i++; @endphp
                @endforeach
            </div>

            <!-- RESPONSABLE DE LA STATION (OU SON REPRÉSENTANT) -->
            <div class="col-md-6">
                <h6>RESPONSABLE DE LA STATION (OU SON REPRÉSENTANT)</h6>
                <p><strong>Date:</strong> {{ $plans->after_responsible_date ? $plans->after_responsible_date->format('d/m/Y') : '—' }}</p>
                <p><strong>Heure:</strong> {{ $plans->after_responsible_time ? $plans->after_responsible_time->format('H:i') : '—' }}</p>
                <p><strong>Nom:</strong> {{ $plans->after_responsible_name ?? '—' }}</p>
            </div>
        </div>
    </div>
</div>


                <a href="{{ route('plan.index') }}" class="btn btn-primary">Back to List</a>
            </div>
        </div>
    </div>
</x-app-layout>
