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
        /* body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
            margin: 0;
        } */

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        .header h1 {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .label {
            flex: 1 1 30%;
            font-weight: bold;
            color: #333;
        }

        .input-field,
        .textarea {
            flex: 1 1 65%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .textarea {
            height: 100px;
            resize: vertical;
        }

        .checkbox-group {
            flex: 1 1 65%;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .image-section img {
            max-width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 10px;
        }

        .submit-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        .alert {
            background: #ffe5e5;
            border-left: 5px solid red;
            margin-bottom: 20px;
            padding: 10px 15px;
            color: #d8000c;
            border-radius: 5px;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

              
                 <a href="{{ route('daily_readiness.create') }}" class="btn btn-primary inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold uppercase bg-green-600 text-white rounded-md hover:bg-green-500" style="float: right">
                    {{ __('Create Readiness') }}
                </a>
            {{-- <div class="card shadow mb-4"> --}}
                {{-- <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Daily Readiness Forms</h5>
                </div> --}}
                <div class="card-body">
                    <table id="readiness_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Site Name</th>
                                <th>Company Name</th>
                                <th>Permit #</th>
                                <th>Status</th>
                                <th>Rate (%)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($readiness_forms as $form)
                            <tr>
                                <td>{{ $form->id }}</td>
                                <td>{{ $form->date }}</td>
                                <td>{{ $form->site_name }}</td>
                                <td>{{ $form->company_name }}</td>
                                <td>{{ $form->permit_number }}</td>
                                <td>
                                    <span class="badge {{ $form->status == 'Green' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $form->status }}
                                    </span>
                                </td>
                                <td>{{ $form->readiness_rate }}%</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye"></i></a>
                                    <a href="#" class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            {{-- </div> --}}
                </div>
            </div>
    </div>

<!-- DataTables CDN -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css">
<script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
    <script>
    $(document).ready(function () {
        $('#readiness_table').DataTable({
            responsive: true,
           "lengthChange": false,
        });
    });
</script>
</x-app-layout>
