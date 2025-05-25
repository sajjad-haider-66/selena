<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create - Talk/Animation
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <a title="back" href="{{ route('talk_animation.create') }}"
                    class="bt btn-primary inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-gray disabled:opacity-25">
                    Create Talk
                </a>
                <div class="card-body">
                    <table id="talk_table" class="table table-bordered table-striped">
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
                            @foreach ($talkanimations as $form)
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
                                        <a href="#" class="btn btn-sm btn-info" title="View"><i
                                                class="fa fa-eye"></i></a>
                                        <a href="#" class="btn btn-sm btn-warning" title="Edit"><i
                                                class="fa fa-pencil"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger" title="Delete"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css">
<script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#talk_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
</x-app-layout>
