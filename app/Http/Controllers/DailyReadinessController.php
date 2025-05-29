<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Checklist;
use App\Traits\ApiResponse;
use App\Models\Notification;
use App\Models\ReadinessForm;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DailyReadinessStoreRequest;
use App\Http\Requests\DailyReadinessUpdateRequest;

class DailyReadinessController extends Controller
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
        $this->middleware('permission:daily_readiness-list|daily_readiness-create|daily_readiness-edit|daily_readiness-show|daily_readiness-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:daily_readiness-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:daily_readiness-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:daily_readiness-delete', ['only' => ['destroy']]);
        $this->middleware('permission:daily_readiness-show', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $readiness_forms = ReadinessForm::latest()->get();
        return view('readiness.index', compact('readiness_forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all checklist questions from the database
        $checklists = Checklist::all();
        return view('readiness.create', compact('checklists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DailyReadinessStoreRequest $request)
    {
            // Calculate readiness rate
            $readinessRate = $this->calculateReadinessRate($request->checklist_data);
            $status = $readinessRate >= 75 ? 'Green' : 'Blocked';

            // Save Readiness Form
            $form = ReadinessForm::create([
                'date' => $request->date,
                'site_name' => $request->site_name,
                'company_name' => $request->company_name,
                'permit_number' => $request->permit_number,
                'commentaires' => $request->commentaires,
                'nom' => $request->nom,
                'entreprise' => $request->entreprise,
                'user_id' => Auth::id(),
                'checklist_data' => $request->checklist_data,
                'readiness_rate' => $readinessRate,
                'status' => $status,
            ]);

            // Save checklist items
            foreach ($request->checklist_data as $item) {
                Checklist::create([
                    'readiness_form_id' => $form->id,
                    'question' => $item['question'],
                    'answer' => $item['answer'],
                    'score' => $item['score'] ?? 1,
                ]);
            }

            // Notify RQSE manager if status is Blocked
            if ($status === 'Blocked') {
                $manager = User::whereHas('roles', fn($q) => $q->where('name', 'SuperManger'))->first();
                if ($manager) {
                    Notification::create([
                        'to_user_id' => $manager->id,
                        'action' => 'daily_work_readness',
                        'message' => "Readiness form blocked for site Name {$form->site_name}. Rate: {$readinessRate}%",
                    ]);
                }
            }

            // Return JSON response for AJAX
          return $this->success('Readiness form submitted successfully.', ['success' => true, 'data' => null]);

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
      
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
     
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DailyReadinessUpdateRequest $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
      
    }

    private function calculateReadinessRate($checklistData)
    {
        $totalScore = 0;
        $count = 0;
        foreach ($checklistData as $item) {
            if ($item['answer'] === 'Yes') {
                $totalScore += $item['score'] ?? 1;
            }
            if ($item['answer']) {
                $count++;
            }
        }
        return $count ? ($totalScore / $count) * 100 : 0;
    }

    public function Notification()
    {
        $all_notifications = Notification::where('to_user_id', auth()->user()->id)->get();
        return view('readiness.notification', compact('all_notifications'));
    }
}