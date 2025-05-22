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
        .checklist-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .checklist-item {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
        }
        .checklist-item:last-child {
            border-bottom: none;
        }
        .checklist-item label {
            font-weight: 600;
            color: #343a40;
        }
        .form-check {
            margin-left: 20px;
        }
        .form-check-input {
            margin-top: 3px;
        }
        .form-check-label {
            color: #495057;
        }
        .progress-container {
            margin: 20px 0;
            text-align: center;
        }
        .progress-label {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #212529;
        }
        .progress {
            height: 25px;
            border-radius: 5px;
            background-color: #e9ecef;
        }
        .progress-bar {
            font-weight: bold;
            font-size: 1rem;
            transition: width 0.3s ease-in-out;
        }
        .alert-green .progress-bar {
            background-color: #28a745;
        }
        .alert-blocked .progress-bar {
            background-color: #dc3545;
        }
        .btn-submit {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            font-size: 1.1rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
          #success-message, #error-message {
            display: none;
            margin-bottom: 20px;
        }
        .error-border {
            border: 1px solid #dc3545 !important;
        }
    </style>

 <div class="row justify-content-center mt-4">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Confined Spaces Checklist</h4>
                    <span class="badge bg-light text-dark">Total Energies</span>
                </div>
                <div class="card-body">
                    <div id="success-message" class="alert alert-success"></div>
                    <div id="error-message" class="alert alert-danger"></div>
                    <form id="readinessForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" name="date" id="date" class="form-control">
                                <div class="invalid-feedback">Please select a date.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="site_name" class="form-label">Lieu (Site)</label>
                                <input type="text" name="site_name" id="site_name" class="form-control">
                                <div class="invalid-feedback">Please select a site.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="company_name" class="form-label">Entreprise observée (Company)</label>
                                <input type="text" name="company_name" id="company_name" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="permit_number" class="form-label">Numéro de permis</label>
                                <input type="text" name="permit_number" id="permit_number" class="form-control">
                            </div>
                        </div>

                        <div class="checklist-section">
                            <h5 class="mb-3">Points à vérifier</h5>
                            <div id="checklist">
                                <!-- Question 1 -->
                                <div class="checklist-item">
                                    <label class="form-label">1. La vérification «Feu Vert Sécurité» a-t-elle été réalisée ?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[0][answer]" value="Yes" class="form-check-input checklist-input">
                                            <label class="form-check-label">Oui</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[0][answer]" value="No" class="form-check-input checklist-input">
                                            <label class="form-check-label">Non</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="checklist_data[0][answer]" value="N/A" class="form-check-input checklist-input">
                                            <label class="form-check-label">N/A</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="checklist_data[0][question]" value="La vérification *Feu Vert Sécurité* a-t-elle été réalisée ?">
                                    <input type="hidden" name="checklist_data[0][score]" value="1">
                                    <div class="invalid-feedback">Please select an option.</div>
                                </div>
                                <!-- Question 2 -->
                                <div class="checklist-item">
                                    <label class="form-label">2. Appliquer la check-list «Travaux sur systèmes
                                        dé-énergisés » pour chaque énergie et répondre:
                                        tous les points applicables sont-ils conformes ?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[1][answer]" value="Yes" class="form-check-input checklist-input" >
                                            <label class="form-check-label">Oui</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[1][answer]" value="No" class="form-check-input checklist-input">
                                            <label class="form-check-label">Non</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="checklist_data[1][answer]" value="N/A" class="form-check-input checklist-input">
                                            <label class="form-check-label">N/A</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="checklist_data[1][question]" value="Appliquer la check-list «Travaux sur systèmes
                                        dé-énergisés » pour chaque énergie et répondre:
                                        tous les points applicables sont-ils conformes ?">
                                    <input type="hidden" name="checklist_data[1][score]" value="1">
                                    <div class="invalid-feedback">Please select an option.</div>
                                </div>
                                <!-- Question 3 -->
                                <div class="checklist-item">
                                    <label class="form-label">3. Une vérification d’atmosphère a-t-elle
                                    été réalisée avant l’entrée dans l’ espace confiné ?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[2][answer]" value="Yes" class="form-check-input checklist-input" >
                                            <label class="form-check-label">Oui</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[2][answer]" value="No" class="form-check-input checklist-input">
                                            <label class="form-check-label">Non</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="checklist_data[2][answer]" value="N/A" class="form-check-input checklist-input">
                                            <label class="form-check-label">N/A</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="checklist_data[2][question]" value="Une vérification d’atmosphère a-t-elle
                                    été réalisée avant l’entrée dans l’ espace confiné ?">
                                    <input type="hidden" name="checklist_data[2][score]" value="1">
                                    <div class="invalid-feedback">Please select an option.</div>
                                </div>
                                <!-- Question 4 -->
                                <div class="checklist-item">
                                    <label class="form-label">4. L’atmosphère est-elle surveillée (ou régulièrement
                                        testée) pendant toute la présence en espace confiné ?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[3][answer]" value="Yes" class="form-check-input checklist-input" >
                                            <label class="form-check-label">Oui</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[3][answer]" value="No" class="form-check-input checklist-input">
                                            <label class="form-check-label">Non</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="checklist_data[3][answer]" value="N/A" class="form-check-input checklist-input">
                                            <label class="form-check-label">N/A</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="checklist_data[3][question]" value="L’atmosphère est-elle surveillée (ou régulièrement
                                        testée) pendant toute la présence en espace confiné ?">
                                    <input type="hidden" name="checklist_data[3][score]" value="1">
                                    <div class="invalid-feedback">Please select an option.</div>
                                </div>
                                <!-- Question 5 -->
                                <div class="checklist-item">
                                    <label class="form-label">5. La surveillance à l’entrée est-elle déterminée
                                        et assurée en tout temps ?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[4][answer]" value="Yes" class="form-check-input checklist-input" >
                                            <label class="form-check-label">Oui</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[4][answer]" value="No" class="form-check-input checklist-input">
                                            <label class="form-check-label">Non</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="checklist_data[4][answer]" value="N/A" class="form-check-input checklist-input">
                                            <label class="form-check-label">N/A</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="checklist_data[4][question]" value="La surveillance à l’entrée est-elle déterminée
                                        et assurée en tout temps ?">
                                    <input type="hidden" name="checklist_data[4][score]" value="1">
                                    <div class="invalid-feedback">Please select an option.</div>
                                </div>
                                <!-- Question 6 -->
                                <div class="checklist-item">
                                    <label class="form-label">6. LLe nombre de personnes présentes
                                    dans l’espace confiné est-il suivi à tout moment
                                    du travail dans l’espace confiné ?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[5][answer]" value="Yes" class="form-check-input checklist-input" >
                                            <label class="form-check-label">Oui</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[5][answer]" value="No" class="form-check-input checklist-input">
                                            <label class="form-check-label">Non</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="checklist_data[5][answer]" value="N/A" class="form-check-input checklist-input">
                                            <label class="form-check-label">N/A</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="checklist_data[5][question]" value="LLe nombre de personnes présentes
                                    dans l’espace confiné est-il suivi à tout moment
                                    du travail dans l’espace confiné ?">
                                    <input type="hidden" name="checklist_data[5][score]" value="1">
                                    <div class="invalid-feedback">Please select an option.</div>
                                </div>
                                <!-- Question 7 -->
                                <div class="checklist-item">
                                    <label class="form-label">7. La communication entre le personnel de surveillance
                                    de l’entrée et les entrants est-elle en place
                                    et régulièrement testée ?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[6][answer]" value="Yes" class="form-check-input checklist-input" >
                                            <label class="form-check-label">Oui</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[6][answer]" value="No" class="form-check-input checklist-input">
                                            <label class="form-check-label">Non</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="checklist_data[6][answer]" value="N/A" class="form-check-input checklist-input">
                                            <label class="form-check-label">N/A</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="checklist_data[6][question]" value="La communication entre le personnel de surveillance
                                    de l’entrée et les entrants est-elle en place
                                    et régulièrement testée ?">
                                    <input type="hidden" name="checklist_data[6][score]" value="1">
                                    <div class="invalid-feedback">Please select an option.</div>
                                </div>
                                <!-- Question 8 -->
                                <div class="checklist-item">
                                    <label class="form-label">8. L’espace confiné est-il ventilé ?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[7][answer]" value="Yes" class="form-check-input checklist-input" >
                                            <label class="form-check-label">Oui</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[7][answer]" value="No" class="form-check-input checklist-input">
                                            <label class="form-check-label">Non</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="checklist_data[7][answer]" value="N/A" class="form-check-input checklist-input">
                                            <label class="form-check-label">N/A</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="checklist_data[7][question]" value="Les permis de travail sont-ils validés ?">
                                    <input type="hidden" name="checklist_data[7][score]" value="1">
                                    <div class="invalid-feedback">Please select an option.</div>
                                </div>
                                <!-- Question 9 -->
                                <div class="checklist-item">
                                    <label class="form-label">9. Si requise par le permis de travail, une protection
                                    respiratoire adaptée est-elle utilisée ?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[8][answer]" value="Yes" class="form-check-input checklist-input" >
                                            <label class="form-check-label">Oui</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[8][answer]" value="No" class="form-check-input checklist-input">
                                            <label class="form-check-label">Non</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="checklist_data[8][answer]" value="N/A" class="form-check-input checklist-input">
                                            <label class="form-check-label">N/A</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="checklist_data[8][question]" value="Si requise par le permis de travail, une protection
                                    respiratoire adaptée est-elle utilisée ?">
                                    <input type="hidden" name="checklist_data[8][score]" value="1">
                                     <div class="invalid-feedback">Please select an option.</div>
                                </div>
                                <!-- Question 10 -->
                                <div class="checklist-item">
                                    <label class="form-label">10. Le plan de sauvetage est-il connu et prêt à être activé ?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[9][answer]" value="Yes" class="form-check-input checklist-input" >
                                            <label class="form-check-label">Oui</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input type="radio" name="checklist_data[9][answer]" value="No" class="form-check-input checklist-input">
                                            <label class="form-check-label">Non</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="checklist_data[9][answer]" value="N/A" class="form-check-input checklist-input">
                                            <label class="form-check-label">N/A</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="checklist_data[9][question]" value="Le plan de sauvetage est-il connu et prêt à être activé ?">
                                    <input type="hidden" name="checklist_data[9][score]" value="1">
                                    <div class="invalid-feedback">Please select an option.</div>
                                </div>
                            </div>
                        </div>

                        <div class="progress-container">
                            <div class="progress-label" id="readiness-label">Readiness Rate: 0%</div>
                            <div class="progress" id="readiness-progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>

                          <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="commentaires" class="form-label">Commentaires</label>
                                <input type="text" name="commentaires" id="commentaires" class="form-control" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" name="nom" id="nom" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="entreprise" class="form-label">Entreprise</label>
                                <input type="text" name="entreprise" id="entreprise" class="form-control">
                            </div>
                            {{-- <div class="col-md-6 mb-3">
                                <label for="signature" class="form-label">Signature</label>
                                <input type="text" name="signature" id="signature" class="form-control @error('signature') is-invalid @enderror" value="{{ old('signature') }}">
                                @error('signature')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                        </div>

                        <button type="submit" class="btn btn-submit w-100">Submit Checklist</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            // Readiness Rate Calculation
            const checklistInputs = $('.checklist-input');
            const readinessLabel = $('#readiness-label');
            const progressBar = $('#readiness-progress .progress-bar');

            function calculateReadinessRate() {
                let totalScore = 0;
                let count = 0;
                checklistInputs.each(function () {
                    if (this.checked && this.value === 'Yes') {
                        totalScore += parseInt($(this).closest('.checklist-item').find('input[name$="[score]"]').val());
                    }
                    if (this.checked) {
                        count++;
                    }
                });
                const rate = count ? (totalScore / count) * 100 : 0;
                readinessLabel.text(`Readiness Rate: ${rate.toFixed(1)}%`);
                progressBar.css('width', `${rate}%`);
                progressBar.text(`${rate.toFixed(1)}%`);
                progressBar.parent().removeClass('alert-green alert-blocked');
                progressBar.parent().addClass(rate >= 75 ? 'alert-green' : 'alert-blocked');
            }

            checklistInputs.on('change', calculateReadinessRate);

            // AJAX Form Submission
            $('body').on('submit', '#readinessForm', function (e) {
                e.preventDefault(); // Prevent default form submission

                const formData = $(this).serialize(); // Serialize form data
                const submitButton = $(this).find('button[type="submit"]');
                submitButton.prop('disabled', true); // Disable submit button to prevent multiple submissions

                // Reset previous error states
                $('#success-message').hide();
                $('#error-message').hide();
                $('.form-control').removeClass('error-border');
                $('.checklist-item').removeClass('error-border');
                $('.invalid-feedback').hide();

                  // Client-side validation
                let hasError = false;
                const dateInput = $('#date');
                const siteInput = $('#site_name');
                const checklistItems = $('.checklist-item');

                if (!dateInput.val()) {
                    dateInput.addClass('error-border');
                    dateInput.next('.invalid-feedback').show();
                    hasError = true;
                }
                if (!siteInput.val()) {
                    siteInput.addClass('error-border');
                    siteInput.next('.invalid-feedback').show();
                    hasError = true;
                }
                checklistItems.each(function () {
                    const radioGroup = $(this).find('input[type="radio"]');
                    if (!radioGroup.is(':checked')) {
                        $(this).addClass('error-border');
                        $(this).find('.invalid-feedback').show();
                        hasError = true;
                    }
                });

                if (hasError) {
                    $('#error-message').text('Please fill out all required fields.').show();
                    submitButton.prop('disabled', false);
                    return; // Stop submission if validation fails
                }

                $.ajax({
                    url: '{{ route("daily_readiness.store") }}', // Route to store the form
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                         if (response.responseCode == 200) {
                            $('#success-message').text(response.message).show();
                            // Redirect after 2 seconds
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                            submitButton.prop('disabled', false);
                        }
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = 'Please fix the following errors:<br>';
                        $.each(errors, function (key, value) {
                            errorMessage += `- ${value[0]}<br>`;
                            if (key === 'date') {
                                $('#date').addClass('error-border');
                                $('#date').next('.invalid-feedback').text(value[0]).show();
                            }
                            if (key === 'site_name') {
                                $('#site_name').addClass('error-border');
                                $('#site_name').next('.invalid-feedback').text(value[0]).show();
                            }
                            if (key.startsWith('checklist_data')) {
                                const index = key.match(/\d+/)[0];
                                $(`.checklist-item:eq(${index})`).addClass('error-border');
                                $(`.checklist-item:eq(${index}) .invalid-feedback`).text(value[0]).show();
                            }
                        });
                        $('#error-message').html(errorMessage).show();
                        submitButton.prop('disabled', false);
                    },
                    complete: function () {
                        // Scroll to top of form to show messages
                        $('html, body').animate({
                            scrollTop: $('#readinessForm').offset().top
                        }, 500);
                         submitButton.prop('disabled', false);
                    }
                });
            });
        });
    </script>
</x-app-layout>
