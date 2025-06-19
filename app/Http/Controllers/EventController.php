<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Action;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Notifications\EventReported;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

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
        $this->middleware('permission:event-list|event-create|event-edit|event-show|event-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:event-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:event-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:event-delete', ['only' => ['destroy']]);
        $this->middleware('permission:event-show', ['only' => ['show']]);
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
            'autre' => 'nullable|string',
            'autre_checkbox' => 'nullable|string',
            'risques' => 'nullable|string',
            'analyse' => 'nullable|array',
            'frequence' => 'nullable|in:1,2,3,4',
            'gravite' => 'nullable|in:1,2,3,4',
            'propositions' => 'nullable|array',
            'mesures' => 'nullable|array',
            'actions' => 'nullable|array',
            'attachments' => 'nullable|array',
        ]);

        // Calculate cotation
        $frequence = $data['frequence'] ?? 1;
        $gravite = $data['gravite'] ?? 1;
        $cotation = $frequence * $gravite;

        // Process actions
        $actions = $data['actions'] ?? [];
        if ($cotation > 10) {
            $actions[] = [
                'description' => 'Urgent action required',
                'responsible' => 'RQSE Team',
                'deadline' => now()->addHours(24)->toDateString(),
                'type' => 'I',
            ];
        } elseif ($cotation > 6) {
            $actions[] = [
                'description' => 'Action within 48h',
                'responsible' => 'RQSE Team',
                'deadline' => now()->addDays(2)->toDateString(),
                'type' => 'C',
            ];
        } elseif ($cotation > 1) {
            $actions[] = [
                'description' => 'Action within 1 week',
                'responsible' => 'RQSE Team',
                'deadline' => now()->addDays(7)->toDateString(),
                'type' => 'P',
            ];
        }

        // Handle attachments (assuming file upload via AJAX)
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('events', 'public');
                $attachments[] = $path;
            }
        }

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
            'analyse' => json_encode($data['analyse'] ?? []),
            'cotation' => $cotation,
            'frequence' => $frequence,
            'gravite' => $gravite,
            'path' => $single_image ?? null,
            'propositions' => json_encode($data['propositions'] ?? []),
            'mesures' => json_encode($data['mesures'] ?? []),
            'actions' => json_encode($actions),
            'attachments' => json_encode($attachments),
        ]);

        // Auto-generate Action
        $priority = $cotation > 10 ? 'High' : ($cotation > 6 ? 'Medium' : 'Low');
        $action = Action::create([
            'origin' => 'Evenement',
            'origin_view_id' => $event->id,
            'action_origin' => 'event',
            'description' => 'Address ' . $data['risques'],
            'issued_date' => now(),
            // 'type' => $actions[0]['type'] ?? 'Preventive',
            'pilot_id' => $this->assignResponsible($event->type, $cotation),
            'deadline' => $actions[0]['deadline'] ?? now()->addDays(7),
            'json_data' => json_encode(['event_id' => $event->id, 'progress' => 0]),
            'due_date' => now()->addDays(7),
            'progress_rate' => 0,
            'efficiency' => 'N',
            'comments' => 'Action generated from event',
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
            'analyse' => 'nullable|array',
            'frequence' => 'nullable|in:1,2,3,4',
            'gravite' => 'nullable|in:1,2,3,4',
            'propositions' => 'nullable|array',
            'mesures' => 'nullable|array',
            'actions' => 'nullable|array',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,mp4,mov|max:20480', // 20MB max
        ]);

        // Calculate cotation
        $frequence = $data['frequence'] ?? 1;
        $gravite = $data['gravite'] ?? 1;
        $cotation = $frequence * $gravite;

        // Process actions
        $actions = $data['actions'] ?? [];
        if ($cotation > 10) {
            $actions[] = [
                'description' => 'Urgent action required',
                'responsible' => 'RQSE Team',
                'deadline' => now()->addHours(24)->toDateString(),
                'type' => 'I',
            ];
        } elseif ($cotation > 6) {
            $actions[] = [
                'description' => 'Action within 48h',
                'responsible' => 'RQSE Team',
                'deadline' => now()->addDays(2)->toDateString(),
                'type' => 'C',
            ];
        } elseif ($cotation > 1) {
            $actions[] = [
                'description' => 'Action within 1 week',
                'responsible' => 'RQSE Team',
                'deadline' => now()->addDays(7)->toDateString(),
                'type' => 'P',
            ];
        }

        // Handle attachments
        $existingAttachments = json_decode($event->attachments, true) ?? [];
        $newAttachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('events', 'public');
                $newAttachments[] = $path;
            }
        }
        $attachments = array_merge($existingAttachments, $newAttachments);

        // Update event
        $event->update([
            'date' => $data['date'],
            'lieu' => $data['lieu'],
            'type' => $data['type'],
            'emetteur' => $data['emetteur'],
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
            'propositions' => json_encode($data['propositions'] ?? []),
            'mesures' => json_encode($data['mesures'] ?? []),
            'actions' => json_encode($actions),
            'attachments' => json_encode($attachments),
        ]);

        // Update or create associated action
        // $action = Action::where('origin_id', $event->id)->where('origin', 'Event-' . $event->id)->first();
        // if ($action) {
        //     $action->update([
        //         'description' => 'Address ' . $data['risques'],
        //         'deadline' => $actions[0]['deadline'] ?? now()->addDays(7),
        //         'json_data' => json_encode(['event_id' => $event->id, 'progress' => $action->progress_rate]),
        //         'due_date' => now()->addDays(7),
        //         'comments' => 'Action updated from event editing',
        //     ]);
        // } else {
        //     Action::create([
        //         'origin' => 'Event-' . $event->id,
        //         'origin_id' => $event->id,
        //         'description' => 'Address ' . $data['risques'],
        //         'issued_date' => now(),
        //         'pilot_id' => $this->assignResponsible($event->type, $cotation),
        //         'deadline' => $actions[0]['deadline'] ?? now()->addDays(7),
        //         'json_data' => json_encode(['event_id' => $event->id, 'progress' => 0]),
        //         'due_date' => now()->addDays(7),
        //         'progress_rate' => 0,
        //         'efficiency' => 'N',
        //         'comments' => 'Action generated from event editing',
        //     ]);
        // }

        // Notify users
        $notification = Notification::create([
            'to_user_id' => Auth::id(),
            'from_user_id' => Auth::id(),
            'action' => 'user_event_update_notify',
            'message' => 'Event has been updated',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Event updated successfully.',
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
        return $this->success('Event Delete Successfully', ['success' => true, 'data' => null]);
    }
}
