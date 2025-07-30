<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit - Talk/Animation') }}
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
            background-color: rgba(0, 0, 0, .03);;
            color: rgb(0, 0, 0);
        }
        .blue-header {
            background-color: rgba(0, 0, 0, .03);;
            color: rgb(0, 0, 0);
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
                    
                     <div class="card-header text-black d-flex justify-content-between align-items-center">
                        <h4>Talk Animation</h4>
                    </div>
                    <!-- The Form -->
                    <form id="talkForm" enctype="multipart/form-data" data-id="{{ $talk['id']}}">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <!-- First Table -->
                        <table>
                            <tr>
                                <th width="15%">DATE :</th>
                                <td width="35%"><input type="date" name="date" value="{{ $talk['date'] ?? ''}}" required></td>
                                <th width="15%">LIEU (SITE/CHANTIER) :</th>
                                <td width="35%"><input type="text" name="lieu" value="{{ $talk['lieu'] ?? ''}}" required></td>
                            </tr>
                            <tr>
                                <th>Thème :</th>
                                <td><input type="text" name="theme" value="{{ $talk['theme'] ?? ''}}" placeholder="Les produits corrosifs" required></td>
                                <th>Animateur(s)</th>
                                <td class="animatuer-section">
                                    @foreach($talk['animateur'] as $key => $animateur)
                                        <div class="input-group mb-2">
                                            <input class="form-control" type="text" name="animateur[{{ $key }}]" value="{{ $animateur }}" required>
                                            @if($key > 0)
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-danger remove-animateur">Remove</button>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                    <button type="button" id="add-animateur" class="btn btn-outline-dark btn-sm mt-2">Add More</button>
                                </td>
                              
                            </tr>
                            {{-- <tr>
                                <th>Signature</th>
                                <td colspan="3"><input type="text" value="{{ $talk['signature'] ?? ''}}" name="signature"></td>
                            </tr> --}}
                            <tr>
                                <td colspan="4">
                                    <div class="checkbox-group">
                                        <div class="checkbox-item security">
                                            <input type="checkbox" name="security" id="security" {{ $talk['security'] == 1 ? 'checked' : ''}}>
                                            <label for="security">Sécurité</label>
                                        </div>
                                        <div class="checkbox-item health">
                                            <input type="checkbox" name="health" id="health" {{ $talk['health'] == 1 ? 'checked' : ''}}>
                                            <label for="health">Santé</label>
                                        </div>
                                        <div class="checkbox-item environment">
                                            <input type="checkbox" name="environment" id="environment" {{ $talk['environment'] == 1 ? 'checked' : ''}}>
                                            <label for="environment">Environnement</label>
                                        </div>
                                        <div class="checkbox-item rse">
                                            <input type="checkbox" name="rse" id="rse" {{ $talk['rse'] == 1 ? 'checked' : ''}}>
                                            <label for="rse">RSE</label>
                                        </div>
                                         <div class="checkbox-item Surete">
                                            <input type="checkbox" name="Surete" id="Surete" {{ $talk['Surete'] == 1 ? 'checked' : ''}}>
                                            <label for="Surete">Surete</label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="blue-header">Principaux points abordés</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <textarea name="points" rows="4" style="width:100%; border:none; padding:8px;" placeholder="Saisir les points couverts">{{ $talk->points }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="blue-header">Commentaires des collaborateurs sur le thème</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div>
                                         <input type="file" name="corrosive_image" accept="image/*" class="form-control mb-2">
                                         <!-- Textarea for Description -->
                                        <textarea name="commentaires" rows="3" class="form-control" placeholder="Enter image description...">{{ $talk->commentaires }}</textarea>
                                        <div colspan="4">
                                            <div class="mt-2" class="mb-2">
                                                @if ($talk->path)
                                                <i class="fa fa-trash-o click-remove" aria-hidden="true" style="color:red; cursor: pointer"> Remove Image</i>
                                                    <img src="{{ asset('storage/' . $talk->path) }}" alt="Uploaded Image"
                                                        width="200" height="150" class="rounded shadow">
                                                @else
                                                    <p><em>Aucune image disponible</em></p>
                                                @endif
                                            </div>
                                        </dive>
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
                                <th width="50%">Nom</th>
                                <th width="50%">Prénom</th>
                            </tr>
                            @foreach (json_decode($talk->participants, true) as $participant)
                           <tbody id="participant-body">
                             <tr>
                                <td><input type="text" name="participant_name[]" value="{{ $participant['name'] }}"></td>
                                <td><input type="text" name="participant_signature[]" value="{{ $participant['signature'] }}"></td>
                            </tr>
                          
                           </tbody>
                            @endforeach
                              <tr>
                                <td colspan="3">
                                    <button type="button" id="add-participant" class="btn btn-outline-dark btn-sm">Add More</button>
                                </td>
                            </tr>
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
                                <th width="15%">Type d'Action</th>
                                <th width="5%">Remove</th>
                            </tr>
                            @foreach (json_decode($talk->actions, true) as $index => $action)
                                <tr class="action-row">
                                    <td><textarea name="actions[{{ $index }}][action]" class="form-control" required>{{ $action['action'] }}</textarea></td>
                                    <td><input type="text" name="actions[{{ $index }}][responsable]" class="form-control" value="{{ $action['responsable'] }}" required></td>
                                    <td><input type="date" name="actions[{{ $index }}][delai]" class="form-control" value="{{ $action['delai'] }}" required></td>
                                    <td>
                                        <select name="actions[{{ $index }}][type]" class="form-select" required>
                                            <option value="Immediate" {{ $action['type'] == 'Immediate' ? 'selected' : '' }}>Imméd. (I)</option>
                                            <option value="Corrective" {{ $action['type'] == 'Corrective' ? 'selected' : '' }}>Corrective (C)</option>
                                            <option value="Preventive" {{ $action['type'] == 'Preventive' ? 'selected' : '' }}>Préventive (P)</option>
                                        </select>
                                    </td>
                                    <td><button type="button" class="btn btn-danger remove-action" {{ $index == 0 ? 'disabled' : '' }}>Remove</button></td>
                                </tr>
                            @endforeach
                        </table>
                        <button type="button" id="add-action" class="btn btn-outline-dark btn-sm mt-2">Add Action</button>
                        <div class="action-legend mt-2">I : Action Immédiate ; C : Action Corrective ; P : Action Préventive</div>
                        
                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-800 transition ease-in-out duration-150" style="background-color: blue;">
                                Update
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
                        <td><input type="text" name="actions[${actionCount}][action]"></td>
                        <td><input type="text" name="actions[${actionCount}][responsable]"></td>
                        <td><input type="date" name="actions[${actionCount}][delai]"></td>
                        <td>
                            <select name="actions[${actionCount}][type]" class="form-select">
                                <option value="Immediate">Imméd. (I)</option>
                                <option value="Corrective">Corrective (C)</option>
                                <option value="Preventive">Préventive (P)</option>
                            </select>
                        </td>
                        <td style="text-align:center;"><button type="button" class="btn btn-danger btn-sm remove-action" style="background-color: red;">Remove</button></td>
                    </tr>
                `;
                $('#actions-table tbody').append(newAction);
            });

            // Remove Action
            $(document).on('click', '.remove-action', function () {
                $(this).closest('tr').remove();
            });

            let animCount = 0;
            
            // Add anim Dynamically
            $('#add-animateur').on('click', function () {
                animCount++;
                const newAnim = `
                    <div class="input-group mt-2 remove-animateur-input">
                        <input type="text" name="animateur[${animCount}]" class="form-control" required>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger  remove-animateur">Remove</button>
                        </div>
                    </div>
                `;
                $(this).before(newAnim);
            });

            // Remove anim
            $(document).on('click', '.remove-animateur', function () {
                $(this).closest('.remove-animateur-input').remove();
            });

            // Remove Image
            $('body').on('click', '.click-remove', function (e) {
                e.preventDefault();
                if (confirm("Are you sure you want to remove this image?")) {
                    $.ajax({
                        url: "{{ route('talk.removeImage', $talk->id) }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                location.reload();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            toastr.error('An error occurred while removing the image.');
                        }
                    });
                }
            });

            // add participant
            $('#add-participant').on('click', function () {
                var newRow = `
                    <tr class="participant-row">
                        <td><input type="text" name="participant_name[]" class="form-control"></td>
                        <td><input type="text" name="participant_signature[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                    </tr>`;
                $('#participant-body').append(newRow);
            });

            // Remove button handler
            $(document).on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
            });

            // AJAX Form Submission
          $('#talkForm').on('submit', function (e) {
        e.preventDefault();

    const form = $(this);
    const formData = new FormData(this); // Create FormData from the form
    const submitButton = form.find('button[type="submit"]');
    const id = form.data('id');

    submitButton.prop('disabled', true);

        $.ajax({
            url: '{{ route("talk_animation.update", ":id") }}'.replace(':id', id), // Dynamic route with ID
            type: 'POST', // Use POST with _method=PUT for Laravel
            data: formData,
            contentType: false, // Required for file uploads
            processData: false, // Required for file uploads
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
            },
            success: function (response) {
                if (response.responseCode == 200) {
                    toastr.success('Talk event updated successfully.');
                    setTimeout(() => {
                        window.location.href = '{{ route("talk_animation.index") }}';
                    }, 2000);
                }
            },
            error: function (xhr) {
                submitButton.prop('disabled', false);
                const errors = xhr.responseJSON?.errors || {};
                let errorMessage = 'Please fix the following errors:<br>';
                if (Object.keys(errors).length > 0) {
                    $.each(errors, function (key, value) {
                        errorMessage += `- ${value[0]}<br>`;
                    });
                } else {
                    errorMessage = xhr.responseJSON?.message || 'An error occurred.';
                }
                toastr.error(errorMessage);
            }
        });
    });
        });
    </script>
</x-app-layout>