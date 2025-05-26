<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TalkAnimation;
use App\Http\Requests\TalkAnimationUpdateRequest;

class TalkAnimationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //KEY : MULTIPERMISSION
        $this->middleware('permission:talk_animation-list|talk_animation-create|talk_animation-edit|talk_animation-show|talk_animation-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:talk_animation-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:talk_animation-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:talk_animation-delete', ['only' => ['destroy']]);
        $this->middleware('permission:talk_animation-show', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $talkanimations = TalkAnimation::latest()->get();
        return view('talk_animations.index', compact('talkanimations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('talk_animations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'lieu' => 'required|string',
            'theme' => 'required|string',
            'animateur' => 'required|string',
            'signature' => 'nullable|string',
            'security' => 'nullable|boolean',
            'health' => 'nullable|boolean',
            'environment' => 'nullable|boolean',
            'rse' => 'nullable|boolean',
            'points' => 'nullable|string',
            'commentaires' => 'nullable|string',
            'participant_name' => 'nullable|array',
            'participant_signature' => 'nullable|array',
            'action' => 'nullable|array',
            'responsable' => 'nullable|array',
            'delai' => 'nullable|array',
            'immediate' => 'nullable|array',
            'corrective' => 'nullable|array',
            'preventive' => 'nullable|array',
        ]);

        // Process participants
        $participants = [];
        if ($request->has('participant_name')) {
            foreach ($request->input('participant_name') as $index => $name) {
                if (!empty($name)) {
                    $participants[] = [
                        'name' => $name,
                        'signature' => $request->input('participant_signature')[$index] ?? '',
                    ];
                }
            }
        }

        // Process actions
        $actions = [];
        if ($request->has('action')) {
            foreach ($request->input('action') as $index => $actionDescription) {
                if (!empty($actionDescription)) {
                    $type = [];
                    if (in_array($index, $request->input('immediate', []))) $type[] = 'I';
                    if (in_array($index, $request->input('corrective', []))) $type[] = 'C';
                    if (in_array($index, $request->input('preventive', []))) $type[] = 'P';
                    $actions[] = [
                        'description' => $actionDescription,
                        'responsable' => $request->input('responsable')[$index] ?? '',
                        'delai' => $request->input('delai')[$index] ?? '',
                        'type' => implode(',', $type),
                    ];
                }
            }
        }

        // Basic stats for now (can be extended later)
        $stats = [
            'total_participants' => count($participants),
            'event_date' => $data['date'],
        ];

        $talk = TalkAnimation::create([
            'date' => $data['date'],
            'lieu' => $data['lieu'],
            'theme' => $data['theme'],
            'animateur' => $data['animateur'],
            'signature' => $data['signature'],
            'security' => $request->has('security'),
            'health' => $request->has('health'),
            'environment' => $request->has('environment'),
            'rse' => $request->has('rse'),
            'points' => $data['points'],
            'commentaires' => $data['commentaires'],
            'participants' => json_encode($participants),
            'actions' => json_encode($actions),
            'stats' => json_encode($stats),
        ]);

        // Notify users (basic structure - implementation depends on your notification setup)
        // $users = User::all();
        // Notification::send($users, new TalkInvitation($talk));

        return response()->json([
            'success' => true,
            'message' => 'Talk event created successfully.',
            'redirect' => route('talk.index'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        // return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        // return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TalkAnimationUpdateRequest $request, TalkAnimation $talkAnimation)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {

    }
}