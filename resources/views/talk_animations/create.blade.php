<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Talk/Animation
        </h2>
    </x-slot>
    
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid black;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #0066cc;
            color: white;
            font-weight: bold;
        }
        .blue-header {
            background-color: #0066cc;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 8px;
        }
        input[type="text"], input[type="date"] {
            width: 100%;
            border: none;
            padding: 5px;
            box-sizing: border-box;
        }
        .checkbox-group {
            display: flex;
            gap: 30px;
            padding: 10px;
        }
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .checkbox-item.security {
            color: red;
        }
        .checkbox-item.health {
            color: blue;
        }
        .checkbox-item.environment {
            color: green;
        }
        .checkbox-item.rse {
            color: #FF8C00; /* Orange for RSE */
        }
        .checkbox-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 5px;
        }
        .corrosive-img {
            display: block;
            margin: 10px auto;
            max-width: 120px;
        }
        .action-legend {
            text-align: center;
            font-size: 0.9em;
        }
    </style>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Success and Error Messages -->
                    @if (session('success'))
                        <div class="alert alert-success bg-green-100 border-t-4 border-green-500 rounded-b text-green-600 px-4 py-3 shadow-md my-3" role="alert">
                            <div class="flex">
                                <div>
                                    <p class="text-sm text-success">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-b text-red-600 px-4 py-3 shadow-md my-3" role="alert">
                            <p><strong>Opps Something went wrong</strong></p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger rounded-b text-red-600 px-4 py-3 shadow-md my-3" role="alert">
                            <div class="flex">
                                <div>
                                    <p class="text-sm text-danger">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Permission based button -->
                    @can('category-create')
                    <a title="new" href="{{ route('category.create') }}" class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-black uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25">
                        Create New Talk/Animation
                    </a>
                    @endcan
                    
                    <!-- The Form -->
                    <form method="POST" action="">
                        @csrf
                        
                        <!-- First Table -->
                        <table>
                            <tr>
                                <th width="15%">DATE :</th>
                                <td width="35%"><input type="date" name="date"></td>
                                <th width="15%">LIEU (SITE/CHANTIER) :</th>
                                <td width="35%"><input type="text" name="lieu"></td>
                            </tr>
                            <tr>
                                <th>Thème :</th>
                                <td><input type="text" name="theme" value="Les produits corrosifs"></td>
                                <th>Animateur(s)</th>
                                <td><input type="text" name="animateur"></td>
                            </tr>
                            <tr>
                                <th>Signature</th>
                                <td colspan="3"><input type="text" name="signature"></td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div class="checkbox-group">
                                        <div class="checkbox-item security">
                                            <input type="checkbox" name="security" id="security">
                                            <label for="security">Sécurité</label>
                                        </div>
                                        <div class="checkbox-item health">
                                            <input type="checkbox" name="health" id="health">
                                            <label for="health">Santé</label>
                                        </div>
                                        <div class="checkbox-item environment">
                                            <input type="checkbox" name="environment" id="environment">
                                            <label for="environment">Environnement</label>
                                        </div>
                                        <div class="checkbox-item rse">
                                            <input type="checkbox" name="rse" id="rse">
                                            <label for="rse">RSE</label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="blue-header">Principaux points abordés</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <textarea name="points" rows="4" style="width:100%; border:none; padding:8px;">Un produit corrosif est un produit qui va attaquer et détruire la matière organique donc les tissus corporels. La plupart sont des acides et des bases : les acides corrosifs les plus communs sont les acides chlorhydriques, sulfuriques, nitriques, chromiques, acétiques et fluorhydriques (avec une toxicité particulière)</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="blue-header">Commentaires des collaborateurs sur le thème</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div>
                                        <textarea name="commentaires" rows="2" style="width:100%; border:none; padding:8px;">En voyant ce pictogramme, il faut bien penser à s'équiper des EPI adéquates</textarea>
                                        <img src="{{ asset('images/corrosive_pictogram.png') }}" alt="Pictogramme Corrosif" class="corrosive-img">
                                    </div>
                                </td>
                            </tr>
                        </table>
                        
                        <!-- Participants Table -->
                        <table>
                            <tr>
                                <th colspan="2">Participants</th>
                            </tr>
                            <tr>
                                <th width="50%">NOM, Prénom</th>
                                <th width="50%">Signature</th>
                            </tr>
                            @for ($i = 0; $i < 6; $i++)
                            <tr>
                                <td><input type="text" name="participant_name[]"></td>
                                <td><input type="text" name="participant_signature[]"></td>
                            </tr>
                            @endfor
                        </table>
                        
                        <!-- Actions Table -->
                        <table>
                            <tr>
                                <th colspan="6" class="blue-header">Action(s) à mettre en place</th>
                            </tr>
                            <tr>
                                <th width="40%">Action(s) à mettre en place</th>
                                <th width="20%">Responsable</th>
                                <th width="20%">Délai</th>
                                <th width="5%">I</th>
                                <th width="5%">C</th>
                                <th width="5%">P</th>
                            </tr>
                            @for ($i = 0; $i < 3; $i++)
                            <tr>
                                <td><input type="text" name="action[]"></td>
                                <td><input type="text" name="responsable[]"></td>
                                <td><input type="text" name="delai[]"></td>
                                <td style="text-align:center;"><input type="checkbox" name="immediate[]" value="{{ $i }}"></td>
                                <td style="text-align:center;"><input type="checkbox" name="corrective[]" value="{{ $i }}"></td>
                                <td style="text-align:center;"><input type="checkbox" name="preventive[]" value="{{ $i }}"></td>
                            </tr>
                            @endfor
                            <tr>
                                <td colspan="6" class="action-legend">I : Action Immédiate ; C : Action Corrective ; P : Action Préventive</td>
                            </tr>
                        </table>
                        
                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-800 transition ease-in-out duration-150">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>