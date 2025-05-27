<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\TalkAnimation;
use Illuminate\Support\Facades\Auth;
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
            // 'security' => 'nullable|boolean',
            // 'health' => 'nullable|boolean',
            // 'environment' => 'nullable|boolean',
            // 'rse' => 'nullable|boolean',
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

        $talk = TalkAnimation::create([
            'date' => $data['date'],
            'created_by' => auth()->user()->id,
            'lieu' => $data['lieu'],
            'theme' => $data['theme'],
            'animateur' => $data['animateur'] ?? 'dummy',
            'signature' => $data['signature']?? 'dummy',
            'security' => $request->has('security')?? 'dummy',
            'health' => $request->has('health')?? 'dummy',
            'environment' => $request->has('environment')?? 'dummy',
            'rse' => $request->has('rse')?? 'dummy',
            'points' => $data['points'],
            'commentaires' => $data['commentaires'],
            'participants' => json_encode($participants),
            'actions' => json_encode($actions),
            'status' => 'scheduled',
        ]);

        // Notify and Invite Users
        // $users = User::where('role', '!=', 'RQSE Manager')->get();
        // Notification::send($users, new TalkInvitation($talk));

        return response()->json([
            'success' => true,
            'message' => 'Talk event created successfully.',
            'redirect' => route('talk_animation.index'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $talk = TalkAnimation::findOrFail($id);
        return view('talk_animations.show', compact('talk'));
    }

    public function uploadMaterials(Request $request, $id)
    {
        $talk = TalkAnimation::findOrFail($id);

        $materials = $talk->materials ?? [];
        foreach ($request->file('materials') as $file) {
            $path = $file->store('talks', 'public');
            $materials[] = $path;
        }

        $talk->update(['materials' => $materials]);
        return redirect()->back()->with('success', 'Materials uploaded successfully.');
    }

    public function markAttendance(Request $request, $id)
    {
        $talk = TalkAnimation::findOrFail($id);
        if ($talk->date != now()->toDateString()) {
            return response()->json(['error' => 'Attendance can only be marked on the event day.'], 400);
        }

        $userId = Auth::id();
        $attendance = Attendance::firstOrNew([
            'user_id' => $userId,
            'talk_animation_id' => $talk->id,
            'date' => now()->toDateString(),
        ]);

        if (!$attendance->check_in) {
            $attendance->check_in = now()->toTimeString();
            $attendance->status = 'checked_in';
            $attendance->save();

            // $talk->increment('participants_count');
        }

        return response()->json(['success' => true, 'message' => 'Attendance marked successfully.']);
    }

    public function markAttendanceQR(Request $request, $id)
    {
        $talk = TalkAnimation::findOrFail($id);
        if ($talk->date != now()->toDateString()) {
            return response()->json(['error' => 'Attendance can only be marked on the event day.'], 400);
        }

        $userId = $request->input('user_id'); // From QR code scan
        $attendance = Attendance::firstOrNew([
            'user_id' => $userId,
            'talk_id' => $talk->id,
            'date' => now()->toDateString(),
        ]);

        if (!$attendance->check_in) {
            $attendance->check_in = now()->toTimeString();
            $attendance->status = 'checked_in';
            $attendance->save();

            $talk->increment('participants_count');
        }

        return response()->json(['success' => true, 'message' => 'Attendance marked via QR code.']);
    }

    public function submitFeedback(Request $request, $id)
    {
        $talk = TalkAnimation::findOrFail($id);
        $request->validate([
            'feedback' => 'required|string',
            'concerns' => 'nullable|string',
        ]);

        $feedback = $talk->feedback ?? [];
        $feedback[] = [
            'user_id' => Auth::id(),
            'feedback' => $request->input('feedback'),
            'submitted_at' => now()->toDateTimeString(),
        ];

        $concerns = $talk->concerns ?? [];
        if ($request->filled('concerns')) {
            $concerns[] = [
                'user_id' => Auth::id(),
                'concern' => $request->input('concerns'),
                'submitted_at' => now()->toDateTimeString(),
            ];
        }

        $talk->update([
            'feedback' => $feedback,
            'concerns' => $concerns,
        ]);

        return response()->json(['success' => true, 'message' => 'Feedback submitted successfully.']);
    }

    public function archive(Request $request, $id)
    {
        $talk = TalkAnimation::findOrFail($id);
        $talk->update([
            'status' => 'archived',
            'notes' => $request->input('notes', 'Talk completed and archived.'),
        ]);

        return redirect()->back()->with('success', 'Talk archived successfully.');
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