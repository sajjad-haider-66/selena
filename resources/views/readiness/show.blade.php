<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show - Daily Work Readiness Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <h3 class="text-lg font-semibold mb-4">Readiness Details</h3>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Date:</strong> {{ $readiness->date }}
                    </div>
                    <div class="col-md-6">
                        <strong>Site Name:</strong> {{ $readiness->site_name }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Company Name:</strong> {{ $readiness->company_name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Permit Number:</strong> {{ $readiness->permit_number }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nom:</strong> {{ $readiness->nom }}
                    </div>
                    <div class="col-md-6">
                        <strong>Entreprise:</strong> {{ $readiness->entreprise }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Signature:</strong> {{ $readiness->signature ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong> <span class="badge {{ $readiness->status == 'Blocked' ? 'bg-danger' : 'bg-success' }}">{{ $readiness->status }}</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <strong>Commentaires:</strong>
                        <p>{{ $readiness->commentaires }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <strong>Checklist Data:</strong>
                         <ul class="list-group">
                            @foreach ($checklistData as $checklist)
                                @php
                                    // Get the question based on the checklist_id
                                    $question = $questions->get($checklist['checklist_id']);
                                @endphp
                                <li class="list-group-item">
                                    <strong>Question:</strong> {{ $question->question ?? 'N/A' }} - 
                                    <strong>Answer:</strong> {{ $checklist['answer'] }} - 
                                    <strong>Score:</strong> {{ $checklist['score'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <strong>Readiness Rate:</strong> {{ $readiness->readiness_rate }}%
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('daily_readiness.index') }}" class="btn btn-primary">Back to Readiness List</a>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>