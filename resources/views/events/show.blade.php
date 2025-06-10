<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Details') }}
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
            background-color: #007bff;
            color: white;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 5px;
        }

        .category-content {
            display: block;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .detail-value {
            padding: 8px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .attachment-list a {
            display: block;
            margin: 5px 0;
            color: #007bff;
            text-decoration: none;
        }

        .attachment-list a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="row">
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="form-label">Date</label>
                                <div class="detail-value">{{ $event->date }}</div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Lieu (site / chantier)</label>
                                <div class="detail-value">{{ $event->lieu }}</div>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="form-label">Type d'événement</label>
                                <div class="detail-value">{{ $event->type }}</div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Émetteur</label>
                                <div class="detail-value">{{ $event->emetteur ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Catégories</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ $event->securite ? 'checked' : '' }} disabled>
                                <label>Sécurité</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" {{ $event->sante ? 'checked' : '' }} disabled>
                                <label>Santé</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" {{ $event->environnement ? 'checked' : '' }} disabled>
                                <label>Environnement</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" {{ $event->rse ? 'checked' : '' }} disabled>
                                <label>RSE</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Circonstances détaillées</label>
                        <div class="detail-value">{{ $event->circonstances ?? 'N/A' }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Risques encourus</label>
                        <div class="detail-value">{{ $event->risques ?? 'N/A' }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Analyse simplifiée</label>
                        @php
                            $analyse = json_decode($event->analyse, true) ?? [];
                        @endphp

                        <!-- Sécurité des accès -->
                        <div class="category-title">Sécurité des accès</div>
                        <div class="category-content">
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
                                        <input type="checkbox" {{ isset($analyse['securite_acces']) && in_array($item, $analyse['securite_acces']) ? 'checked' : '' }} disabled>
                                        {{ $item }}
                                    </div>
                                @endforeach
                                @if (!empty($analyse['securite_acces']['other']))
                                    <div class="checkbox-item">
                                        <div class="detail-value">Autre: {{ $analyse['securite_acces']['other'] }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Matériel de sécurité -->
                        <div class="category-title">Matériel de sécurité</div>
                        <div class="category-content">
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
                                        <input type="checkbox" {{ isset($analyse['materiel_securite']) && in_array($item, $analyse['materiel_securite']) ? 'checked' : '' }} disabled>
                                        {{ $item }}
                                    </div>
                                @endforeach
                                @if (!empty($analyse['materiel_securite']['other']))
                                    <div class="checkbox-item">
                                        <div class="detail-value">Autre: {{ $analyse['materiel_securite']['other'] }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Information sur les risques -->
                        <div class="category-title">Information sur les risques</div>
                        <div class="category-content">
                            <div class="checkbox-group">
                                @foreach ([
                                    'Absence de PdP ou de PPSPS',
                                    'Non communication du PdP ou du PPSPS au collaborateur',
                                    'Information sur les risques potentiels incomplète ou absente',
                                    'Absence d’accueil sécurité sur le site'
                                ] as $item)
                                    <div class="checkbox-item">
                                        <input type="checkbox" {{ isset($analyse['info_risques']) && in_array($item, $analyse['info_risques']) ? 'checked' : '' }} disabled>
                                        {{ $item }}
                                    </div>
                                @endforeach
                                @if (!empty($analyse['info_risques']['other']))
                                    <div class="checkbox-item">
                                        <div class="detail-value">Autre: {{ $analyse['info_risques']['other'] }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Ambiances et situations de travail -->
                        <div class="category-title">Ambiances et situations de travail</div>
                        <div class="category-content">
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
                                        <input type="checkbox" {{ isset($analyse['ambiances']) && in_array($item, $analyse['ambiances']) ? 'checked' : '' }} disabled>
                                        {{ $item }}
                                    </div>
                                @endforeach
                                @if (!empty($analyse['ambiances']['other']))
                                    <div class="checkbox-item">
                                        <div class="detail-value">Autre: {{ $analyse['ambiances']['other'] }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Formation sécurité / Habilitations -->
                        <div class="category-title">Formation sécurité / Habilitations</div>
                        <div class="category-content">
                            <div class="checkbox-group">
                                @foreach ([
                                    'Formation sécurité insuffisante ou absente',
                                    'Intervention d’un collaborateur non habilité',
                                    'Habilitation périmée, à réexaminée'
                                ] as $item)
                                    <div class="checkbox-item">
                                        <input type="checkbox" {{ isset($analyse['formation']) && in_array($item, $analyse['formation']) ? 'checked' : '' }} disabled>
                                        {{ $item }}
                                    </div>
                                @endforeach
                                @if (!empty($analyse['formation']['other']))
                                    <div class="checkbox-item">
                                        <div class="detail-value">Autre: {{ $analyse['formation']['other'] }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="form-label">Fréquence d’exposition</label>
                                <div class="detail-value">
                                    @switch($event->frequence)
                                        @case(1) Faible (< 1 fois/an) @break
                                        @case(2) Moyenne (< 1 fois/mois) @break
                                        @case(3) Grande (> 1 fois/mois) @break
                                        @case(4) Grande (> 1 fois/semaine) @break
                                        @default N/A
                                    @endswitch
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Gravité des dommages</label>
                                <div class="detail-value">
                                    @switch($event->gravite)
                                        @case(1) Gêne ou dommage léger @break
                                        @case(2) Blessure légère @break
                                        @case(3) Blessure grave @break
                                        @case(4) Blessure mortelle @break
                                        @default N/A
                                    @endswitch
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="form-label">Propositions pour éviter</label>
                                @php
                                    $propositions = json_decode($event->propositions, true) ?? [];
                                @endphp
                                <div class="detail-value">{{ $propositions[0] ?? 'N/A' }}</div>
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
                                    <input type="checkbox" {{ in_array($mesure, $mesures) ? 'checked' : '' }} disabled>
                                    <label>{{ $mesure == 'Equipement' ? 'Equipement de sécurité' : $mesure }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Actions à mettre en place</label>
                        <table class="action-table">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Responsable</th>
                                    <th>Délai</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $actions = json_decode($event->actions, true) ?? [];
                                @endphp
                                @forelse ($actions as $action)
                                    <tr>
                                        <td>{{ $action['description'] ?? 'N/A' }}</td>
                                        <td>{{ $action['responsible'] ?? 'N/A' }}</td>
                                        <td>{{ $action['deadline'] ?? 'N/A' }}</td>
                                        <td>
                                            @switch($action['type'] ?? '')
                                                @case('I') Immédiate @break
                                                @case('C') Corrective @break
                                                @case('P') Préventive @break
                                                @default N/A
                                            @endswitch
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Aucune action définie</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Attachments (Photos/Videos)</label>
                        @php
                            $attachments = json_decode($event->attachments, true) ?? [];
                        @endphp
                        @if (!empty($attachments))
                            <div class="attachment-list">
                                @foreach ($attachments as $attachment)
                                    <a href="{{ Storage::url($attachment) }}" target="_blank">View Attachment</a>
                                @endforeach
                            </div>
                        @else
                            <div class="detail-value">Aucun attachment</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <a href="{{ route('event.index') }}" class="btn btn-secondary">Retour</a>
                        <a href="{{ route('event.edit', $event->id) }}" class="btn btn-primary" style="background-color: #007bff">Modifier</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>