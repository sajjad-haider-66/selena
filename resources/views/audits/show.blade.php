<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View - Audit') }}
        </h2>
    </x-slot>

    <style>
        .section-title {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .score-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .score-table th,
        .score-table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
        }

        .score-table th {
            background-color: #007bff;
            color: white;
        }

        .action-row {
            background-color: #f8f9fa;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        .btn.btn-primary {
            background-color: #0d6efd !important;
            color: white !important;
        }

        .btn.btn-secondary {
            background-color: #d4d4d4 !important;
            color: white !important;
        }
    </style>

    <div class="row justify-content-center mt-4">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4>Détails de l'Audit</h4>
                    <a href="{{ route('audit.edit', $audit->id) }}" class="btn btn-secondary">Edit Audit</a>
                </div>
                <div class="card-body">
                    <!-- Meta Info -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold">Date</label>
                            <p>{{ $audit->date }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Lieu (site / chantier)</label>
                            <p>{{ $audit->lieu }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold">Auditeur</label>
                            <p>{{ $audit->auditeur }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Nom de l'intervenant</label>
                            <p>{{ $audit->intervenant }}</p>
                        </div>
                    </div>

                    <!-- Questions Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th style="width: 50%;">Thèmes abordés</th>
                                    <th>TS</th>
                                    <th>S</th>
                                    <th>IS</th>
                                    <th>SO</th>
                                    <th>Commentaires</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $questions = [
                                        'L\'intervenant et son métier' => [
                                            'Quelle est votre mission, les enjeux client, les résultats à fournir ?',
                                            'Quels sont les risques associés à votre métier (risques classiques, coactivité, produits chimiques) ?',
                                            'Quelles sont les formations nécessaires (habilitation électrique, autorisations, GIES ½, etc..) ?',
                                            'Quelles sont les habilitations nécessaires ? Sont-elles suffisantes ?',
                                            'Quelles sont les consignes d’urgence du site ? Alerte Gaz / H2S / incendie ?',
                                        ],
                                        'L\'intervenant et ses moyens' => [
                                            'Quels sont les EPI pour cette mission ?',
                                            'État visuel ?',
                                            'Sont-ils adaptés au travail ?',
                                            'Correctement porté ?',
                                        ],
                                        'L\'intervenant et son environnement' => [
                                            'Quels sont les risques liés à l\'environnement client (Culture SSE) ?',
                                            'Quels sont les moyens d\'accès au site et zone d\'intervention ?',
                                            'Respecte-t-il les consignes de sécurité du chantier ?',
                                            'Quelle est la démarche MASE de votre entreprise ?',
                                            'Y a-t-il un Plan de Prévention ou PPSPS ? 3 principaux risques ?',
                                        ],
                                        'L\'intervenant et son relationnel' => [
                                            'Attentes du client en termes de savoir-être ?',
                                            'Remontées d’informations récentes ?',
                                            '(difficultés, aléas, bonnes pratiques, SD…) que vous avez réalisé récemment ?',
                                            'Dernier thème de causerie / animation SSE ?',
                                        ],
                                    ];

                                    // Ensure responses is an array
                                    $responses = is_string($audit->responses)
                                        ? json_decode($audit->responses, true)
                                        : $audit->responses;
                                    $responses = is_array($responses) ? $responses : [];
                                    $radios = ['TS', 'S', 'IS', 'SO'];
                                    $index = 0;
                                @endphp

                                @foreach ($questions as $section => $qs)
                                    <tr class="table-primary fw-bold text-start">
                                        <td colspan="6">{{ $section }}</td>
                                    </tr>

                                    @foreach ($qs as $q)
                                        <tr>
                                            <td class="text-start">{{ $q }}</td>
                                            @foreach ($radios as $r)
                                                <td>
                                                    {{ isset($responses[$index]) && is_array($responses[$index]) && $responses[$index]['note'] == $r ? '✓' : '' }}
                                                </td>
                                            @endforeach
                                            <td>
                                                {{ isset($responses[$index]) && is_array($responses[$index]) ? $responses[$index]['comment'] : '' }}
                                            </td>
                                        </tr>
                                        @php $index++; @endphp
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h5>Culture SSE terrain</h5>
                    <p>{{ $audit->culture_sse ?? 'N/A' }}</p>
                    <p><strong>QSER Score:</strong> {{ $audit->qser_score ?? 'N/A' }}</p>

                    <h5 class="mt-4">Actions à mettre en place</h5>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered align-middle">
                            <thead class="table-secondary text-center">
                                <tr class="table-primary">
                                    <th>Action(s)</th>
                                    <th>Responsable</th>
                                    <th>Délai</th>
                                    <th>Type d'Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $actions = is_array($audit->actions) ? $audit->actions : json_decode($audit->actions, true);
                                @endphp
                                @if (!empty($actions))
                                    @foreach ($actions as $action)
                                        <tr class="action-row">
                                            <td>{{ $action['description'] ?? '' }}</td>
                                            <td>{{ $action['responsable'] ?? '' }}</td>
                                            <td>{{ $action['delai'] ?? '' }}</td>
                                            <td>
                                                {{ $action['type'] == 'Immediate' ? 'Imméd. (I)' : ($action['type'] == 'Corrective' ? 'Corrective (C)' : 'Préventive (P)') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">No actions defined.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Back Button -->
                    <div class="text-center" style="float: left;">
                        <a href="{{ route('audit.index') }}" class="btn btn-primary">Back to Audits</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
