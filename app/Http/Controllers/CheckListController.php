<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckListController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        //KEY : MULTIPERMISSION
        $this->middleware('permission:Liste des formulaires de vérification|Créer un formulaire de vérification|Modifier un formulaire de vérification|Voir un formulaire de vérification|Supprimer un formulaire de vérification', ['only' => ['index', 'store']]);
        $this->middleware('permission:Créer un formulaire de vérification', ['only' => ['create', 'store']]);
        $this->middleware('permission:Modifier un formulaire de vérification', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Supprimer un formulaire de vérification', ['only' => ['destroy']]);
        $this->middleware('permission:Voir un formulaire de vérification', ['only' => ['show']]);
    }

    public function index()
    {
        $checklists = Checklist::select('category', DB::raw('COUNT(*) as question_count'))
            ->groupBy('category')
            ->get();
        return view('checklists.index', compact('checklists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('checklists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        foreach ($request->checklists as $key => $checklist) {

            $saveChecklist = Checklist::create([
                'category' => $request->category,
                'question' => $checklist,
                'score' => 1, // Default score set to 1
            ]);
        }

        return $this->success($saveChecklist, 'Liste de contrôle créée avec succès', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $checklists = Checklist::where('category', $id)->get();
        return view('checklists.show', compact('checklists'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $name)
    {

        $checklists = Checklist::where('category', $name)->get();
        // Check if the checklist exists
        if (!$checklists) {
            return $this->error('Checklist not found', 404);
        }
        return view('checklists.edit', compact('checklists', 'name'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $name)
    {
        $checklist = Checklist::where('category', $name)->delete();

        foreach ($request->checklists as $key => $checklist) {

            $saveChecklist = Checklist::create([
                'category' => $request->category,
                'question' => $checklist,
                'score' => 1, // Default score set to 1
            ]);
        }

         return redirect()->route('checklist.index')->with('success', 'Liste de contrôle mise à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $name)
    {
        if (!$name) {
            return $this->error('Checklist not found', 404);
        }
        $checklist = Checklist::where('category', $name)->delete();
        return $this->success(null, 'Liste de contrôle supprimée avec succès', 200);
    }
}
