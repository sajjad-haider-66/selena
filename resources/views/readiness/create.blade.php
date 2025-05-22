<x-app-layout>
    <x-slot name="title">
        Incident Report Form
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create - Daily Work Readiness') }}
        </h2>
    </x-slot>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
            margin: 0;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        .header h1 {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .label {
            flex: 1 1 30%;
            font-weight: bold;
            color: #333;
        }

        .input-field,
        .textarea {
            flex: 1 1 65%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .textarea {
            height: 100px;
            resize: vertical;
        }

        .checkbox-group {
            flex: 1 1 65%;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .image-section img {
            max-width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 10px;
        }

        .submit-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        .alert {
            background: #ffe5e5;
            border-left: 5px solid red;
            margin-bottom: 20px;
            padding: 10px 15px;
            color: #d8000c;
            border-radius: 5px;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                <a href="{{ route('subcategory.index') }}" class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold uppercase bg-green-600 text-white rounded-md hover:bg-green-500">
                    {{ __('Back') }}
                </a>

                @if ($errors->any())
                    <div class="alert">
                        <strong>Oops! Something went wrong:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert">
                        {{ session('error') }}
                    </div>
                @endif

                    <div class="header">
                        <h1>Formulaire de Rapport d'Incident</h1>
                    </div>

                    <form method="POST" action="#">
                        @csrf

                        <div class="row">
                            <div class="label">Date :</div>
                            <input type="date" name="date" class="input-field">
                        </div>

                        <div class="row">
                            <div class="label">Lieu (Site/Chantier) :</div>
                            <input type="text" name="location" class="input-field" value="Station Total Relais des Tilleuls à Chatou">
                        </div>

                        <div class="row">
                            <div class="label">Type d'Événement :</div>
                            <div class="checkbox-group">
                                <div class="checkbox-item"><input type="checkbox" name="event_type[]" value="situation_dangereuse" checked> Situation Dangereuse</div>
                                <div class="checkbox-item"><input type="checkbox" name="event_type[]" value="presque_accident"> Presque Accident</div>
                                <div class="checkbox-item"><input type="checkbox" name="event_type[]" value="incident"> Incident</div>
                                <div class="checkbox-item"><input type="checkbox" name="event_type[]" value="accident"> Accident</div>
                                <div class="checkbox-item"><input type="checkbox" name="event_type[]" value="maladie"> Maladie Professionnelle</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="label">Émetteur :</div>
                            <input type="text" name="emetteur" class="input-field">
                        </div>

                        <div class="row">
                            <div class="label">Domaine :</div>
                            <div class="checkbox-group">
                                <div class="checkbox-item"><input type="checkbox" name="domaine[]" value="securite" checked> Sécurité</div>
                                <div class="checkbox-item"><input type="checkbox" name="domaine[]" value="sante"> Santé</div>
                                <div class="checkbox-item"><input type="checkbox" name="domaine[]" value="environnement"> Environnement</div>
                                <div class="checkbox-item"><input type="checkbox" name="domaine[]" value="rse"> RSE</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="label">Circonstances Détaillées :</div>
                            <textarea name="details" class="textarea">Lors de notre intervention au sein de Total Relais des Tilleuls à Chatou pour une opération de nettoyage haute pression, nous avons projeté de l'eau sur le coffret électrique provoquant un court-circuit. Éclairage coupé dans la station de lavage.</textarea>
                        </div>

                        <div class="image-section">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==" alt="Incident Image">
                        </div>

                        <div class="row">
                            <div class="label">Risques Encourus :</div>
                            <textarea name="risks" class="textarea">Le risque encourus aurait pu provoquer un départ de feu du coffret ainsi qu'un dommage financier au niveau de l'éclairage.</textarea>
                        </div>
                        <div class="header mt-8">
                            <h1>Analyse simplifiée (Recueil des faits sur les manquements liés aux risques identifiés ci-dessous)</h1>
                        </div>

                            <div class="row">
                                <div class="label w-full font-semibold">Sécurité des accès :</div>
                                <div class="checkbox-group">
                                    @foreach(['Chute de plain pied ou escalier', 'Chute dans trémie sans protection ou mal protégée', 'Chute de hauteur', 'Chute d’objet', 'Franchissement d’un balisage ou d’un garde-corps', 'Cheminement non sécurisé (manque de visibilité, obstacle, sol instable …)'] as $item)
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="access_security[]" value="{{ $item }}"> {{ $item }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="row">
                                <div class="label w-full font-semibold">Matériel de sécurité :</div>
                                <div class="checkbox-group">
                                    @foreach(['Matériel de sécurité non vérifié', 'Matériel de sécurité inadapté', 'Matériel de sécurité indisponible', 'Non-respect d’une consigne de sécurité', 'Non port des EPI', 'Non utilisation d’EPC'] as $item)
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="safety_equipment[]" value="{{ $item }}"> {{ $item }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="row">
                                <div class="label w-full font-semibold">Information sur les risques :</div>
                                <div class="checkbox-group">
                                    @foreach(['Absence de PdP ou de PPSPS', 'Non communication du PdP ou du PPSPS au collaborateur', 'Information sur les risques potentiels incomplète ou absente', 'Absence d’accueil sécurité sur le site'] as $item)
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="risk_information[]" value="{{ $item }}"> {{ $item }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="row">
                                <div class="label w-full font-semibold">Ambiances et situations de travail :</div>
                                <div class="checkbox-group">
                                    @foreach(['Produits toxiques, nocifs', 'Produits corrosifs, irritants', 'Risque électrique', 'Risque d’incendie, d’explosion', 'Risques liés à la coactivité (interventions superposées)', 'Modification des risques en cours de mission', 'Conditions d’hygiène dans les locaux'] as $item)
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="work_conditions[]" value="{{ $item }}"> {{ $item }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="row">
                                <div class="label w-full font-semibold">Formation sécurité / Habilitations :</div>
                                <div class="checkbox-group">
                                    @foreach(['Formation sécurité insuffisante ou absente', 'Intervention d’un collaborateur non habilité', 'Habilitation périmée, à réexaminée'] as $item)
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="training_issues[]" value="{{ $item }}"> {{ $item }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="row">
                                <div class="label">Autres :</div>
                                <textarea name="other_notes" class="textarea"></textarea>
                            </div>
 
                        <div class="header mt-8">
                            <h1>Cotation du risque</h1>
                        </div>

                        <div class="grid grid-cols-3 gap-4 border p-4">
                            <div>
                                <strong>F : Fréquence d’exposition à ce danger</strong>
                                <ul>
                                    <li>1 : Faible (expo. &lt; 1 fois par an)</li>
                                    <li>2 : Moyenne (expo. &lt; 1 fois par mois)</li>
                                    <li>3 : Grande (expo. &gt; 1 fois par mois)</li>
                                    <li>4 : Grande (expo. &gt; 1 fois par semaine)</li>
                                </ul>
                            </div>
                            <div>
                                <strong>G : Gravité des dommages qui auraient pu survenir</strong>
                                <ul>
                                    <li>1 : Gêne ou dommage léger (Soin infirmier)</li>
                                    <li>2 : Blessure légère (ASA)</li>
                                    <li>3 : Blessure grave (AAA)</li>
                                    <li>4 : Blessure grave (ATMORTEL)</li>
                                </ul>
                            </div>
                            <div>
                                <strong>C : Cotation du risque</strong>
                                <ul>
                                    <li>C = 1 à 6 ➔ <span class="text-green-600">Action à entreprendre sous 1 semaine</span></li>
                                    <li>C = 6 à 10 ➔ <span class="text-blue-600">Action à entreprendre sous 48 h</span></li>
                                    <li>C &gt; 10 ➔ <span class="text-red-600 font-bold">Action urgente à entreprendre immédiatement</span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="font-semibold">Propositions pour éviter que cette situation dangereuse ne se reproduise :</label>
                            <textarea name="prevention_proposal" class="textarea w-full">Rénover les coffrets électriques par des coffrets étanche et protéger tous les coffrets avant toute intervention</textarea>
                        </div>

                        <div class="mt-6">
                            <h2 class="font-semibold">Nature des mesures qui permettraient d’éviter un accident</h2>
                            <div class="checkbox-group grid grid-cols-2 gap-2">
                                <div>
                                    <label>
                                        <input type="checkbox" name="measures[]" value="Information / formation" checked>
                                        Information / formation
                                    </label>
                                    <p class="text-sm text-gray-600 ml-6">Information sur les dangers, procédures, plan de prévention, signalisation</p>
                                </div>
                                <div>
                                    <label>
                                        <input type="checkbox" name="measures[]" value="Organisation" checked>
                                        Organisation
                                    </label>
                                    <p class="text-sm text-gray-600 ml-6">Préparation de la mission (bien protéger les coffrets électriques et autres éléments...)</p>
                                </div>
                                <div>
                                    <label>
                                        <input type="checkbox" name="measures[]" value="Equipement de sécurité">
                                        Equipement de sécurité
                                    </label>
                                  
                                </div>
                             
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <button type="submit" class="submit-btn">Soumettre</button>
                        </div>
                    </form>

                </div>
            </div>
    </div>
</x-app-layout>
