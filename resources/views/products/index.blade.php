<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create - Audit') }}
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
        .header {
            border-bottom: 2px solid #007bff;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #007bff;
            font-size: 24px;
        }
        .row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            align-items: center;
        }
        .label {
            flex: 1;
            font-weight: bold;
            color: #333;
        }
        .input-field, .textarea {
            flex: 2;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
        }
        .textarea {
            height: 100px;
            resize: vertical;
        }
        .table-section {
            width: 100%;
            overflow-x: auto;
            margin-top: 20px;
        }
        .table-section table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-section th, .table-section td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .table-section th {
            background-color: #007bff;
            color: white;
        }
        .submit-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger text-red-600 px-4 py-3 shadow-md mb-3">
                        <strong>Oops! Something went wrong.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Session Error --}}
                @if (session('error'))
                    <div class="alert alert-danger text-red-600 px-4 py-3 shadow-md mb-3">
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                @endif

                    <div class="header">
                        <h1>Formulaire d'Audit</h1>
                    </div>

                    <div class="row">
                        <label class="label">Date :</label>
                        <input type="date" class="input-field" name="audit_date">
                    </div>

                    <div class="row">
                        <label class="label">Lieu (Site/Chantier) :</label>
                        <input type="text" class="input-field" name="location">
                    </div>

                    <div class="row">
                        <label class="label">Auditeur :</label>
                        <input type="text" class="input-field" name="auditor">
                    </div>

                    <div class="row">
                        <label class="label">Intervenant :</label>
                        <input type="text" class="input-field" name="intervenant" placeholder="Nom">
                    </div>

                    <div class="table-section">
                        <table>
                            <thead>
                                <tr>
                                    <th>Thèmes</th>
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
                                        "L'Intervenant et son métier",
                                        "Quelle est votre mission, les enjeux client, les résultats à fournir ?",
                                        "Quels sont les risques associés à votre métier (classiques, coactivité, chimiques, classés) ?",
                                        "Formations nécessaires (habilitation électrique, autorisations, GIES ½, Caces, HARNAIS, etc..)",
                                        "Habilitations nécessaires pour cette mission ? Sont-elles suffisantes ?",
                                        "Que faire en cas d'alerte Gaz ? d'Alerte H2S ? d'alerte incendie ?",
                                        "L'Intervenant et ses moyens",
                                        "Quels sont les EPI pour cette mission ?",
                                        "État visuel des EPI ? Adaptés au travail ?",
                                        "Portés ?",
                                        "L'Intervenant et son environnement"
                                    ];
                                @endphp

                                @foreach ($questions as $question)
                                    <tr>
                                        <td>{{ $question }}</td>
                                        <td><input type="checkbox" name="ts[]"></td>
                                        <td><input type="checkbox" name="s[]"></td>
                                        <td><input type="checkbox" name="is[]"></td>
                                        <td><input type="checkbox" name="so[]"></td>
                                        <td><textarea class="textarea" rows="1" name="comments[]"></textarea></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="submit-btn">Submit Audit</button>
               
            </div>
        </div>
    </div>
</x-app-layout>
