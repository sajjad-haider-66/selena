<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create - Events') }}
        </h2>
    </x-slot>

    <style>

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
                
                <div class="container">
                    <div class="card-header text-black d-flex justify-content-between align-items-center">
                        <h2><strong>Détail d’action</strong></h2>
                    </div>
                    <form id="actionForm">
                        @csrf
                        <div class="form-section">
                            <table class="table table-bordered">
                                <tr>
                                    <td><label for="action_number">Détail d’action N° :</label></td>
                                    <td><input type="text" name="action_number" id="action_number" class="form-control" required></td>
                                </tr>
                                <tr>
                                    <td><label for="origin">Origine :</label></td>
                                    <td><input type="text" name="origin" id="origin" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td><label for="issue_description">Descriptions du dysfonctionnement/amélioration :</label></td>
                                    <td><textarea name="issue_description" id="issue_description" class="form-control"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="issue_date">Date d’émission :</label></td>
                                    <td><input type="date" name="issue_date" id="issue_date" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td><label for="description">Description :</label></td>
                                    <td><textarea name="description" id="description" class="form-control"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="type">Type (I/C/P) :</label></td>
                                    <td>
                                        <select name="type" id="type" class="form-control">
                                            <option value="">Select Type</option>
                                            <option value="Immediate">I</option>
                                            <option value="Corrective">C</option>
                                            <option value="Preventive">P</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="pilot">Pilote :</label></td>
                                    <td><input type="text" name="pilot" id="pilot" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td><label for="deadline">Délai :</label></td>
                                    <td><input type="date" name="deadline" id="deadline" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td><label for="verifier">Vérificateur :</label></td>
                                    <td><input type="text" name="verifier" id="verifier" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td><label for="verified_date">Action vérifiée le :</label></td>
                                    <td><input type="date" name="verified_date" id="verified_date" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td><label for="comment">Commentaire (optionnel) :</label></td>
                                    <td><textarea name="comment" id="comment" class="form-control"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label for="progress_percentage">Taux d’avancement :</label></td>
                                    <td><input type="number" name="progress_percentage" id="progress_percentage" class="form-control" min="0" max="100" step="1"></td>
                                </tr>
                                <tr>
                                    <td><label for="effectiveness">Efficacité :</label></td>
                                         <select name="effectiveness" id="effectiveness" class="form-control">
                                            <option value="">Select Type</option>
                                            <option value="O">O</option>
                                            <option value="N">N</option>
                                        </select>
                                </tr>
                            </table>
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
    </div>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            // AJAX Form Submission
            $('#actionForm').on('submit', function (e) {
                e.preventDefault();

                // Reset messages
                $('#success-message').hide();
                $('#error-message').hide();
                $('.form-control').removeClass('is-invalid');
                $('.form-check-input').removeClass('is-invalid');

                const formData = $(this).serialize();
                const submitButton = $(this).find('button[type="submit"]');
                submitButton.prop('disabled', true);

                $.ajax({
                    url: '{{ route("action.store") }}',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        
                        if (response.responseCode == 200) {
                            $('#success-message').text('Form submitted successfully!').show();
                            toastr.success('Form submitted successfully!');
                            setTimeout(() => {
                            window.location.href = '{{ route('action.index') }}';
                            }, 2000);
                        }
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = 'Please fix the following errors:<br>';
                        toastr.error('Please fix the following errors:<br>');
                        $.each(errors, function (key, value) {
                            errorMessage += `- ${value[0]}<br>`;
                            $(`[name="${key}"]`).addClass('is-invalid');
                        });
                        $('#error-message').html(errorMessage).show();
                        submitButton.prop('disabled', false);
                    }
                });
            });
        });
    </script>
</x-app-layout>
