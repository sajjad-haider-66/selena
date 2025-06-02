<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show - Audit Details') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <h1>Plan de Prévention Journalier Details</h1>
                <div class="form-section">
                    <h4>PLAN DE PRÉVENTION JOURNALIER</h4>
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>N°</strong></td>
                            <td>{{ $plans->plan_number }}</td>
                        </tr>
                    </table>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nom de l'Entreprise</th>
                                <th>Entreprise principale</th>
                                <th>Entreprise sous-traitante</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>{{ $plans->main_enterprise_1 }}</td>
                                <td>{{ $plans->subcontractor_1 }}</td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>{{ $plans->main_enterprise_2 }}</td>
                                <td>{{ $plans->subcontractor_2 }}</td>
                            </tr>
                        </tbody>
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
                            <td colspan="3">{{ $plans->operation_description }}</td>
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
                            <td>{{ $plans->interference_risks }}</td>
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
                                <td>{{ $plans->work_nature }}</td>
                                <td>{{ $plans->risk_nature }}</td>
                                <td>{{ $plans->training_certifications }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="form-section">
                    <h4>PERMIS ET DOCUMENTS</h4>
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>PIR/PIRL :</strong> {{ $plans->pir_pirl ? 'Yes' : 'No' }}</td>
                            <td><strong>Document Technique Amiante :</strong>
                                {{ $plans->technical_document ? 'Yes' : 'No' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Grue :</strong> {{ $plans->crane ? 'Yes' : 'No' }}</td>
                            <td><strong>Déclaration d'intention de Commencement de Travaux :</strong>
                                {{ $plans->work_start_declaration ? 'Yes' : 'No' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Échafaudage :</strong> {{ $plans->scaffolding ? 'Yes' : 'No' }}</td>
                            <td><strong>Plans de Réseaux :</strong> {{ $plans->network_plans ? 'Yes' : 'No' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Certificat de dégazage :</strong>
                                {{ $plans->degassing_certificate ? 'Yes' : 'No' }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>Permis de feu :</strong></td>
                            <td>{{ $plans->fire_permit }}</td>
                        </tr>
                        <tr>
                            <td><strong>Permis spécifique :</strong></td>
                            <td>{{ $plans->specific_permit }}</td>
                        </tr>
                        <tr>
                            <td><strong>Autres (préciser) :</strong></td>
                            <td>{{ $plans->other_permit }}</td>
                        </tr>
                    </table>
                </div>

                <a href="{{ route('plan.index') }}" class="btn btn-primary">Back to List</a>
            </div>
        </div>
    </div>
</x-app-layout>
