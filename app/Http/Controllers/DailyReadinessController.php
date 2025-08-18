<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Checklist;
use App\Traits\ApiResponse;
use App\Models\Notification;
use App\Models\ReadinessForm;
use App\Models\ChecklistAnswer;
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
        $this->middleware('permission:Liste des validations journalières|Créer une validation journalière|Modifier une validation joumallière|Voir une validation journalière|Supprimer une validation journalière', ['only' => ['index', 'store']]);
        $this->middleware('permission:Créer une validation journalière', ['only' => ['create', 'store']]);
        $this->middleware('permission:Modifier une validation joumallière', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Supprimer une validation journalière', ['only' => ['destroy']]);
        $this->middleware('permission:Voir une validation journalière', ['only' => ['show']]);
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
        // Fetch all checklist questions and group by category
        $checklistsByCategory = Checklist::all()->groupBy('category');
        $today = now()->toDateString();
        $userId = Auth::id();

        // Check if a submission exists for today
        $hasSubmittedToday = ReadinessForm::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->pluck('form_heading')
            ->toArray();
            
        // Return the view with the checklist data and today's date

        return view('readiness.create', compact('checklistsByCategory', 'today', 'hasSubmittedToday'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DailyReadinessStoreRequest $request)
    {
        // dd($request->all());
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
                'form_heading' => $request->form_heading,
                'user_id' => Auth::id(),
                'checklist_data' => $request->checklist_data,
                'readiness_rate' => $readinessRate,
                'status' => $status,
            ]);

            // Save checklist items
            foreach ($request->checklist_data as $item) {
                ChecklistAnswer::create([
                    'readiness_form_id' => $form->id,
                    'question' => $item['checklist_id'],
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
                        'message' => "Formulaire de préparation bloqué pour le site Nom {$form->site_name}. Rate: {$readinessRate}%",
                    ]);
                }
            }

            // Return JSON response for AJAX
          return $this->success('Formulaire de préparation soumis avec succès.', ['success' => true, 'data' => null]);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $readiness = ReadinessForm::findOrFail($id);
        
        // Decode the checklist_data JSON
        $checklistData = $readiness->checklist_data;
        
        // Extract checklist IDs
        $checklistIds = array_column($checklistData, 'checklist_id');
        
        // Fetch questions from the checklist table
        $questions = Checklist::whereIn('id', $checklistIds)->get()->keyBy('id');

        return view('readiness.show', compact('readiness', 'checklistData', 'questions'));
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
    public function destroy($id)
    {
        $daily = ReadinessForm::FindOrFail($id);
        $daily->delete();
        return $this->success('Préparation Supprimer avec succès', ['success' => true, 'data' => null]);
    }

    private function calculateReadinessRate($checklistData)
    {
        $totalScore = 0;
        $count = 0;

        foreach ($checklistData as $item) {
            if ($item['answer'] === 'Oui') {
                $totalScore += $item['score'] ?? 1;
                $count++;
            } elseif ($item['answer'] === 'Non') {
                $count++;
            }
            // N/A is ignored
        }

        return $count ? ($totalScore / $count) * 100 : 0;
    }

    public function Notification()
    {
        $all_notifications = Notification::where('to_user_id', auth()->user()->id)->get();
        return view('readiness.notification', compact('all_notifications'));
    }
}