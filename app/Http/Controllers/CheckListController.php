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
        $this->middleware('permission:checklist-list|checklist-create|checklist-edit|checklist-show|checklist-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:checklist-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:checklist-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:checklist-delete', ['only' => ['destroy']]);
        $this->middleware('permission:checklist-show', ['only' => ['show']]);
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
        return view('Checklists.create');
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

        return $this->success($saveChecklist, 'Checklist created successfully', 200);
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

         return redirect()->route('checklist.index')->with('success', 'Checklist updated successfully');
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
        return $this->success(null, 'Checklist deleted successfully', 200);
    }
}
