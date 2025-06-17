<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create - Audit') }}
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
                
                {{-- <a href="{{ route('audit.index') }}" title="Back"
                   class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-black uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500">
                    Go Back
                </a> --}}
                <a href="{{ route('audit.create') }}" class="btn btn-primary inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold uppercase bg-green-600 text-white rounded-md hover:bg-green-500" style="float: right">
                {{ __('Create Audit') }}
                </a>
                <div class="card-body">
                    <table id="audit_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Lieu</th>
                                <th>Auditeur</th>
                                <th>Intervenant</th>
                                <th>Culture_sse</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($audits as $audit)
                            <tr>
                                <td>{{ $audit->id }}</td>
                                <td>{{ $audit->date }}</td>
                                <td>{{ $audit->lieu }}</td>
                                <td>{{ $audit->auditeur }}</td>
                                <td>{{ $audit->intervenant }}</td>
                                <td>{{ $audit->culture_sse }}</td>
                                <td>
                                    <a href="{{ route('audit.show', $audit->id) }}" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('audit.edit', $audit->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger delete-audits" data-id="{{ $audit->id }}" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
               
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
    <script>
    $(document).ready(function () {
        $('#audit_table').DataTable({
            responsive: true,
            "lengthChange": false,
        });
        $('body').on('click', '.delete-audits', function () {
            deleteAudits($(this));
        });
        function deleteAudits(data) {
            let active = "Delete";
                let remove_id = data.data("id");

            Swal.fire({
                title: 'Are you sure you want to ' + active + ' this?',
                text: "You can't undo this action.",
                type: active === 'Active' ? 'success' : 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, ' + active + ' it!',
                confirmButtonColor: "#4B49AC",
                confirmButtonClass: "btn-danger",
                cancelButtonText: "Cancel",
                allowOutsideClick: false,
                onClose: () => {
                    removeBodyPadding();
                },
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        data: { '_method': 'DELETE' },
                        url: "audit/destory/" + remove_id,
                        type: 'Post',
                        success: function (data) {
                            console.log(data);
                            if (data.responseCode === 200) {
                                toastr.success('Audit deleted successfully');
                                setTimeout(function () {// wait for 2 secs(2)
                                    window.location.reload(); // then reload the page.(3)
                                }, 1000);

                            } else if (data.responseCode === 401) {
                                toastr.error(data.response);
                            }
                            return data;
                        },
                        error: function (response) {
                            let message = 'Something Went Wrong';

                            if (response.responseJSON.message != undefined) {
                                message = response.responseJSON.message
                            }
                            toastr.error(message);
                        }
                    });
                }
            });
        }
    });
</script>
</x-app-layout>
