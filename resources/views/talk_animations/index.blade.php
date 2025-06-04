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
                                <th>Lieu</th>
                                <th>Theme</th>
                                <th>Animateur</th>
                                <th>Commentaires</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($talkanimations as $talk)
                                <tr>
                                    <td>{{ $talk->id }}</td>
                                    <td>{{ $talk->date }}</td>
                                    <td>{{ $talk->lieu }}</td>
                                    <td>{{ $talk->theme }}</td>
                                    <td>{{ $talk->animateur }}</td>
                                    <td>{{ $talk->commentaires }}</td>
                                    <td>
                                        <span class="badge {{ $talk->status == 'Green' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $talk->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('talk_animation.show', $talk->id) }}" class="btn btn-sm btn-info" title="View"><i
                                                class="fa fa-eye"></i></a>
                                        <a href="{{ route('talk_animation.edit', $talk->id) }}" class="btn btn-sm btn-warning" title="Edit"><i
                                                class="fa fa-pencil"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger delete-talks" data-id="{{ $talk->id }}" title="Delete"><i
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

        $('body').on('click', '.delete-talks', function () {
            deleteTalks($(this));
        });
        function deleteTalks(data) {
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
                        url: "talk/destory/" + remove_id,
                        type: 'Post',
                        success: function (data) {
                            console.log(data);
                            if (data.responseCode === 200) {
                                toastr.success('talk animation deleted successfully');
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
