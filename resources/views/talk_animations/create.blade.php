<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create - Talk/Animation') }}
        </h2>
    </x-slot>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: rgba(0, 0, 0, .03);
            color: rgb(0, 0, 0);
        }
        .blue-header {
            background-color: rgba(0, 0, 0, .03);
            color: #000000;
            text-align: center;
        }
        .checkbox-group {
            display: flex;
            gap: 20px;
            padding: 10px 0;
        }
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        input[type="text"], input[type="date"], textarea {
            width: 100%;
            border: 1px solid #dee2e6;
            padding: 8px;
            border-radius: 4px;
        }
        .corrosive-img {
            max-width: 50px;
            margin-top: 10px;
        }
        .action-legend {
            font-size: 12px;
            text-align: center;
            padding: 5px;
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
                            <p><strong>Oops Something went wrong</strong></p>
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
                    <a title="new" href="{{ route('talk_animation.create') }}" class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-black uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25">
                        Create New Talk/Animation
                    </a>
                    @endcan
                     <div class="card-header text-black d-flex justify-content-between align-items-center">
                        <h4>Talk Animation</h4>
                    </div>
                    <!-- The Form -->
                    <form id="talkForm" method="POST">
                        @csrf
                        
                        <!-- First Table -->
                        <table>
                            <tr>
                                <th width="15%">DATE :</th>
                                <td width="35%"><input type="date" name="date" required></td>
                                <th width="15%">LIEU (SITE/CHANTIER) :</th>
                                <td width="35%"><input type="text" name="lieu" required></td>
                            </tr>
                            <tr>
                                <th>Thème :</th>
                                <td><input type="text" name="theme" value="Les produits corrosifs" required></td>
                                <th>Animateur(s)</th>
                                <td><input type="text" name="animateur" required></td>
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
                                    <textarea name="points" rows="4" style="width:100%; border:none; padding:8px;" placeholder="Saisir les points couverts"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="blue-header">Commentaires des collaborateurs sur le thème</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div>
                                        <textarea name="commentaires" rows="2" style="width:100%; border:none; padding:8px;" placeholder="Entrer des commentaires"></textarea>
                                        {{-- <img src="{{ asset('images/corrosive_pictogram.png') }}" alt="Pictogramme Corrosif" class="corrosive-img"> --}}
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
                        <table id="actions-table">
                            <tr>
                                <th colspan="7" class="blue-header">Action(s) à mettre en place</th>
                            </tr>
                            <tr>
                                <th width="35%">Action(s) à mettre en place</th>
                                <th width="20%">Responsable</th>
                                <th width="20%">Délai</th>
                                <th width="5%">I</th>
                                <th width="5%">C</th>
                                <th width="5%">P</th>
                                {{-- <th width="5%">Remove</th> --}}
                            </tr>
                            <tr class="action-row">
                                <td><input type="text" name="action[0]"></td>
                                <td><input type="text" name="responsable[0]"></td>
                                <td><input type="date" name="delai[0]"></td>
                                <td style="text-align:center;"><input type="checkbox" name="immediate[]" value="0"></td>
                                <td style="text-align:center;"><input type="checkbox" name="corrective[]" value="0"></td>
                                <td style="text-align:center;"><input type="checkbox" name="preventive[]" value="0"></td>
                                {{-- <td style="text-align:center;"><button type="button" class="btn btn-danger btn-sm remove-action" style="background-color: red;">Remove</button></td> --}}
                            </tr>
                        </table>
                        <button type="button" id="add-action" class="btn btn-outline-dark btn-sm mt-2">Add Action</button>
                        <div class="action-legend mt-2">I : Action Immédiate ; C : Action Corrective ; P : Action Préventive</div>
                        
                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-800 transition ease-in-out duration-150" style="background-color: blue;">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            let actionCount = 0;

            // Add Action Dynamically
            $('#add-action').on('click', function () {
                actionCount++;
                const newAction = `
                    <tr class="action-row">
                        <td><input type="text" name="action[${actionCount}]"></td>
                        <td><input type="text" name="responsable[${actionCount}]"></td>
                        <td><input type="date" name="delai[${actionCount}]"></td>
                        <td style="text-align:center;"><input type="checkbox" name="immediate[]" value="${actionCount}"></td>
                        <td style="text-align:center;"><input type="checkbox" name="corrective[]" value="${actionCount}"></td>
                        <td style="text-align:center;"><input type="checkbox" name="preventive[]" value="${actionCount}"></td>
                        <td style="text-align:center;"><button type="button" class="btn btn-danger btn-sm remove-action" style="background-color: red;">Remove</button></td>
                    </tr>
                `;
                $('#actions-table tbody').append(newAction);
            });

            // Remove Action
            $(document).on('click', '.remove-action', function () {
                $(this).closest('tr').remove();
            });

            // AJAX Form Submission
            $('#talkForm').on('submit', function (e) {
                e.preventDefault();

                const formData = $(this).serialize();
                const submitButton = $(this).find('button[type="submit"]');
                submitButton.prop('disabled', true);

                $.ajax({
                    url: '{{ route("talk_animation.store") }}',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        toastr.success(response.message);
                        if (response.success) {
                            window.location.href = response.redirect;
                        }
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = 'Please fix the following errors:<br>';
                        toastr.error(response.message);
                        $.each(errors, function (key, value) {
                            errorMessage += `- ${value[0]}<br>`;
                        });
                        alert(errorMessage);
                        submitButton.prop('disabled', false);
                    }
                });
            });
        });
    </script>
</x-app-layout>