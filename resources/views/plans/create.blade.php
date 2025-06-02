<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report an Event') }}
        </h2>
    </x-slot>

    <style>
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000 !important;
        }

        .form-section {
            margin-bottom: 20px;
        }

        .form-section h4 {
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #000;
            text-align: center;
            font-weight: bold;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div id="success-message" class="alert alert-success" style="display: none;"></div>
                    <div id="error-message" class="alert alert-danger" style="display: none;"></div>

                    <div class="container">
                        <h1>Plan de Prévention Journalier</h1>
                        <form id="plan_form">
                            @csrf
                            <div class="form-section">
                                <h4>PLAN DE PRÉVENTION JOURNALIER</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><label for="plan_number">N°</label></td>
                                        <td><input type="text" name="plan_number" id="plan_number"
                                                class="form-control" required></td>
                                    </tr>
                                </table>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nom de l'Entreprise</th>
                                            <th>Entreprise principale</th>
                                            <th>Entreprise sous-traitante</th>
                                            <th>Nom de l'intervenant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td><input type="text" name="main_enterprise_1" class="form-control"></td>
                                            <td><input type="text" name="subcontractor_1" class="form-control"></td>
                                            <td><input type="text" name="speaker_1" class="form-control"></td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td><input type="text" name="main_enterprise_2" class="form-control"></td>
                                            <td><input type="text" name="subcontractor_2" class="form-control"></td>
                                            <td><input type="text" name="speaker_3" class="form-control"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-section">
                                <h4>OPÉRATION À EFFECTUER</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><label for="location">Emplacement prévu :</label></td>
                                        <td><input type="text" name="location" id="location" class="form-control"></td>
                                        <td><label for="start_time">Début d'intervention :</label></td>
                                        <td><input type="time" name="start_time" id="start_time"
                                                class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="operation_description">Description :</label></td>
                                        <td colspan="3">
                                            <textarea name="operation_description" id="operation_description" class="form-control"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="operative_mode_number">N° mode opératoire :</label></td>
                                        <td><input type="text" name="operative_mode_number"
                                                id="operative_mode_number" class="form-control"></td>
                                        <td><label for="end_time">Fin d'intervention prévue :</label></td>
                                        <td><input type="time" name="end_time" id="end_time" class="form-control">
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="form-section">
                                <h4>RISQUES D'INTERFÉRENCE AVEC L'OPÉRATION</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>
                                            <textarea name="interference_risks" class="form-control"></textarea>
                                        </td>
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
                                            <td>
                                                <textarea name="work_nature" class="form-control"></textarea>
                                            </td>
                                            <td>
                                                <textarea name="risk_nature" class="form-control"></textarea>
                                            </td>
                                            <td>
                                                <textarea name="training_certifications" class="form-control"></textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-section">
                                <h4>PERMIS ET DOCUMENTS</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><label><input type="checkbox" name="pir_pirl" value="1">
                                                PIR/PIRL</label></td>
                                        <td><label><input type="checkbox" name="technical_document" value="1">
                                                Document Technique Amiante</label></td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="checkbox" name="crane" value="1"> Grue</label>
                                        </td>
                                        <td><label><input type="checkbox" name="work_start_declaration" value="1">
                                                Déclaration d'intention de Commencement de Travaux</label></td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="checkbox" name="scaffolding" value="1">
                                                Échafaudage</label></td>
                                        <td><label><input type="checkbox" name="network_plans" value="1"> Plans de
                                                Réseaux</label></td>
                                    </tr>
                                    <tr>
                                        <td><label><input type="checkbox" name="degassing_certificate"
                                                    value="1"> Certificat de dégazage</label></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><label for="fire_permit">Permis de feu :</label></td>
                                        <td><input type="text" name="fire_permit" id="fire_permit"
                                                class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="specific_permit">Permis spécifique :</label></td>
                                        <td><input type="text" name="specific_permit" id="specific_permit"
                                                class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="other_permit">Autres (préciser) :</label></td>
                                        <td><input type="text" name="other_permit" id="other_permit"
                                                class="form-control"></td>
                                    </tr>
                                </table>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#plan_form').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var submitButton = $(this).find('button[type="submit"]');
                submitButton.prop('disabled', true);

                $.ajax({
                    url: '{{ route('plan.store') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.responseCode == 200) {
                            $('#success-message').text(response.message).show();
                            toastr.success('Form submitted successfully!');
                            setTimeout(() => {
                               window.location.href = '{{ route('plan.index') }}';
                            }, 2000);
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = 'Please fix the following errors:<br>';
                        toastr.error('Please fix the following errors:<br>');
                        $.each(errors, function(key, value) {
                            errorMessage += `- ${value[0]}<br>`;
                        });
                        $('#error-message').html(errorMessage).show();
                        submitButton.prop('disabled', false);
                    }
                });
            });

            // Toggle category content
            window.toggleCategory = function(categoryId) {
                const content = document.getElementById(categoryId);
                content.classList.toggle('active');
            };
        });
    </script>
</x-app-layout>
