<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create - Check List') }}
        </h2>
    </x-slot>

    <style>
        .section-title {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .score-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .score-table th,
        .score-table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
        }

        .score-table th {
            background-color: #007bff;
            color: white;
        }

        .action-row {
            background-color: #f8f9fa;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        #success-message,
        #error-message {
            display: none;
            margin-bottom: 20px;
        }

        .btn.btn-primary {
            background-color: #0d6efd !important;
            color: white !important;
        }

        .btn.btn-secondary {
            background-color: #d4d4d4 !important;
            color: white !important;
        }

        .btn.btn-danger {
            background-color: #fd290d !important;
            color: white !important;
        }
    </style>

    <div class="row justify-content-center mt-4">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4>Check List</h4>
                </div>
                <div class="card-body">
                    <div id="success-message" class="alert alert-success"></div>
                    <div id="error-message" class="alert alert-danger"></div>
                    <form id="checklistForm">
                        @csrf

                        <!-- Meta Info -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Form Heading</label>
                                <input type="text" name="category" class="form-control" required>
                            </div>
                            <div class="col-md-3 mt-4">
                                <button type="button" id="add-more" class="btn btn-info mb-3">Add More</button>
                            </div>
                        </div>
                        <div class="row mb-3" id="checklist-container">
                            <div class="col-md-9">
                                <div class="form-group checklist-row">
                                    <label for="checklist_1">Question</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="checklists[]" id="checklist_1" placeholder="Enter checklist" required>
                                        <button type="button" class="btn btn-danger remove-checklist">Remove</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Submit -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
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

            // Counter for unique input IDs
            let checklistCount = 1;

            // Add new variation input field
            $('#add-more').click(function() {
                let newchecklist = `
                <div class="col-md-9 mt-3">
                    <div class="form-group checklist-row">
                        <label for="checklist_${checklistCount}">Question</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="checklists[]" id="checklist_${checklistCount}" placeholder="Enter variation">
                            <button type="button" class="btn btn-danger remove-checklist">Remove</button>
                        </div>
                    </div>
                </div>`;
                $('#checklist-container').append(newchecklist);
                checklistCount++;
            });

            // Remove variation input field
            $(document).on('click', '.remove-checklist', function() {
                if ($('.checklist-row').length > 1) {
                    $(this).closest('.checklist-row').remove();
                } else {
                    alert('At least one checklist is required.');
                }
            });

            // AJAX Form Submission
            $('#checklistForm').on('submit', function (e) {
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
                    url: '{{ route("checklist.store") }}',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        
                        if (response.responseCode == 200) {
                            $('#success-message').text('Form submitted successfully!').show();
                             toastr.success('Form submitted successfully!');
                            setTimeout(() => {
                               window.location.href = '{{ route('checklist.index') }}';
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