<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EventReported;

class EventController extends Controller
{

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
            'type' => 'required|in:Dangerous situation,Near miss,Work accident,Occupational illness',
            'emetteur' => 'nullable|string',
            // 'securite' => 'nullable|boolean',
            // 'sante' => 'nullable|boolean',
            // 'environnement' => 'nullable|boolean',
            // 'rse' => 'nullable|boolean',
            'circonstances' => 'nullable|string',
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

        $event = Event::create([
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

        // Notify Client or RQSE (basic structure)
        // $client = User::where('role', 'client')->first();
        // $rqse = User::where('role', 'rqse')->first();
        // Notification::send([$client, $rqse], new EventReported($event));

        return response()->json([
            'success' => true,
            'message' => 'Event reported successfully.',
            'redirect' => route('event.index'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
