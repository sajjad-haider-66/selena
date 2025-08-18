<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Action;
use App\Traits\ApiResponse;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Notifications\EventReported;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //KEY : MULTIPERMISSION
        $this->middleware('permission:Liste des événements|Créer un événement|Modifier un événement|Voir un événement|Supprimer un événement', ['only' => ['index', 'store']]);
        $this->middleware('permission:Créer un événement', ['only' => ['create', 'store']]);
        $this->middleware('permission:Modifier un événement', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Supprimer un événement', ['only' => ['destroy']]);
        $this->middleware('permission:Voir un événement', ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::get();
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'lieu' => 'required|string',
            'type' => 'required',
            'emetteur' => 'nullable|string',
            'circonstances' => 'nullable|string',
            'autre' => 'nullable|string',
            'autre_checkbox' => 'nullable|string',
            'risques' => 'nullable|string',
            'analyse' => 'nullable|array',
            'frequence' => 'nullable|in:1,2,3,4',
            'gravite' => 'nullable|in:1,2,3,4',
            'propositions' => 'nullable|array',
            'mesures' => 'nullable|array',
            'actions' => 'nullable|array',
        ]);

        // Calculate cotation
        $frequence = $data['frequence'] ?? 1;
        $gravite = $data['gravite'] ?? 1;
        $cotation = $frequence * $gravite;

        // Process actions
        $actions = $data['actions'] ?? [];

        // Handle attachments (assuming file upload via AJAX)
        // $attachments = [];
        // if ($request->hasFile('attachments')) {
        //     foreach ($request->file('attachments') as $file) {
        //         $path = $file->store('events', 'public');
        //         $attachments[] = $path;
        //     }
        // }

         // Handle single image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $single_image = $file->store('events', 'public');
        }

        $event = Event::create([
            'date' => $data['date'],
            'lieu' => $data['lieu'],
            'type' => $data['type'],
            'emetteur' => $data['emetteur'],
            'securite' => $request->has('securite'),
            'sante' => $request->has('sante'),
            'environnement' => $request->has('environnement'),
            'rse' => $request->has('rse'),
            'risques' => $data['risques'],
            'autre' => $data['autre'],
            'autre_checkbox' => $data['autre_checkbox'],
            'circonstances' => $data['circonstances'],
            'analyse' => json_encode($data['analyse'] ?? []),
            'cotation' => $cotation,
            'frequence' => $frequence,
            'gravite' => $gravite,
            'path' => $single_image ?? null,
            'propositions' => json_encode($data['propositions'] ?? []),
            'mesures' => json_encode($data['mesures'] ?? []),
            'actions' => json_encode($actions),
            'attachments' => $request->has('surete'),
        ]);

        // Auto-generate Action
        $priority = $cotation > 10 ? 'High' : ($cotation > 6 ? 'Medium' : 'Low');
        $action = Action::create([
            'origin' => 'Evenement',
            'origin_view_id' => $event->id,
            'action_origin' => 'event',
            'description' =>  $actions[0]['description'] ?? 'Address ' . $data['risques'],
            'issued_date' => now(),
            'emission' => now(),
            'type' => $actions[0]['type'] ?? 'Preventive',
            'pilot_id' => $actions[0]['responsable'] ?? 'test',
            'due_date' => $actions[0]['delai'] ?? now()->addDays(7),
            'json_data' => json_encode(['event_id' => $event->id, 'progress' => 0]),
            'progress_rate' => 0,
            'efficiency' => 'N',
            'comments' => $data['type'] ?? 'Action generated from event',
        ]);

        // Notify Client or RQSE (basic structure)
        // $client = User::where('role', 'client')->first();
        // $rqse = User::where('role', 'rqse')->first();
        // Notification::send([$client, $rqse], new EventReported($event));

        $notification = Notification::create([
            'to_user_id' => Auth::id(),
            'from_user_id' => Auth::id(),
            'action' => 'user_event_notify',
            'message' => 'Ypu are invite for this event',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Event reported successfully.',
            'redirect' => route('event.index'),
        ]);
    }

    private function assignResponsible($eventType, $cotation)
    {
        if ($cotation > 10 || $eventType === 'Work accident') {
            return User::role('SuperManager')->first()->id ?? 1;
        }

        return User::role('RQSE Team')->first()->id ?? 1;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'lieu' => 'required|string',
            'type' => 'required',
            'emetteur' => 'nullable|string',
            'circonstances' => 'nullable|string',
            'risques' => 'nullable|string',
            'autre' => 'nullable|string',
            'autre_checkbox' => 'nullable|string',
            'analyse' => 'nullable|array',
            'frequence' => 'nullable|in:1,2,3,4',
            'gravite' => 'nullable|in:1,2,3,4',
            'propositions' => 'nullable|array',
            'mesures' => 'nullable|array',
            'actions' => 'nullable|array',
            
            // 'attachments.*' => 'file|mimes:jpg,jpeg,png,mp4,mov|max:20480',
        ]);

        // Calculate cotation
        $frequence = $data['frequence'] ?? 1;
        $gravite = $data['gravite'] ?? 1;
        $cotation = $frequence * $gravite;

        // Process actions
        $actions = $data['actions'] ?? [];

           // Handle single image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $single_image = $file->store('events', 'public');
        }


        // Update event
        $event->update([
            'date' => $data['date'],
            'lieu' => $data['lieu'],
            'type' => $data['type'],
            'emetteur' => $data['emetteur'],
            'autre' => $data['autre'],
            'autre_checkbox' => $data['autre_checkbox'],
            'securite' => $request->has('securite'),
            'sante' => $request->has('sante'),
            'environnement' => $request->has('environnement'),
            'rse' => $request->has('rse'),
            'circonstances' => $data['circonstances'],
            'risques' => $data['risques'],
            'analyse' => json_encode($data['analyse'] ?? []),
            'cotation' => $cotation,
            'frequence' => $frequence,
            'gravite' => $gravite,
            'path' => $single_image ?? $event->path, // Keep existing path if no new image
            'propositions' => json_encode($data['propositions'] ?? []),
            'mesures' => json_encode($data['mesures'] ?? []),
            'actions' => json_encode($actions),
            'attachments' => $request->has('surete'),
        ]);


        $action = Action::where('action_origin', 'event')
            ->where('origin_view_id', $event->id)
            ->first();

        if ($action) {
            $action->update([
                'origin'         => 'Evenement',                             // same as create
                'origin_view_id' => $event->id,                              // same as create
                'action_origin'  => 'event',                                 // add missing key
                'action_number'  => $action->action_number ?? $this->random_number(), 
                'description'    => $actions[0]['description'] ?? ('Address ' . $data['risques']),
                'issued_date'    => now(),
                'emission'       => now(),
                'type'           => $actions[0]['type'] ?? $action->type ?? 'Preventive',
                'pilot_id'       => $actions[0]['responsable'] ?? $action->pilot_id ?? 'test',
                'due_date'       => $actions[0]['delai'] ?? $action->due_date ?? now()->addDays(7),
                'json_data'      => json_encode(['event_id' => $event->id, 'progress' => 0]),
                'progress_rate'  => 0,
                'efficiency'     => 'N',
                'comments'       => $data['type'] ?? 'Action updated from event',
            ]);
        }

        // Notify users
        $notification = Notification::create([
            'to_user_id' => Auth::id(),
            'from_user_id' => Auth::id(),
            'action' => 'user_event_update_notify',
            'message' => 'L événement a été mis à jour',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Événement mis à jour avec succès.',
            'redirect' => route('event.index'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $event = Event::FindOrFail($id);
        $event->delete();
        // Check if related action exists
        $delAction = Action::where('origin_view_id', $id)
            ->where('action_origin', 'event')
            ->first();

        if ($delAction) {
            $delAction->delete();
        }
        return $this->success('L événement a été supprimé avec succès', ['success' => true, 'data' => null]);
    }

        /**
     * Remove image from event.
     */
    public function removeImage(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);
        if ($event->path) {
            // Delete the image file from storage
            Storage::disk('public')->delete($event->path);
            // Set the path to null in the database
            $event->path = null;
            $event->save();
            return response()->json(['success' => true, 'message' => 'Image supprimée avec succès.']);
        }
    }
}
