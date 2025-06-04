<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Plan de Prévention Journalier') }}
        </h2>
    </x-slot>

    <style>
        .table-bordered th, .table-bordered td { border: 1px solid #000 !important; padding: 5px; }
        .form-section { margin-bottom: 25px; }
        .form-section h4 { background: #f8f9fa; padding: 10px; border: 1px solid #000; text-align: center; }
        input[type="text"], input[type="date"], input[type="time"], textarea { width: 100%; }
        .checkbox-list { columns: 2; -webkit-columns: 2; -moz-columns: 2; }
        .checkbox-list label { display: block; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

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
                                <tr>
                                    <td><input type="text" name="external_company_2"></td>
                                    <td><input type="text" name="main_company_2"></td>
                                    <td><input type="text" name="subcontractor_2"></td>
                                    <td><input type="text" name="intervenant_2"></td>
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
                                            <label><input type="checkbox" name="risques[]" value="Risque biologique"> Risque biologique</label>
                                            <label><input type="checkbox" name="risques[]" value="Risque ergonomiques"> Risque ergonomiques</label>
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
                                            <label><input type="checkbox" name="formations[]" value="Autres"> Autres <input type="text" name="formations_autre"></label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mesures préventives -->
                    <div class="form-section">
                        <h4>MESURES PRÉVENTIVES</h4>
                        <textarea name="preventive_measures" rows="3"></textarea>
                    </div>

                    <!-- Permis et documents -->
                    <div class="form-section">
                        <h4>PERMIS ET DOCUMENTS</h4>
                        <table class="table table-bordered">
                            <tr>
                                <td><label><input type="checkbox" name="pir_pirl" value="1"> PIR/PIRL</label></td>
                                <td><label><input type="checkbox" name="document_technique_amiante" value="1"> Document Technique Amiante</label></td>
                            </tr>
                            <tr>
                                <td><label><input type="checkbox" name="grue" value="1"> Grue</label></td>
                                <td><label><input type="checkbox" name="declaration_commencement_travaux" value="1"> Déclaration d'intention de Commencement de Travaux</label></td>
                            </tr>
                            <tr>
                                <td><label><input type="checkbox" name="echafaudage" value="1"> Échafaudage</label></td>
                                <td><label><input type="checkbox" name="plans_reseaux" value="1"> Plans de Réseaux</label></td>
                            </tr>
                            <tr>
                                <td><label><input type="checkbox" name="certificat_degazage" value="1"> Certificat de dégazage</label></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Permis de feu :</td>
                                <td><input type="text" name="permis_de_feu"></td>
                            </tr>
                            <tr>
                                <td>Permis spécifique :</td>
                                <td><input type="text" name="permis_specifique"></td>
                            </tr>
                            <tr>
                                <td>Autres (préciser) :</td>
                                <td><input type="text" name="autres_permis"></td>
                            </tr>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
