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
            background-color: #eff0f2;
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

        .head-read{
            background-color: #ebeef1;
        }

      
        .nav-tabs .nav-link:hover {
        border-color: #227ed9 #2c6eaf #fff;
        }

        .error-border { border-color: red !important; }
        .alert-success, .alert-danger { display: none; }
        .category-heading { font-weight: bold; margin-top: 1rem; }
    </style>

    <div class="container mt-5">
        <h1>Checklist Forms</h1>

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="formTabs" role="tablist">
            @foreach ($checklistsByCategory as $category => $questions)
                <li class="nav-item">
                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="category-{{ \Illuminate\Support\Str::slug($category) }}-tab" data-bs-toggle="tab" href="#category-{{ \Illuminate\Support\Str::slug($category) }}" role="tab">
                        {{ $category ?: 'Uncategorized' }}
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="formTabContent">
            @foreach ($checklistsByCategory as $category => $questions)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="category-{{ \Illuminate\Support\Str::slug($category) }}" role="tabpanel">
                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-header text-black d-flex justify-content-between align-items-center head-read">
                            <h4 class="mb-0">{{ $category ?: 'Uncategorized' }} Checklist</h4>
                        </div>
                        <div class="card-body">
                            <div id="success-message-{{ \Illuminate\Support\Str::slug($category) }}" class="alert alert-success"></div>
                            <div id="error-message-{{ \Illuminate\Support\Str::slug($category) }}" class="alert alert-danger"></div>
                            <form id="readinessForm-{{ \Illuminate\Support\Str::slug($category) }}" data-category="{{ \Illuminate\Support\Str::slug($category) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="date-{{ \Illuminate\Support\Str::slug($category) }}" class="form-label">Date</label>
                                        <input type="date" name="date" id="date-{{ \Illuminate\Support\Str::slug($category) }}" class="form-control">
                                        <div class="invalid-feedback">Please select a date.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="site_name-{{ \Illuminate\Support\Str::slug($category) }}" class="form-label">Lieu (Site)</label>
                                        <input type="text" name="site_name" id="site_name-{{ \Illuminate\Support\Str::slug($category) }}" class="form-control">
                                        <div class="invalid-feedback">Please select a site.</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <input type="hidden" name="form_heading" id="form_heading" value="{{ \Illuminate\Support\Str::slug($category) }}">
                                    <div class="col-md-6 mb-3">
                                        <label for="company_name-{{ \Illuminate\Support\Str::slug($category) }}" class="form-label">Entreprise observée (Company)</label>
                                        <input type="text" name="company_name" id="company_name-{{ \Illuminate\Support\Str::slug($category) }}" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="permit_number-{{ \Illuminate\Support\Str::slug($category) }}" class="form-label">Numéro de permis</label>
                                        <input type="text" name="permit_number" id="permit_number-{{ \Illuminate\Support\Str::slug($category) }}" class="form-control">
                                    </div>
                                </div>

                                <div class="checklist-section">
                                    <h5 class="mb-3">Points à vérifier</h5>
                                    <div id="checklist-{{ \Illuminate\Support\Str::slug($category) }}">
                                        @foreach ($questions as $index => $checklist)
                                            <div class="checklist-item">
                                                <label class="form-label">{{ $index + 1 }}. {{ $checklist->question }}</label>
                                                <div class="d-flex">
                                                    @foreach (['Yes', 'No', 'N/A'] as $option)
                                                        <div class="form-check me-3">
                                                            <input type="radio" name="checklist_data[{{ $index }}][answer]" value="{{ $option }}" class="form-check-input checklist-input">
                                                            <label class="form-check-label">{{ $option }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <input type="hidden" name="checklist_data[{{ $index }}][checklist_id]" value="{{ $checklist->id }}">
                                                <input type="hidden" name="checklist_data[{{ $index }}][score]" value="{{ $checklist->score ?? 1 }}">
                                                <div class="invalid-feedback">Please select an option.</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="progress-container">
                                    <div class="progress-label" id="readiness-label-{{ \Illuminate\Support\Str::slug($category) }}">Readiness Rate: 0%</div>
                                    <div class="progress" id="readiness-progress-{{ \Illuminate\Support\Str::slug($category) }}">
                                        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="commentaires-{{ \Illuminate\Support\Str::slug($category) }}" class="form-label">Commentaires</label>
                                        <input type="text" name="commentaires" id="commentaires-{{ \Illuminate\Support\Str::slug($category) }}" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nom-{{ \Illuminate\Support\Str::slug($category) }}" class="form-label">Nom</label>
                                        <input type="text" name="nom" id="nom-{{ \Illuminate\Support\Str::slug($category) }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="entreprise-{{ \Illuminate\Support\Str::slug($category) }}" class="form-label">Entreprise</label>
                                        <input type="text" name="entreprise" id="entreprise-{{ \Illuminate\Support\Str::slug($category) }}" class="form-control">
                                    </div>
                                </div>

                                @if (!in_array(\Illuminate\Support\Str::slug($category), $hasSubmittedToday))
                                     <div class="mt-6">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-800 transition ease-in-out duration-150" style="background-color: blue;">
                                            Enregistrer
                                        </button>
                                    </div>
                                @else
                                    <div class="alert alert-info">This form has already been submitted for today.</div>
                                @endif
                            </form>
                        </div>
                    </div>   
                </div>
            @endforeach
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Readiness Rate Calculation
            function calculateReadinessRate(category) {
                let totalScore = 0;
                let count = 0;

                $(`#checklist-${category} .checklist-input:checked`).each(function () {
                    const value = $(this).val();

                    if (value === 'Yes') {
                        const score = parseInt($(this).closest('.checklist-item').find('input[name$="[score]"]').val());
                        totalScore += score;
                        count++;
                    } else if (value === 'No') {
                        // Count No but no score
                        count++;
                    }
                    // N/A is ignored completely
                });

                const rate = count ? (totalScore / count) * 100 : 0;

                $(`#readiness-label-${category}`).text(`Readiness Rate: ${rate.toFixed(1)}%`);
                $(`#readiness-progress-${category} .progress-bar`)
                    .css('width', `${rate}%`)
                    .text(`${rate.toFixed(1)}%`);

                const progressParent = $(`#readiness-progress-${category}`);
                progressParent.removeClass('alert-green alert-blocked');
                progressParent.addClass(rate >= 75 ? 'alert-green' : 'alert-blocked');
            }


            // Bind readiness rate calculation to radio button changes
            $('.checklist-input').on('change', function() {
                const category = $(this).closest('form').data('category');
                calculateReadinessRate(category);
            });

            // AJAX Form Submission
            $('form[id^="readinessForm-"]').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const category = form.data('category');
                const submitButton = form.find('button[type="submit"]');
                submitButton.prop('disabled', true);

                $(`#success-message-${category}, #error-message-${category}`).hide();
                $('.form-control, .checklist-item').removeClass('error-border');
                $('.invalid-feedback').hide();

                let hasError = false;
                const dateInput = $(`#date-${category}`);
                const siteInput = $(`#site_name-${category}`);
                const checklistItems = form.find('.checklist-item');

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
                    $(`#error-message-${category}`).text('Please fill out all required fields.').show();
                    submitButton.prop('disabled', false);
                    return;
                }

                $.ajax({
                    url: '{{ route('daily_readiness.store') }}',
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.responseCode == 200) {
                            $(`#success-message-${category}`).text(response.message).show();
                            toastr.success(response.message);
                            setTimeout(() => {
                                window.location.href = '{{ route('daily_readiness.index') }}';
                            }, 2000);
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors || { message: xhr.responseJSON.message || 'An error occurred.' };
                        let errorMessage = 'Please fix the following errors:<br>';
                        if (xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else {
                             toastr.error('something went wrong, please try again later');
                            $.each(errors, function(key, value) {
                                errorMessage += `- ${value[0]}<br>`;
                                if (key === 'date') {
                                    $(`#date-${category}`).addClass('error-border');
                                    $(`#date-${category}`).next('.invalid-feedback').text(value[0]).show();
                                }
                                if (key === 'site_name') {
                                    $(`#site_name-${category}`).addClass('error-border');
                                    $(`#site_name-${category}`).next('.invalid-feedback').text(value[0]).show();
                                }
                                if (key.startsWith('checklist_data')) {
                                    const index = key.match(/\d+/)[0];
                                    form.find(`.checklist-item:eq(${index})`).addClass('error-border');
                                    form.find(`.checklist-item:eq(${index}) .invalid-feedback`).text(value[0]).show();
                                }
                            });
                        }
                        $(`#error-message-${category}`).html(errorMessage).show();
                    },
                    complete: function() {
                        $('html, body').animate({ scrollTop: form.offset().top }, 500);
                        submitButton.prop('disabled', false);
                    }
                });
            });
        });
    </script>
</x-app-layout>

