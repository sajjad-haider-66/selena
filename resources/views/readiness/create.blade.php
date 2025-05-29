<x-app-layout>
    <x-slot name="title">
        Daily Work Readiness
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

        .category-heading {
            font-size: 1.25rem;
            font-weight: 700;
            color: #f7f8f8;
            background-color: #0D6EFD;
            padding: 10px 15px;
            border-radius: 6px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .checklist-item {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            background-color: #e7f1ff;
            border-radius: 5px;
            margin-bottom: 10px;
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

        #success-message,
        #error-message {
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
                    {{-- <a href="{{ route('daily_readiness.index') }}"
                        class="btn btn-secondary inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold uppercase bg-green-600 text-white rounded-md hover:bg-green-500">
                        {{ __('Back') }}
                    </a> --}}
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
                                @php
                                    $questionIndex = 0;
                                @endphp
                                @foreach ($checklists->groupBy('category') as $category => $questions)
                                    <div class="category-heading">{{ $category }}</div>
                                    @foreach ($questions as $checklist)
                                        <div class="checklist-item">
                                            <label class="form-label">{{ $questionIndex + 1 }}. {{ $checklist->question }}</label>
                                            <div class="d-flex">
                                                <div class="form-check me-3">
                                                    <input type="radio" name="checklist_data[{{ $questionIndex }}][answer]" value="Yes" class="form-check-input checklist-input">
                                                    <label class="form-check-label">Oui</label>
                                                </div>
                                                <div class="form-check me-3">
                                                    <input type="radio" name="checklist_data[{{ $questionIndex }}][answer]" value="No" class="form-check-input checklist-input">
                                                    <label class="form-check-label">Non</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" name="checklist_data[{{ $questionIndex }}][answer]" value="N/A" class="form-check-input checklist-input">
                                                    <label class="form-check-label">N/A</label>
                                                </div>
                                            </div>
                                            <input type="hidden" name="checklist_data[{{ $questionIndex }}][question]" value="{{ $checklist->question }}">
                                            <input type="hidden" name="checklist_data[{{ $questionIndex }}][score]" value="1">
                                            <div class="invalid-feedback">Please select an option.</div>
                                        </div>
                                        @php
                                            $questionIndex++;
                                        @endphp
                                    @endforeach
                                @endforeach
                            </div>
                        </div>

                        <div class="progress-container">
                            <div class="progress-label" id="readiness-label">Readiness Rate: 0%</div>
                            <div class="progress" id="readiness-progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="commentaires" class="form-label">Commentaires</label>
                                <input type="text" name="commentaires" id="commentaires" class="form-control">
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
                        </div>

                        <button type="submit" class="btn btn-submit w-100">Submit Checklist</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Readiness Rate Calculation
            function calculateReadinessRate() {
                let totalScore = 0;
                let count = 0;
                $('.checklist-input').each(function() {
                    if (this.checked && this.value === 'Yes') {
                        totalScore += parseInt($(this).closest('.checklist-item').find('input[name$="[score]"]').val());
                    }
                    if (this.checked) {
                        count++;
                    }
                });
                const rate = count ? (totalScore / count) * 100 : 0;
                $('#readiness-label').text(`Readiness Rate: ${rate.toFixed(1)}%`);
                $('#readiness-progress .progress-bar').css('width', `${rate}%`).text(`${rate.toFixed(1)}%`);
                const progressParent = $('#readiness-progress');
                progressParent.removeClass('alert-green alert-blocked');
                progressParent.addClass(rate >= 75 ? 'alert-green' : 'alert-blocked');
            }

            $(document).on('change', '.checklist-input', calculateReadinessRate);

            // AJAX Form Submission
            $('body').on('submit', '#readinessForm', function(e) {
                e.preventDefault();

                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                submitButton.prop('disabled', true);

                $('#success-message').hide();
                $('#error-message').hide();
                $('.form-control, .checklist-item').removeClass('error-border');
                $('.invalid-feedback').hide();

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
                checklistItems.each(function() {
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
                    return;
                }

                $.ajax({
                    url: '{{ route('daily_readiness.store') }}',
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.responseCode == 200) {
                            $('#success-message').text(response.message).show();
                            setTimeout(() => {
                                window.location.href = '{{ route('daily_readiness.index') }}';
                            }, 2000);
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = 'Please fix the following errors:<br>';
                        $.each(errors, function(key, value) {
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
                    },
                    complete: function() {
                        $('html, body').animate({ scrollTop: $('#readinessForm').offset().top }, 500);
                        submitButton.prop('disabled', false);
                    }
                });
            });
        });
    </script>
</x-app-layout>

