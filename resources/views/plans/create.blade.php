<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Plan de Prévention') }}
        </h2>
    </x-slot>

    <style>
        .table-bordered th, .table-bordered td { border: 1px solid #000 !important; padding: 5px; }
        .form-section { margin-bottom: 25px; }
        .form-section h4 { background: #f8f9fa; padding: 10px; border: 1px solid #000; text-align: center; }
        input[type="text"], input[type="date"], input[type="time"], textarea { width: 100%; }
        .checkbox-list { columns: 1; -webkit-columns: 1; -moz-columns: 1; }
        .checkbox-list label { display: block; }
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
                                <td style="width:20%"><label for="plan_number">N° A</label></td>
                                <td style="width:30%"><input type="text" name="plan_number" id="plan_number" required></td>
                                <td style="width:20%"><label for="work_date">DATE des travaux</label></td>
                                <td style="width:30%"><input type="date" name="work_date" id="work_date" required></td>
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
                                    <td><input type="text" name="external_company_1"></td>
                                    <td><input type="text" name="main_company_1"></td>
                                    <td><input type="text" name="subcontractor_1"></td>
                                    <td><input type="text" name="intervenant_1"></td>
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
                                <td><input type="text" name="location"></td>
                                <td>Début d'intervention :</td>
                                <td><input type="time" name="start_time"></td>
                            </tr>
                            <tr>
                                <td>Description :</td>
                                <td colspan="3"><textarea name="description"></textarea></td>
                            </tr>
                            <tr>
                                <td>N° mode opératoire :</td>
                                <td><input type="text" name="operative_mode_number"></td>
                                <td>Fin d'intervention prévue :</td>
                                <td><input type="time" name="end_time"></td>
                            </tr>
                        </table>
                    </div>

                    <!-- Risques d'interférence -->
                    <div class="form-section">
                        <h4>RISQUES D'INTERFÉRENCE AVEC L'OPÉRATION</h4>
                        <table class="table table-bordered">
                            <tr>
                                <td>Dépotage prévu à :</td>
                                <td><input type="time" name="depotage_time"></td>
                            </tr>
                            <tr>
                                <td>Présence dans la zone de Travail de :</td>
                                <td><input type="text" name="presence_zone" placeholder="bouteilles de gaz, fûts…"></td>
                            </tr>
                            <tr>
                                <td>Autres travaux prévus ce jour :</td>
                                <td><textarea name="other_works"></textarea></td>
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
                                            <label><input type="checkbox" name="travail[]" value="Travaux sur appareil de distribution"> Travaux sur appareil de distribution</label>
                                            <label><input type="checkbox" name="travail[]" value="Nettoyage de la piste"> Nettoyage de la piste</label>
                                            <label><input type="checkbox" name="travail[]" value="Travaux sur équipements électriques"> Travaux sur équipements électriques</label>
                                            <label><input type="checkbox" name="travail[]" value="Travaux de plomberie"> Travaux de plomberie</label>
                                            <label><input type="checkbox" name="travail[]" value="Travaux de peinture"> Travaux de peinture</label>
                                            <label><input type="checkbox" name="travail[]" value="Perçage, meulage, découpage, soudage, décapage"> Perçage, meulage, découpage, soudage, décapage</label>
                                            <label><input type="checkbox" name="travail[]" value="Levage"> Levage</label>
                                            <label><input type="checkbox" name="travail[]" value="Travaux sur tuyauterie"> Travaux sur tuyauterie</label>
                                            <label><input type="checkbox" name="travail[]" value="Vidange/dégazage/nettoyage cuve hydrocarbures"> Vidange/dégazage/nettoyage cuve hydrocarbures</label>
                                            <label><input type="checkbox" name="travail[]" value="Vidange/dégazage/brûlage/nettoyage cuve GPLC"> Vidange/dégazage/brûlage/nettoyage cuve GPLC</label>
                                            <label><input type="checkbox" name="travail[]" value="Ré-épreuve cuve"> Ré-épreuve cuve</label>
                                            <label><input type="checkbox" name="travail[]" value="Fouille / terrassement"> Fouille / terrassement</label>
                                            <label><input type="checkbox" name="travail[]" value="Forage"> Forage</label>
                                            <label><input type="checkbox" name="travail[]" value="Visites / audits / contrôles / études engineering"> Visites / audits / contrôles / études engineering</label>
                                            <label><input type="checkbox" name="travail[]" value="Travaux d'entretien des abords de la station"> Travaux d'entretien des abords de la station</label>
                                            <label><input type="checkbox" name="travail[]" value="Travaux de démolition"> Travaux de démolition</label>
                                            <label><input type="checkbox" name="travail[]" value="Intervention sur portique de lavage"> Intervention sur portique de lavage</label>
                                            <label><input type="checkbox" name="travail[]" value="Autres"> Autres <input type="text" name="travail_autre"></label>
                                            <hr><label class="mt-2"><strong><u>SITUATION PARTICULIÈRE</u></strong></label>
                                            <label><input type="checkbox" name="travail[]" value="Présence de public "> Présence de public </label>
                                            <label><input type="checkbox" name="travail[]" value="Espace confiné / fouille"> Espace confiné / fouille</label>
                                            <label><input type="checkbox" name="travail[]" value="Travaux en hauteur"> Travaux en hauteur</label>
                                            <label><input type="checkbox" name="travail[]" value="Volumes de sécurité"> Volumes de sécurité</label>
                                            <label><input type="checkbox" name="travail[]" value="Autres"> Autres (précisez) : <input type="text" name="travail_autre"></label>
                                            <hr><label class="mt-2"><strong><u>MOYENS / OUTILS </u></strong></label>
                                            <label><input type="checkbox" name="travail[]" value="Manuel "> Manuel </label>
                                            <label><input type="checkbox" name="travail[]" value="Matériel électrique"> Matériel électrique</label>
                                            <label><input type="checkbox" name="travail[]" value="Matériel pneumatique"> Matériel pneumatique</label>
                                            <label><input type="checkbox" name="travail[]" value="Nacelle "> Nacelle </label>
                                            <label><input type="checkbox" name="travail[]" value="PIR / PIRL "> PIR / PIRL </label>
                                            <label><input type="checkbox" name="travail[]" value="Grue"> Grue</label>
                                            <label><input type="checkbox" name="travail[]" value="Echafaudage"> Echafaudage</label>
                                            <label><input type="checkbox" name="travail[]" value="Autres"> Autres (précisez) : <input type="text" name="travail_autre"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox-list">
                                            <label><input type="checkbox" name="risques[]" value="Circulation routière"> Circulation routière</label>
                                            <label><input type="checkbox" name="risques[]" value="Incendie"> Incendie</label>
                                            <label><input type="checkbox" name="risques[]" value="Explosion"> Explosion</label>
                                            <label><input type="checkbox" name="risques[]" value="Sources d'énergie"> Sources d'énergie</label>
                                            <label><input type="checkbox" name="risques[]" value="Risques électriques"> Risques électriques</label>
                                            <label><input type="checkbox" name="risques[]" value="Risques hydrauliques"> Risques hydrauliques</label>
                                            <label><input type="checkbox" name="risques[]" value="Risques liés à la pression"> Risques liés à la pression</label>
                                            <label><input type="checkbox" name="risques[]" value="Risques de chute"> Risques de chute</label>
                                            <label><input type="checkbox" name="risques[]" value="Eboulement / Écrasement / Ensevelissement"> Eboulement / Écrasement / Ensevelissement</label>
                                            <label><input type="checkbox" name="risques[]" value="Asphyxie"> Asphyxie</label>
                                            <label><input type="checkbox" name="risques[]" value="Coupure, brûlure, choc…"> Coupure, brûlure, choc…</label>
                                            <label><input type="checkbox" name="risques[]" value="Bruit"> Bruit</label>
                                            <label><input type="checkbox" name="risques[]" value="Risques chimiques"> Risques chimiques</label>
                                            <label><input type="checkbox" name="risques[]" value="- Hydrocarbure "> - Hydrocarbure </label>
                                            <label><input type="checkbox" name="risques[]" value="- GPLC / GNC / GNL "> - GPLC / GNC / GNL </label>
                                            <label><input type="checkbox" name="risques[]" value="- Autres produits "> - Autres produits </label>
                                            <label><input type="checkbox" name="risques[]" value="Risque biologique"> Risque biologique</label>
                                            <label><input type="checkbox" name="risques[]" value="Risque"> Risque</label>
                                            <label><input type="checkbox" name="risques[]" value="- Manipulation de charges"> - Manipulation de charges</label>
                                            <label><input type="checkbox" name="risques[]" value="- Contrainte de postures"> - Contrainte de postures</label>
                                            <label><input type="checkbox" name="risques[]" value="Risques pour l’environnement : "> Risques pour l’environnement : </label>
                                            <label><input type="checkbox" name="risques[]" value="- Pollution air"> - Pollution air</label>
                                            <label><input type="checkbox" name="risques[]" value="- Pollution sol"> - Pollution sol</label>
                                            <label><input type="checkbox" name="risques[]" value="- Pollution eau"> - Pollution eau</label>
                                            <label><input type="checkbox" name="risques[]" value="Autres"> Autres <input type="text" name="risques_autre"></label>
                                            <hr><label class="mt-2"><strong><u>DOCUMENTS DISPONIBLES </u></strong></label>
                                            <label><input type="checkbox" name="risques[]" value="Fiche de Données Sécurité "> Fiche de Données Sécurité </label>
                                            <label><input type="checkbox" name="risques[]" value="Document Technique"> Amiante</label>
                                            <label><input type="checkbox" name="risques[]" value="Déclaration d’Intention de"> Commencement de Travaux</label>
                                            <label><input type="checkbox" name="risques[]" value="Plans de réseaux"> Plans de réseaux</label>
                                            <label><input type="checkbox" name="risques[]" value="Certificat de dégazage "> Certificat de dégazage </label>
                                            <label><input type="checkbox" name="risques[]" value="Autres"> Autres <input type="text" name="risques_autre"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox-list">
                                            <label><input type="checkbox" name="formations[]" value="Autorisation de conduite d'un engin de chantier"> Autorisation de conduite d'un engin de chantier</label>
                                            <label><input type="checkbox" name="formations[]" value="Habilitation électrique"> Habilitation électrique</label>
                                            <label><input type="checkbox" name="formations[]" value="Arrêt de la distribution"> Arrêt de la distribution</label>
                                            <label><input type="checkbox" name="formations[]" value="Arrêt d’une autre activité"> Arrêt d’une autre activité</label>
                                            <label><input type="checkbox" name="formations[]" value="Arrêt des travaux pendant le dépotage"> Arrêt des travaux pendant le dépotage</label>
                                            <label><input type="checkbox" name="formations[]" value="Repérage physique préalable des réseaux enterrés"> Repérage physique préalable des réseaux enterrés</label>
                                            <label><input type="checkbox" name="formations[]" value="Mise à la terre des équipements et test"> Mise à la terre des équipements et test</label>
                                            <label><input type="checkbox" name="formations[]" value="Surveillance permanente par un 2éme intervenant"> Surveillance permanente par un 2éme intervenant</label>
                                            <label><input type="checkbox" name="formations[]" value="Analyse d’atmosphère en continu"> Analyse d’atmosphère en continu</label>
                                            <label><input type="checkbox" name="formations[]" value="Extincteurs adaptés"> Extincteurs adaptés</label>
                                            <label><input type="checkbox" name="formations[]" value="Réception des échafaudages"> Réception des échafaudages</label>
                                            <label><input type="checkbox" name="formations[]" value="Obturation des égouts / regards"> Obturation des égouts / regards</label>
                                            <label><input type="checkbox" name="formations[]" value="Consignation des réseaux électriques / hydrauliques"> Consignation des réseaux électriques / hydrauliques</label>
                                            <label><input type="checkbox" name="formations[]" value="Outillage / matériel ATEX"> Outillage / matériel ATEX</label>
                                            <label><input type="checkbox" name="formations[]" value="Balisage de la zone, aide à la"> circulation</label>
                                            <label><input type="checkbox" name="formations[]" value="Autres"> Autres <input type="text" name="formations_autre"></label>
                                            <label><input type="checkbox" name="formations[]" value="Port d’EPI et autres équipements spécifiques :"> Port d’EPI et autres équipements spécifiques :</label>
                                            <label><input type="checkbox" name="formations[]" value="- Appareil respiratoire, ventilation forcée"> - Appareil respiratoire, ventilation forcée</label>
                                            <label><input type="checkbox" name="formations[]" value="- Harnais, baudrier, filet de sécurité,sangle de retenue">- Harnais, baudrier, filet de sécurité,sangle de retenue </label>
                                            <label><input type="checkbox" name="formations[]" value="- Mise à disposition casqueanti-bruit">- Mise à disposition casqueanti-bruit</label>
                                            <label><input type="checkbox" name="formations[]" value="- Aide à la manutention">- Aide à la manutention </label>
                                            <label><input type="checkbox" name="formations[]" value="Autres"> Autres <input type="text" name="formations_autre"></label>
                                            <label><input type="checkbox" name="formations[]" value="Permis spécifique :">Permis spécifique : </label>
                                            <label><input type="checkbox" name="formations[]" value="- Permis de feu"> - Permis de feu</label>
                                            <label><input type="checkbox" name="formations[]" value="- Permis delevage">- Permis delevage </label>
                                            <label><input type="checkbox" name="formations[]" value="- Permis de fouille">- Permis de fouille </label>
                                            <label><input type="checkbox" name="formations[]" value="Autres"> Autres <input type="text" name="formations_autre"></label>
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
                                        <input type="text" name="avant_entreprise_1" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>2- Nom:</label>
                                        <input type="text" name="avant_entreprise_2" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>3- Nom:</label>
                                        <input type="text" name="avant_entreprise_3" class="form-control">
                                    </div>
                                </div>
                                <!-- RESPONSABLE DE LA STATION OU SON REPRÉSENTANT -->
                                <div class="col-md-6">
                                    <h6>RESPONSABLE DE LA STATION OU SON REPRÉSENTANT</h6>
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

                    <!-- VALIDATION APRÈS LES TRAVAUX -->
                    <div class="card mb-4">
                        <div class="text-center card-header font-weight-bold">
                            VALIDATION APRÈS LES TRAVAUX
                        </div>
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="apres_travail_termine" id="apres_travail_termine">
                                <label class="form-check-label" for="apres_travail_termine">
                                    Le travail est terminé
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="apres_travail_non_termine" id="apres_travail_non_termine">
                                <label class="form-check-label" for="apres_travail_non_termine">
                                    Le travail n'est pas terminé
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="apres_station_normale" id="apres_station_normale">
                                <label class="form-check-label" for="apres_station_normale">
                                    La station est rendue à une exploitation normale
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="apres_chantier_propre" id="apres_chantier_propre">
                                <label class="form-check-label" for="apres_chantier_propre">
                                    Le chantier a été propre et en sécurité, la reprise du travail fera l’objet d’une nouvelle autorisation de travail prévue le :
                                </label>
                                <input type="date" name="apres_nouvelle_autorisation" class="form-control mt-2" style="width:auto;">
                            </div>

                            <div class="row">
                                <!-- ENTREPRISE(S) EXTÉRIEURE(S) INTERVENANTE(S) -->
                                <div class="col-md-6">
                                    <h6>ENTREPRISE(S) EXTÉRIEURE(S) INTERVENANTE(S)</h6>
                                    <div class="form-group">
                                        <label>1. Nom:</label>
                                        <input type="text" name="apres_entreprise_1_nom" class="form-control">
                                        <label>Date:</label>
                                        <input type="date" name="apres_entreprise_1_date" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>2. Nom:</label>
                                        <input type="text" name="apres_entreprise_2_nom" class="form-control">
                                        <label>Date:</label>
                                        <input type="date" name="apres_entreprise_2_date" class="form-control">
                                    </div>
                                </div>
                                <!-- RESPONSABLE DE LA STATION (OU SON REPRÉSENTANT) -->
                                <div class="col-md-6">
                                    <h6>RESPONSABLE DE LA STATION (OU SON REPRÉSENTANT)</h6>
                                    <div class="form-group">
                                        <label>Date :</label>
                                        <input type="date" name="apres_responsable_date" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Heure :</label>
                                        <input type="time" name="apres_responsable_heure" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Nom :</label>
                                        <input type="text" name="apres_responsable_nom" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-800 transition ease-in-out duration-150" style="background-color: blue;">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
