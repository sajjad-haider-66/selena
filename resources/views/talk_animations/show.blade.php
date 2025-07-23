<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Talk Event: {{ $talk->theme }}
        </h2>
    </x-slot>
    @php
        $participants = json_decode($talk->participants);
    @endphp
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div
                            class="alert alert-success bg-green-100 border-t-4 border-green-500 rounded-b text-green-600 px-4 py-3 shadow-md my-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div id="message"
                        class="alert alert-success bg-green-100 border-t-4 border-green-500 rounded-b text-green-600 px-4 py-3 shadow-md my-3"
                        style="display: none;"></div>
                    <div id="error-message" class="alert alert-danger rounded-b text-red-600 px-4 py-3 shadow-md my-3"
                        style="display: none;"></div>

                    {{-- Event Info --}}
                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                        <p><strong>Date:</strong> {{ $talk->date }}</p>
                        <p><strong>Location:</strong> {{ $talk->lieu }}</p>
                        <p><strong>Theme:</strong> {{ $talk->theme }}</p>
                        <p><strong>Animator:</strong>
                            @foreach ($talk->animateur as $item)
                                {{ $item }},
                            @endforeach
                        </p>
                        <!-- Categories Section -->
                        {{-- <tr>
                            <td colspan="4">
                                <div class="checkbox-group">
                                    @php
                                        $categories = [
                                            'security' => 'Sécurité',
                                            'health' => 'Santé',
                                            'environment' => 'Environnement',
                                            'rse' => 'RSE',
                                            'Surete' => 'Surete',
                                        ];
                                    @endphp

                                    @foreach ($categories as $key => $label)
                                        @if ($talk[$key])
                                            <span class="badge badge-primary m-1">{{ $label }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                        </tr> --}}

                        <!-- Title for Points -->
                        <tr>
                            <td colspan="4" class="blue-header">Principaux points abordés</td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <div style="padding: 10px; border: 1px solid #ddd; background: #f9f9f9;">
                                    {{ $talk->points ?? '—' }}
                                </div>
                            </td>
                        </tr>

                        <!-- Title for Comments -->
                        <tr>
                            <td colspan="4" class="blue-header">Commentaires des collaborateurs sur le thème</td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <div class="mb-2">
                                    @if ($talk->path)
                                        <img src="{{ asset('storage/' . $talk->path) }}" alt="Uploaded Image"
                                            width="200" height="150" class="rounded shadow">
                                    @else
                                        <p><em>Aucune image disponible</em></p>
                                    @endif
                                </div>

                                <div style="padding: 10px; border: 1px solid #ddd; background: #f9f9f9;">
                                    {{ $talk->commentaires ?? '—' }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <div class="checkbox-group">
                                    <div class="checkbox-item security">
                                        <input type="checkbox" name="security" id="security"
                                            {{ $talk['security'] == 1 ? 'checked' : '' }}>
                                        <label for="security">Sécurité</label>
                                    </div>
                                    <div class="checkbox-item health">
                                        <input type="checkbox" name="health" id="health"
                                            {{ $talk['health'] == 1 ? 'checked' : '' }}>
                                        <label for="health">Santé</label>
                                    </div>
                                    <div class="checkbox-item environment">
                                        <input type="checkbox" name="environment" id="environment"
                                            {{ $talk['environment'] == 1 ? 'checked' : '' }}>
                                        <label for="environment">Environnement</label>
                                    </div>
                                    <div class="checkbox-item rse">
                                        <input type="checkbox" name="rse" id="rse"
                                            {{ $talk['rse'] == 1 ? 'checked' : '' }}>
                                        <label for="rse">RSE</label>
                                    </div>
                                    <div class="checkbox-item Surete">
                                        <input type="checkbox" name="Surete" id="Surete"
                                            {{ $talk['Surete'] == 1 ? 'checked' : '' }}>
                                        <label for="Surete">Surete</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold mb-4 text-indigo-700">👥 Participants</h3>

                            <div class="overflow-x-auto">
                                <table
                                    class="table-auto w-full text-sm border-collapse border border-gray-200 shadow-sm rounded-md">
                                    <thead class="bg-indigo-100 text-indigo-800">
                                        <tr>
                                            <th class="px-4 py-2 border border-gray-300 text-left">#</th>
                                            <th class="px-4 py-2 border border-gray-300 text-left">Nom</th>
                                            <th class="px-4 py-2 border border-gray-300 text-left">Prénom</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (json_decode($talk->participants) as $index => $participant)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2 border border-gray-300">{{ $index + 1 }}</td>
                                                <td class="px-4 py-2 border border-gray-300">{{ $participant->name }}
                                                </td>
                                                <td class="px-4 py-2 border border-gray-300">
                                                    {{ $participant->signature }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <p><strong>Status:</strong> {{ $talk->status }}</p>
                    </div>

                    {{-- Only show if today --}}
                    @if ($talk->date == now()->toDateString())
                        {{-- Attendance --}}
                        <div class="border-t pt-4">
                            <h3 class="text-lg font-semibold mb-2 text-indigo-700">📝 Mark Attendance</h3>
                            <form id="attendanceForm" method="POST">
                                @csrf
                                <button type="button" id="markAttendance"
                                    class="px-4 py-2 mb-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                                    style="background-color: rgb(27, 218, 106)">Mark Attendance</button>
                            </form>
                        </div>

                        {{-- Upload Materials --}}
                        <div class="border-t pt-4">
                            <h3 class="text-lg font-semibold mb-2 text-indigo-700">📁 Upload Materials</h3>
                            <form action="{{ route('talk_animation.materials', $talk->id) }}" method="POST"
                                enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                <input type="file" name="materials[]" multiple
                                    class="block w-full text-sm text-gray-600">
                                <button type="submit"
                                    class="px-4 py-2 mt-2 mb-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                                    style="background-color: rgb(13, 159, 196)">Upload</button>
                            </form>
                        </div>

                        {{-- Submit Feedback --}}
                        <div class="border-t pt-4">
                            <h3 class="text-lg font-semibold mb-2 text-indigo-700">🗣️ Submit Feedback</h3>
                            <form id="feedbackForm" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="feedback" class="block font-medium">Feedback</label>
                                    <textarea name="feedback" id="feedback" rows="3" class="w-full border rounded px-3 py-2" required></textarea>
                                </div>
                                <div>
                                    <label for="concerns" class="block font-medium">Concerns (Optional)</label>
                                    <textarea name="concerns" id="concerns" rows="3" class="w-full border rounded px-3 py-2"></textarea>
                                </div>
                                <button type="button" id="submitFeedback"
                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 mb-2"
                                    style="background-color: rgb(15, 12, 231)">Submit Feedback</button>
                            </form>
                        </div>
                    @endif

                    {{-- Archive Option --}}
                    @if ($talk->status != 'archived' && Auth::user()->role == 'RQSE Manager')
                        <div class="border-t pt-4">
                            <h3 class="text-lg font-semibold mb-2 text-red-600">📦 Archive Talk</h3>
                            <form action="{{ route('talk_animation.archive', $talk->id) }}" method="POST"
                                class="space-y-4">
                                @csrf
                                <div>
                                    <label for="notes" class="block font-medium">Notes (Optional)</label>
                                    <textarea name="notes" id="notes" rows="3" class="w-full border rounded px-3 py-2"></textarea>
                                </div>
                                <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                                    style="background-color: rgb(9, 94, 173)">Archive</button>
                            </form>
                        </div>
                    @endif

                    {{-- Display Materials --}}
                    @if ($talk->materials)
                        <div class="border-t pt-4">
                            <h3 class="text-lg font-semibold mb-2 text-indigo-700">📚 Materials</h3>
                            <ul class="list-disc list-inside text-blue-600">
                                @foreach ($talk->materials as $material)
                                    <li><a href="{{ asset('storage/' . $material) }}" target="_blank"
                                            class="underline">View Material</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Display Feedback --}}
                    @if ($talk->feedback)
                        <div class="border-t pt-4">
                            <h3 class="text-lg font-semibold mb-2 text-indigo-700">📋 Feedback</h3>
                            <ul class="space-y-2">
                                @foreach ($talk->feedback as $fb)
                                    <li class="bg-gray-100 p-2 rounded">"{{ $fb['feedback'] }}" <span
                                            class="text-xs text-gray-500">(User {{ $fb['user_id'] }})</span></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h5 class="mt-4">Actions à mettre en place</h5>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered align-middle">
                            <thead class="table-secondary text-center">
                                <tr class="table-primary">
                                    <th>Action(s)</th>
                                    <th>Responsable</th>
                                    <th>Délai</th>
                                    <th>Type d'Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $actions = json_decode($talk->actions, true) ?? [];
                                @endphp
                                @if (!empty($actions))
                                    @foreach ($actions as $action)
                                        <tr class="action-row">
                                            <td>{{ $action['action'] ?? '' }}</td>
                                            <td>{{ $action['responsable'] ?? '' }}</td>
                                            <td>{{ $action['delai'] ?? '' }}</td>
                                            <td>
                                                {{ $action['type'] == 'Immediate' ? 'Imméd. (I)' : ($action['type'] == 'Corrective' ? 'Corrective (C)' : 'Préventive (P)') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">No actions defined.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    {{-- Display Concerns --}}
                    @if ($talk->concerns)
                        <div class="border-t pt-4">
                            <h3 class="text-lg font-semibold mb-2 text-indigo-700">⚠️ Concerns</h3>
                            <ul class="space-y-2">
                                @foreach ($talk->concerns as $concern)
                                    <li class="bg-yellow-100 p-2 rounded">{{ $concern['concern'] }} <span
                                            class="text-xs text-gray-600">(User {{ $concern['user_id'] }})</span></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#markAttendance').on('click', function() {
                $.ajax({
                    url: '{{ route('talk_animation.attendance', $talk->id) }}',
                    type: 'POST',
                    data: $('#attendanceForm').serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#message').text(response.message).show();
                            setTimeout(() => location.reload(), 2000);
                        }
                    },
                    error: function(xhr) {
                        $('#error-message').text(xhr.responseJSON.error).show();
                    }
                });
            });

            $('#submitFeedback').on('click', function() {
                $.ajax({
                    url: '{{ route('talk_animation.feedback', $talk->id) }}',
                    type: 'POST',
                    data: $('#feedbackForm').serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#message').text(response.message).show();
                            setTimeout(() => location.reload(), 2000);
                        }
                    },
                    error: function(xhr) {
                        $('#error-message').text(xhr.responseJSON.message).show();
                    }
                });
            });
        });
    </script>
</x-app-layout>
