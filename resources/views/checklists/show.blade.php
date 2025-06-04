<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show - Check List Details') }}
        </h2>
    </x-slot>
    <div class="py-12 px-5">
        <div class="row mb-3">
            <div class="col-md-12">
                <strong>Checklist Data:</strong>
                <ul class="list-group">
                     <strong>Form:  {{ $checklists[0]->category ?? 'N/A' }} </strong>
                    @foreach ($checklists as $checklist)
                        <li class="list-group-item">
                            <strong>Form: </strong> {{ $checklist->category ?? 'N/A' }}
                            <strong>Question:</strong> {{ $checklist->question ?? 'N/A' }} -
                            <strong>Score:</strong> {{ $checklist['score'] }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
