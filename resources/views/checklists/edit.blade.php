<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit - Audit') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <a title="back" href="{{ route('checklist.index') }}"
                    class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-black uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25">
                    Go back
                </a>
                <!-- Calls when validation errors triggers starts -->
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
                <!-- Calls when validation errors triggers ends -->

                <!-- Calls when session error triggers starts -->
                @if (session('error'))
                    <div class="alert alert-danger rounded-b text-red-600 px-4 py-3 shadow-md my-3" role="alert">
                        <div class="flex">
                            <div>
                                <p class="text-sm text-danger">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- Calls when session error triggers ends -->
                <form action="{{ route('checklist.update', $checklists[0]['category']) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Form Heading</label>
                            <input type="text" name="category" class="form-control" value="{{ $checklists[0]['category'] }}" required>
                        </div>
                        <div class="col-md-3 mt-4">
                            <button type="button" id="add-more" class="btn btn-info mb-3">Add More</button>
                        </div>
                    </div>
                    <div class="row mb-3" id="checklist-container">
                        @foreach ($checklists as $index => $checklist)
                            <div class="col-md-9">
                                <div class="form-group checklist-row">
                                    <label for="checklist_{{ $index + 1 }}">Question: {{ $index + 1 }}</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="checklists[]"
                                            id="checklist_{{ $index + 1 }}" placeholder="Enter checklist"
                                            value="{{ $checklist['question'] }}" required>
                                        @if ($index > 0)
                                            <button type="button" class="btn btn-danger remove-checklist">Remove</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <div>
                        <button title="update" type="submit"
                            class="inline-flex items-center px-4 py-2 my-3 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {

            // Counter for unique input IDs
            let checklistCount = 1;

            // Add new variation input field
            $('#add-more').click(function() {
                let newchecklist = `
                <div class="col-md-9 mt-3 checklist-row">
                    <div class="form-group">
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
        });
    </script>
</x-app-layout>
