<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Attendance;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\TalkAnimation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TalkAnimationUpdateRequest;

class TalkAnimationController extends Controller
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
            'animateur' => 'nullable|array',
            'signature' => 'nullable|string',
            'commentaires' => 'nullable|string',
            'points' => 'nullable|string',
            'participant_name' => 'nullable|array',
            'participant_signature' => 'nullable|array',
            'actions' => 'nullable|array',
            'responsable' => 'nullable|array',
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

        // Process actions array
        $actions = $data['actions'] ?? [];
        

        // Handle attachments (assuming file upload via AJAX)
        if ($request->hasFile('corrosive_image')) {
            $file = $request->file('corrosive_image');
            $path = $file->store('talks', 'public');
        }

        $talk = TalkAnimation::create([
            'date' => $data['date'],
            'created_by' => auth()->user()->id,
            'lieu' => $data['lieu'],
            'theme' => $data['theme'],
            'animateur' => $data['animateur'] ?? '',
            'signature' => $data['signature']?? '',
            'security' => $request->has('security')?? '',
            'health' => $request->has('health')?? '',
            'environment' => $request->has('environment')?? '',
            'rse' => $request->has('rse')?? '',
            'points' => $data['points'],
            'participants' => json_encode($participants),
            'actions' => json_encode($actions),
            'path' => $path ?? null,
            'commentaires' => $data['commentaires'] ?? null,
            'status' => 'scheduled',
        ]);

        if ($actions) {
            Action::create([
                'origin' => 'TalkAnimation',
                'origin_view_id' => $talk->id,
                'action_origin' => 'talk_animation',
                'action_number' => $this->random_number(),
                'description' => $actions[0]['action'] ?? 'talk description',
                'issued_date' => now(),
                'emission' => now(),
                'pilot_id' => $data['animateur'][0] ?? 'dummy' ?? auth()->user()->id,
                'due_date' => $actions[0]['delai'] ?? now()->addDays(7),
                'json_data' => json_encode(['talk_id' => $talk->id, 'progress' => 0]),
                'progress_rate' => 0,
                'efficiency' => 'N',
                'type' => $actions[0]['type'] ?? now()->addDays(7),
                'comments' => 'Action generated from event',
            ]);
        } 

        // Notify and Invite Users
        // $users = User::where('role', '!=', 'RQSE Manager')->get();
        // Notification::send($users, new TalkInvitation($talk));

        return response()->json([
            'success' => true,
            'message' => 'Talk event created successfully.',
            'redirect' => route('talk_animation.index'),
        ]);
    }

    function random_number($min = 0, $max = 1000)
    {
        return mt_rand($min, $max);
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

        // ✅ Check if files are uploaded
        if ($request->hasFile('materials')) {
            foreach ($request->file('materials') as $file) {
                $path = $file->store('talks', 'public');
                $materials[] = $path;
            }
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
    public function edit($id)
    {
        $talk = TalkAnimation::findOrFail($id);
        return view('talk_animations.edit', compact('talk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'lieu' => 'required|string',
            'theme' => 'required|string',
            'animateur' => 'nullable|array',
            'signature' => 'nullable|string',
            'commentaires' => 'nullable|string',
            'points' => 'nullable|string',
            'participant_name' => 'nullable|array',
            'participant_signature' => 'nullable|array',
            'actions' => 'nullable|array',
            'responsable' => 'nullable|array',
            'delai' => 'nullable|array',
            'immediate' => 'nullable|array',
            'corrective' => 'nullable|array',
            'preventive' => 'nullable|array',
        ]);

        // Find the existing TalkAnimation
        $talkAnimation = TalkAnimation::findOrFail($id);

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

        // Process actions array
        $actions = $data['actions'] ?? [];

        // Handle attachments (assuming file upload via AJAX)
        if ($request->hasFile('corrosive_image')) {
            $file = $request->file('corrosive_image');
            $path = $file->store('talks', 'public');
            $data['path'] = $path; // Update path in data
        } else {
            $data['path'] = $talkAnimation->path; // Keep existing path if no new file uploaded
        }

        // Update the TalkAnimation
        $talkAnimation->update([
            'date' => $data['date'],
            'lieu' => $data['lieu'],
            'theme' => $data['theme'],
            'animateur' => $data['animateur'] ?? 'dummy',
            'signature' => $data['signature'] ?? 'dummy',
            'security' => $request->has('security') ?? 'dummy',
            'health' => $request->has('health') ?? 'dummy',
            'environment' => $request->has('environment') ?? 'dummy',
            'rse' => $request->has('rse') ?? 'dummy',
            'points' => $data['points'],
            'path' => $data['path'],
            'commentaires' => $data['commentaires'],
            'participants' => json_encode($participants),
            'actions' => json_encode($actions),
            'status' => 'scheduled',
        ]);

        return $this->success('Talk event updated successfully.', ['success' => true, 'data' => null]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $talk = TalkAnimation::FindOrFail($id);
        $talk->delete();
          // Check if related action exists
        $delAction = Action::where('origin_view_id', $id)->first();

        if ($delAction) {
            $delAction->delete();
        }
        return $this->success('Talk Animation Delete Successfully', ['success' => true, 'data' => null]);
    }
}